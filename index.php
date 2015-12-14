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
        function showShips(str) {
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";

            } else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET", "getships.php", true);
                xmlhttp.send();
            }
        }
    </script>

</head>
<body>
<h1>Hoofdpagina</h1>
<h3>Op deze pagina vindt u een overzicht van alle schepen die de laatste tijd in de haven zijn geweest. Klik op één van
de schepen om meer informatie te krijgen over dit schip.</h3>
<button onclick="showShips(this.value)" value="gitm">Get Ships</button>
<div id="txtHint"><b>Ship info will be listed here...</b></div>
</body>
</html>