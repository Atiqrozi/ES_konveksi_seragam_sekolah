<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class Pesanan_Export_Excel implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $timestamp;

    public function __construct()
    {
        $this->timestamp = now()->format('Y-m-d_H-i-s');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Invoice',
            'Nama Customer',
            'Total Transaksi',
            'Created At',   
            'Updated At'            
        ];
    }

    public function map($invoice): array
    {
        return [
            $invoice->id,
            $invoice->invoice,
            $invoice->user->nama,
            $invoice->sub_total,
            $invoice->created_at,
            $invoice->updated_at,
        ];
    }

    public function collection()
    {
        if (auth()->user()->hasRole('Sales')) {
            return Invoice::where('customer_id', Auth::user()->id)->get();
        }
        
        else {
            return Invoice::all();
        }
    }

    public function title(): string
    {
        return 'Invoice - ' . $this->timestamp;
    }
}
