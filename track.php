<!DOCTYPE HTML>
<?php
/**
 * Created by PhpStorm.
 * User: Thijs
 * Date: 12-12-2015
 * Time: 13:41
 */

require_once 'db.php';
require_once 'config.php';
require_once 'kade_anderetest.php';
?>
<html>
<head>
    <title>Tracking</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body style="align-self: center">
<h1 style="text-align:center;">Tracking Page</h1>



<?php
if (isset($_GET['mmsi'])) {
    $count = "SELECT count(mmsi) as count FROM ais_data WHERE mmsi=$_GET[mmsi] $limiter";
    if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
    $num_rec_per_page = 120;
    $total_records = 0;
    $start_from = ($page-1) * $num_rec_per_page;
    if ($result = mysqli_query($con, $count)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $total_records = $row['count'];
        }
    mysqli_free_result($result);
}
    $hours = round(($total_records / 60), 1);
    $sql = "SELECT name, timestamp, longitude, latitude, navstat FROM ais_data WHERE mmsi=$_GET[mmsi] $limiter ORDER BY TIMESTAMP DESC LIMIT $start_from, $num_rec_per_page";

    if ($result = mysqli_query($con, $sql)) {
        echo '
        <h3 style="text-align:center;">Hier staan de gegevens van het schip dat is aangeklikt in de tabel op de hoofdpagina, onderverdeeld in stukken van twee uur. </h3>
        <table id="extra">
        <tr>
            <th>' . $_GET["mmsi"] . '</th>
            <th>' . $_GET["name"] . '</th>
            <th>totale tijd in havengebied ≈ ' . $hours . ' uur</th>
        </tr>
        </table>
        <table>
        <tr>
        <th>
            Bijzonderheid
        </th>
        <th>
            Tijd
        </th>
        <th>
            Longitude
        </th>
        <th>
            Latitude
        </th>
        <th>
            Navigatiestatus 0-15(<a href="http://catb.org/gpsd/AIVDM.html#_types_1_2_and_3_position_report_class_a">?</a>)
        </th>
        <!--
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
        </th>-->
        </tr>';
        $first = null;
        $nav5 = array();
        $numResult = mysqli_num_rows($result);
        $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);

        $counter = 0;
        $kades = getKades($con);
        $polygons = createPolygons($kades);
        foreach ($results as $row) {

//check if navstat == 5, after that push the row in an array.
//            if($row['navstat'] == 5)
//            {
//                array_push($nav5 , $row);
//            }
            if($first == null) {
                $date = DateTime::createFromFormat('U', $row['timestamp']);
                echo '<tr><td>Eerste meetpunt</td><td>' . date_format($date, 'H:i:s d-m-Y') .
                    '</td><td>' . $row['longitude'] . '</td><td>' . $row['latitude'] . '</td><td>' . $row['navstat'] . '</td></tr>';
                $first = 1;
            }
            if($row['navstat'] == 5)
            {

                $date = DateTime::createFromFormat('U', $row['timestamp']);
                echo '<tr><td>Kade meetpunt aan kade ' . checkShipIsOnKade($polygons, $row) . '</td><td>' . date_format($date, 'H:i:s d-m-Y') .
                    '</td><td>' . $row['longitude'] . '</td><td>' . $row['latitude'] . '</td><td><a href="https://www.google.nl/maps/@' . $row['latitude'] . ',' . $row['longitude'] . ',17z?hl=en">Google Maps</a></td></tr>';
            }
            if(++$counter ==$numResult)
            {
                $date = DateTime::createFromFormat('U', $row['timestamp']);
                echo '<tr><td>Laatste meetpunt</td><td>' . date_format($date, 'H:i:s d-m-Y') .
                    '</td><td>' . $row['longitude'] . '</td><td>' . $row['latitude'] . '</td><td>' . $row['navstat'] . '</td></tr>';
            }

            //echo '<tr><td style="font-size: x-small">' . date_format($date, 'H:i:s d-m-Y') . '</td><td>' . $row['longitude'] . '</td><td>' . $row['latitude'] . '</td><td>' . $row['navstat'] . '</td><td><a href="https://www.google.nl/maps/@' . $row['latitude'] . ',' . $row['longitude'] . ',17z?hl=en">Google Maps</a></td></tr>';
        }
        $total_pages = ceil($total_records / $num_rec_per_page);

        echo '</table>';
        echo '<div id="navbalk">';
        for ($i=1; $i<=$total_pages; $i++) {
            echo "<a href='track.php?mmsi=" . $_GET['mmsi'] . "&page=" . $i ."&name=" . $_GET['name'] . "'>".$i. "</a> ";
        };
    }
} else {
    echo "<h2>Oeps!</h2> er is iets fout gegaan. <br />Ga terug naar de hoofdpagina en probeer het opnieuw.<br/><br/>";

}
    ?>

<a href="index.php"><br/>terug naar de hoofdpagina.</a>
<!--</div>-->
</body>
</html>

