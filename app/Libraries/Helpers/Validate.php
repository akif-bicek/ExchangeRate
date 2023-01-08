<?php


use App\Libraries\Response;
use Illuminate\Support\Facades\Validator;

if (!function_exists('validations'))
{
    function validations($request, $rules)
    {
        $validator = Validator::make($request, $rules);
        if ($validator->fails())
        {
            $fails = array_values($validator->getMessageBag()->toArray())[0];
            return Response::out(status: Response::BADREQUEST, errors: $fails);
        }
    }
}
