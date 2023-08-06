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
    <title>Simple Responsive Admin</title>
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
                     <h2>GROUPE MEMBERS </h2>   
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                  <div class="col-lg-6 col-md-6">
                        <h5>Groupe Members</h5>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Reg</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>RURANGWA LEO</td>
                                    <td>LEO</td>
                                    <td>221011546</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>UMUTONI</td>
                                    <td>ALICE </td>
                                    <td>221001323</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>UWASE </td>
                                    <td>CHRISTELLA</td>
                                    <td>221011483</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>UWONKUNDA</td>
                                    <td>MIREILLE</td>
                                    <td>221018336</td>
                                </tr><tr>
                                    <td>5</td>
                                    <td>UMUTONI</td>
                                    <td>BENITHA</td>
                                    <td>221005939</td>
</tr>
                            </tbody>
                        </table>

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
   <script src="scripts.js"></script>
</html>
