<?php session_start();
$config = require('inc/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title><?php echo $config['title']; ?></title>
  <link rel="icon" href="favicon.png" type="image/png">
  <link rel="stylesheet" href="inc/style.css">
</head>

<body>

  <?php
  require('inc/main.php');
  ?>

  <footer><?php echo gmdate("Y-m-d H:i:s"); ?> (Zulu) -
    <span>
      source code <a href="https://github.com/dvdn/Kanbasks" target="_blank">dvdn/Kanbasks</a>
    </span>
  </footer>
</body>

</html>
