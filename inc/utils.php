<?php


 /**
 * setGroupInSession
 * existing POST value or first of the file
 *
 * @param  array $data
 * @return void
 */
function setGroupInSession($data)
{
  if (isset($_POST['group'])) {
    $_SESSION['group'] = $_POST['group'];
  }
  $firstGroupName = count($data) ? array_keys($data)[0] : '';
  $_SESSION['group'] = (isset($_SESSION['group']) && count($data) && array_key_exists($_SESSION['group'], $data)) ? $_SESSION['group'] : $firstGroupName;
}
