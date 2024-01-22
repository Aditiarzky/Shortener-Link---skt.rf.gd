<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;

class UrlController extends Controller
{
    public function shorten(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
        ]);

        $originalUrl = $request->input('original_url');
        $customCode = $request->input('custom_code');

        $shortUrl = $this->generateShortUrl($customCode);

        Url::create([
            'original_url' => $originalUrl,
            'short_url' => $shortUrl,
        ]);

        return redirect('/')->with('shortUrl', $shortUrl);
    }

    public function showForm()
    {
    $existingCustomCodes = Url::pluck('short_url')->toArray();
    return view('welcome', ['existingCustomCodes' => $existingCustomCodes]);
    }

    public function redirect($short)
    {
        $url = Url::where('short_url', $short)->firstOrFail();
        return redirect($url->original_url);
    }

    private function generateShortUrl($customCode = null)
    {
        $prefix = ''; // Anda dapat menambahkan awalan khusus jika diinginkan

        // Gunakan bagian kustom jika disediakan, jika tidak, gunakan random
        $shortUrl = $prefix . ($customCode ?? base_convert(uniqid(), 16, 36));

        // Periksa keunikan bagian kustom
        while (Url::where('short_url', $shortUrl)->exists()) {
            // Jika bagian kustom sudah ada, tambahkan karakter acak tambahan
            $shortUrl .= substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 1);
        }

        return $shortUrl;
    }
}
