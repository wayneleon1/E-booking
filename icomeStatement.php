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
    <title>Profit & Loss Account</title>
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
                     <h2>Profit & Loss Account </h2>   
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
      <div>
        <?php
        // Connect to the database
        require_once 'connection.php';

        // Prepare the SQL statement to fetch income and expense accounts from the Accounts table
        $sql = "SELECT account_id, account_name, account_type FROM accounts 
                WHERE account_type = 'income' OR account_type = 'expense'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Initialize total revenues and total expenses
            $total_revenues = 0;
            $total_expenses = 0;

            // Display the table header
            echo '<table class="table table-striped table-bordered table-hover">';
            echo '<tr><th>Category</th><th>Amount</th></tr>';

            // Loop through the accounts and calculate the total revenues and total expenses
            while ($row = $result->fetch_assoc()) {
                $account_id = $row['account_id'];

                // Calculate the total debit and credit amounts for each account
                $sql_amounts = "SELECT SUM(debit_amount) as total_debit, SUM(credit_amount) as total_credit 
                                FROM journalEntries
                                WHERE account_id = $account_id";

                $result_amounts = $conn->query($sql_amounts);
                $row_amounts = $result_amounts->fetch_assoc();

                $debit_amount = $row_amounts['total_debit'];
                $credit_amount = $row_amounts['total_credit'];

                // Calculate the account balance
                $balance = $debit_amount - $credit_amount;

                // Update total revenues or total expenses based on the account type
                if ($row['account_type'] == 'income') {
                    $total_revenues += $balance;
                } else {
                    $total_expenses += $balance;
                }

                // Display the account name and balance in the table
                echo '<tr>';
                echo '<td>' . $row['account_name'] . '</td>';
                echo '<td>' . number_format($balance, 2) . '</td>';
                echo '</tr>';
            }

            // Calculate net income or loss
            $net_income_loss = $total_revenues - $total_expenses;

            // Display the total revenues, total expenses, and net income or loss
            echo '<tr>';
            echo '<td><strong>Revenue:</strong></td>';
            echo '<td></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Sales Revenue</td>';
            echo '<td>' . number_format($total_revenues, 2) . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Other Revenues</td>';
            echo '<td></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td><strong>Total Revenue</strong></td>';
            echo '<td>' . number_format($total_revenues, 2) . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td><strong>Expenses:</strong></td>';
            echo '<td></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Cost of Goods Sold</td>';
            echo '<td>' . number_format($total_expenses, 2) . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Gross Profit</td>';
            echo '<td>' . number_format($total_revenues - $total_expenses, 2) . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td>Operating Expenses:</td>';
            echo '<td></td>';
            echo '</tr>';

            // Additional expense categories can be displayed here if needed

            echo '<tr>';
            echo '<td><strong>Total Operating Expenses</strong></td>';
            echo '<td>' . number_format($total_expenses, 2) . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td><strong>Operating Income (or Loss)</strong></td>';
            echo '<td>' . number_format($total_revenues - $total_expenses, 2) . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td><strong>Other Income</strong></td>';
            echo '<td></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td><strong>Other Expenses</strong></td>';
            echo '<td></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td><strong>Net Income (or Loss)</strong></td>';
            echo '<td>' . number_format($net_income_loss, 2) . '</td>';
            echo '</tr>';

            echo '</table>';
        } else {
            echo 'No income or expense accounts found.';
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
