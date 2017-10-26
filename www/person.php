
<!DOCTYPE html>
<html>
<?php
    $db_connection = mysql_connect("localhost", "cs143", "");
    if (!$db_connection) {
        $errmsg = mysql_error($db_connection);
        print "Connection failed: $errmsg Exiting the program. <br>";
        exit(1);
    }
    $db_selected = mysql_select_db("CS143", $db_connection);
    if (!$db_selected) {
        $errmsg = mysql_error($db_selected);
        print "Unable to select the database specified. Exiting program.";
        exit(1);
    }
    $id = (int) $_GET["id"];
    $query = "SELECT * FROM {$_GET["person_type"]} WHERE id={$id}";
    $sanitized_name = mysql_real_escape_string($name, $db_connection);
    $sanitized_query = sprintf($query, $sanitized_name);
    $rs = mysql_query($sanitized_query, $db_connection);
    $actorrow = mysql_fetch_row($rs);
    $name = $actorrow[2].' '.$actorrow[1];
    mysql_free_result($rs);
    // TODO: Check the result of $rs (invalid id or something)


    $query = "SELECT * FROM MovieActor AS ma, Movie AS m WHERE ma.aid={$id} AND m.id=ma.mid";
    $sanitized_name = mysql_real_escape_string($name, $db_connection);
    $sanitized_query = sprintf($query, $sanitized_name);
    $moviers = mysql_query($sanitized_query, $db_connection);
    $movierow = mysql_fetch_row($moviers);
    // Free the result and close the connection to the database
    mysql_free_result($moviers);
    mysql_close($db_connection);
?>
<title> <?php echo $name ?> - LMDb </title>
<body style="background-color:#CEDBED;">
<h1> <?php echo $name ?> </h1>
<!--TODO: show actual info from movie result-->
<?php var_dump($movierow); ?>

</body>
</html>