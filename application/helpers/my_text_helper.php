<?php
error_reporting(E_ALL & ~E_NOTICE);

/**
 * check text or replace text
 *
 * @param String|null $text
 * @param String|null $replace
 * @return void
 */
function textShow(String $text = null, String $replace = null)
{
  # code...
  $result = trim($text) ? trim($text) : "";

  if ($replace && !$result) {
    $result = $replace;

  }

  return $result;
}

/**
 * check null
 *
 * @param String|null $text
 * @return void
 */
function textNull(String $text = null)
{
  # code...
  $result = null;

  if (trim($text)) {
    if ($text != "null" && $text != "NULL") {
      $result = $text;
    }
  }

  return $result;
}
