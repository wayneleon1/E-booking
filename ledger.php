<?php
session_start();
if(!isset($_SESSION['id']))
{
      header("Location: index.php");
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ledger</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
     
      <!-- /. NAV BAR  -->
    <?php
    include 'navheader.php';
    ?>
      <!-- /. NAV TOP  -->
      <?php
    include 'navtop.php';
    ?>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>LEDGER ACCOUNTS </h2>   
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
     <div class="content">
        <?php
        // Connect to the database
        require_once 'connection.php';

        // Fetch all unique account IDs and names from the Accounts table
        $sql_accounts = "SELECT account_id, account_name, account_type FROM accounts";
        $result_accounts = $conn->query($sql_accounts);

        if ($result_accounts->num_rows > 0) {
            // Loop through each account and display its ledger details in a separate table
            while ($row_account = $result_accounts->fetch_assoc()) {
                $account_id = $row_account['account_id'];
                $account_name = $row_account['account_name'];
                $account_type = $row_account['account_type'];

                // Determine whether to show Dr (Debit) side or Cr (Credit) side based on the account type
                $is_debit_account = ($account_type === 'asset' || $account_type === 'expense') ? true : false;

                // Prepare the SQL statement to fetch transactions for the specified account
                $sql = "SELECT t.transaction_date, t.description, j.debit_amount, j.credit_amount
                        FROM transactions t
                        INNER JOIN journalEntries j ON t.transaction_id = j.transaction_id
                        WHERE j.account_id = $account_id
                        ORDER BY t.transaction_date";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Display the ledger account details in a table
                    echo '<h3>' . $account_name . ' (' . strtoupper($account_type) . ')</h3>';
                    echo '<table class="table table-striped table-bordered table-hover">';
                    echo '<tr><th>Date</th><th>Description</th><th>Debit</th><th>Credit</th></tr>';

                    $balance = 0;

                    while ($row = $result->fetch_assoc()) {
                        $debit_amount = $row['debit_amount'];
                        $credit_amount = $row['credit_amount'];
                        $balance += ($is_debit_account ? ($debit_amount - $credit_amount) : ($credit_amount - $debit_amount));

                        echo '<tr>';
                        echo '<td>' . $row['transaction_date'] . '</td>';
                        echo '<td>' . $row['description'] . '</td>';
                        echo '<td>' . ($debit_amount > 0 ? number_format($debit_amount, 2, '.', ',') : '') . '</td>';
                        echo '<td>' . ($credit_amount > 0 ? number_format($credit_amount, 2, '.', ',') : '') . '</td>';
                        echo '</tr>';
                    }

                    // Display the final balance on the Dr (Debit) or Cr (Credit) side
                    echo '<tr>';
                    echo '<td colspan="2" align="right"><strong>Total ' . ($is_debit_account ? 'Debit' : 'Credit') . '</strong></td>';
                    echo '<td>' . ($is_debit_account ? number_format($balance, 2, '.', ',') : '') . '</td>';
                    echo '<td>' . (!$is_debit_account ? number_format($balance, 2, '.', ',') : '') . '</td>';
                    echo '</tr>';

                    echo '</table>';
                } else {
                    // echo '<p>No transactions found for this account.</p>';
                }
            }
        } else {
            // echo '<p>No accounts found.</p>';
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
                 <!-- /. ROW  -->           
    </div>
             <!-- /. PAGE INNER  -->

            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
        <!-- /. Footer  -->
    <?php
    include 'footer.php';
    ?>
   <?php
    include 'scripts.php';
    ?>
</html>
