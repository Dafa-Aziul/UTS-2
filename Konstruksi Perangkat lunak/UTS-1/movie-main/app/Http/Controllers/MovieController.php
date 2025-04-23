<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;

class MovieController extends Controller
{

    public function index()
    {

        $query = Movie::latest();
        if (request('search')) {
            $query->where('judul', 'like', '%' . request('search') . '%')
                ->orWhere('sinopsis', 'like', '%' . request('search') . '%');
        }
        $movies = $query->paginate(6)->withQueryString();
        return view('homepage', compact('movies'));
    }

    public function detail($id)
    {
        $movie = Movie::find($id);
        return view('detail', compact('movie'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('input', compact('categories'));
    }

    public function store(StoreMovieRequest $request)
    {
        // Ambil data yang sudah tervalidasi
        $validated = $request->validated();

        // Simpan file foto jika ada
        if ($request->hasFile('foto_sampul')) {
            $validated['foto_sampul'] = $request->file('foto_sampul')->store('movie_covers', 'public');
        }

        // Simpan data ke database
        Movie::create($validated);

        return redirect('/')->with('success', 'Data berhasil disimpan');
    }

    public function data()
    {
        $movies = Movie::latest()->paginate(10);
        return view('data-movies', compact('movies'));
    }

    public function form_edit($id)
    {
        $movie = Movie::find($id);
        $categories = Category::all();
        return view('form-edit', compact('movie', 'categories'));
    }

    public function update(UpdateMovieRequest $request, $id)
    {
        $validated= $request->validated();
        // Validasi data
        // Ambil data movie yang akan diupdate
        $movie = Movie::findOrFail($id);

        // Jika ada file yang diunggah, simpan file baru
        if ($request->hasFile('foto_sampul')) {
            $randomName = Str::uuid()->toString();
            $fileExtension = $request->file('foto_sampul')->getClientOriginalExtension();
            $fileName = $randomName . '.' . $fileExtension;

            // Simpan file foto ke folder public/images
            $path = $request->file('foto_sampul')->storeAs('movie_covers', $fileName, 'public');
            $validated['foto_sampul'] = $path;
            // Hapus foto lama jika ada
            if ($movie->foto_sampul && Storage::disk('public')->exists($movie->foto_sampul)) {
                // Menghapus file lama jika ada
                Storage::disk('public')->delete($movie->foto_sampul);
            }

            // Update record di database dengan foto yang baru
            $movie->update($validated);
        } else {
            // Jika tidak ada file yang diunggah, update data tanpa mengubah foto
            $movie->update($validated);
        }

        return redirect('/movies/data')->with('success', 'Data berhasil diperbarui');
    }

    public function delete($id)
    {
        $movie = Movie::findOrFail($id);

        // Delete the movie's photo if it exists
        if (File::exists(public_path('images/' . $movie->foto_sampul))) {
            File::delete(public_path('images/' . $movie->foto_sampul));
        }

        // Delete the movie record from the database
        $movie->delete();

        return redirect('/movies/data')->with('success', 'Data berhasil dihapus');
    }
}
