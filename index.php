<?php session_start();
$config = require('inc/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title><?php echo $config['title']; ?></title>
  <link rel="stylesheet" href="inc/style.css">
</head>

<body>

  <?php
  require('inc/utils.php');
  require('inc/viewDashboard.php');
  require('inc/Crud.php');

  $crud = new Crud($config['data_filepath']);
  setGroupInSession($crud);

  // Display page content
  viewMenu($crud);

  if (count($crud->data)) {
    viewGroups($crud, ANCHOR_NAME);
  }
  viewActions($crud, $_SESSION['group'], ANCHOR_NAME);
  viewHead();
  viewData($crud);
  ?>

  <footer><?php echo gmdate("Y-m-d\TH:i:s\Z"); ?></footer>
</body>

</html>
