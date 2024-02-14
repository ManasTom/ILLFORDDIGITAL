<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];
    $service = $_POST['service'];
    $scale = $_POST['scale'];
    $goal = $_POST['goal'];
    $startDate = $_POST['startDate'];    
    $message = $_POST['message'];

    $to = "contact@illforddigital.com, illforddigital@gmail.com";
    $subject = " Enquiry for Digital Marketing Services";
    $headers = "From: $email";

    $email_body = "You have received a new message from $name.\n".
                  "Email address: $email\n".
                  "Mobile Number: $phone\n".
                  "Nationality : $country\n".
                  "\n".
                  "questionare: \n".
                  "Q) Which Service You Want? \n".
                  "Ans) $service .\n".
                  "Q) What is the scope or scale of your project? \n".
                  "Ans) $scale .\n".
                  "Q) What is your primary goal for seeking our services? \n".
                  "Ans) $goal .\n".
                  "Q) When do you aim to start this project? \n".
                  "Ans) $startDate .\n".
                  "\n".
                  "\n".
                  "Responder's Message: $message\n";

    // Use mail() function to send the email
    if (mail($to, $subject, $email_body, $headers)) {
        // Send thank-you email to the responder
        $responder_subject = "Thank you for contacting us!";
        $responder_message = "Dear $firstname,\n\nThank you for contacting us. We have received your message and will get back to you shortly.\n\nBest regards,\nThe Illford Digital Team";

        $responder_headers = "From: illforddigital@gmail.com"; // Change this to your sender email

        mail($email, $responder_subject, $responder_message, $responder_headers);
        header('Location: digital-marketingServices-thankyou.html');
    } else {
        header('Location: oops.html');
        
    }
}
?>
