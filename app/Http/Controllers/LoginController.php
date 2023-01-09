<?php

namespace App\Http\Controllers;

use App\Libraries\Response;
use App\Libraries\validate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $validator = new Validate(
            $request->all(),
            $user->rules['login']
        );

        if ($validator->fails())
        {
            return $validator->response();
        }

        if ($user)
        {
            if (Hash::check($request->password, $user->password))
            {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                return Response::out(
                    message: 'Login Successful',
                    data: [
                        'token' => $token->token
                    ]
                );
            }
            else
            {
                return Response::out(
                    status: Response::UNPROCESSABLEENTITIY,
                    message: 'Password mismatch'
                );
            }
        }
        else
        {
            return Response::out(
                status: Response::UNPROCESSABLEENTITIY,
                message: 'User does not exist'
            );
        }
    }
}
