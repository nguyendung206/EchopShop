<?php

namespace App\Http\Controllers\web;

use App\Enums\TypePolicy;
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
        $type = null;
        $currentUrl = $request->url();
        switch (true) {
            case stripos($currentUrl, 'security') !== false:
                $type = TypePolicy::SECURITY;
                break;
            case stripos($currentUrl, 'term') !== false:
                $type = TypePolicy::TERM;
                break;
            case stripos($currentUrl, 'prohibited') !== false:
                $type = TypePolicy::PROHIBITED;
                break;
            case stripos($currentUrl, 'communicate') !== false:
                $type = TypePolicy::COMMUNICATE;
                break;
            case stripos($currentUrl, 'safeToUse') !== false:
                $type = TypePolicy::SAFETOUSE;
                break;
            default:
                break;
        }
        $policies = $this->policyService->getPolicyHome($type);

        return view('web.policy.policy', compact('policies'));
    }
}
