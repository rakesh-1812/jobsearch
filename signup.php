<?php
// Include database connection file
require_once 'config.php';

// Initialize a variable for the message
$message = "";
$messageClass = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs from the form
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if the fields are not empty
    if (!empty($name) && !empty($email) && !empty($password)) {
        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if the email already exists in the database
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            // Email already exists
            $message = "Email already registered!";
            $messageClass = "error-message";
        } else {
            // Insert user data into the database
            $query = "INSERT INTO users (username, email, password) VALUES (:name, :email, :password)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                $message = "User registered successfully!";
                $messageClass = "success-message";
            } else {
                $message = "Error: Could not register the user.";
                $messageClass = "error-message";
            }
        }
    } else {
        $message = "Please fill in all fields.";
        $messageClass = "error-message";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Job Hub</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .signup-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            margin-top: 15px;
            font-size: 14px;
            padding: 10px;
            border-radius: 4px;
        }
        .success-message {
            color: green;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }
        .error-message {
            color: red;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

    <div class="signup-container">
        <h2>Sign Up</h2>

        <?php
        // Display the message after form submission
        if ($message != "") {
            echo "<p class='message $messageClass'>" . $message . "</p>";
        }
        ?>

        <form action="signup.php" method="POST">
            <input type="text" id="name" name="name" placeholder="Your Name" required><br>

            <input type="email" id="email" name="email" placeholder="Your Email" required><br>

            <input type="password" id="password" name="password" placeholder="Your Password" required><br>

            <button type="submit">Sign Up</button>
        </form>
    </div>

</body>
</html>
