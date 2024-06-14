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

    // Database credentials
    $servername = "localhost";
    $username = "root";    // Default username for XAMPP/WAMP
    $password = "";        // Default password for XAMPP/WAMP is empty
    $dbname = "contact_form";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO submissions (name, email, message) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sss", $name, $email, $message);

    // Execute the statement
    if ($stmt->execute()) {
        $thankYouMessage = "Thank you, your message has been received. Redirecting to the previous page in 5 seconds...";
    } else {
        $thankYouMessage = "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid Request";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f5f5f5;
            margin: 0;
        }
        .message-box {
            text-align: center;
            background: white;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            animation: fadeIn 2s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            text-decoration: none;
            display: inline-block;
        }
    </style>
    <script type="text/javascript">
        setTimeout(function() {
            window.history.back();
        }, 5000); // 5 seconds
    </script>
</head>
<body>
    <div class="message-box">
        <p><?php echo $thankYouMessage; ?></p>
        <a href="javascript:window.history.back();" class="button">Go Back</a>
    </div>
</body>
</html>

