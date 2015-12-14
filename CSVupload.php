<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Upload page</title>
</head>
<body>
<div id="container">
    <div id="form">

        <?php

        include "db.php"; //Connect to Database through dbUtils
        //------------------------------------------------------------------------------//
        //Upload the CSV File containing the transactions 								//
        //------------------------------------------------------------------------------//
        if (isset($_POST['submit'])) {
            if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
                echo "<h1>" . "File " . $_FILES['filename']['name'] . " uploaded successfully." . "</h1>";
                echo "<h2>Displaying contents:</h2>";
                readfile($_FILES['filename']['tmp_name']);
            }
//------------------------------------------------------------------------------//
//				//Import uploaded file into the 'transactie' table				//
//------------------------------------------------------------------------------//
            $handle = fopen($_FILES['filename']['tmp_name'], "r");
            //create the query from the CSV file
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $import = "	INSERT INTO kadepunt(Kade_id,longitude,latitude)
					VALUES('$data[0]','$data[1]','$data[2]')";
                //execute query
                if ($con->query($import) === TRUE) {
                    $succes = TRUE;
                } else {
                    echo "Error: " . $import . "<br>" . $con->error;
                    $succes = FALSE;
                }

            }
//------------------------------------------------------------------------------//
//						give the user some feedback.							//
//------------------------------------------------------------------------------//
            if ($succes === TRUE) {
                echo "<br/> nieuwe transacties succesvol toegevoegd.";
            } else {
                echo "<br/> Er is een fout opgetreden! probeer het opnieuw.";
            }

            fclose($handle);//Close the open file pointe
//------------------------------------------------------------------------------//
//							//view upload form 									//
//------------------------------------------------------------------------------//
        } else {

            print "Upload new csv by browsing to file and clicking on Upload<br />\n";

            print "<form enctype='multipart/form-data' action='CSVupload.php' method='post'>";

            print "File name to import:<br />\n";

            print "<input size='50' type='file' name='filename'><br />\n";

            print "<input type='submit' name='submit' value='Upload'></form>";

        }

        ?>

    </div>
</div>
</body>
</html>