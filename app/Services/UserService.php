<?php

namespace App\Services;
use App\Models\Users;

class UserService
{
    public function filter($filters)
    {

        $query = Users::query();
        if(!empty($filters['name'])){
            $query->where('name','like', '%'.$filters['name'].'%');
        }
        if(isset($filters['status'])){
            $query->where('status', $filters['status']);
        }
        if(isset($filters['gender'])) {
            $query->where('gender', $filters['gender'] );
        }
        return $query->paginate(5);
    }
}