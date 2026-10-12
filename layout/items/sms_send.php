<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
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
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    if(isset($_SESSION['user_id']))
    {
        $user_id = $_SESSION['user_id'];
    }
    else
    {
        $user_id = 0;
    };

	date_default_timezone_set("Africa/Accra");
    $date = date('Y-m-d');
    $sms_date = $_SESSION['sms_date'];
    $sms_recipient = $_SESSION['sms_recipient'];
    $sms_gender = $_SESSION['sms_gender'];
    $sms_telephone = $_SESSION['sms_telephone'];
    $sms_message = $_SESSION['sms_message'];
    $sms_category = $_SESSION['sms_category'];
    $sms_appointment_date = $_SESSION['sms_appointment_date'];

    $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
    $result_company = mysqli_query($con,$sql_company);
    $row_company = mysqli_fetch_array($result_company);
    $company_name = $row_company['trading_name'];

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
        if($sms_category == 'BULK_MESSAGE')
        {
            if($sms_recipient == 'ALL')
            {
                if($sms_gender == 3)
                {
                    $query = "SELECT * FROM patients WHERE telephone !=''";
                }
                else
                {
                    $query = "SELECT * FROM patients WHERE telephone !='' AND gender ='$sms_gender'";
                };
            }
            else
            {
                if($sms_telephone != '')
                {
                    $query = "SELECT * FROM patients WHERE patient_id='$sms_recipient'";
                };
            };
        }
        else
        {
            $query = "SELECT * FROM appointment WHERE date ='$sms_appointment_date'";
        };

        $query_run = mysqli_query($con,$query);
        if(!empty($query_run) && mysqli_num_rows($query_run) > 0)
        {
            while($row = mysqli_fetch_assoc($query_run))
            {
                if($sms_category == 'BULK_MESSAGE')
                {
                    $received_from = $row['firstName'].' '.$row['lastName'];
                    $telephone = $row['telephone'];
                    $phone = substr($telephone, 1, 9);
                    $to = '233'.$phone;
                    $message = 'Dear '.$received_from.', '.$sms_message;
                }
                else
                {
                    $received_from = $row['name'];
                    $telephone = $row['phone'];
                    $phone = substr($telephone, 1, 9);
                    $to = '233'.$phone;
                    $message = 'Dear '.$received_from.', we remind you of your appointment on '.$sms_appointment_date.' at '.$row['time'].' We will be expecting you. Enjoy a good day.';
                };
            
                // Usage example with a single phone number
                $apiKey = "dGNCT2V3ZEtwa0p4PUp2Y2F3c3k="; // Your API key
                $arr = explode(' ',trim($company_name));
                $from = $arr[0]; // Sender's identifier (should not exceed 11 characters)
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
            };
        }
        else
        {
            echo 'No patient found';
        };
    };
?>
<script type='text/javascript'>window.close();</script>