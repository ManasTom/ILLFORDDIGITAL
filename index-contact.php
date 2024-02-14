<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $countryCode = $_POST['countryCode'];
    $message = $_POST['message'];

    $to = "contact@illforddigital.com, illforddigital@gmail.com"; 
    $subject = "Enquiry for Digital Marketing Services - Home Page ";
    $headers = "From: $email";

    $email_body = "You have received a new message from \n".
                   "Full Name : $name \n".
                  "Email address: $email\n".
                  "Mobile Number: $countryCode $phone\n".
                  "Message:\n $message";

    // mail() function to send the email
    if (mail($to, $subject, $email_body, $headers)) {
        // Send thank-you email to the responder
        $responder_subject = "Thank you for contacting us!";
        $responder_message = "Dear $name,\n\nThank you for contacting us. We have received your message and will get back to you shortly.\n\nBest regards,\nThe Illford Digital Team";

        $responder_headers = "From: illforddigital@gmail.com"; // Change this to your sender email

        mail($email, $responder_subject, $responder_message, $responder_headers);

        // Redirect to the thank-you page
        header('Location: alert.html');
    } else {
        // Redirect to the error page if there's an issue with sending the email
        header('Location: oops.html');
    }
}
?>
