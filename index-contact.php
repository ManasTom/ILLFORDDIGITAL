
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $countryCode = htmlspecialchars($_POST['countryCode']);
    $message = htmlspecialchars($_POST['message']);

    // Validate email and phone number formats
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Handle invalid email address
        header('Location: oops.html');
        exit;
    }

    // Check if phone number is valid (you might need more comprehensive validation)
    if (!preg_match('/^\d{10}$/', $phone)) {
        // Handle invalid phone number
        header('Location: oops.html');
        exit;
    }

    // Prepare email headers
    $to = "contact@illforddigital.com, illforddigital@gmail.com";
    $cc = "dm.illforddigital@gmail.com, edb@illforddigital.com"; 
    $subject = "Enquiry for Digital Marketing Services - Home Page";
    $headers = "From: " . $email . "\r\n";
    $headers .= "CC: " . $cc . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    $email_body = "You have received a new message from\n" .
                  "Full Name: $name\n" .
                  "Email address: $email\n" .
                  "Mobile Number: $countryCode $phone\n" .
                  "Message:\n$message";

    // Send the email
    if (mail($to, $subject, $email_body, $headers)) {
        // Send thank-you email to the responder
        $responder_subject = "Thank you for contacting us!";
        $responder_message = "Dear $name,\n\nThank you for contacting us. We have received your message and will get back to you shortly.\n\nBest regards,\nThe Illford Digital Team";

        $responder_headers = "From: illforddigital@gmail.com";
        mail($email, $responder_subject, $responder_message, $responder_headers);

        // Redirect to the thank-you page
        header('Location: alert.html');
        exit;
    } else {
        // Redirect to the error page if there's an issue with sending the email
        header('Location: oops.html');
        exit;
    }
}
?>