<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['nullable', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:30'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10'],
        ]);

        // Require at least email or phone
        if (empty($validated['email']) && empty($validated['phone'])) {
            return back()
                ->withInput()
                ->withErrors(['email' => __('Vui lòng cung cấp email hoặc số điện thoại.')]);
        }

        $contact = Contact::create($validated);

        // Send email notification — silently fail so form still works if mail not configured
        try {
            $adminEmail = config('mail.admin_email', config('mail.from.address'));
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new ContactMail($contact));
            }
        } catch (\Throwable $e) {
            // Log but do not bubble — contact is already saved
            logger()->error('ContactMail failed: ' . $e->getMessage());
        }

        return back()->with('success', __('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.'));
    }
}
