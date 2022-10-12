<?php

namespace ThirdPartyOauth;

use ThirdPartyOauth\ConfigReader;

class BaseOauth{
  protected $configReader;
  function __construct(){
    $this->configReader = ConfigReader::getInstance();
  }
}
