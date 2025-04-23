<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prayer Times & Daily Verse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f3f6f9;
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            border-radius: 16px;
        }
        .card-header {
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }
        .verse-text {
            font-size: 28px;
            font-weight: 500;
            color: #2c3e50;
        }
        .verse-translation {
            font-style: italic;
            color: #6c757d;
        }
        .btn-refresh {
            border-radius: 20px;
            padding: 6px 18px;
        }
    </style>
</head>
<body>

<div class="container my-5">
    {{-- Prayer Times Card --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-1">🕌 Prayer Times</h3>
            <small>{{ $kota ?? 'Unknown City' }} - {{ \Carbon\Carbon::parse($tanggal ?? now())->translatedFormat('l, d F Y') }}</small><br>
            @if(isset($tanggalHijriah['hijri']))
                <small>Hijri: {{ $tanggalHijriah['hijri']['date'] }} ({{ $tanggalHijriah['hijri']['month']['en'] }} {{ $tanggalHijriah['hijri']['year'] }} AH)</small>
            @endif
        </div>
        <div class="card-body">
            <div class="row text-center">
                @foreach ($jadwal ?? [] as $name => $time)
                    <div class="col-6 col-md-4 my-2">
                        <div class="bg-light p-3 rounded shadow-sm">
                            <strong class="d-block text-capitalize">{{ $name }}</strong>
                            <span class="text-dark">{{ $time }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('jadwal-sholat') }}" class="btn btn-sm btn-outline-primary btn-refresh">🔄 Refresh Times</a>
        </div>
    </div>

    {{-- Daily Verse Card --}}
    <div class="card shadow">
        <div class="card-header bg-success text-white text-center">
            <h4 class="mb-0">📖 Daily Qur'anic Verse</h4>
        </div>
        <div class="card-body text-center">
            @if(isset($ayat))
                <h5 class="mb-3">Surah {{ $ayat['surah']['englishName'] ?? 'Unknown Surah' }} (Verse {{ $ayat['numberInSurah'] ?? '-' }})</h5>
                <p class="verse-text">{{ $ayat['text'] ?? '-' }}</p>
                <p class="verse-translation mt-3">{{ $terjemahan['text'] ?? 'Translation not available' }}</p>
            @else
                <p class="text-danger">No verse available today.</p>
            @endif
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('jadwal-sholat') }}" class="btn btn-outline-success btn-refresh">🔁 New Verse</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
