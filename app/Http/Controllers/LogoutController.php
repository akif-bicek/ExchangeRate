<?php

namespace App\Http\Controllers;

use App\Libraries\Response;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return Response::out(message: 'You have been successfully logged out!');
    }
}
