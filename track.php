<!DOCTYPE HTML>
<?php
/**
 * Created by PhpStorm.
 * User: Thijs
 * Date: 12-12-2015
 * Time: 13:41
 */

require_once 'db.php';

$sql = "SELECT name, timestamp, longitude, latitude, navstat FROM ais_data WHERE mmsi=$_GET[mmsi] ORDER BY TIMESTAMP DESC";
?>
<html>
<head>
    <title>Tracking</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<h1>Tracking Page</h1>
<h3>Hier staan de gegevens van het schip dat is aangeklikt ind e tabel op de hoofdpagina.</h3>


<?php
    if ($result = mysqli_query($con, $sql)) {
        echo '
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
            $date = new DateTime();
            $date->setTimestamp ( $row['timestamp'] );
            echo '<tr><td style="font-size: x-small">' . $date->format('H:i:s, d-m-Y') . '</td><td>' . $row['longitude'] . '</td><td>' . $row['latitude'] . '</td><td>' . $row['navstat'] . '</td><td><a href="https://www.google.nl/maps/@' . $row['latitude'] . ',' . $row['longitude'] . ',17z?hl=en">Google Maps</a></td></tr>';
        }
        mysqli_free_result($result);
        echo '</table>';
    } else {
        echo "Something went wrong. Please return to the main page and try again.";
    }
    mysqli_close($con);

    ?>

<a href="index.php">back to the main page.</a>
</body>
</html>