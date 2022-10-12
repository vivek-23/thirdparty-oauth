<?php

session_start();

require_once 'autoload.php';

$gitOauth = new ThirdPartyOauth\GithubOauth();

echo $gitOauth->getAccessToken($_GET);
