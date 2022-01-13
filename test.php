<?php

require 'user.php';

$user = new User("badrkaiba","badr","badr@gmail.com","badr","sebaa");
$user->getAllInfo;
// var_dump($user);
var_dump($_SESSION['connect_user']);
?>