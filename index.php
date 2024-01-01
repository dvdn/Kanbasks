<?php $config = include('config.php');?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $config['title']; ?></title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php include('viewCrud.php'); ?>
  </body>
</html>
