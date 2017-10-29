<!DOCTYPE html>
<html>
<title> MovieInfo - LMDb </title>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Core CSS -->
    <link href="jsAndCss/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMejsAndCss CSS -->
    <link href="jsAndCss/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Social jsAndCssttons CSS -->
    <link href="jsAndCss/vendor/bootstrap-social/bootstrap-social.css" rel="stylesheet">

    <!-- Custom jsAndCssS -->
    <link href="jsAndCss/dist/css/sb-admin-2.css" rel="stylesheet">

     <!-- DataTables CSS -->
    <link href="jsAndCss/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="jsAndCss/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

     <!-- Custom CSS -->
    <link href="jsAndCss/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom jsAndCssnts -->
    <link href="jsAndCss/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">LMDb - Localhost Movie Database</a>
            </div>
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <form method="GET" action="search.php">
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Search Movies/Actors" size="100" value="<?php echo $_GET["search"] ?>"/>
                                </form>
                            </span>
                            </div>
                        </li>
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Main Menu</a>
                        </li>
                        <li>
                            <a href="newperson.php"><i class="fa fa-user fa-fw"></i> Add new Actor/Director </a>
                        </li>
                        <li>
                            <a href="newmovie.php"><i class="fa fa-film fa-fw"></i> Add new Movie</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
</nav>

     <div id="page-wrapper">


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

$actorErrorFlag = false;
$actorErrorMsg = "";
$directorErrorFlag = false;
$directorErrorMsg = "";

$id = (int)$_GET["id"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int)$_POST["id"]; // We sent the id as a POST parameter in this case
    if (!empty($_POST["newActor"])) {
        $role = $_POST["role"];
        if (empty($role)){
            $actorErrorMsg = "Please make sure that the role is not empty";
            $actorErrorFlag = TRUE;
        }
        if (!$actorErrorFlag){
            $first = split(" ", $_POST["name"])[0];
            $last = split(" ", $_POST["name"])[1];
            $query = "INSERT INTO MovieActor SELECT $id, a.id, '$role' FROM Actor AS a WHERE a.first='$first' AND a.last='$last'";
            $newActorRs = mysql_query($query, $db_connection);
            if (mysql_affected_rows() == 0){
                $actorErrorMsg =  "Unable to find this actor. Please check if you typed the name correctly, or go <a href=newperson.php>here</a> to add the Actor.";
                $actorErrorFlag = TRUE;
            }    
        }
    } else if (!empty($_POST["newDirector"])) {
        $first = split(" ", $_POST["name"])[0];
        $last = split(" ", $_POST["name"])[1];
        $query = "INSERT INTO MovieDirector SELECT $id, d.id FROM Director AS d WHERE d.first='$first' AND d.last='$last' AND ($id, d.id) NOT IN (SELECT * FROM MovieDirector)";
        $newDirectorRs = mysql_query($query, $db_connection);
        if (mysql_affected_rows() == 0){
            $directorErrorMsg = "Unable to find this Director, or director already added to movie. Please check if you typed the name correctly, or go <a href=newperson.php>here</a> to add the Director.";
            $directorErrorFlag = TRUE;
        }
    } else if (!empty($_POST["newReview"])) {
        $name = $_POST["name"];
        if (empty($name)){
            $name = "Anonymous";
        }
        $rating = (int)$_POST["rating"];
        $comment = $_POST["comment"];
        $query = "INSERT INTO Review SELECT '$name', NOW(), $id, $rating, '$comment'";
        $reviewRs = mysql_query($query, $db_connection);
    }
}


$moviequery = "SELECT * FROM Movie WHERE id={$id}";
$rs = mysql_query($moviequery, $db_connection);
if (mysql_num_rows($rs) == 0) {
    header("Location: notfound.php"); // Redirect to display page
    return;
}
$row = mysql_fetch_row($rs);
$title = $row[1];
$year = $row[2];
$rating = $row[3];
$company = $row[4];
mysql_free_result($rs);

$actorquery = "SELECT * FROM MovieActor AS ma, Actor AS a WHERE ma.mid={$id} AND a.id = ma.aid";
$actorrs = mysql_query($actorquery, $db_connection);

$directorquery = "SELECT * FROM MovieDirector AS md, Director AS d WHERE md.mid={$id} AND d.id=md.did";
$directorrs = mysql_query($directorquery, $db_connection);

$genrequery = "SELECT * FROM MovieGenre WHERE mid={$id}";
$genrers = mysql_query($genrequery, $db_connection);

$reviewsquery = "SELECT * FROM Review WHERE mid={$id}";
$reviewsrs = mysql_query($reviewsquery, $db_connection);

$reviewsaveragequery = "SELECT AVG(rating) FROM Review WHERE mid={$id}";
$reviewavgrs = mysql_query($reviewsaveragequery, $db_connection);
$reviewavgrow = mysql_fetch_row($reviewavgrs);
$reviewavg = $reviewavgrow[0];
if (is_null($reviewavg)) {
    $reviewstring = "<i>Not enough reviews yet for an average score</i>";
} else {
    $reviewstring = "Users gave this movie an average score of {$reviewavg}/5";
}

$salesQuery = "SELECT * FROM Sales WHERE mid={$id}";
$sales = mysql_query($salesQuery, $db_connection);
$thisSale = FALSE;
if ($sales != FALSE)
    $thisSale = mysql_fetch_row($sales);

$ratingQuery = "SELECT * FROM MovieRating WHERE mid={$id}";
$ratings = mysql_query($ratingQuery, $db_connection);
$thisRating = FALSE;
if ($ratings != FALSE)
    $thisRating = mysql_fetch_row($ratings);

// Free the result and close the connection to the database
mysql_close($db_connection);
?>

<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
         <h1> <?php echo "$title ($year)" ?> </h1>
        </div>
    <div class="panel-body">

<?php echo $reviewstring ?> <br>

<?php
echo "Genres:";
$genreHtml = "";
while ($row = mysql_fetch_row($genrers)) {
    $genreHtml .= " <b>{$row[1]}</b>,";
}
if (empty($genreHtml)) {
    $genreHtml .= "<i>None</i>,";
}

echo substr($genreHtml, 0, -1);
?>
<br>
<?php
if (!empty($rating)) {
    echo "Rated $rating <br>";
}
//// Producer
if (!empty($company)) {
    echo "Produced by: $company <br>";
}

////////// Director
echo "Directed by: ";
$directorsHtml = "";
while ($row = mysql_fetch_row($directorrs)) {
    $did = $row[1];
    $name = $row[4] . ' ' . $row[3];
    $directorsHtml .= "<a href=person.php?person_type=Director&id={$did}>{$name}</a> ";
}
if (empty($directorsHtml)) {
    $directorsHtml = "<i>Unknown</i> "; // Keep this space at the end to be trimmed off
}
echo substr($directorsHtml, 0, -1);
echo "<br>";

////// Sales Information
$ticketsSold = 0;
$totalIncome = 0;
if ($thisSale != FALSE) {
    $ticketsSold = $thisSale[1];
    $totalIncome = $thisSale[2];
}
echo "Total tickets sold: $ticketsSold <br>";
echo "Total income: $totalIncome <br>";

////// Rotten/IMDB Information

$imdbRating = NULL;
$rotRating = NULL;
if ($thisRating != FALSE) {
    $imdbRating = $thisRating[1];
    $rotRating = $thisRating[2];
}

if (is_null($imdbRating))
    echo "The IMDB Rating currently does not exist <br>";
else
    echo "The IMDB Rating is: $imdbRating <br>";
if (is_null($rotRating))
    echo "The Rotten Tomatoes Rating currently does not exist <br>";
else
    echo "The Rotten Tomatoes Rating is: $rotRating <br>";

?>

<h4>Add New Director</h4>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="text" id="name" name="name" placeholder="Director Full Name" size="20 value="<?php echo isset($_POST['name']) && $directorErrorFlag ? $_POST['name'] : '' ?>"">
    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
    <input type="submit" id="newDirector" name="newDirector"> <br> <br>
</form>

<?php
if ($directorErrorFlag){
    echo $directorErrorMsg;
}
?>

<?php

echo "<br><br>";
////////// Actors
$actorsHtml = "";
$evenOrOdd = "even";
while ($row = mysql_fetch_row($actorrs)) {
    if ($evenOrOdd == "even")
        $evenOrOdd = "odd";
    else
        $evenOrOdd = "even";
    $aid = $row[1];
    $aname = $row[5] . ' ' . $row[4];
    $role = $row[2];
    $actorsHtml .= "<tr><td><a href=person.php?person_type=Actor&id={$aid}>{$aname}</a></td>\t";
    $actorsHtml .= "<td>{$role}</td></tr>";

}

echo "<div class=\"row\">";
if (empty($actorsHtml)) {
    echo "<i>No known actors for this movie</i>";
} else {
    echo "<div class=\"panel-body\">";
    echo "<table width=\"100%\" class=\"tabel table-striped table-bordered table-hover\" id=\"ActorTable\">\n";
    echo "<thead> <tr align=center>";
    $actorsHtml = "<th>Actor</th><th>Role</th></tr> </thead><tbody>" . $actorsHtml;
    echo $actorsHtml;
    echo "</tbody>";
    echo "</table><br>";
    echo "</div>";
}
echo "</div>";
?>
<h4>Add New Actor</h4>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="text" id="name" name="name" placeholder="Actor Full Name" size="20" value="<?php echo isset($_POST['name']) && $actorErrorFlag ? $_POST['name'] : '' ?>">
    <input type="text" id="role" name="role" placeholder="Actor Role" size="50" maxlength="50" value="<?php echo isset($_POST['role']) && $actorErrorFlag ? $_POST['role'] : '' ?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
    <input type="submit" id="newActor" name="newActor"> <br> <br>
</form>

<?php
if ($actorErrorFlag){
    echo $actorErrorMsg;
}
?>

<?php
echo "<h2>Reviews</h2>";
$reviewsHtml = "";
while ($row = mysql_fetch_row($reviewsrs)) {
    $name = $row[0];
    $time = $row[1];
    $rating = $row[3];
    $comment = $row[4];

    $reviewsHtml .= "<b>{$name}</b> - <i>{$rating}/5 Stars<br>Posted at {$time}</i><br>{$comment}<br><br>";
}

if (empty($reviewsHtml)) {
    $reviewsHtml = "<i>No reviews yet!</i>";
}

echo $reviewsHtml;

?>

<br> <br>
<h3>Leave a Review:</h3>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="text" id="name" name="name" placeholder="Name" size="20" maxlength="20"> <br>
    <p>Your rating:</p>
    <select name="rating">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select> <br>
    <input type="text" id="comment" name="comment" placeholder="Review/Comment" size="100" maxlength="500" > <br> <br>
    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
    <input type="submit" id="newReview" name="newReview"> <br> <br>
</form>
</div>
</div>
</div>

<script src="jsAndCss/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="jsAndCss/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="jsAndCss/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="jsAndCss/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="jsAndCss/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="jsAndCss/vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="jsAndCss/dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#ActorTable').DataTable({
            responsive: true
        });
    });
    </script>
</body>
</html>