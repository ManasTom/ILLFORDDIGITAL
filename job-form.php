<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $jobId = $_POST['jobId'];
    $jobTitle = $_POST['jobTitle'];
    $applicantName = $_POST['applicantName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $message = $_POST['message'];

    // File upload handling for the resume
    $resume = $_FILES['resume'];
    $resumeFileName = $resume['name'];
    $resumeTmpName = $resume['tmp_name'];
    $resumeFileSize = $resume['size'];

    // Set the recipient email addresses
    $recipients = array(
        "career@illforddigital.com",
        "contact@illforddigital.com",
        "illforddigital@gmail.com"
    );

    // Set a consistent "From" address for the confirmation email
    $confirmationFrom = "career@illforddigital.com"; // Replace with the desired email address

    // Set the subject of the email
    $subject = "Job Application: $jobTitle (Job ID: $jobId)";

    // Build the email message
    $messageBody = "Applicant Name: $applicantName\n";
    $messageBody .= "Job Title: $jobTitle\n";
    $messageBody .= "Job ID: $jobId\n";
    $messageBody .= "Email: $email\n";
    $messageBody .= "Phone Number: $phoneNumber\n";
    $messageBody .= "Message:\n$message\n";

    // Create a boundary for the email
    $boundary = md5(time());

    // Headers for the email
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

    // Message text
    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= $messageBody . "\r\n\r\n";

    // Attach resume file
    $fileContent = file_get_contents($resumeTmpName);
    $body .= "--$boundary\r\n";
    $body .= "Content-Type: application/octet-stream; name=\"$resumeFileName\"\r\n";
    $body .= "Content-Disposition: attachment; filename=\"$resumeFileName\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
    $body .= chunk_split(base64_encode($fileContent)) . "\r\n";

    // Send the email to multiple recipients
    foreach ($recipients as $recipient) {
        if (!mail($recipient, $subject, $body, $headers)) {
            echo "Error sending email to $recipient";
        }
    }

    // Confirmation email to the applicant
    $confirmationSubject = "Application Confirmation";
    $confirmationMessage = "Dear $applicantName,\n\nThank you for submitting your job application for '$jobTitle'. We have received your application and will review it shortly.\n\nBest regards,\nThe Illford Digital Hiring Team";

    // Headers for the confirmation email with a consistent "From" address
    $confirmationHeaders = "From: $confirmationFrom\r\n";
    $confirmationHeaders .= "Reply-To: $confirmationFrom\r\n";

    // Send the confirmation email to the applicant
    if (!mail($email, $confirmationSubject, $confirmationMessage, $confirmationHeaders)) {
        echo "Error sending confirmation email to $email";
    }

    // Redirect to the thank-you page
    header('Location: alert.html');
} else {
    // Redirect to the error page if there's an issue with the form submission
    header('Location: oops.html');
}
?>
