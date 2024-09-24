<?php

namespace App\Services;

use App\Enums\Status;
use App\Models\Policy;
use Exception;

class PolicyService
{
    public function index($request)
    {
        $query = Policy::query();
        if (! empty($request['search'])) {
            $query->where('description', 'like', '%'.$request['search'].'%');
        }
        if (isset($request['status'])) {
            $query->where('status', $request['status']);
        }

        return $query->paginate(10);
    }

    public function store($request)
    {
        $policyData = [
            'description' => $request['description'],
            'status' => $request['status'],
            'type' => $request['type'],
        ];

        return Policy::create($policyData);
    }

    public function update($request, $id)
    {
        $policy = Policy::findOrFail($id);

        $policyData = [
            'description' => $request['description'],
            'status' => $request['status'],
            'type' => $request['type'],
        ];
        $policy->update($policyData);

        return $policy;
    }

    public function destroy($id)
    {
        try {
            $policy = Policy::findOrFail($id);
            $check = $policy->delete();

            return $check;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getPolicyHome($request, $type)
    {
        $policies = Policy::query()->where('status', Status::ACTIVE)->where('type', $type)->get();
        return $policies;
    }
}
