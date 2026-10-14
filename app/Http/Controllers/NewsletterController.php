<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterRequest;
use App\Models\NewsletterSubscriber;

class NewsletterController extends Controller
{
    public function store(NewsletterRequest $request)
    {
        NewsletterSubscriber::updateOrCreate(['email' => strtolower($request->string('email')->toString())], ['status' => 'subscribed', 'subscribed_at' => now(), 'unsubscribed_at' => null]);
        return back()->with('success', 'Thanks — you’re on the Lunara list.');
    }
}
