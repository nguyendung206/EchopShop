<?php

namespace App\Services;

use App\Models\Term;
use Exception;

class TermService
{
    public function index($request)
    {
        $query = Term::query();
        if (! empty($request->search)) {
            $query->where('description', 'like', '%'.$request->search.'%');
        }
        if (isset($request->status)) {
            $query->where('status', $request->status);
        }

        return $query->paginate(10);
    }

    public function store($request)
    {
        $termData = [
            'description' => $request->description,
            'status' => $request->status,
        ];

        return Term::create($termData);
    }

    public function update($request, $id)
    {
        $term = Term::findOrFail($id);

        $termData = [
            'description' => $request->description,
            'status' => $request->status,
        ];
        $term->update($termData);

        return $term;
    }

    public function destroy($id)
    {
        try {
            $term = Term::findOrFail($id);
            $check = $term->delete();

            return $check;
        } catch (Exception $e) {
            return false;
        }
    }
}
