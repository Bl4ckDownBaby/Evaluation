<?php

class Autoload
{
  // accessible qu'a l'intérieur de la classe
  private static $classDirectory = './classes/';

  public static function classesAutoloader ($class) {
    $path = static::$classDirectory . "$class.php";
    if (file_exists($path) && is_readable($path)) require $path;
  }
}
