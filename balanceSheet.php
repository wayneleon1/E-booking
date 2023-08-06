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
                     <h2>BALANCE SHEET </h2>   
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                  <div>

        <?php
        // Connect to the database
        require_once 'connection.php';

        // Fetch asset, liability, equity, and P&L account balances from the Accounts table
        $sql_assets = "SELECT account_id, account_name FROM accounts WHERE account_type = 'asset'";
        $sql_liabilities = "SELECT account_id, account_name FROM accounts WHERE account_type = 'liability'";
        $sql_equity = "SELECT account_id, account_name FROM accounts WHERE account_type = 'equity'";
        $sql_profit_loss = "SELECT account_id, account_name FROM accounts WHERE account_type = 'income' OR account_type = 'expense'";

        $result_assets = $conn->query($sql_assets);
        $result_liabilities = $conn->query($sql_liabilities);
        $result_equity = $conn->query($sql_equity);
        $result_profit_loss = $conn->query($sql_profit_loss);

        // Calculate the total balance for assets, liabilities, equity, and P&L
        $total_assets = 0;
        $total_liabilities = 0;
        $total_equity = 0;
        $total_profit_loss = 0;

        // Display the balance sheet table
        echo '<table class="table table-striped table-bordered table-hover">';
        echo '<tr><th>Assets</th><th>Amount</th><th>Liabilities</th><th>Amount</th></tr>';

        // Calculate and display asset and liability balances
        while ($row_assets = $result_assets->fetch_assoc()) {
            $account_id_assets = $row_assets['account_id'];
            $account_name_assets = $row_assets['account_name'];

            // Calculate the total amount for each asset account
            $sql_amount_assets = "SELECT SUM(debit_amount - credit_amount) as total_amount 
                                  FROM journalEntries
                                  WHERE account_id = $account_id_assets";

            $result_amount_assets = $conn->query($sql_amount_assets);
            $row_amount_assets = $result_amount_assets->fetch_assoc();

            $amount_assets = $row_amount_assets['total_amount'];

            // Update the total assets
            $total_assets += $amount_assets;

            echo '<tr>';
            echo '<td>' . $account_name_assets . '</td>';
            echo '<td>' . $amount_assets . '</td>';

            // Display liability balances
            if ($row_liabilities = $result_liabilities->fetch_assoc()) {
                $account_id_liabilities = $row_liabilities['account_id'];
                $account_name_liabilities = $row_liabilities['account_name'];

                // Calculate the total amount for each liability account
                $sql_amount_liabilities = "SELECT SUM(debit_amount - credit_amount) as total_amount 
                                           FROM journalEntries
                                           WHERE account_id = $account_id_liabilities";

                $result_amount_liabilities = $conn->query($sql_amount_liabilities);
                $row_amount_liabilities = $result_amount_liabilities->fetch_assoc();

                $amount_liabilities = $row_amount_liabilities['total_amount'];

                // Update the total liabilities
                $total_liabilities += $amount_liabilities;

                echo '<td>' . $account_name_liabilities . '</td>';
                echo '<td>' . $amount_liabilities . '</td>';
            } else {
                echo '<td></td><td></td>';
            }

            echo '</tr>';
        }

        // Calculate and display equity balances
        while ($row_equity = $result_equity->fetch_assoc()) {
            $account_id_equity = $row_equity['account_id'];
            $account_name_equity = $row_equity['account_name'];

            // Calculate the total amount for each equity account
            $sql_amount_equity = "SELECT SUM(debit_amount - credit_amount) as total_amount 
                                  FROM journalEntries
                                  WHERE account_id = $account_id_equity";

            $result_amount_equity = $conn->query($sql_amount_equity);
            $row_amount_equity = $result_amount_equity->fetch_assoc();

            $amount_equity = $row_amount_equity['total_amount'];

            // Update the total equity
            $total_equity += $amount_equity;

            // Display equity balances
            echo '<tr>';
            echo '<td></td><td></td>';
            echo '<td>' . $account_name_equity . '</td>';
            echo '<td>' . $amount_equity . '</td>';
            echo '</tr>';
        }

        // Calculate and display P&L balances
        echo '<tr><th colspan="2">Total Assets</th><th colspan="2">Total Liabilities and Equity</th></tr>';
        while ($row_profit_loss = $result_profit_loss->fetch_assoc()) {
            $account_id_profit_loss = $row_profit_loss['account_id'];
            $account_name_profit_loss = $row_profit_loss['account_name'];

            // Calculate the total amount for each P&L account
            $sql_amount_profit_loss = "SELECT SUM(debit_amount - credit_amount) as total_amount 
                                       FROM journalEntries
                                       WHERE account_id = $account_id_profit_loss";

            $result_amount_profit_loss = $conn->query($sql_amount_profit_loss);
            $row_amount_profit_loss = $result_amount_profit_loss->fetch_assoc();

            $amount_profit_loss = $row_amount_profit_loss['total_amount'];

            // Update the total P&L
            $total_profit_loss += $amount_profit_loss;

            // Display P&L balances
            echo '<tr>';
            echo '<td>' . $account_name_profit_loss . '</td>';
            echo '<td>' . $amount_profit_loss . '</td>';
            echo '<td></td><td></td>';
            echo '</tr>';
        }

        // Calculate the total liabilities and equity
        $total_liabilities_and_equity = $total_liabilities + $total_equity;

        // Display total assets and total liabilities and equity
        echo '<tr>';
        echo '<td><strong>Total Assets</strong></td>';
        echo '<td><strong>' . $total_assets . '</strong></td>';
        echo '<td><strong>Total Liabilities and Equity</strong></td>';
        echo '<td><strong>' . $total_liabilities_and_equity . '</strong></td>';
        echo '</tr>';

        echo '</table>';

        // Display the total profit & loss
        // echo '<h3>Profit & Loss</h3>';
        // echo '<p>Total Profit (or Loss): ' . $total_profit_loss . '</p>';

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
