<?php
require_once('vendor/autoload.php');

$stripe = [
  "secret_key"      => "",
  "publishable_key" => "",
];

\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>
