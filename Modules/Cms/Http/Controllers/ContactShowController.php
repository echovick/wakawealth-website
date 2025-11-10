<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Modules\Cms\Models\Contact;

/**
 * @author WakaWealth Development Team
 */
final class ContactShowController
{
    /**
     * Display the specified contact.
     */
    public function __invoke(Contact $contact): Response
    {
        return Inertia::render('Cms/Contacts/Show', [
            'contact' => $contact,
        ]);
    }
}
