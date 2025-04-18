<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars($_POST["name"]);
    $email   = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    $to      = "ashniyaalosious7@gmail.com";  // your email
    $subject = "New Feedback from BuildTrack";
    $body    = "Name: $name\nEmail: $email\nMessage:\n$message";
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo "<script>alert('Feedback sent successfully!'); window.location.href='contact.html';</script>";
    } else {
        echo "<script>alert('Failed to send feedback.'); window.location.href='contact.html';</script>";
    }
} else {
    echo "Invalid request.";
}
?>
