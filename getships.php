<!DOCTYPE html>
<html>
<?php
require_once 'db.php';
$limit = 18446744073709551615;
$sql = "SELECT mmsi, name, timestamp FROM ( SELECT mmsi, name, timestamp FROM ais_data ORDER BY timestamp DESC LIMIT 18446744073709551615) AS sub GROUP BY mmsi ORDER BY timestamp DESC"; //TODO optimise query
?>
<head></head>
<body>
<?php
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


if ($result = mysqli_query($con, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $date = DateTime::createFromFormat('U', $row['timestamp']);
        echo '<tr><td><a href="track.php?mmsi=' . $row['mmsi'] . '&name=' . $row['name'] .
            '">' . $row['mmsi'] . '</a></td><td>' . $row['name'] . '</td><td>' . date_format($date, 'H:i:s d-m-Y') . '</td></tr>';
    }
    mysqli_free_result($result);
} else echo '</table><br/>something went wrong in your query. it did not return any results.';
mysqli_close($con);

?>


</body>
</html>