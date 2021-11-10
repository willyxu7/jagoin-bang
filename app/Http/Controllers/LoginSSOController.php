<?php

namespace App\Http\Controllers;

use App\Services\LoginSSOService;
use Illuminate\Http\Request;

class LoginSSOController extends Controller
{

    public function __construct(private LoginSSOService $loginSSOService)
    {
    }

    public function index(Request $request)
    {
        $this->loginSSOService->loginSSO($request->toArray());

        return redirect()->route('dashboard');
    }

}
