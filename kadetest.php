<?php
/**
 * Created by PhpStorm.
 * User: Maaike
 * Date: 15-12-2015
 * Time: 19:31
 */
require_once 'db.php';
$sql = 'SELECT K.id AS kid, K.naam AS knaam , P.id AS pid , P.longitude AS plongitude, P.latitude AS platitude
        FROM kadepunt P , kade K WHERE K.id = P.Kade_id ORDER BY K.id ASC , P.id ASC';
$kade = null;
if ($result = mysqli_query($con, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        if($kade != $row['kid'])
        {
            echo'</ul><br>';
            $kade = $row['kid'];
            echo 'Kade naam: ' . $row['knaam'];
            echo '<br>Kadepunten:';
            echo '<ul><li>' . $row['pid'] . ' Longitude: ' . $row['plongitude'] . ' Latitude: ' . $row['platitude'] . '</li>';
        }
        else{
            echo '<li>' . $row['pid'] . ' Longitude: ' . $row['plongitude'] . ' Latitude: ' . $row['platitude'] . '</li>';
        }
    }
    mysqli_free_result($result);
}
mysqli_close($con);
echo '</ul>';
