<?php
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\OAuth;
        use League\OAuth2\Client\Provider\Google;
        require_once($_SERVER['DOCUMENT_ROOT'] .'/vendor/autoload.php');
        require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
        require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/get_oauth_token.php');

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;

        //Set the encryption mechanism to use:
        // - SMTPS (implicit TLS on port 465) or
        // - STARTTLS (explicit TLS on port 587)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

        $mail->SMTPAuth = true;
        $mail->AuthType = 'XOAUTH2';
        
        $email = 'ramothapp@gmail.com'; // the email used to register google app
        $clientId = '86411046870-iontfo8no4csvm5nku3inar8n8r0858c.apps.googleusercontent.com';
        $clientSecret = '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';
        
        $db = new DB();
        $updateToken = $db->update_refresh_token($token);
        $refreshToken = $db->get_refresh_token();
        
        //Create a new OAuth2 provider instance
        $provider = new Google(
            [
                'clientId' => $clientId,
                'clientSecret' => $clientSecret,
            ]
        );
        
        //Pass the OAuth provider instance to PHPMailer
        $mail->setOAuth(
            new OAuth(
                [
                    'provider' => $provider,
                    'clientId' => $clientId,
                    'clientSecret' => $clientSecret,
                    'refreshToken' => $refreshToken,
                    'userName' => $email,
                ]
            )
        );

        $company_id = $_SESSION['company_id'];
        $employee_email = $_SESSION['employee_email'];
        $employee_name = $_SESSION['employee_name'];

        //if($Invoice_email_1 !== '')
        //{
            $filename = $_SERVER['DOCUMENT_ROOT'] .'/img/pay_slip.pdf';
            $mail->setFrom($email, 'Ramoth Account');
            $mail->addAddress($employee_email, $employee_name);
            //$mail->addAddress($employee_email, $employee_name);
            $mail->isHTML(true);
            $mail->Subject = 'AfLIA MEMBERSHIP DUES';

            $body ='<p>Dear Sir/Madam</p><br>'.

                '<p><b>Compliments of the Season</b></p>'.

                '<p>We are happy to have you as a loyal member of AfLIA in good standing and we look forward to your continued 
                membership to enable us offer services to support your work to the communities you serve.</p><br>'.

                '<p>Please find attached AfLIA invoice for membership fees for the year 2024 for your attention.</p><br>'.
                '<p>Kindly indicate your invoice number on the bank transfer document and also note that all bank charges are to be 
                paid by the sender.</p><br>'.
                '<p>Please send payment notification / SWIFT advice to the Accountant via accountant@aflia.net</p><br><br>'.

                '<p>Many thanks</p><br>'.
                '<p>Bless Dzah, CA</p>'.
                '<p>Accountant</p>'.
                '<p>African Library & Information Associations & Institutions (AfLIA)</p>'.
                '<p>PMB BC38, Burma Camp</p>'.
                '<p>INSTI Building, CSIR Headquarters, Accra.</p>'.
                '<p>Tel: +233 208 343 468/ +233 246 182 176</p><br>';
            
            $mail->Body = $body;
            $mail->AddAttachment($filename);
            
            //send the message, check for errors
            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message sent!';
            };
            echo  "<script type='text/javascript'>";
            echo "window.close();";
            echo "</script>";
        //};
?>