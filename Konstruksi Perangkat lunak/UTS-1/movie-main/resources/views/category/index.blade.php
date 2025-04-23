@extends('layout.template')

@section('title', 'Data Kategori')

@section('content')

<h1>Data-Movie</h1>
<table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Nama Kategori</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
        <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $category->nama_kategori }}</td>
            <td>{{ $category->keterangan }}</td>
            <td class="text-nowrap">
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
                <form action="/categories/{{ $category->id }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
    <div class="d-flex justify-content-center">
        {{ $categories->links() }}
    </div>
@endsection
