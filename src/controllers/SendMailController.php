<?php

namespace Cmendoza\ApiCdc\controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Cmendoza\ApiCdc\models\ModelMongoAll as Model;

class SendMailController
{
    public static function sendMail()
    {

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'mail.cdcac.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'contacto@cdcac.com';                     //SMTP username
            $mail->Password   = '@ednasys.com359+-';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('carlos.cdms.c@gmail.com', 'Mailer');
            //$mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            error_log('Message has been sent');
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }



    public static function storeMessage($fields)
    {
        $id = uniqid();
        $data = [
            '_id' => $id, 'name' => $fields['name'],
            'email' => $fields['email'], 'userKey' => $fields['userKey'],
            'message' => $fields['message'], 'created' => date("Y-m-d H:i:s"),
        ];
        $messageMail = new Model('messageMail');
        $result = $messageMail->save($data);
        return $result;
    }
}
