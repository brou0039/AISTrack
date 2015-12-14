<!DOCTYPE HTML>
<?php
/**
 * Created by PhpStorm.
 * User: Maaike
 * Date: 10-12-2015
 * Time: 19:40
 */

  //db.php is used to connect to the database. in this file a mysqli object is made, called $con.

//$sql = "SELECT mmsi, name, timestamp FROM ais_data WHERE type IN(0 ,33) OR type >=70 GROUP BY mmsi ORDER BY timestamp DESC";
require_once 'db.php';
?>
<html>
<head>
    <title>Hoofdpagina PoC groep C</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script>
        function showShips() {
            $.get("getships.php", function(data) {
                document.getElementById("txtHint").innerHTML = data;
            });
        }

    $(document).ready(function(){
        $("#showShipButton").click(showShips);
    });
    </script>

</head>
<body>
<h1>Hoofdpagina</h1>
<h3>Op deze pagina vindt u een overzicht van alle schepen die de laatste tijd in de haven zijn geweest. Klik op één van
de schepen om meer informatie te krijgen over dit schip.</h3>
<button id="showShipButton" value="gitm">Get Ships</button>
<div id="txtHint"><b>Ship info will be listed here...</b></div>
</body>
</html>
