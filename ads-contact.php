<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $countryCode = $_POST['countryCode'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    $to = "contact@illforddigital.com, illforddigital@gmail.com"; // Your email address
    $subject = " Enquiry for Digital Marketing Course";
    $headers = "From: $email";

    $email_body = "You have received a new message from $firstname $lastname.\n".
                  "Email address: $email\n".
                  "Mobile Number: $countryCode $phone\n".
                  "Message: $message\n";

    // Use mail() function to send the email
    if (mail($to, $subject, $email_body, $headers)) {
        // Send thank-you email to the responder
        $responder_subject = "Thank you for contacting us!";
        $responder_message = "Dear $firstname,\n\nThank you for contacting us. We have received your message and will get back to you shortly.\n\nBest regards,\nThe Illford Digital Team";

        $responder_headers = "From: illforddigital@gmail.com"; // Change this to your sender email

        mail($email, $responder_subject, $responder_message, $responder_headers);
        header('Location: thankyou.html');
    } else {
        header('Location: oops.html');
        
    }
}
?>
