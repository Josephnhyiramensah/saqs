<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    $company_id = $_SESSION['company_id'];
    if(isset($_SESSION['user_id'])){$user_id = $_SESSION['user_id'];}else{$user_id = 0;};
    $branch_id = $_SESSION['branch_id'];

	date_default_timezone_set("Africa/Accra");
    $date = date('Y-m-d');

    $query_sms = "SELECT SUM(qty_purchased) AS qty_in, SUM(qty_sent) AS qty_out FROM sms WHERE company_id='$company_id'";
    $result_sms = mysqli_query($con,$query_sms);
    if(!empty($result_sms) && mysqli_num_rows($result_sms) > 0)
    {
        $row_sms = mysqli_fetch_assoc($result_sms);
        $sms_bal = $row_sms['qty_in'] - $row_sms['qty_out'];
    }
    else
    {
        $sms_bal = 0;
    };
    
    if($sms_bal > 0)
    {
        /*$query = "SELECT * FROM patients WHERE company_id='$company_id' AND 
        DATE_FORMAT(DOB, '%m-%d') = DATE_FORMAT('$date', '%m-%d')";
        $result = mysqli_query($con,$query);
        if(!empty($result) && mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                $received_from = $row['firstName'].' '.$row['lastName'];
                $telephone = $row['telephone'];*/
                $received_from = 'Ekow Dadzie Andam';
                $telephone = '0244897809';
                $phone = substr($telephone, 1, 9);
                $to = '233'.$phone;
                $message = 'Dear '.$received_from.', We celebrate you on your special day. Happy Birthday!';
            

                // Usage example with a single phone number
                $apiKey = "dGNCT2V3ZEtwa0p4PUp2Y2F3c3k="; // Your API key
                $from = "LUCY_HERBAL"; // Sender's identifier (should not exceed 11 characters)
                //$message = "Your message here"; // Message to be sent
                    
                /**
                 * Sends an SMS using the iSendGH API.
                 *
                 * @param string $apiKey The API key for authentication.
                 * @param string $to The recipient's phone number.
                 * @param string $from The sender's identifier (should not exceed 11 characters).
                 * @param string $message The message to be sent.
                 * @return array An array with the success status and response or error message.
                 */
                function sendSMS($apiKey, $to, $from, $message) 
                {
                    // URL encode the message to ensure it's properly formatted
                    $encodedMessage = urlencode($message);

                    // Ensure the 'from' identifier is within the allowed length (max 11 characters)
                    if (strlen($from) > 11) 
                    {
                        return ['success' => false, 'error' => 'Sender identifier should not exceed 11 characters.'];
                    }

                    // Construct the API URL with the necessary parameters
                    $url = "https://sms.isendgh.com/sms/api?action=send-sms&api_key={$apiKey}&from={$from}&to={$to}&sms={$encodedMessage}";
                    
                    // Initialize a new cURL session
                    $ch = curl_init();

                    // Set cURL options
                    curl_setopt($ch, CURLOPT_URL, $url);               // Set the URL
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    // Return the response as a string

                    // Execute the cURL request
                    $response = curl_exec($ch);

                    // Check for errors during the cURL execution
                    if (curl_errno($ch)) {
                        // Capture the error message
                        $err = curl_error($ch);
                        
                        // Close the cURL session
                        curl_close($ch);
                        // Return an array indicating failure and the error message
                        return ['success' => false, 'error' => $err];
                    }

                    // Close the cURL session
                    curl_close($ch);

                    // Decode the JSON response from the API
                    $decodedResponse = json_decode($response, true);
                    
                    // Check if decoding was successful
                    if (json_last_error() === JSON_ERROR_NONE) {
                        // Return the decoded response
                        return ['success' => true, 'response' => $decodedResponse];
                    } else {
                        // Return an error if the response is not valid JSON
                        return ['success' => false, 'error' => $response];
                        //return ['success' => false, 'error' => 'Invalid JSON response from API.'];
                    };
                }

                // Call the sendSMS function and store the result
                $result = sendSMS($apiKey, $to, $from, $message);

                // Set the content type to application/json
                header('Content-Type: application/json');

                // Check the result and output the appropriate JSON response
                if ($result['success']) {
                    // Output the decoded response in JSON format
                    echo json_encode(['success' => true, 'response' => $result['response']]);
                    $remarks = $result['response'];
                } else {
                    // Output the error message in JSON format
                    echo json_encode(['success' => false, 'error' => $result['error']]);
                    $remarks = $result['error'];
                };

                $query_msg = "INSERT INTO `sms`(`date`,`qty_sent`,`name`,`status`,`company_id`,`created_by`,
                `created_datetime`) VALUES ('$date',1,'$received_from','$remarks','$company_id','$user_id',NOW())";
                mysqli_query($con,$query_msg);
            /*};
        }
        else
        {
            echo 'No patient found with DOB on '.$date;
        };*/
    };
echo  "<script type='text/javascript'>window.close();</script>";
?>