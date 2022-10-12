<?php

namespace ThirdPartyOauth;

use Exception;

class GithubOauth extends BaseOauth{
  private $clientId, $clientSecretKey;
  public function __construct(){
    parent::__construct();
    $this->clientId = $this->configReader->get('git.client_id');
    $this->clientSecretKey = $this->configReader->get('git.client_secret_key');
  }

  public function login(){
    $_SESSION['github_state'] = bin2hex(random_bytes(10));
    $params = [
      'client_id' => $this->clientId,
      'state' => $_SESSION['github_state'],
      'redirect_uri' => $this->configReader->get('git.redirect_uri')
    ];

    $apiEndpoint = $this->configReader->get('git.OAUTH_ENDPOINTS.INITIAL_CONNECT.URL') . '?' . http_build_query($params);

    header('Location:'. $apiEndpoint);
    exit;
  }

  public function getAccessToken($params){
    if(!isset($params['code'], $params['state']) || $params['state'] !== $_SESSION['github_state']){
      throw new Exception("Unrecognized Oauth behaviour!!");
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->configReader->get('git.OAUTH_ENDPOINTS.ACCESS_TOKEN.URL'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
      'client_id' => $this->configReader->get('git.client_id'),
      'client_secret' => $this->configReader->get('git.client_secret_key'),
      'code' => $params['code'],
      'state' => $_SESSION['github_state']
    ]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Content-type:application/x-www-form-urlencoded',
      'Accept:application/json'
    ]);
    $response = curl_exec($ch);
    $curl_info = curl_getinfo($ch);
    curl_close($ch);
    if($curl_info['http_code'] !== 200){
      throw new Exception("Fetching access token failed!! Error received: " .$response);
    }
    return $response;
  }
}
