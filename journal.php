
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
    <title>General Journal</title>
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
                     <h2>GENERAL JOURNAL </h2>   
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
      <div>
                  <?php
        // Connect to the database
        require_once 'connection.php';

        // Fetch data from Transactions, JournalEntries, and Accounts tables
        $sql = "SELECT t.transaction_id, t.transaction_date, t.description, 
         j.account_id, j.debit_amount, j.credit_amount, a.account_name
  FROM transactions t
  INNER JOIN journalEntries j ON t.transaction_id = j.transaction_id
  INNER JOIN accounts a ON j.account_id = a.account_id
  ORDER BY t.transaction_date DESC";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Display the general journal table
            echo '<table class="table table-striped table-bordered table-hover">';
            echo '<tr><th>Date</th><th>Description</th><th>Account</th><th>Debit</th><th>Credit</th></tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['transaction_date'] . '</td>';
                echo '<td>' . $row['description'] . '</td>';
                echo '<td>' . $row['account_name'] . '</td>';
                echo '<td>' . ($row['debit_amount'] == "0.00" ? '' : number_format($row['debit_amount'], 2, '.', ',') ) . '</td>';
                echo '<td>' . ($row['credit_amount'] == "0.00" ? '' : number_format($row['credit_amount'], 2, '.', ',') ) . '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo 'No data found.';
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
