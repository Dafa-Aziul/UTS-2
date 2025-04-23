@extends('layout.template')  
@section('title', 'Input Data Movie')  
@section('content')
<a href="{{ route('categories.index') }}" class="btn btn-primary mt-4">List Ketegori</a>
<h2 class="mb-4">Tambah Movie Baru</h2>
<form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="nama_kategori" class="form-label">Nama Kategori:</label>
        <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}" required="">
        @error('nama_kategori')
            <div class="invalid-feedback">{{ $message }}</div>
            
        @enderror
    </div>
    <div class="mb-3">
        <label for="keterangan" class="form-label">keterangan:</label>
        <input type="text" class="form-control @error('keterangan') is-invalid @enderror" value="{{ old('keterangan') }}" class="form-control" id="keterangan" name="keterangan" required="">
        @error('keterangan')
            <div class="invalid-feedback">{{ $message }}</div>
            
        @enderror
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
@endsection