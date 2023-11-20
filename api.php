<?php

$api_key = ''; 
$base_url = 'https://api.mobitechtechnologies.com/sms/sendsms';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $name = $_POST["name"];
    $email = $_POST["email"];
    $age = $_POST["age"];
    $profession = $_POST["profession"];
    $password = $_POST["password"];

    // Customize the message with user input
    $message = "New member details:\nName: $name\nProfession: $profession\nAge: $age";

    // Define phone numbers
    $phone_numbers = array("",);

    foreach ($phone_numbers as $phone_number) {
        $data = json_encode(array(
            "mobile" => $phone_number,
            "response_type" => "json",
            "sender_name" => "23107",
            "service_id" => 0,
            "message" => $message
        ));

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $base_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'h_api_key: ' . $api_key,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        echo "Message sent to " . $phone_number . ": " . $response . "\n";
    }
}
?>
