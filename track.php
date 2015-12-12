<!DOCTYPE HTML>
<?php
/**
 * Created by PhpStorm.
 * User: Thijs
 * Date: 12-12-2015
 * Time: 13:41
 */

require_once 'db.php';

$sql = "SELECT name, timestamp, longitude, latitude, navstat FROM ais_data WHERE mmsi=$_GET[mmsi] ORDER BY TIMESTAMP ASC";
?>
<html>
<head>
    <title>Tracking</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<h1>Tracking Page</h1>
<h3>This page shows the movements (longitude and latitude) of the ship you clicked.</h3>


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
            timestamp
        </th>
        <th>
            longitude
        </th>
        <th>
            latitude
        </th>
        <th>
            navigational status (0-15)
        </th>
        </tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr><td style="font-size: x-small">' . date('H:i:s, d-m-Y', $row['timestamp']) . '</td><td>' . $row['longitude'] . '</td><td>' . $row['latitude'] . '</td><td>' . $row['navstat'] . '</td></tr>';
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