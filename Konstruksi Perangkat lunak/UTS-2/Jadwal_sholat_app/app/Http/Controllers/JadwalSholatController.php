<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class JadwalSholatController extends Controller
{
    public function showJadwalSholat(){
        $tanggal = Carbon::now()->format('d-m-Y');
        $kota = 'Padang';
        $country = 'Indonesia';
        $method = 11;
    
        // Jadwal sholat
        $resJadwal = Http::get("http://api.aladhan.com/v1/timingsByCity/{$tanggal}?city={$kota}&country={$country}&method={$method}");
    
        // Ayat random
        $resAyat = Http::get("http://api.alquran.cloud/v1/ayah/random");
        // dd([$resAyat]);  
        if ($resJadwal->successful() && $resAyat->successful()) {
            $jadwal = $resJadwal['data']['timings'];
            $tanggalHijriah = $resJadwal['data']['date'];
    
            $ayat = $resAyat['data'];
            $surahNumber = $ayat['surah']['number'];
            $ayatInSurah = $ayat['numberInSurah'];
    
            // Ambil terjemahan
            $resTerjemahan = Http::get("http://api.alquran.cloud/v1/ayah/{$surahNumber}:{$ayatInSurah}/en.asad");
            $terjemahan = $resTerjemahan;
    
            return view('jadwal', [
                'tanggal' => $tanggal,
                'kota' => $kota,
                'jadwal' => $jadwal,
                'tanggalHijriah' => $tanggalHijriah,
                'ayat' => $ayat,
                'terjemahan' => $terjemahan,
            ]);
        } else {
            return view('jadwal')->with('error', 'Gagal mengambil data dari API.');
        }
    }
}
