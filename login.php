<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $file = fopen("users.txt", "r");
    $validUser = false;

    if ($file) {
        while (($line = fgets($file)) !== false) {
            list($name, $email, $hashedPassword) = explode("|", trim($line));

            // Match with either name or email
            if (($username === $name || $username === $email) && password_verify($password, $hashedPassword)) {
                $validUser = true;

                // Set session and cookie
                $_SESSION["user"] = $name;
                setcookie("user", $name, time() + (86400 * 7), "/"); // Cookie lasts 7 days

                break;
            }
        }
        fclose($file);
    }

    if ($validUser) {
        header("Location: main.html");
        exit;
    } else {
        echo "<script>alert('Invalid username or password.'); window.history.back();</script>";
        exit;
    }
} else {
    header("Location: index.html");
    exit;
}
?>
