
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
    <title>E-Booking</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link
      href="http://fonts.googleapis.com/css?family=Open+Sans"
      rel="stylesheet"
      type="text/css"
    />
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
      <div id="page-wrapper">
        <div id="page-inner">
          <div class="row">
            <div class="col-lg-12">
              <h2>ADMIN DASHBOARD</h2>
            </div>
          </div>
          <!-- /. ROW  -->
          <hr />
          <div class="row">
            <div class="col-lg-12">
              <?php
              if(isset($_SESSION['status'])){
                ?>
                <div class="alert alert-info">
                <strong>Welcome <?php
        // Connect to the database
        require_once 'connection.php';

        // Fetch data from Transactions, JournalEntries, and Accounts tables
        $sql = "SELECT username FROM users";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               
                echo  $row['username'];
            }
        } else {
            echo 'No data found.';
        }

        // Close the database connection
        $conn->close();
        ?></strong> <?php echo $_SESSION['status']; ?>
              </div>
                <?php
                  
                  unset($_SESSION['status']);
              }
              ?>
            </div>
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
  </body>
</html>
