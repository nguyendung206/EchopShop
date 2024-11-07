<?php

namespace App\Http\Controllers\web;

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
        $path = $request->path();
        $contents = $this->staticContentService->getStaticContentHome($path);

        return view('web.staticContent.staticPage', ['contents' => $contents, 'type' => $path]);
    }
}
