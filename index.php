<?php session_start();
$config = require('inc/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title><?php echo $config['title']; ?></title>
  <link rel="icon" href="favicon.png" type="image/png" >
  <link rel="stylesheet" href="inc/style.css">
</head>

<body>

  <?php
  require('inc/main.php');
  ?>

  <footer><?php echo gmdate("Y-m-d\TH:i:s\Z"); ?></footer>
</body>

</html>
