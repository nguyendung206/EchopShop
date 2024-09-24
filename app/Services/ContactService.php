<?php

namespace App\Services;

use App\Models\Contact;
use Exception;

class ContactService
{
    public function index($request)
    {
        $query = Contact::query();
        if (! empty($request['search'])) {
            $query->where('name', 'like', '%'.$request['search'].'%');
        }

        return $query->paginate(10);
    }

    public function destroy($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $check = $contact->delete();

            return $check;
        } catch (Exception $e) {
            return false;
        }
    }

    public function store($request)
    {
        $contactData = [
            'name' => $request['name'],
            'email' => $request['email'],
            'content' => $request['content'],
        ];

        return Contact::create($contactData);
    }
}
