<!DOCTYPE html>
<html>
<title> Create Movie - LMDb </title>
<body style="background-color:#CEDBED;">
<h1> Create Movie </h1>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="text" id="title" name="title" placeholder="Movie Title" size="20"> <br> <br>
    <input type="number" id="year" name="year" placeholder="Movie Year" size="4"> <br> <br>
    <input type="text" id="rating" name="rating" placeholder="Movie Rating" size="10"> <br> <br>
    <input type="text" id="company" name="company" placeholder="Production Company" size="50"> <br> <br>
    <!--    TODO: Adding dynamic number of Genres!-->
    <!--    TODO: Adding dynamic number of Actors!-->
    <!--    TODO: Adding dynamic number of Directors!-->
    <input type="submit" value="Submit">
</form>

<?php

function validationErrors() {
    $year = $_POST["year"];
    $title = $_POST["title"];
    $rating = $_POST["rating"];
    $company = $_POST["company"];
    // TODO: Need at least 1 actor
    // TODO: Need at least 1 director
    // TODO: Need at least 1 genre
    return (empty($year) || empty($title) || empty($rating) || empty($company));
}

function fillOutFields() {
    // TODO: Fill out fields with previously submitted values
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (validationErrors()) {
        fillOutFields();
        print "Please fill out all fields";
        exit(1);
    }
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

    $id_update_query = mysql_real_escape_string("UPDATE MaxMovieID SET id=id+1", $db_connection);
    $id_rs = mysql_query($id_update_query, $db_connection);
    $id_query = mysql_query("SELECT id FROM MaxMovieID", $db_connection);
    $id = (int) mysql_fetch_row($id_query)[0];
    $year = $_POST["persontype"];
    $year = $_POST["year"];
    $title = $_POST["title"];
    $rating = $_POST["rating"];
    $company = $_POST["company"];
    $query = "INSERT INTO Movie VALUES ({$id}, '{$title}', {$year}, '{$rating}', '{$company}')";
    $sanitized_name = mysql_real_escape_string($name, $db_connection);
    $sanitized_query = sprintf($query, $sanitized_name);
    $rs = mysql_query($sanitized_query, $db_connection);


    // TODO: For every Actor entered, add an entry to MovieActor
    // TODO: For every Director entered, add an entry to MovieDirector
    // TODO: For every Genre entered, add an entry to MovieGenre

    $actors = [];
    $directors = []; // todo: store the director id's
    $genres = []; // todo: store the genre strings

    $query = "INSERT INTO MovieActor VALUES ";
    foreach ($actors as $actor) {
        $actorId = ""; // TODO!
        $role = ""; // TODO!
        $query .= "({$actorId}, {$id}, '{$role}'),";
    }
    $query = substr($query, 0, -1); // omits the last comma
    $sanitized_name = mysql_real_escape_string($name, $db_connection);
    $sanitized_query = sprintf($query, $sanitized_name);
    $rs = mysql_query($sanitized_query, $db_connection);

    $query = "INSERT INTO MovieDirector VALUES ";
    foreach ($directors as $directorId) {
        $query .= "({$directorId}, {$id}),";
    }
    $query = substr($query, 0, -1); // omits the last comma
    $sanitized_name = mysql_real_escape_string($name, $db_connection);
    $sanitized_query = sprintf($query, $sanitized_name);
    $rs = mysql_query($sanitized_query, $db_connection);

    $query = "INSERT INTO MovieGenre VALUES ";
    foreach ($genres as $genre) {
        $query .= "({$id}, '{$genre}'),";
    }
    $query = substr($query, 0, -1); // omits the last comma
    $sanitized_name = mysql_real_escape_string($name, $db_connection);
    $sanitized_query = sprintf($query, $sanitized_name);
    $rs = mysql_query($sanitized_query, $db_connection);



    mysql_free_result($rs);
    mysql_close($db_connection);
    header( "Location: movie.php?id={$id}"); // Redirect to display page
}
?>

</body>
</html>