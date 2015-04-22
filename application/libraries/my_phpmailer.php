<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_PHPMailer {
    public function My_PHPMailer(){
        require_once('PHPMailer/class.phpmailer.php');
    }
    
    public function Enviar($datosEmail){
 
        $fp = fsockopen("www.google.com", 80, $errno, $errstr, 10); // work fine
        if (!$fp){
            log_message("INFO", "www.google.com -  $errstr   ($errno)");
        }
        else{
            log_message("INFO", "www.google.com -  ok");
        }

        $fp = fsockopen("smtp.gmail.com", 21, $errno, $errstr, 10); // NOT work
        if (!$fp){
            log_message("INFO","smtp.gmail.com 465  -  $errstr   ($errno)");
        }
        else{
            log_message("INFO", "smtp.gmail.com 465 -  ok");
        }
        
        /*$fp = fsockopen("smtp.gmail.com", 465, $errno, $errstr, 10); // NOT work
        if (!$fp){
            log_message("INFO","smtp.gmail.com 465  -  $errstr   ($errno)");
        }
        else{
            log_message("INFO", "smtp.gmail.com 465 -  ok");
        }


        $fp = fsockopen("smtp.gmail.com", 587, $errno, $errstr, 10); // NOT work
        if (!$fp)
            log_message("INFO", "smtp.gmail.com 587  -  $errstr   ($errno)");
        else
            log_message("INFO", "smtp.gmail.com 587 -  ok");
*/
        
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
        $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
        $mail->Port       = 465;                   // set the SMTP port 
 
        $mail->Username   = "emplea.barbate@gmail.com";    // GMAIL username
        $mail->Password   = "Emple@2014";          // GMAIL password
             
        $mail->From       = $datosEmail['direccion'];
        $mail->FromName   = utf8_decode($datosEmail['nombre']);
        $mail->Subject    = utf8_decode($datosEmail['asunto']);
        $mail->AddAddress($datosEmail['destino']);
        $mail->IsHTML(TRUE);
        $mail->Body = utf8_decode($datosEmail['texto']);
             
        if(!$mail->Send()) {
           return FALSE;
        }        
        else {
            return TRUE;
        }
    }
}
?>