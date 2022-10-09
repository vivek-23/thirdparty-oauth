<?php

namespace ThirdPartyOauth;

use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use FilesystemIterator;

final class ConfigReader{
  private static ?ConfigReader $instance = null;
  private $configMap;

  private const configPath = __DIR__ . DIRECTORY_SEPARATOR . 'config';

  private function __construct(){
    $this->configMap = [];
    $configFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(self::configPath, FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::SKIP_DOTS));
    foreach($configFiles as $file){
      if(strtolower(pathinfo($file->getPathname(), PATHINFO_EXTENSION)) === 'example'){
        continue;
      }
      $this->configMap = array_merge($this->configMap, include_once $file->getPathname());
    }
  }

  public static function getInstance(){
    if(self::$instance === null){
        self::$instance = new ConfigReader();
    }
    return self::$instance;
  }
  
  public function get($keyPath){
    $val = $this->configMap;
    foreach(explode(".", $keyPath) as $key){
      if(!isset($val[ $key ])){
        throw new Exception("$key not found for path $keyPath in any of the config files!!");
      }
      $val = $val[ $key ];
    }
    return $val;
  }
}
