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
  include('inc/viewDashboard.php');
  include('inc/Crud.php');
  $crud = new Crud($config['data_filepath']);

  function setGroupInSession($crud)
  {
    if (isset($_POST['group'])) {
      $_SESSION['group'] = $_POST['group'];
    }
    $firstGroupName = count($crud->data) ? array_keys($crud->data)[0] : '';
    $_SESSION['group'] = (isset($_SESSION['group']) && count($crud->data) && array_key_exists($_SESSION['group'], $crud->data)) ? $_SESSION['group'] : $firstGroupName; // first group by default
  }

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
