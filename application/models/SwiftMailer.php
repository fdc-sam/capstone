<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Swiftmailer extends CI_Model {
    public function __construct(){
        parent::__construct();
    }

    /*
        $from = 'aodrs2019@gmail.com';
        $to      = $email;
        $subject = 'Verification code';
        $headers = 'Content-type: text/html; charser =UTF-8;' . '\r \n';
        $headers .= "From: " . $from . "\r\n";
        $headers .= "Reply-To: ". $to . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $message = '<html><body>';
        $message .= '<h1>Hi, Student</h1>';
        $message .= '</body></html>';
        $message = '<html><body>';
        $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
        $message .= "<tr><td><strong>Your Username:</strong> </td><td>" . $fName . "</td></tr>";
        $message .= "<tr><td><strong>Your Password:</strong> </td><td>" . $randstr . "</td></tr>";
        $message .= "<tr><td><strong>Your Verification Code:</strong> </td><td>" . $randstr . "</td></tr>";
        $message .= '</table>';
        $message .= '</body></html>';
    */ 
    public function mailSend($from = null, $to = null, $subject = null, $headers = '', $message = ''){
        if (
            isset($from) && 
            isset($to) && 
            isset($subject) && 
            isset($headers) && 
            isset($message)
        ) {
            // Create the Transport
            $transport = (new Swift_SmtpTransport('smtp.lolipop.jp', 465, 'ssl'))
            ->setUsername('info@eyepro.online')
            ->setPassword('jwz_c_YS-0KMJHop');
          
            // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);
      
            // Create a message
            $message = (new Swift_Message($subject))
            ->setFrom(['info@eyepro.online' => 'EVSU-OCC'])
            ->setTo([$to])
            ->setBody($message, 'text/html');
      
            // Send the message
            $result = $mailer->send($message);
          
            // set variables
            $resultArr = array(
                'flag_email' => null,
                'output' => ''
            );
            if ($result) {
                $resultArr = array(
                    'flag_email' => true,
                    'output' => 'email_send'
                );
              
                return $resultArr;
            }
        }
        
        return false;
    }
 

}
