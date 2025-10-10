<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Invoice;
use App\Models\User;
use App\Models\UkuranProduk;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PesananStoreRequest;
use App\Http\Requests\PesananUpdateRequest;
use App\Exports\Pesanan_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Charts\Pesanan\PemasukanChart;
use App\Charts\Pesanan\ProdukTerlarisChart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PesananController extends Controller
{
    /**
     * Display a listing of invoices.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $this->authorize('view-any', Invoice::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $customer_input = $request->input('customer_input');

        // Validate date range
        if ($start_date && $end_date && $start_date > $end_date) {
            return redirect()->back()
                ->withErrors(['end_date' => 'Tanggal selesai tidak boleh lebih kecil dari tanggal mulai.'])
                ->with('error', 'Rentang tanggal tidak valid!');
        }

        $customers = User::role('Sales')->pluck('nama', 'id');

        $invoices = Invoice::query()
            ->when($customer_input, function ($query) use ($customer_input) {
                $query->where('customer_id', $customer_input);
            })
            ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                $query->whereDate('invoices.updated_at', '>=', $start_date)
                    ->whereDate('invoices.updated_at', '<=', $end_date);
            })
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($query) use ($search) {
                    $query->where('nama', 'LIKE', "%{$search}%");
                })->orWhere('invoice', 'LIKE', "%{$search}%");
            })
            ->with('user');

        // Apply sorting
        if ($sortBy === 'customer') {
            $invoices = $invoices->join('users', 'invoices.customer_id', '=', 'users.id')
                ->orderBy('users.nama', $sortDirection)
                ->select('invoices.*');
        } else {
            $invoices = $invoices->orderBy('invoices.' . $sortBy, $sortDirection);
        }

        // Filter for Sales role
        if (auth()->user()->roles->contains('name', 'Sales')) {
            $invoices->where('customer_id', Auth::user()->id);
        }

        $invoices = $invoices->paginate($paginate)->appends($request->query());

        return view('transaksi.invoice.index', compact(
            'invoices', 
            'search', 
            'customers', 
            'sortBy', 
            'sortDirection', 
            'start_date', 
            'end_date'
        ));
    }

    /**
     * Show diagram and charts for invoices.
     */
    public function diagram(PemasukanChart $pemasukan, ProdukTerlarisChart $produk_terlaris, Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subDays(7)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $total_pemasukan = Invoice::whereBetween('created_at', [$startDate, $endDate])->sum('sub_total');

        return view('transaksi.invoice.diagram', [
            'pemasukan' => $pemasukan->build($startDate, $endDate),
            'produk_terlaris' => $produk_terlaris->build(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_pemasukan' => $total_pemasukan,
        ]);
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Invoice::class);

        $produks = Produk::pluck('nama_produk', 'id');
        $users = User::role('Sales')->pluck('nama', 'id');
        $create = 'create';
        
        // Get harga data dari UkuranProduk (bukan BiayaProduk)
        $ukuran_produks = UkuranProduk::all()->groupBy('produk_id');

        return view('transaksi.invoice.create', compact('produks', 'create', 'users', 'ukuran_produks'));
    }

    /**
     * Store a newly created invoice in storage.
     */
    public function store(PesananStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Invoice::class);

        try {
            DB::beginTransaction();

            $data = $request->validated();

            // Clean price format
            foreach ($data['harga'] as $index => $harga) {
                $data['harga'][$index] = str_replace(['Rp ', '.', ','], '', $harga);
            }

            // Create invoice
            $invoice = $this->createInvoice($request->customer_id);

            // Process order items and validate stock
            $total_subtotal = $this->processOrderItems($data, $invoice);

            // Update customer billing
            $this->updateCustomerBilling($invoice, $total_subtotal);

            DB::commit();

            return redirect()
                ->route('invoice.edit', $invoice)
                ->with('success', 'Invoice berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified invoice.
     */
    public function show(Request $request, Invoice $invoice): View
    {
        $this->authorize('view', $invoice);

        $pesanans = Pesanan::where('invoice_id', $invoice->id)
            ->with(['produk'])
            ->get();

        return view('transaksi.invoice.show', compact('invoice', 'pesanans'));
    }

    /**
     * Show the form for editing the specified invoice.
     */
    public function edit(Request $request, Invoice $invoice): View
    {
        $this->authorize('update', $invoice);

        $pesanans = Pesanan::where('invoice_id', $invoice->id)
            ->with(['produk'])
            ->get();

        return view('transaksi.invoice.edit', compact('invoice', 'pesanans'));
    }

    /**
     * Update the specified invoice in storage.
     */
    public function update(Request $request, Invoice $invoice): RedirectResponse
    {
        $this->authorize('update', $invoice);

        $validatedData = $request->validate([
            'jumlah_bayar' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $jumlah_bayar = $validatedData['jumlah_bayar'];

            // Update customer's bill
            $user = $invoice->user;
            $user->tagihan = max(0, $user->tagihan - $jumlah_bayar);
            $user->save();

            // Update invoice
            $invoice->update([
                'jumlah_bayar' => $jumlah_bayar,
                'tagihan_sisa' => $user->tagihan
            ]);

            DB::commit();

            return redirect()
                ->route('invoice.index')
                ->with('success', 'Pembayaran berhasil diproses!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses pembayaran!');
        }
    }

    /**
     * Remove the specified invoice from storage.
     */
    public function destroy(Request $request, Invoice $invoice): RedirectResponse
    {
        $this->authorize('delete', $invoice);

        try {
            DB::beginTransaction();

            // Restore stock for all order items
            $this->restoreStock($invoice);

            // Restore customer billing
            $this->restoreCustomerBilling($invoice);

            // Delete invoice (cascade will delete pesanans)
            $invoice->delete();

            DB::commit();

            return redirect()
                ->route('invoice.index')
                ->with('success', 'Invoice berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus invoice!');
        }
    }

    /**
     * Export invoices to Excel.
     */
    public function export_excel()
    {
        try {
            return Excel::download(
                new Pesanan_Export_Excel, 
                'Pesanan_' . now()->format('Y-m-d_H-i-s') . '.xlsx'
            );
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengekspor Excel!');
        }
    }

    /**
     * Export invoices to PDF.
     */
    public function export_pdf()
    {
        try {
            if (auth()->user()->roles->contains('name', 'Sales')) {
                $invoices = Invoice::where('customer_id', Auth::user()->id)
                    ->with(['user', 'pesanans.produk'])
                    ->get();
            } else {
                $invoices = Invoice::with(['user', 'pesanans.produk'])->get();
            }

            $pdf = PDF::loadView('PDF.pesanan', compact('invoices'))
                ->setPaper('a4', 'landscape');

            return $pdf->download('Pesanan_' . now()->format('Y-m-d_H-i-s') . '.pdf');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengekspor PDF!');
        }
    }

    /**
     * Generate PDF for specific invoice.
     */
    public function invoice_pdf($invoice_id)
    {
        try {
            $invoice = Invoice::with(['user', 'pesanans.produk'])->findOrFail($invoice_id);
            
            $this->authorize('view', $invoice);

            $pesanans = $invoice->pesanans;

            $pdf = PDF::loadView('PDF.invoice', compact('invoice', 'pesanans'))
                ->setPaper('a4', 'portrait');

            return $pdf->download('Invoice_' . $invoice->invoice . '_' . now()->format('Y-m-d_H-i-s') . '.pdf');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat membuat PDF invoice!');
        }
    }

    // ========== PRIVATE HELPER METHODS ==========

    /**
     * Create new invoice with auto-generated invoice number.
     */
    private function createInvoice($customer_id): Invoice
    {
        $todayInvoiceCount = Invoice::whereDate('created_at', today())->count();

        $invoice = new Invoice();
        $invoice->customer_id = $customer_id;
        $invoice->invoice = 'IVC-' . date('Ymd') . '-' . str_pad($todayInvoiceCount + 1, 3, '0', STR_PAD_LEFT);
        $invoice->tagihan_sebelumnya = User::find($customer_id)->tagihan ?? 0;
        $invoice->save();

        return $invoice;
    }

    /**
     * Process order items and validate stock.
     */
    private function processOrderItems(array $data, Invoice $invoice): float
    {
        $total_subtotal = 0;

        foreach ($data['produk_id'] as $index => $produk_id) {
            $ukuran = $data['ukuran'][$index];
            $jumlah_pesanan = $data['jumlah_pesanan'][$index] ?? 0;
            $harga = $data['harga'][$index];

            // Validate stock
            $ukuran_produk = UkuranProduk::where('produk_id', $produk_id)
                ->where('ukuran', $ukuran)
                ->first();

            if (!$ukuran_produk || $ukuran_produk->stok < $jumlah_pesanan) {
                throw new \Exception("Stok tidak cukup untuk {$ukuran_produk->produk->nama_produk} ukuran {$ukuran}");
            }

            // Create order item
            $pesanan = new Pesanan();
            $pesanan->invoice_id = $invoice->id;
            $pesanan->produk_id = $produk_id;
            $pesanan->ukuran = $ukuran;
            $pesanan->harga = $harga;
            $pesanan->jumlah_pesanan = $jumlah_pesanan;
            $pesanan->save();

            // Update stock
            $ukuran_produk->stok -= $jumlah_pesanan;
            $ukuran_produk->save();

            // Calculate subtotal
            $total_subtotal += $jumlah_pesanan * $harga;
        }

        return $total_subtotal;
    }

    /**
     * Update customer billing information.
     */
    private function updateCustomerBilling(Invoice $invoice, float $total_subtotal): void
    {
        $user = User::find($invoice->customer_id);
        $user->tagihan += $total_subtotal;
        $user->save();

        $invoice->update([
            'tagihan_total' => $user->tagihan,
            'sub_total' => $total_subtotal
        ]);
    }

    /**
     * Restore stock when invoice is deleted.
     */
    private function restoreStock(Invoice $invoice): void
    {
        $pesanans = Pesanan::where('invoice_id', $invoice->id)->get();

        foreach ($pesanans as $pesanan) {
            $ukuran_produk = UkuranProduk::where('produk_id', $pesanan->produk_id)
                ->where('ukuran', $pesanan->ukuran)
                ->first();

            if ($ukuran_produk) {
                $ukuran_produk->stok += $pesanan->jumlah_pesanan;
                $ukuran_produk->save();
            }
        }
    }

    /**
     * Restore customer billing when invoice is deleted.
     */
    private function restoreCustomerBilling(Invoice $invoice): void
    {
        $user = $invoice->user;
        
        // Subtract the invoice total from customer's bill
        $user->tagihan -= $invoice->sub_total;
        
        // Add back any payments made
        $user->tagihan += $invoice->jumlah_bayar ?? 0;
        
        // Ensure bill doesn't go negative
        $user->tagihan = max(0, $user->tagihan);
        $user->save();
    }
}
