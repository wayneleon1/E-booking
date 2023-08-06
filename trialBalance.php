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
    <title>Balance Sheet</title>
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
                     <h2>TRIAL BALANCE </h2>   
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
      
     <div>
        <?php
        // Connect to the database
        require_once 'connection.php';

        // Fetch account balances from the Accounts table
        $sql = "SELECT account_id, account_name FROM accounts";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Initialize total debit and credit balances
            $total_debit = 0;
            $total_credit = 0;

            // Display the trial balance table
            echo '<table class="table table-striped table-bordered table-hover">';
            echo '<tr><th>Account</th><th>Debit</th><th>Credit</th></tr>';

            while ($row = $result->fetch_assoc()) {
                $account_id = $row['account_id'];
                $account_name = $row['account_name'];

                // Calculate the total debit and credit amounts for each account
                $sql_amounts = "SELECT SUM(debit_amount) as total_debit, SUM(credit_amount) as total_credit 
                                FROM journalEntries
                                WHERE account_id = $account_id";

                $result_amounts = $conn->query($sql_amounts);
                $row_amounts = $result_amounts->fetch_assoc();

                $debit_amount = $row_amounts['total_debit'];
                $credit_amount = $row_amounts['total_credit'];

                // Calculate the balance for each account
                $balance = $debit_amount - $credit_amount;
                
                // 0 balance accounts are not displayed
                if ($balance == 0) {
                    continue;
                }

                // Update the total debit and credit balances
                if ($balance > 0) {
                    $total_debit += $balance;
                } elseif ($balance < 0) {
                    $total_credit += $balance;
                }

                echo '<tr>';
                echo '<td>' . $account_name . '</td>';
                echo '<td>' . ($balance == 0 ? '' : ($balance > 0 ? number_format($balance, 2, '.', ',') : '')) . '</td>';
                echo '<td>' . ($balance == 0 ? '' : ($balance < 0 ? number_format(abs($balance), 2, '.', ',') : '')) . '</td>';
        
                echo '</tr>';
            }

            // Display the total debit and credit balances in the last row
            echo '<tr>';
            echo '<td><strong>Total</strong></td>';
            echo '<td>' . number_format($total_debit, 2, '.', ',') . '</td>';
            echo '<td>' . number_format(abs($total_credit), 2, '.', ',') . '</td>';
            echo '</tr>';

            echo '</table>';
        } else {
            echo 'No accounts found.';
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
