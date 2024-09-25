<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $country = htmlspecialchars($_POST['country']);
    $phone = htmlspecialchars($_POST['phone']);
    $service = htmlspecialchars($_POST['service']);
    $scale = htmlspecialchars($_POST['scale']);
    $goal = htmlspecialchars($_POST['goal']);
    $startDate = htmlspecialchars($_POST['startDate']);
    $message = htmlspecialchars($_POST['message']);

    // Validate email and phone number formats
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Handle invalid email address
        header('Location: oops.html');
        exit;
    }

    if (!preg_match('/^\d{10}$/', $phone)) {
        // Handle invalid phone number
        header('Location: oops.html');
        exit;
    }

    // Set recipient email addresses
    $to = "contact@illforddigital.com, illforddigital@gmail.com";

// Set CC email addresses
$cc = "dm.illforddigital@gmail.com, edb@illforddigital.com"; 

    // Set email subject
    $subject = "Enquiry for Digital Marketing Services";

    // Set email headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "CC: $cc\r\n";

    // Construct email body
    $email_body = "You have received a new message from $name.\n" .
        "Email address: $email\n" .
        "Mobile Number: $phone\n" .
        "Nationality: $country\n" .
        "\n" .
        "Questionnaire: \n" .
        "Q) Which Service You Want? \n" .
        "Ans) $service .\n" .
        "Q) What is the scope or scale of your project? \n" .
        "Ans) $scale .\n" .
        "Q) What is your primary goal for seeking our services? \n" .
        "Ans) $goal .\n" .
        "Q) When do you aim to start this project? \n" .
        "Ans) $startDate .\n" .
        "\n" .
        "\n" .
        "Responder's Message: $message\n";

    // Use mail() function to send the email
    if (mail($to, $subject, $email_body, $headers)) {
        // Send thank-you email to the responder
        $responder_subject = "Thank you for contacting us!";
        $responder_message = "Dear $name,\n\nThank you for contacting us. We have received your message and will get back to you shortly.\n\nBest regards,\nThe Illford Digital Team";

        $responder_headers = "From: illforddigital@gmail.com"; // Change this to your sender email

        mail($email, $responder_subject, $responder_message, $responder_headers);
        
        // Redirect to the thank-you page
        header('Location: dm-services-thank-you.html');
        exit;
    } else {
        // Redirect to the error page if there's an issue with sending the email
        header('Location: oops.html');
        exit;
    }
}
?>
