<!DOCTYPE HTML>
<?php
/**
 * Created by PhpStorm.
 * User: Thijs
 * Date: 12-12-2015
 * Time: 13:41
 */

require_once 'db.php';

$sql = "SELECT name,  ";
$sql .= "       TIMESTAMP,  ";
$sql .= "       lontitude,  ";
$sql .= "       latitude,  ";
$sql .= "       navstat ";
$sql .= "FROM ais_data  ";
$sql .= "WHERE mmsi=227075560 ";
$sql .= "ORDER BY TIMESTAMP ASC";
