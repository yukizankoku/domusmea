<?php

namespace App\Http\Controllers;

use App\Models\Compro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('about.contact');
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email:dns',
            'message' => 'required|string|min:10',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'userMessage' => $request->message,
        ];

        // dd($data); // Ini untuk memeriksa isi data

        Mail::send('about.mail', $data, function ($message) {
            $message->to('domusmea.id@gmail.com')
                    ->subject('New Contact Form Submission');
        });

        // Mail::raw("Name: {$request->name}\nEmail: {$request->email}\nMessage: {$request->message}", function ($message) {
        //     $message->to('damar728@gmail.com')
        //             ->subject('New Contact Form Submission');
        // });

        return redirect()->back()->with('success', 'Email sent successfully!');
    }
}
