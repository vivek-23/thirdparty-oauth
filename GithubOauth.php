<?php

namespace ThirdPartyOauth;

class GithubOauth{
  private $clientId, $clientSecretKey;
  public function __construct(){
    $this->clientId = $configReader->get('git.client_id');
    $this->clientSecretKey = $configReader->get('git.client_secret_key');
  }

  public function login(){
    
  }
}
