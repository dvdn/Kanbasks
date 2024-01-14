<?php

/**
 * setGroupInSession
 *
 * @param  Crud $crud
 * @return void
 */
function setGroupInSession($crud)
{
  if (isset($_POST['group'])) {
    $_SESSION['group'] = $_POST['group'];
  }
  $firstGroupName = count($crud->data) ? array_keys($crud->data)[0] : '';
  $_SESSION['group'] = (isset($_SESSION['group']) && count($crud->data) && array_key_exists($_SESSION['group'], $crud->data)) ? $_SESSION['group'] : $firstGroupName; // first group by default
}
