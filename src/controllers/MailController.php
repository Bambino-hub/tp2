<?php

namespace App\controllers;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MailController extends Controller
{
    public function mail($to, $subject, $body, $AltBody)
    {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'hoberenakbambino@gmail.com';                     //SMTP username
            $mail->Password   = 'nswbwdevodhvjxjm ';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            // on rajoute l'encodage charset = 'utf-8'
            $mail->CharSet = 'utf-8';

            //Recipients // l'expéditeur
            $mail->setFrom('hoberenakbambino@gmail.com', 'bambino');

            // le destinataire
            $mail->addAddress($to);     //Add a recipient

            // si on veut ajouter un deuxieme destinataire
            // $mail->addAddress('ellen@example.com');               //Name is optional

            // A qui on veut repondere si celui qui s'inscrit veut envoyer un message
            $mail->addReplyTo('hoberenakbambino@gmail.com', 'bambino');

            // ça c'est pour les copies 

            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            // //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            // on active l'evoie du html
            $mail->isHTML(true);                                  //Set email format to HTML

            //object de l'envoie d'email
            $mail->Subject = $subject;

            // Le contenue
            $mail->Body    = $body;

            //l'istruction asuivre 
            $mail->AltBody = $AltBody;

            //la fonction qui nous permet d'envoyer l'email
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
