<!DOCTYPE HTML>
<?php
/**
 * Created by PhpStorm.
 * User: Thijs
 * Date: 12-12-2015
 * Time: 13:41
 */

require_once 'db.php';
?>
<html>
<head>
    <title>Tracking</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<h1>Tracking Page</h1>



<?php
if (isset($_GET['mmsi'])) {
    $sql = "SELECT name, timestamp, longitude, latitude, navstat FROM ais_data WHERE mmsi=$_GET[mmsi] ORDER BY TIMESTAMP DESC";

    if ($result = mysqli_query($con, $sql)) {
        echo '
        <h3>Hier staan de gegevens van het schip dat is aangeklikt in de tabel op de hoofdpagina.</h3>
        <table id="table">
        <tr>
            <th>' . $_GET["mmsi"] . '</th>
            <th>' . $_GET["name"] . '</th>
            </tr>
            <tr>
        <th>
            tijd
        </th>
        <th>
            longitude
        </th>
        <th>
            latitude
        </th>
        <th>
            navigatiestatus 0-15(<a href="http://catb.org/gpsd/AIVDM.html#_types_1_2_and_3_position_report_class_a">?</a>)
        </th>
        <th>
            Google Maps locatie
        </th>
        </tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            $date = DateTime::createFromFormat('U', $row['timestamp']);
            echo '<tr><td style="font-size: x-small">' . date_format($date, 'H:i:s d-m-Y') . '</td><td>' . $row['longitude'] . '</td><td>' . $row['latitude'] . '</td><td>' . $row['navstat'] . '</td><td><a href="https://www.google.nl/maps/@' . $row['latitude'] . ',' . $row['longitude'] . ',17z?hl=en">Google Maps</a></td></tr>';
        }
        mysqli_free_result($result);
        echo '</table>';
    }
} else {
    echo "<h2>Oeps!</h2> er is iets fout gegaan. <br />Ga terug naar de hoofdpagina en probeer het opnieuw.<br/><br/>";

}
    mysqli_close($con);

    ?>

<a href="index.php">terug naar de hoofdpagina.</a>
</body>
</html>