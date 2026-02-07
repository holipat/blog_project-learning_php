<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass assignment için izin verilen alanlar
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'title', 'content', 'image'];

    /**
     * Veritabanında cast edilecek atribütler
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Bu yazının sahibi olan kullanıcıyı döndür
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}