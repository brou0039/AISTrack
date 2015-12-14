<?php
/**
 * Created by PhpStorm.
 * User: Maaike
 * Date: 14-12-2015
 * Time: 18:57
 */
require_once "db.php";
$pages = 0;
$onder = 0;
$boven = 50;
$pag = 1;
$count = "SELECT COUNT(DISTINCT mmsi) AS count FROM ais_data";

if(!isset($_GET['onder']))
{
    $grens1 = 0;
    $grens2 = 50;
}
else{
    $grens1=$_GET['onder'];
    $grens2=$_GET['boven'];
}
$sql = "SELECT mmsi, name, timestamp FROM ( SELECT mmsi, name, timestamp FROM ais_data ORDER BY timestamp DESC LIMIT ".$grens1.",".$grens2.") AS sub GROUP BY mmsi ORDER BY timestamp DESC";

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
            '">' . $row['mmsi'] . '</a></td><td>' . $row['name'] . '</td><td>' . date_format($date, 'H:i:s d-m-Y') . '</td></tr>';
    }
    mysqli_free_result($result);
    echo'</table>';
} else echo '</table><br/>something went wrong in your query. it did not return any results.';
mysqli_close($con);

while($boven <$pages)
{
    echo"<a href='probeersel.php?onder=".$onder."&boven=".$boven."'>".$pag."</a> ";
    $boven =$boven + 50;
    $onder = $boven - 50;
    $pag++;
}
?>