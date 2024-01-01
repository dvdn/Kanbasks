<?php
// PHP debug

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php $config = include('inc/config.php');?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $config['title']; ?></title>
    <link rel="stylesheet" href="inc/style.css">
  </head>
  <body>
    <?php include('inc/viewCrud.php'); ?>
  </body>
</html>
