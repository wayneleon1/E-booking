<?php
session_start();
require_once "connection.php";
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $transaction_date = $_POST["transaction_date"];
    $description = $_POST["description"];
    $accounts = $_POST["accounts"];
    $debits = $_POST["debits"];
    $credits = $_POST["credits"];

    // Validate and sanitize the data (you may add more validation as needed)
    $transaction_date = trim($transaction_date);
    $description = trim($description);

    // Start a transaction (ensure all or nothing)
    $conn->begin_transaction();

    try {
        // Prepare the SQL statement to insert the transaction data into the Transactions table
        $sql_transaction = "INSERT INTO transactions (transaction_date, description) VALUES (?, ?)";

        // Use prepared statements to prevent SQL injection
        $stmt_transaction = $conn->prepare($sql_transaction);
        $stmt_transaction->bind_param("ss", $transaction_date, $description);

        // Execute the statement and check for success
        if (!$stmt_transaction->execute()) {
            throw new Exception("Error saving transaction: " . $stmt_transaction->error);
        }

        // Get the transaction ID of the newly inserted transaction
        $transaction_id = $conn->insert_id;

        // Prepare the SQL statement to insert the journal entries into the JournalEntries table
        $sql_journal_entry = "INSERT INTO journalEntries (transaction_id, account_id, debit_amount, credit_amount) VALUES (?, ?, ?, ?)";

        // Use prepared statements to prevent SQL injection
        $stmt_journal_entry = $conn->prepare($sql_journal_entry);

        // Loop through the accounts, debits, and credits arrays to insert each journal entry
        for ($i = 0; $i < count($accounts); $i++) {
            $account_id = $accounts[$i];
            $debit_amount = $debits[$i];
            $credit_amount = $credits[$i];

            // Execute the statement and check for success
            $stmt_journal_entry->bind_param("iidd", $transaction_id, $account_id, $debit_amount, $credit_amount);
            if (!$stmt_journal_entry->execute()) {
                throw new Exception("Error saving journal entry: " . $stmt_journal_entry->error);
            }
        }

        // If all journal entries are saved successfully, commit the transaction
        $conn->commit();
        header("Location: transaction.php");
        $_SESSION['comfrim']= "Transaction recorded successfully!, Check your journal Table";
    } catch (Exception $e) {
        // If there is an error, rollback the transaction to ensure data consistency
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    // Close the statements and the database connection
    $stmt_transaction->close();
    $stmt_journal_entry->close();
    $conn->close();
}
?>