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
    <title>Transaction</title>
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
                     <h2>TRANSACTION </h2>   
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                  <?php
              if(isset($_SESSION['comfrim'])){
                ?>
                <div class="alert alert-success">
               <?php echo $_SESSION['comfrim']; ?>
              </div>
                <?php
                  
                  unset($_SESSION['comfrim']);
              }
              ?>
    <form action="save_transaction.php" method="post">
        <div  class="row">
            <div class="col-md-6">
                 <h2>Record Transaction</h2>
                     <label for="transaction_date">Transaction Date:</label>
                        <input type="date" class="form-control" id="transaction_date" name="transaction_date" required>

                <label for="description">Description:</label>
                <textarea  class="form-control" id="description" name="description" required></textarea>
            </div>
        </div>
        <div  class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <h4 style="color:darkblue;font-weight:bold;">Choose Account to Debit</h4>
                    <label for="account1">Account:</label>
                        <select class="form-control" id="account1" name="accounts[]" required>
                            <!-- Populate this select dropdown with account options from the "Accounts" table in the database -->
                             <?php include 'get_accounts.php'; ?>
                            <!-- Add more options for each account in the "Accounts" table -->
                        </select>

                    <label for="debit1">Debit:</label>
                        <input type="number" class="form-control"  id="debit1" name="debits[]" required>
                    <label for="credit1">Credit:</label>
                        <input type="number" class="form-control"  id="credit1" name="credits[]" required>
            </div>
            <div class="col-lg-6 col-md-6">
                <h4 style="color:darkblue;font-weight:bold;">Choose Account to Credit</h4>
                    <label for="account${entryCount}">Account:</label>
                        <select class="form-control" id="account${entryCount}" name="accounts[]" required>
                            <?php
                                include "connection.php";
                                $q="SELECT account_id, account_name FROM accounts ORDER BY account_name";
                                $result=mysqli_query($conn,$q);
                                        
                                while($row=mysqli_fetch_array($result))
                                    {
                                    
                                            ?>    
                                                <option value="<?php echo $row['account_id'] ?>" ><?php echo $row['account_name'] ?></option>
                                
                                            <?php
                                    }



                                    ?>
                        </select>
                    <label for="debit${entryCount}">Debit:</label>
                            <input type="number" class="form-control" id="debit${entryCount}" name="debits[]" required>
                    <label for="credit${entryCount}">Credit:</label>
                            <input type="number" class="form-control"  id="credit${entryCount}" name="credits[]" required>     
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <br>
                <input type="submit" class="btn btn-primary" value="Record Transaction">
            </div>
            <div class="col-md-6">
                <br>
                <input type="reset" class="btn btn-danger" value="clear">
            </div>
        </div>
    </form>



             <!-- /. PAGE INNER  -->

            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
        <!-- /. Footer  -->
    <?php
    include 'footer.php';
    ?>
   <script src="scripts.js"></script>
</html>
