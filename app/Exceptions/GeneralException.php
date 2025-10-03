<?php

namespace App\Exceptions;

use Exception;

class GeneralException extends Exception
{
    protected $code;
    protected $message;

    public function __construct($message = "General Exception", $code = 500){
        $this->code = $code;
        $this->message = $message;
    }

    public function render(){
        return response()->json([
            "status_code" => $this->code,
            "message" => $this->message,
            "data" => [],
        ], $this->code);
    }
}
