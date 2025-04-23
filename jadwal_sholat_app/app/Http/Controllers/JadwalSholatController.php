<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class JadwalSholatController extends Controller
{
    public function showJadwalSholat()
    {
        $tanggal = Carbon::now()->format('d-m-Y');
        $kota = 'Padang';
        $country = 'Indonesia';
        $method = 11;

        // Ambil jadwal sholat
        $resJadwal = Http::get("http://api.aladhan.com/v1/timingsByCity/{$tanggal}?city={$kota}&country={$country}&method={$method}");

        // Ayat random dari 1-6236
        $randomAyah = rand(1, 6236);

        // Ambil ayat asli & terjemahan
        $resAyat = Http::get("http://api.alquran.cloud/v1/ayah/random");

        $surahNumber = $resAyat['data']['surah']['number'];
        $ayatInSurah = $resAyat['data']['numberInSurah'];
        $resTerjemahan = Http::get("http://api.alquran.cloud/v1/ayah/{$surahNumber}:{$ayatInSurah}/en.asad");

        if ($resJadwal->successful() && $resAyat->successful() && $resTerjemahan->successful()) {
            $jadwal = $resJadwal['data']['timings'];
            $tanggalHijriah = $resJadwal['data']['date'];
            $ayat = $resAyat->json('data');
            $terjemahan = $resTerjemahan->json('data');

            return view('jadwal', [
                'tanggal' => $tanggal,
                'kota' => $kota,
                'jadwal' => $jadwal,
                'tanggalHijriah' => $tanggalHijriah,
                'ayat' => $ayat,
                'terjemahan' => $terjemahan,
            ]);
        } else {
            return view('jadwal')->with('error', 'Failed to retrieve data from the APIs.');
        }
    }
}
