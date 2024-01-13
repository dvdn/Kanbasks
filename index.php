<?php session_start();
$config = include('inc/config.php');
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
  const DEFAULT_GROUP = 'tasks';
  include('inc/viewDashboard.php');
  include('inc/Crud.php');
  $crud = new Crud($config['data_filepath']);

  if (isset($_POST['group'])) {
    $_SESSION['group'] = $_POST['group'];
  }
  $group = isset($_SESSION['group']) ? $_SESSION['group'] : DEFAULT_GROUP;

  // Display page content
  viewMenu();
  viewGroups($crud);
  viewActions($crud, $group, ANCHOR_NAME, DEFAULT_GROUP);
  viewHead();
  viewData($crud);
  ?>

  <footer><?php echo gmdate("Y-m-d\TH:i:s\Z"); ?></footer>
</body>

</html>