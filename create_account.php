<?php
session_start();
require_once "connection.php";
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $account_name = $_POST["account_name"];
    $account_type = $_POST["account_type"];

    // Validate and sanitize the data (you may add more validation as needed)
    $account_name = trim($account_name);
    $account_type = trim($account_type);

    // Prepare the SQL statement to insert the account data into the Accounts table
    $sql = "INSERT INTO accounts (account_name, account_type) VALUES (?, ?)";

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $account_name, $account_type);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        header("Location: accounts.php");
        $_SESSION['comfrim']= "Account created successful!";
    } else {
        echo "Error creating account: " . $stmt->error;
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
}
?>