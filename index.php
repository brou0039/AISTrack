<!DOCTYPE HTML>
<?php
/**
 * Created by PhpStorm.
 * User: Maaike
 * Date: 10-12-2015
 * Time: 19:40
 */

  //db.php is used to connect to the database. in this file a mysqli object is made, called $con.
require_once 'db.php';

$sql = "SELECT mmsi, name, timestamp FROM ais_data WHERE type IN(0 ,33) OR type >=70 GROUP BY mmsi ORDER BY timestamp DESC";

?>
<html>
<head>
    <title>Hoofdpagina PoC groep C</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<h1>Hoofdpagina</h1>
<h3>Op deze pagina vindt u een overzicht van alle schepen die de laatste tijd in de haven zijn geweest. Klik op één van
de schepen om meer informatie te krijgen over dit schip.</h3>
<table>
    <tr>
        <th>
            MMSI nummer
        </th>
        <th>
            Naam schip
        </th>
        <th>
            Laatst geregistreerde aanwezigheid
        </th>
    </tr>

<?php
if($result = mysqli_query($con, $sql))
{
    while($row = mysqli_fetch_assoc($result))
    {
        $date = new DateTime();
        $date->setTimestamp ( $row['timestamp'] );
        echo '<tr><td><a href="track.php?mmsi=' . $row['mmsi'] . '&name=' . $row['name'] .
            '">' . $row['mmsi'] . '</a></td><td>' . $row['name'] . '</td><td>' . $date->format('H:i:s Y-m-d') . '</td></tr>';
    }
    mysqli_free_result($result);
}
mysqli_close($con);

?>

</table>
</body>
</html>