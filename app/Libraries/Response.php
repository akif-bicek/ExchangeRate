<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Response
{
    const jwt = false;

    const OK = 200;
    const CREATED = 201; // This should be used in create operations
    const ACCEPTED = 202;
    const NOCONTENT = 204; // If there is no message as a result of successful transactions, it should be used.
    const PARITALCONTENT = 206; // Useful when you have to return a paginated list of resources.
    const BADREQUEST = 400; // The standard option for requests that fail to pass validation.
    const UNAUTH = 401;
    const FORBIDDEN = 403; // The user is authenticated, but does not have the permissions to perform an action.
    const NOTFOUND = 404;
    const SERVERERROR = 500; // If something unexpected breaks, this is what your user is going to receive.
    const UNAVAILABLE = 503;

    private static $_instance = null;

    private static function instance()
    {
        if (self::$_instance == null)
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private $_message, $_data, $_metadata, $_response, $_errors;

    public static function out($status = self::OK, $message = null, $data = null, $metadata = null, $errors = null)
    {
        self::instance()->_message = $message;
        self::instance()->_metadata = $metadata;
        self::instance()->_data = $data;
        self::instance()->_errors = $errors;

        if ($status == self::NOCONTENT)
        {
            return response(status: $status);
        }

        return response()->json(self::instance()->response(), $status);
    }

    public static function noOut($status = self::NOCONTENT)
    {
        return response(status: $status);
    }

    private function response()
    {
        $this->clearly('message', $this->_message);
        $this->clearly('data', $this->_data);
        $this->clearly('metadata', $this->_metadata);
        $this->clearly('errors', $this->_errors);

        return $this->jwt();
    }

    private function clearly($key, $value)
    {
        if ($value != null)
        {
            $this->_response[$key] = $value;
        }
    }

    private function jwt()
    {
        $privateKey = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
-----END RSA PRIVATE KEY-----
EOD;

        $publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC8kGa1pSjbSYZVebtTRBLxBz5H
4i2p/llLCrEeQhta5kaQu/RnvuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t
0tyazyZ8JXw+KgXTxldMPEL95+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4
ehde/zUxo6UvS7UrBQIDAQAB
-----END PUBLIC KEY-----
EOD;
        if ($this->convertCheck())
        {
            $this->_response = JWT::encode($this->_response, $privateKey, 'RS256');
        }

        return $this->_response;
    }

    private function convertCheck()
    {
        if (environment() == 'product')
        {
            return true;
        }
        elseif (environment() == 'dev' && self::jwt == true)
        {
            return true;
        }
        elseif (environment() == 'test' && self::jwt == true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
