<!DOCTYPE html>
<html>
<title> LMDB </title>
<body style="background-color:#CEDBED;">
<h1> Localhost Movie DataBase </h1>
<form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="text" id="search" name="search" placeholder="Search" size="100" value="<?php echo $_GET["search"] ?>"/>
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["search"])) {

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

    $search = trim($_GET["search"]);
    $searchsplit = split(' ', $search);


    $actorquery = "SELECT * FROM Actor WHERE ";
    foreach ($searchsplit as $word) {
        $actorquery .= "CONCAT(first, ' ', last) LIKE '%$word%' AND ";
    }
    $actorquery = substr($actorquery, 0, -5);
    $actorrs = mysql_query($actorquery, $db_connection);

    $moviequery = "SELECT * FROM Movie WHERE ";
    foreach ($searchsplit as $word) {
        $moviequery .= "title LIKE '%$word%' AND ";
    }
    $moviequery = substr($moviequery, 0, -5);
    $moviers = mysql_query($moviequery, $db_connection);

    $actorsHtml = "";
    while ($row = mysql_fetch_row($actorrs)) {
        $aid = $row[0];
        $aname = $row[2].' '.$row[1];
        $actorsHtml .= "<tr><td><a href=person.php?person_type=Actor&id={$aid}>{$aname}</a></td>\t";

    }
    if (empty($actorsHtml)) {
        echo "<i>No actors found</i>";
    } else {
        echo "<table border=1 cellspacing=1 cellpadding=2>\n";
        echo "<tr align=center>";
        $actorsHtml = "<th>Actor</th>". $actorsHtml;
        echo $actorsHtml;
        echo "</table><br>";
    }


    $movieHtml = "";
    while ($row = mysql_fetch_row($moviers)) {
        $mid = $row[0];
        $title = $row[1];
        $movieHtml .= "<tr><td><a href=movie.php?id={$mid}>{$title}</a></td>\t";

    }
    if (empty($movieHtml)) {
        echo "<i>No movies found</i>";
    } else {
        echo "<table border=1 cellspacing=1 cellpadding=2>\n";
        echo "<tr align=center>";
        $movieHtml = "<th>Movie</th>". $movieHtml;
        echo $movieHtml;
        echo "</table><br>";
    }

    // Free the result and close the connection to the database
    mysql_free_result($rs);
    mysql_close($db_connection);
}
?>
</body>
</html>