<?php
userip();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Dori mobile blog</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Clean responsive bootstrap website template">
  <meta name="author" content="">
  <!-- styles -->
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
  <link href="assets/css/docs.css" rel="stylesheet">
  <link href="assets/css/prettyPhoto.css" rel="stylesheet">
  <link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">
  <link href="assets/css/flexslider.css" rel="stylesheet">
  <link href="assets/css/refineslide.css" rel="stylesheet">
  <link href="assets/css/font-awesome.css" rel="stylesheet">
  <link href="assets/css/animate.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/login.css" rel="stylesheet">
  <link href="assets/color/default.css" rel="stylesheet">
  <link rel="shortcut icon" href="assets/ico/favicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
  
</head>

<body>
  <header>
    <!-- Navbar -->
    <div class="cbp-af-header">
      <div class=" cbp-af-inner">
        <div class="container">
          <div class="row">

            <div class="span4">
              <!-- logo -->
              <div class="logo">
                <h1><a href="index.php">Dori - Mobile Blog</a></h1>
              </div>
              <!-- end logo -->
            </div>

            <div class="span8">
              <!-- top menu -->
              <div class="navbar">
                <div class="navbar-inner">
                  <nav>
                    <ul class="nav topnav">
                      <li class="dropdown">
                        <a href="index.php">Home</a>
                      </li>
                      <?php 
                      //nav bar guest start
                      if(empty($_SESSION['uid'])) :
                      ?>
                      <li>
                       <a> guest</a>
                      </li>
                      <li>
                        <a href="login.php"><button class="btn btn-success">sign in</button></a>
                      </li>
                      <li>
                        <a href="signup.php"><button class="btn btn-warning">sign up</button></a>
                      </li>
                        <?php
                     else:
                        //nav bar user connected start
                     ?>
                        <li>
                            <a><?= $_SESSION['name'];?></a>
                        </li>
                      <li>
                        <a href="logout.php"><button class="btn btn-danger">sign out</button></a>
                      </li>
                <?php endif;?>
                    </ul>
                  </nav>
                </div>
              </div>
              
              <!-- end menu -->
            </div>
           </div>
 
        </div>
          <!--alert massege-->
            <?php if(isset($_SESSION['msg']) &&!empty($_SESSION['msg'])):?>
          <div class="alert alert-<?= $_SESSION['msg_type'];?> alert-dismissible fade in text-center">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>
                <?= $_SESSION['msg_type'];?>
          </strong>
                <?= $_SESSION['msg'];?>
          </div>
                <?php
                endif;
                ?>

          <!--end alert massege-->

      </div>

    </div>

  </header>
