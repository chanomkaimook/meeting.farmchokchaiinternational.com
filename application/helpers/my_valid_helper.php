<?php
error_reporting(E_ALL & ~E_NOTICE);

/**
 * check text or replace text
 *
 * @param String|null $text
 * @param String|null $type = email
 * @return void
 */
function check_valid(String $text = null, String $type = null)
{
  # code...
  $result = false;
  
  switch($type){
    case 'email':
      if(!filter_var(trim($text), FILTER_VALIDATE_EMAIL)) {
        $result = true;
      }
      break;
  }

  return $result;
}
