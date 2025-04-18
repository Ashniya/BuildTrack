<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);

    if (empty($name) || empty($email) || empty($password)) {
        echo "<script>alert('All fields are required.'); window.history.back();</script>";
        exit;
    }

    $userData = "$name|$email|$password\n";

    // Save to a text file
    file_put_contents("users.txt", $userData, FILE_APPEND);

    echo "<script>alert('Signup successful! Please log in.'); window.location.href='index.html';</script>";
    exit;
}
?>
