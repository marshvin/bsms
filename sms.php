<?php
require 'vendor/autoload.php';
use AfricasTalking\SDK\AfricasTalking;

// Set your app credentials
$username = "bulk101";
$apiKey = "7c5801693580fdc05becab38394b6e5ed60edb024aa4508b77ab5293ba82f607";

// Initialize the SDK
$AT = new AfricasTalking($username, $apiKey);

// Get the SMS service
$sms = $AT->sms();

// Get form data (replace these with your actual form field names)
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$age = $_POST['age'];
$profession = $_POST['profession'];
$phone_number = $_POST['phone_number'];
$githubLink = $_POST['github_link'];

// Compose the message with form data
$message = "A new member set to join\n $firstName $lastName,\nAge: $age\nProfession: $profession\nGitHub: $githubLink\nGitHub: $githubLink";

// Set the numbers you want to send to in international format
$recipients = "+254727309204,+254748493651,+254795658796,+254745820631,+254791067384";

try {
    // Establish a database connection (modify these with your database credentials)
    $dsn = 'mysql:host=localhost;dbname=developers';
    $dbUsername = 'root';
    $dbPassword = '';

    $pdo = new PDO($dsn, $dbUsername, $dbPassword);

    // Insert data into the database
    $sql = "INSERT INTO devs (first_name, last_name, age, profession, phone_number, github_link) 
            VALUES (:first_name, :last_name, :age, :profession, :phone_number, :github_link)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':first_name', $firstName);
    $stmt->bindParam(':last_name', $lastName);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':profession', $profession);
    $stmt->bindParam(':phone_number', $phone_number);
    $stmt->bindParam(':github_link', $githubLink);
    $stmt->execute();

    // Send SMS
    $result = $sms->send([
        'to' => $recipients,
        'message' => $message,
    ]);

    // Redirect to a success page
    header("Location: echo.html");
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
