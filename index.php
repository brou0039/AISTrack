<?php
/**
 * Created by PhpStorm.
 * User: Maaike
 * Date: 10-12-2015
 * Time: 19:40
 */

  //db.php is used to connect to the database. in this file a mysqli object is made, called $con.
require_once 'db.php';

$sql = "SELECT * FROM ais_data";
$result = mysqli_query($con, $sql);
print_r($result);
?>