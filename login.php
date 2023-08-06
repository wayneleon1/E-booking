<?php
session_start();
// Replace these placeholders with your actual database credentials
require_once "connection.php";


try {
    // Connect to the MySQL database
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);

    // Retrieve user input from the login form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if the user exists
    $query = "SELECT * FROM users WHERE username = :username AND password = :password";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'username' => $username,
        'password' => $password, // Note: In production, it's better to hash the password before storing and comparing.
    ]);

    // Check if a matching user is found
    if ($stmt->rowCount() > 0) {
    
        // header.location // You can customize this message or perform further actions here.
         header("Location: home.php");
         $_SESSION['status']= "Login Successful";
         $_SESSION['id']=1;
            exit();

    } else {

    header("Location: index.php");
    $_SESSION['warning']= "Incorrect Username and Password!";
    
    }
} catch (PDOException $e) {
    // Database connection or query error
    die("Error: " . $e->getMessage());
}
?>