<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->get(); // latest() = en yeni en üstte
        
        // posts.index view'ını göster, posts değişkenini gönder
        return view('posts.index', compact('posts'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasyon (doğrulama)
        $request->validate([
            'title' => 'required|min:3|max:100',
            'content' => 'required|min:10'
        ], [
            'title.required' => 'Başlık alanı zorunludur.',
            'title.min' => 'Başlık en az 3 karakter olmalıdır.',
            'content.required' => 'İçerik alanı zorunludur.'
        ]);
        
        // 2. Veritabanına kaydet
        Post::create($request->all());
        
        // 3. Kullanıcıyı blog listesine yönlendir
        return redirect()->route('posts.index')
                         ->with('success', 'Blog yazısı başarıyla eklendi!');
    }

    /**
     * Display the specified resource.
     */
   public function show(Post $post)  // Route Model Binding
{
    // $post otomatik olarak ID'sine göre bulunur
    return view('posts.show', compact('post'));
}

    /**
     * Show the form for editing the specified resource.
     */
public function edit(Post $post)
{
    // Düzenleme formunu göster, içine mevcut veriyi doldur
    return view('posts.edit', compact('post'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {

        $request->validate([
            'title' => 'required|min:3|max:100',
            'content' => 'required|min:10'
        ]);
        
        $post->update($request->all());
        
        return redirect()->route('posts.index')
                         ->with('success', 'Blog yazısı güncellendi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        
        return redirect()->route('posts.index')
                         ->with('success', 'Blog yazısı silindi!');
    }
}
