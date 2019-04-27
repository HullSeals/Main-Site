<?php
/**
 * Created by PhpStorm.
 * User: Lars
 * Date: 30/03/2019
 * Time: 14:48
 */
session_start();
$info = $_SESSION['info'];
echo "Current Location: ".$info['system']."<BR>";
echo "Current hull percentage: ".$info['hull']."<BR>";
echo "Is canopy breached: ".$info['breach']."<BR>";
echo "Oxygen in minutes: ".$info['oxygen']."<BR>";
var_dump($_SESSION['debug']);