<?php
    //SEND MAIL
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\OAuth;
        use League\OAuth2\Client\Provider\Google;
        require_once($_SERVER['DOCUMENT_ROOT'] .'/vendor/autoload.php');
        require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/class-db.php');
        require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/get_oauth_token.php');

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'MAILJET_SMTP_SERVER'; // host
        $mail->SMTPAuth = true;
        $mail->Username = '443ea1b0a0fa879d57f64037dccf8c34'; //API_KEY
        $mail->Password = '3f7a65f47c577bd85cdffe638d0e4e8a'; //SECRET_KEY
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587; //smtp port

        $company_id = $_SESSION['company_id'];
        $Invoice_bal_bf = $_SESSION['Invoice_bal_bf'];
        $Invoice_year = 2024;
        $Invoice_email_1 = 'ekowandam@yahoo.com';
        $Invoice_name = 'Kofi';
        $email = 'eda.success@gmail.com';
        //if($Invoice_email_1 !== '')
        //{
            $filename = $_SERVER['DOCUMENT_ROOT'] .'/ramoth/payroll/img/invoice.pdf';
            
   
            //$mail->setFrom('SENDER_EMAIL_ADDRESS', 'SENDER_NAME');
            //$mail->addAddress('RECIPIENT_EMAIL_ADDRESS', 'RECIPIENT_NAME');

            $mail->setFrom($email, 'Accountant@Ramoth');
            $mail->addAddress($Invoice_email_1, $Invoice_name);
            //$mail->addAddress('ekowandam@yahoo.com', $Invoice_name);
            //$mail->addAddress('mayrocygh@gmail.com', $Invoice_name);
            
            //$mail->addAddress($Invoice_email_1, $Invoice_name);
            /*if($Invoice_email_2 !== '')
            {
                $mail->addAddress($Invoice_email_2, $Invoice_name);
            };
            if($Invoice_email_3 !== '')
            {
                $mail->addAddress($Invoice_email_3, $Invoice_name);
            };
            if($Invoice_email_4 !== '')
            {
                $mail->addAddress($Invoice_email_4, $Invoice_name);
            };*/
            
            $mail->isHTML(true);
            $mail->Subject = 'STOCK TRANSFER';
            
                $body ='<p>Dear Sir/Madam</p><br>'.

                '<p><b>Compliments of the Season</b></p>'.

                '<p>We have been happy to have you as a member of AfLIA , our great association. For some time now however, 
                we have observed that you have not responded to our requests for payment of membership fees even though we 
                have sent Invoices and reminders.  We very much value your membership of AfLIA and so will be most grateful 
                if you could renew your membership.</p><br>'.

                '<p>Please find attached AfLIA invoice for membership fees for the year '. $Invoice_year .' as well as Arrears for the 
                previous year(s) for your attention.</p><br>'.
                '<p>Kindly indicate your invoice number on the bank transfer document and also note that all bank charges are 
                to be paid by the sender.</p><br>'.
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