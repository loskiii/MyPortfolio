<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    // Path to 'submissions.txt'. Ensure this path is writable by your web server.
    $file_path = __DIR__ . "\\submissions.txt";

    // Save data to file
    $file = fopen($file_path, "a");
    fwrite($file, "Name: $name\nEmail: $email\nMessage: $message\n\n");
    fclose($file);

    echo "Thank you, your message has been received.";
} else {
    echo "Invalid Request";
}
?>
