<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Artikel;
use App\Models\WaktuOpenLamaran;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
    public function index()
    {
        $produk_terlaris = DB::table('pesanans')
            ->join('produks', 'pesanans.produk_id', '=', 'produks.id')
            ->select('produks.id', 'produks.nama_produk', 'produks.foto_sampul', 'produks.deskripsi_produk', DB::raw('SUM(pesanans.jumlah_pesanan) as total_terjual'))
            ->groupBy('produks.id', 'produks.nama_produk', 'produks.foto_sampul', 'produks.deskripsi_produk')
            ->orderByDesc('total_terjual')
            ->take(3)
            ->get();

        if ($produk_terlaris->isEmpty()) {
            $produk_terlaris = DB::table('produks')
                ->select('id', 'nama_produk', 'foto_sampul', 'deskripsi_produk', 'foto_lain_1', 'foto_lain_2', 'foto_lain_3', 'video')
                ->orderByDesc('created_at')
                ->take(3)
                ->get();
        }

        $recruitment = WaktuOpenLamaran::first();
        $active = $recruitment ? $recruitment->active : 0;

        return view('landing_page.home', compact('recruitment', 'active', 'produk_terlaris'));
    }

    public function kategori_produk()
    {
        $kategoris = Kategori::orderBy('id', 'desc')->paginate(9);

        $recruitment = WaktuOpenLamaran::first();
        $active = $recruitment ? $recruitment->active : 0;

        return view('landing_page.kategori_produk', compact('kategoris', 'recruitment', 'active'));
    }

    public function produk($id)
    {
        $kategori = Kategori::findOrFail($id);
        $produks = Produk::where('kategori_id', $id)->orderBy('id', 'desc')->paginate(9);

        $recruitment = WaktuOpenLamaran::first();
        $active = $recruitment ? $recruitment->active : 0;

        return view('landing_page.produk', compact('kategori', 'produks', 'active'));
    }

    public function artikel()
    {
        $artikels = Artikel::orderBy('id', 'desc')->paginate(9);

        $recruitment = WaktuOpenLamaran::first();
        $active = $recruitment ? $recruitment->active : 0;

        return view('landing_page.artikel', compact('artikels', 'recruitment', 'active'));
    }

    public function show($slug)
    {
        $artikel = Artikel::where('slug', $slug)->firstOrFail();

        $recruitment = WaktuOpenLamaran::first();
        $active = $recruitment ? $recruitment->active : 0;

        return view('landing_page.show', compact('artikel', 'recruitment', 'active'));
    }
}
