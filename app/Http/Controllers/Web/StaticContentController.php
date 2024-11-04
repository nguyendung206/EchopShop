<?php

namespace App\Http\Controllers\web;

use App\Enums\TypeStaticContent;
use App\Http\Controllers\Controller;
use App\Services\StaticContentService;
use Illuminate\Http\Request;

class StaticContentController extends Controller
{
    protected $staticContentService;

    public function __construct(StaticContentService $staticContentService)
    {
        $this->staticContentService = $staticContentService;
    }

    public function getStaticContentHome(Request $request)
    {
        $type = null;
        $currentUrl = $request->url();
        switch (true) {
            case stripos($currentUrl, 'seller-guide') !== false:
                $type = TypeStaticContent::SELLER_GUIDE;
                break;
            case stripos($currentUrl, 'become-seller') !== false:
                $type = TypeStaticContent::BECOME_SELLER;
                break;
            case stripos($currentUrl, 'faq') !== false:
                $type = TypeStaticContent::FAQ;
                break;
            case stripos($currentUrl, 'buyer-protection-policy') !== false:
                $type = TypeStaticContent::BUYER_PROTECTION_POLICY;
                break;
            case stripos($currentUrl, 'feedback') !== false:
                $type = TypeStaticContent::FEEDBACK;
                break;
            case stripos($currentUrl, 'operation-rules') !== false:
                $type = TypeStaticContent::OPERATION_RULES;
                break;
            case stripos($currentUrl, 'dispute-resolution-policy') !== false:
                $type = TypeStaticContent::DISPUTE_RESOLUTION_POLICY;
                break;
            case stripos($currentUrl, 'about-us') !== false:
                $type = TypeStaticContent::ABOUT_US;
                break;
            case stripos($currentUrl, 'contact-us') !== false:
                $type = TypeStaticContent::CONTACT_US;
                break;
            case stripos($currentUrl, 'register') !== false:
                $type = TypeStaticContent::REGISTER;
                break;
            case stripos($currentUrl, 'login') !== false:
                $type = TypeStaticContent::LOGIN;
                break;
            case stripos($currentUrl, 'favourite') !== false:
                $type = TypeStaticContent::FAVOURITE;
                break;
            case stripos($currentUrl, 'message') !== false:
                $type = TypeStaticContent::MESSAGE;
                break;
            case stripos($currentUrl, 'security') !== false:
                $type = TypeStaticContent::SECURITY;
                break;
            case stripos($currentUrl, 'term') !== false:
                $type = TypeStaticContent::TERM;
                break;
            case stripos($currentUrl, 'prohibited') !== false:
                $type = TypeStaticContent::PROHIBITED;
                break;
            case stripos($currentUrl, 'communicate') !== false:
                $type = TypeStaticContent::COMMUNICATE;
                break;
            case stripos($currentUrl, 'safe-to-use') !== false:
                $type = TypeStaticContent::SAFETOUSE;
                break;
            default:
                break;
        }
        $contents = $this->staticContentService->getStaticContentHome($type);

        return view('web.staticContent.staticPage', ['contents' => $contents, 'type' => $type->value]);
    }
}
