<?php
    //this is the very first line in the php code 
    //#1 Load the namespace\ClassNames into this file so they can be used to create instances to avoid name conflicts
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //#2 include/import the files containing the needed namespace\ClassNames
    require './vendor/phpmailer/src/Exception.php';
    require './vendor/phpmailer/src/PHPMailer.php';
    require './vendor/phpmailer/src/SMTP.php';

    //Load Composer's autoloader
    require './vendor/autoload.php';

    /**
     * just call this function on any script and the mail will be forwarded
     * @param string $subject - This is the subject of the mail you want to send
     * @param string|HTMLElement $bodyHtml - This is the body of the message to be sent
     * @param string $userEmail - This is the email of the receiver if you are sending to only one receiver
     * @param string $userEmailArray - The array of the receivers email if you are sending to many receivers
    */
    
    function mailTo($subject,$bodyHtml,$userEmail=null,$usersEmailArray=[]) {
        if (($userEmail==null && $usersEmailArray==[])) {
            return "Empty receivers. Please add the useremail or the users email array";
        }

        //#3 Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'example@gmail.com';                     //SMTP username of the outgoing smtp
            $mail->Password   = 'above username password';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //The email account of th above username or the email address on the same username panel
            $mail->setFrom('example@gmail.com', 'MysiteName');
            
            //add the email accounts of the email receivers.
            if ($usersEmailArray!=[]) {
                //Add the user email recipient if his email is not empty
                $userEmail!=null ? $mail->addAddress($userEmail) : "";
                foreach($usersEmailArray as $emailVal){
                    $mail->addAddress($emailVal);     //Add a recipient
                }
            }
            else {
                //just add the useremail
                $mail->addAddress($userEmail);
            }

            //$mail->addAddress('devprox202@gmail.com', 'Joe User');     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment();         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    =  $bodyHtml;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return 'Message sent successfully';
        } catch (Exception $e) {
            return $e->errorMessage();
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

?>
