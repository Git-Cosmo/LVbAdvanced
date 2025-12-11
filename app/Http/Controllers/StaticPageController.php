<?php

namespace App\Http\Controllers;

use App\Services\SeoService;
use Illuminate\View\View;

class StaticPageController extends Controller
{
    protected $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    /**
     * Display the terms of service page.
     */
    public function terms(): View
    {
        $this->seoService->generateMetaTags([
            'title' => 'Terms of Service - FPSociety',
            'description' => 'Read our terms of service and user agreement for FPSociety gaming community.',
        ]);

        return view('static.terms');
    }

    /**
     * Display the privacy policy page.
     */
    public function privacy(): View
    {
        $this->seoService->generateMetaTags([
            'title' => 'Privacy Policy - FPSociety',
            'description' => 'Learn how FPSociety collects, uses, and protects your personal information.',
        ]);

        return view('static.privacy');
    }

    /**
     * Display the contact us page.
     */
    public function contact(): View
    {
        $this->seoService->generateMetaTags([
            'title' => 'Contact Us - FPSociety',
            'description' => 'Get in touch with the FPSociety team. We\'re here to help with questions and support.',
        ]);

        return view('static.contact');
    }

    /**
     * Handle contact form submission.
     */
    public function sendContact(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|in:general,support,abuse,feedback,partnership,other',
            'message' => 'required|string|max:5000',
        ]);

        // Log the contact form submission (without PII)
        \Illuminate\Support\Facades\Log::info('Contact form submission', [
            'subject' => $validated['subject'],
            'timestamp' => now()->toDateTimeString(),
        ]);

        // In a production environment, you would send an email here
        // For now, we'll just redirect back with a success message

        return back()->with('success', 'Thank you for your message! We\'ll get back to you as soon as possible.');
    }
}
