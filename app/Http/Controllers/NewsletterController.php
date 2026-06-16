<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:subscribers,email',
            'name' => 'nullable|string|max:100',
        ]);
        
        $subscriber = Subscriber::create($validated);
        
        // Optional: Send welcome email
        // Mail::to($subscriber->email)->send(new WelcomeNewsletterMail($subscriber));
        
        return response()->json([
            'success' => true,
            'message' => 'Successfully subscribed! Check your email for confirmation.'
        ]);
    }
}