<?php

session_start();

require_once 'autoload.php';

$gitOauth = new ThirdPartyOauth\GithubOauth();

$gitOauth->login();
