<?php

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Cms\Http\Controllers\ContactStoreRequest;
use Modules\Cms\Models\Contact;

final class ContactStoreController
{
    public function __invoke(ContactStoreRequest $request): RedirectResponse
    {
        $contact = new Contact();
        $contact->type = $request->input('type', 'general');
        $contact->full_name = $request->input('full_name');
        $contact->email = $request->input('email');
        $contact->phone_number = $request->input('phone_number');
        $contact->subject = $request->input('subject');
        $contact->message = $request->input('message');
        $contact->meta = $request->input('meta', []);
        $contact->save();

        return redirect()
            ->back()
            ->with('success', 'Thank you for your message. We will get back to you within 24 hours.');
    }
}
