<?php

namespace App\Exceptions;

use App\Notifications\Main\ErrorReportNotification;
use App\User;
use Exception;
use Throwable;

class ClientErrorException extends Exception
{
    protected $message;
    public function __construct($message, $code, $trace=null, $mailable=true){
        $this->message = $message;  
        $this->code = $code;
        $this->trace = $trace;
        $this->mailable = $mailable;
    }

    public function render()
    {
        // if($this->mailable)
        // {
        //     $this->reportError($this->message, $this->code, $this->trace);
        // }
        // // return $ss;
        return response()->json(['error'=>['message'=>$this->message]], $this->code);
    }

    // public function reportError($message, $code, $trace)
    // {

    //     $backend = new User;
    //     $backend->email = "favescsskr@gmail.com";
       
        
    //     $mail_details = [
    //         'subject' => 'Error encountered on NGCart.com',
    //         'greeting' => '<span style="font-size:40px">There is a '.$code.' error.</span>',
    //         'body' => '<br>
    //                     <b>Hi</b><br>
    //                     Here is the error</b>
    //                     <br> <hr>
    //                     <b>'.url()->full().'</b><br><br>
    //                     '.json_encode($message).' <br> <br>
    //                     '.json_encode($trace).'
    //                     <hr>

    //                     <small style="color:#999">
    //                     If you have any questions, you can contact us at
    //                     <a href="mailto:support@ngcart.com" style="color:#ff8000; text-decoration:none">
    //                     support@ngcart.com</a>.
    //                     </small>
    //                     <br><br><br>
    //                     ',
    //     ];

    //     $notification = new ErrorReportNotification($mail_details);

    //     try{
    //         $backend->notify($notification);
    //     }
    //     catch(Throwable $e){
    //         $report = ["client_message"=>$message, "client_trace"=>$trace];
    //         throw new ClientErrorException($e->getMessage(), 400, $report, false );
    //     }

    // }
}
