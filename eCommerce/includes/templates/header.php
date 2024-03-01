<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php getTitle() ?></title>
    <link rel="stylesheet" href="<?php echo $css;?>bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo $css;?>font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo $css;?>jquery-ui.css" />
    <link rel="stylesheet" href="<?php echo $css;?>jquery.selectBoxIt.css" />
    <link rel="stylesheet" href="<?php echo $css;?>frontend.css" />
</head>
<body>
   <nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      
      <a class="navbar-brand" href="index.php">Home Page</a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
      <li><a href="confirm-buy.php" class="fa fa-shopping-cart">
    <?php
    // Display the count of items in the shopping cart
    if (isset($_SESSION['user'])) {
        $userid = $_SESSION['uid'];
        $stmt = $con->prepare("SELECT COUNT(*) FROM `confirm-buy` WHERE Member_ID = ?");
        $stmt->execute(array($userid));
        $cartItemCount = $stmt->fetchColumn();
        echo '<span class="cart-item-count">' . $cartItemCount . '</span>';
    }
    ?>
</a>
</li>

        <?php
        $allCats = getAllFrom("*", "categories", "", "where parent = 0", "ID", "ASC");
        foreach ($allCats as $cat) {
          echo '<li><a href="categories.php?pageid=' . $cat['ID'] . '&pagename=' . str_replace(' ', '-', $cat['Name']) . '">' . $cat['Name'] . '</a></li>';
        }
        ?>
        <?php
        if (isset($_SESSION['user'])) { ?>
              

          <li class="dropdown">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <img class="my-image img-thumbnail img-circle" src="uploads/avatars/' . $item['avatar'] . '" alt=""/>

              <?php echo $sessionUser ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="profile.php">My Profile</a></li>
              <li><a href="newad.php">New Item</a></li>
              <li><a href="profile.php#my-ads">My Items</a></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </li>

        <?php
        } else {
        ?>
          <li><a href="login.php">Login/Signup</a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>