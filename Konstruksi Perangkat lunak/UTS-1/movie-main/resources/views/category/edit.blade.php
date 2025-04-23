@extends('layout.template')  
@section('title', 'Input Data Movie')  
@section('content')
<a href="{{ route('categories.index') }}" class="btn btn-primary mt-4">List Ketegori</a>
<h2 class="mb-4">Tambah Movie Baru</h2>
<form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="mb-3">
        <label for="nama_kategori" class="form-label">Nama Kategori:</label>
        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required="" value="{{ $category->nama_kategori }}">
    </div>
    <div class="mb-3">
        <label for="keterangan" class="form-label">keterangan:</label>
        <input type="text" class="form-control" id="keterangan" name="keterangan" required="" value="{{ $category->keterangan }}">
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
@endsection