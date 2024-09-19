<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Services\PolicyService;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    protected $policyService;

    public function __construct(PolicyService $policyService)
    {
        $this->policyService = $policyService;
    }

    public function getPolicy(Request $request)
    {
        $policies = $this->policyService->getPolicyHome($request);

        return view('web.policy.policy', compact('policies'));
    }
}
