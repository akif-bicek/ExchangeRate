<?php
namespace App\Libraries;

use Illuminate\Support\Facades\Validator;

class validate
{
    private $_request;
    private $_rules;
    private $_response;
    private bool $_fails = false;

    public function __construct($request, $rules)
    {
        $this->_request = $request;
        $this->_rules = $rules;

        $validator = Validator::make($request, $rules);
        if ($validator->fails())
        {
            $this->_fails = true;
            $fails = array_values($validator->getMessageBag()->toArray())[0];
            $this->_response = Response::out(
                status: Response::BADREQUEST,
                errors: $fails
            );
        }
    }

    public function response()
    {
        return $this->_response;
    }

    public function fails()
    {
        return $this->_fails;
    }
}
