<?php
/*
* Written By Chris Allen
* Contact:  	650-395-8594
* Email:		chris@chrisballen.com
*
* Application:	TicTacToe Game
*/
namespace ChrisAllen\TicTacToe\Utilities;

class Result { 
    public $success;
    public $message;
    public $data;
    

    public function __construct($success=true, $message="", $data=null) {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
    }
    
    public function getJson(){
        return json_encode(array("success"=>$this->success, "message"=>$this->message, "data"=>$this->data));
    }
}
