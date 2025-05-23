<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        
        // Kirim email
        Mail::to('leafguardtomato@gmail.com')->send(new ContactFormMail($validated));
        
        return response()->json([
            'success' => true,
            'message' => 'Pesan Anda telah berhasil dikirim! Kami akan segera menghubungi Anda.'
        ]);
    }
}