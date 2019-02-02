<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * Class HomeController.
 */
class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
       
    }

    public function send_mail()
    {
        $requestBody = file_get_contents('php://input');
        $json = json_decode($requestBody);

        $text = $json->result->resolvedQuery;

        $subject = (!empty($json->result->parameters->subject)) ? $json->result->parameters->subject : '';
        $content  = (!empty($json->result->parameters->content)) ? $json->result->parameters->content : '';
        $email   = (!empty($json->result->parameters->email)) ? $json->result->parameters->email : '';
        if(mail($email,$subject,$content)){
            $responseText = prepareResponse($email);
            $response = new \stdClass();
            $response->speech = $responseText;
            $response->displayText = $responseText;
            $response->source = "webhook";
            echo json_encode($json);
        };
}

function prepareResponse($email)
    {
    return "Email sent to ".$email ;    
    }
    


    
}
