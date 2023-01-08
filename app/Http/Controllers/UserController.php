<?php

namespace App\Http\Controllers;

use App\Libraries\Response;
use App\Libraries\validate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $user = new User();
        $validator = new Validate(
            $request->all(),
            $user->rules['register']
        );

        if ($validator->fails())
        {
            return $validator->response();
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if ($user->save())
        {
            return Response::out(
                status: Response::CREATED,
                message: 'Register Successful'
            );
        }
        else
        {
            return Response::out(
                status: Response::SERVERERROR,
                message: 'Register Unsuccessful. Please Try Again!'
            );
        }
    }
}
