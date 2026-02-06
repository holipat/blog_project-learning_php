<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Mass assignment için izin verilen alanlar
    protected $fillable = ['title', 'content'];
    
    // Veya tüm alanlara izin vermek için:
    // protected $guarded = [];
}