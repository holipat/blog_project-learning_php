@extends('layouts.app')

@section('title', isset($post) ? 'Düzenle: ' . $post->title : 'Yeni Yazı')

@section('content')
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-6 fw-bold mb-3" style="color: var(--primary-dark);">
            <i class="bi bi-{{ isset($post) ? 'pencil-square' : 'plus-circle' }} me-2"></i>
            {{ isset($post) ? 'Yazıyı Düzenle' : 'Yeni Yazı Oluştur' }}
        </h1>
        <p class="text-muted">
            {{ isset($post) ? 'Yazınızı güncelleyin ✏️' : 'Harika fikirlerinizi paylaşın! ✨' }}
        </p>
    </div>

    <!-- Form Card -->
    <div class="cute-card">
        <div class="cute-card-body">
            <form action="{{ isset($post) ? route('posts.update', $post) : route('posts.store') }}" 
                  method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($post))
                    @method('PUT')
                @endif
                
                <!-- Title -->
                <div class="mb-4">
                    <label for="title" class="form-label fw-semibold" style="color: var(--primary-dark);">
                        <i class="bi bi-type me-2"></i>Başlık
                    </label>
                    <input type="text" 
                           class="form-control cute-form-control @error('title') is-invalid @enderror" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $post->title ?? '') }}"
                           placeholder="Yazınızın başlığını girin...">
                    @error('title')
                        <div class="invalid-feedback d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ $message }}
                        </div>
                    @enderror
                    <div class="form-text">
                        <i class="bi bi-info-circle me-1"></i>Dikkat çekici ve açıklayıcı bir başlık seçin.
                    </div>
                </div>
                
                <!-- Content -->
                <div class="mb-4">
                    <label for="content" class="form-label fw-semibold" style="color: var(--primary-dark);">
                        <i class="bi bi-text-paragraph me-2"></i>İçerik
                    </label>
                    <textarea class="form-control cute-form-control @error('content') is-invalid @enderror" 
                              id="content" 
                              name="content" 
                              rows="8"
                              placeholder="Yazınızın içeriğini buraya yazın...">{{ old('content', $post->content ?? '') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- Image -->
                <div class="mb-5">
                    <label for="image" class="form-label fw-semibold" style="color: var(--primary-dark);">
                        <i class="bi bi-image me-2"></i>Resim (Opsiyonel)
                    </label>
                    
                    <!-- Current Image Preview -->
                    @if(isset($post) && $post->image)
                        <div class="mb-3">
                            <div class="d-flex align-items-center bg-light rounded p-3" style="border: 2px dashed var(--primary-light);">
                                <div class="me-3">
                                    <img src="{{ asset($post->image) }}" 
                                         alt="Mevcut resim" 
                                         class="rounded"
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Mevcut Resim</h6>
                                    <p class="text-muted small mb-2">{{ basename($post->image) }}</p>
                                    <div class="d-flex gap-2">
                                        <a href="{{ asset($post->image) }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-cute-secondary">
                                            <i class="bi bi-eye me-1"></i>Görüntüle
                                        </a>
                                        <form action="{{ route('posts.delete-image', $post) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-cute-danger"
                                                    onclick="return confirm('Sadece resmi silmek istediğinize emin misiniz?')">
                                                <i class="bi bi-trash me-1"></i>Resmi Sil
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="form-text mt-2">
                                <i class="bi bi-arrow-up-circle me-1"></i>
                                Yeni bir resim yüklerseniz, mevcut resim değiştirilecektir.
                            </div>
                        </div>
                    @endif
                    
                    <!-- File Input -->
                    <input type="file" 
                           class="form-control cute-form-control @error('image') is-invalid @enderror" 
                           id="image" 
                           name="image" 
                           accept="image/*">
                    @error('image')
                        <div class="invalid-feedback d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ $message }}
                        </div>
                    @enderror
                    <div class="form-text">
                        <i class="bi bi-info-circle me-1"></i>
                        JPEG, PNG, JPG, GIF formatları. Maksimum 2MB.
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="d-flex justify-content-between align-items-center pt-4 border-top" 
                     style="border-color: rgba(157, 123, 255, 0.1) !important;">
                    <div>
                        <a href="{{ route('posts.index') }}" class="btn-cute-secondary">
                            <i class="bi bi-x-circle me-2"></i>İptal
                        </a>
                    </div>
                    
                    <div>
                        <button type="submit" class="btn-cute-primary">
                            <i class="bi bi-{{ isset($post) ? 'save' : 'plus-circle' }} me-2"></i>
                            {{ isset($post) ? 'Güncelle' : 'Oluştur' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection