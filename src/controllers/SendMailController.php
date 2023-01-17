<?php

namespace Cmendoza\ApiCdc\controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Cmendoza\ApiCdc\models\ModelMongoAll as Model;

class SendMailController
{
    public static function sendMail($body, $subject, $email, $nombre)
    {

        //mandar correo
        $email = trim($email);

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                // Enable verbose debug output
            $mail->CharSet = 'UTF8';
            $mail->Encoding = 'quoted-printable';
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'mail3.hostweb.com.mx';                 // Specify main and backup SMTP servers
            //$mail->Host = 'mail.cdcac.com';                     // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'contacto2@cdcac.com';               // SMTP username
            $mail->Password = '@Ednasys.com359+-';                // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;      // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to
            //$mail->Port = 587;                                  // TCP port to connect to

            //Recipients
            $mail->setFrom('contacto@cdcac.com', 'Contacto CDC');
            $mail->addReplyTo('contacto@cdcac.com', 'Contacto CDC');

            $mail->addAddress($email, $nombre);                     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            //$mail->msgHTML($body);                                 // Set email format to HTML
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            $mail->ClearAddresses();

            return ['message' => 'Mensaje enviado!!', 'status' => true];
        } catch (Exception $e) {
            return ['message' => 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo, $e->getMessage()];
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
