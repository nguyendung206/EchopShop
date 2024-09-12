<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function filter($filters)
    {

        $query = User::query();
        if (! empty($filters['search'])) {
            $query->where('name', 'like', '%'.$filters['search'].'%');
        }
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (isset($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }

        return $query->paginate(5);
    }
}
