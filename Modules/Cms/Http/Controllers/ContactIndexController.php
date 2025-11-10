<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Contact;

/**
 * @author WakaWealth Development Team
 */
final class ContactIndexController
{
    /**
     * Display a listing of contacts.
     */
    public function __invoke(): Response
    {
        $contacts = Contact::query()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Cms/Contacts/Index', [
            'contacts' => $contacts,
        ]);
    }
}
