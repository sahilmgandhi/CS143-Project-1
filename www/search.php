<!DOCTYPE html>
<html>
<title> LMDB </title>
<body style="background-color:#CEDBED;">
<h1> Localhost Movie DataBase </h1>
<?php $query = ""; ?>
<form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="text" id="search" name="search" placeholder="Search" size="100" value="<?php echo $_GET["search"] ?>"/>
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {

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

    $query = trim($_GET["search"]);
    $sanitized_name = mysql_real_escape_string($name, $db_connection);
    $query_to_issue = sprintf($query, $sanitized_name);
    $rs = mysql_query($query_to_issue, $db_connection);

    // TODO: Show results

    // Free the result and close the connection to the database
    mysql_free_result($rs);
    mysql_close($db_connection);
}
?>
</body>
</html>