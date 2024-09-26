<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Pastikan controller ini di-extend
use App\Models\Post; // Sesuaikan model yang digunakan
{
    // Mengambil semua data
    public function index()
    {
        return Post::all();
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::create($request->all());

        return response()->json($post, 201);
    }

    // Mengambil data berdasarkan id
    public function show($id)
    {
        return Post::findOrFail($id);
    }

    // Mengupdate data
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update($request->all());

        return response()->json($post, 200);
    }

    // Menghapus data
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(null, 204);
    }
}

