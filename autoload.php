<?php

spl_autoload_register(function($className){
  $parts = explode('\\', $className);
  $className = end($parts);
  if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . $className . ".php")){
    require_once __DIR__ . DIRECTORY_SEPARATOR . $className . ".php";
  }else{
    throw new Exception("$className class not found!");
  }
});
