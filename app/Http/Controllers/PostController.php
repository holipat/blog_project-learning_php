<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Tüm blog yazılarını listele (pagination ile)
     */
    public function index()
    {
        $posts = Post::with('user')
            ->latest()
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Yeni yazı oluşturma formunu göster
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Yeni yazıyı veritabanına kaydet
     */
    public function store(Request $request)
    {
        // Validasyon
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'content' => ['required', 'string', 'min:10'],
            'image' => ['nullable', 'image', 'max:2048', 'mimes:jpeg,png,jpg,gif,webp'],
        ]);

        // Resim yüklenirse işle
        if ($request->hasFile('image')) {
            $imagePath = $this->storeImage($request->file('image'));
            $validated['image'] = $imagePath;
        }

        // Mevcut kullanıcıyı ata (test için default 1)
        $validated['user_id'] = auth()->id() ?? 1;

        // Veritabanına kaydet
        Post::create($validated);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Blog yazısı başarıyla oluşturuldu!');
    }

    /**
     * Blog yazısını ayrıntılarıyla göster
     */
    public function show(Post $post)
    {
        // Önceki yazıyı bul
        $previous = Post::where('id', '<', $post->id)
            ->orderBy('id', 'desc')
            ->first();

        // Sonraki yazıyı bul
        $next = Post::where('id', '>', $post->id)
            ->orderBy('id', 'asc')
            ->first();

        return view('posts.show', compact('post', 'previous', 'next'));
    }

    /**
     * Yazı düzenleme formunu göster
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Yazıyı güncelle
     */
    public function update(Request $request, Post $post)
    {

        // Validasyon
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'content' => ['required', 'string', 'min:10'],
            'image' => ['nullable', 'image', 'max:2048', 'mimes:jpeg,png,jpg,gif,webp'],
        ]);

        // Eğer yeni resim yüklendiyse
        if ($request->hasFile('image')) {
            // Eski resmi sil
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            // Yeni resmi kaydet
            $imagePath = $this->storeImage($request->file('image'));
            $validated['image'] = $imagePath;
        }

        // Yazıyı güncelle
        $post->update($validated);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Blog yazısı başarıyla güncellendi!');
    }

    /**
     * Sadece yazının resmini sil
     */
    public function deleteImage(Post $post)
    {
        // Resim var mı kontrol et
        if (!$post->image) {
            return redirect()
                ->back()
                ->with('error', 'Bu yazıda silinecek resim bulunamadı.');
        }

        // Resmi sil
        Storage::disk('public')->delete($post->image);

        // Veritabanında NULL yap
        $post->update(['image' => null]);

        return redirect()
            ->back()
            ->with('success', 'Resim başarıyla silindi.');
    }

    /**
     * Yazıyı sil
     */
    public function destroy(Post $post)
    {
        // Resmi sil
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        // Yazıyı sil (soft delete)
        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Blog yazısı başarıyla silindi!');
    }

    /**
     * Resmi Storage'a kaydet ve yolunu döndür
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @return string|null
     */
    private function storeImage($image): ?string
    {
        if (!$image) {
            return null;
        }

        $fileName = Str::random(32) . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('posts', $fileName, 'public');

        return $path;
    }
}
