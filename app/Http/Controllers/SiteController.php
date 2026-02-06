<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        return 'Ana Sayfa';
    }
    
    public function hakkimizda()
    {
        return 'Hakkımızda Sayfası';
    }

    public function anasayfa()
{
    $data = [
        'isim' => 'Ahmet',
        'meslek' => 'Yazılım Geliştirici'
    ];
    return view('sayfalar.anasayfa', $data);
}
}
