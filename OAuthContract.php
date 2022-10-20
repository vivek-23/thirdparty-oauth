<?php

namespace ThirdPartyOauth;

interface OAuthContract{
  public function getUserDetails($accessToken);
  public function refreshToken();
}
