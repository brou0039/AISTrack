<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: Maaike
 * Date: 14-12-2015
 * Time: 18:57
 */
require_once "db.php";
require_once "config.php";
$pages = 0;
$lower = 0;
$upper = 50;
$pag = 1;
$count = "SELECT COUNT(DISTINCT mmsi) AS count FROM ais_data WHERE type IN(0 ,33) OR type >=70 $limiter";

if(!isset($_GET['onder']))
{
    $lower1 = 0;
    $upper2 = 50;
}
else{
    $lower1 = $_GET['onder'];
    $upper2 = $_GET['boven'];
}
$sql = "SELECT mmsi, name, timestamp FROM ( SELECT mmsi, name, timestamp FROM ais_data WHERE type IN(0 ,33) OR type >=70 $limiter ORDER BY timestamp DESC LIMIT " . $lower1 . "," . $upper2 . ") AS sub GROUP BY mmsi ORDER BY timestamp DESC";
echo '<h1 style="text-align:center;">Hoofdpagina</h1>
<h3 style="text-align:center;">Op deze pagina vindt u een overzicht van alle schepen die de laatste tijd in het havengebied zijn geweest. Klik op één van
de schepen om meer informatie te krijgen over dit schip.</h3>';
echo '<table>
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
    </tr>';

if ($result = mysqli_query($con, $count)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pages = $row['count'];
    }
    mysqli_free_result($result);
}
if ($result = mysqli_query($con, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $date = DateTime::createFromFormat('U', $row['timestamp']);
        echo '<tr><td><a href="track.php?mmsi=' . $row['mmsi'] . '&name=' . $row['name'] .
            '">' . $row['mmsi'] . '</a></td><td>' . $row['name'] . '</td><td>' . date_format($date, 'H:i:s | d-m-Y') . '</td></tr>';
    }
    mysqli_free_result($result);
    echo '</table><br/>';
} else echo '</table><br/>something went wrong in your query. it did not return any results.';
mysqli_close($con);
echo "<div id='navbalk'>";
while ($upper < $pages)
{
    echo "<a href='index.php?lower=" . $lower . "&upper=" . $upper . "'>" . $pag . "</a> ";
    $upper = $upper + 50;
    $lower = $upper - 50;
    $pag++;
}
echo "</div>";
?>
</body>
</html>
