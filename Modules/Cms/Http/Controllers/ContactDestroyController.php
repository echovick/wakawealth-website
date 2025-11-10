<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Cms\Models\Contact;

/**
 * @author WakaWealth Development Team
 */
final class ContactDestroyController
{
    /**
     * Remove the specified contact from storage.
     */
    public function __invoke(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()
            ->route('cms.contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }
}
