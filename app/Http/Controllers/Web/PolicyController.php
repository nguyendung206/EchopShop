<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Policy;
use App\Services\PolicyService;

class PolicyController extends Controller
{
    protected $policyService;

    public function __construct(PolicyService $policyService)
    {
        $this->policyService = $policyService;
    }

    public function getPolicy(Request $request) {
            $policies = $this->policyService->getPolicyHome($request);
            return view('web.policy.policy', compact('policies'));
    }
}
