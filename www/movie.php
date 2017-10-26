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
$moviequery = "SELECT * FROM Movie WHERE id={$id}";
$sanitized_name = mysql_real_escape_string($name, $db_connection);
$sanitized_query = sprintf($moviequery, $sanitized_name);
$rs = mysql_query($sanitized_query, $db_connection);
$row = mysql_fetch_row($rs);
$title = $row[1];
$year = $row[2];
$rating = $row[3];
$company = $row[4];
mysql_free_result($rs);
// TODO: Check the result of $rs (invalid id or something)



$actorquery = "SELECT * FROM MovieActor WHERE mid={$id}";
$sanitized_name = mysql_real_escape_string($name, $db_connection);
$sanitized_query = sprintf($actorquery, $sanitized_name);
$actorrs = mysql_query($sanitized_query, $db_connection);


$directorquery = "SELECT * FROM MovieDirector WHERE mid={$id}";
$sanitized_name = mysql_real_escape_string($name, $db_connection);
$sanitized_query = sprintf($directorquery, $sanitized_name);
$directorrs = mysql_query($sanitized_query, $db_connection);


$genrequery = "SELECT * FROM MovieGenre WHERE mid={$id}";
$sanitized_name = mysql_real_escape_string($name, $db_connection);
$sanitized_query = sprintf($genrequery, $sanitized_name);
$genrers = mysql_query($sanitized_query, $db_connection);

$reviewsquery = "SELECT * FROM Review WHERE mid={$id}";
$sanitized_name = mysql_real_escape_string($name, $db_connection);
$sanitized_query = sprintf($genrequery, $sanitized_name);
$reviewsrs = mysql_query($sanitized_query, $db_connection);

$reviewsaveragequery = "SELECT AVG(rating) FROM Review WHERE mid={$id}";
$sanitized_name = mysql_real_escape_string($name, $db_connection);
$sanitized_query = sprintf($genrequery, $sanitized_name);
$reviewavg = mysql_fetch_row(mysql_query($sanitized_query, $db_connection))[0];



// Free the result and close the connection to the database
mysql_close($db_connection);
?>
<title> <?php echo $title ?> - LMDb </title>
<body style="background-color:#CEDBED;">
<h1> <?php echo $title ?> </h1>
<!--TODO: show actual info from movie + actor + director + genre results -->


<!--TODO: Show list of directors-->
<!--TODO: Have a field on this page itself to be able to add directors to this movie-->
<!--TODO: Show list of actors-->
<!--TODO: Have a field on this page itself to be able to add actors to this movie-->


<!--TODO: Show all other comments for this movie-->
<br> <br>
<?php echo "Users gave this movie an average score of {$reviewavg}/5" ?>
<br> <br>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="text" id="name" name="name" placeholder="Name" size="20"> <br> <br>
    <select name="rating">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select> <br>
    <input type="text" id="comment" name="comment" placeholder="Comment" size="100"> <br> <br>
    <input type="submit" value="Add Comment">
</form>

</body>
</html>