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
            'content' => 'required|min:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // 2MB'a kadar
        ], [
            'title.required' => 'Başlık alanı zorunludur.',
            'title.min' => 'Başlık en az 3 karakter olmalıdır.',
            'content.required' => 'İçerik alanı zorunludur.'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
        }
        
        // 2. Veritabanına kaydet
        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath // null veya 'images/xxx.jpg'
        ]);
        
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
            'content' => 'required|min:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
            
            // Post'un image alanını güncelle
            $post->image = $imagePath;
        } else {
            // Eğer yeni resim yüklenmediyse, mevcut resmi koru
            $post->image = $post->image; // Bu satır aslında gereksiz, sadece açıklama için
        }
        
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();
        
        return redirect()->route('posts.index')
                         ->with('success', 'Blog yazısı güncellendi!');
    }

    /**
 * Sadece resmi sil (post'u değil)
 */
    public function deleteImage(Post $post)
    {
        // 1. Resim var mı kontrol et
        if (!$post->image) {
            return redirect()->back()
                ->with('error', 'Bu gönderide silinecek resim bulunamadı.');
        }
        
        // 2. Fiziksel dosyayı sil
        $imagePath = public_path($post->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        
        // 3. Veritabanındaki image alanını NULL yap
        $post->image = null;
        $post->save();
        
        // 4. Geri dön ve başarı mesajı göster
        return redirect()->back()
            ->with('success', 'Resim başarıyla silindi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->image) {
            $imagePath = public_path($post->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        $post->delete();
        
        return redirect()->route('posts.index')
                         ->with('success', 'Blog yazısı silindi!');
    }
}
