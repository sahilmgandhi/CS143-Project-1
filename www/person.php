
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
    $sex = $actorrow[3];
    $dob = $actorrow[4];
    $dod = $actorrow[5];
    // TODO: Check the result of $rs (invalid id or something)


    $query = "SELECT * FROM MovieActor AS ma, Movie AS m WHERE ma.aid={$id} AND m.id=ma.mid";
    $sanitized_name = mysql_real_escape_string($name, $db_connection);
    $sanitized_query = sprintf($query, $sanitized_name);
    $moviers = mysql_query($sanitized_query, $db_connection);

    // Free the result and close the connection to the database
    mysql_free_result($rs);
    mysql_close($db_connection);
?>
<title> <?php echo $name ?> - LMDb </title>
<body style="background-color:#CEDBED;">
<form method="GET" action="search.php">
    <input type="text" id="search" name="search" placeholder="Search" size="100" value="<?php echo $_GET["search"] ?>"/>
    <input type="submit" id="submit" name="submit" value="Search">
</form>
<h1> <?php echo $name ?> </h1>
<?php
echo "<h3>Sex: $sex</h3>";
if (!empty($dob)) {
    echo "Born on $dob\t";
}
if (!empty($dod) && $dod != '0000-00-00') {
    echo "Died on $dod<br>";
}
else{
    echo "Currently still alive! <br>";
}
?>

<?php
$movieHtml = "";
while ($row = mysql_fetch_row($moviers)) {
    $mid = $row[0];
    $role = $row[2];
    $title = $row[4];

    $movieHtml .= "<tr><td><a href=movie.php?id={$mid}>{$title}</a></td>\t";
    $movieHtml .= "<td>{$role}</td></tr>";

}
if (empty($movieHtml)) {
    $movieHtml = "<i>$name has not been in any movies yet</i>";
} else {
    $movieHtml = "<table border=1 cellspacing=1 cellpadding=2>\n" . "<tr align=center>". "<th>Movie</th><th>Role</th>". $movieHtml;
}
echo $movieHtml;
echo "</table><br>";

?>

</body>
</html>