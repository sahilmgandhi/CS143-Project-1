<!DOCTYPE html>
<html>
<title> Create Movie - LMDb </title>
<body style="background-color:#CEDBED;">
<form method="GET" action="search.php">
    <input type="text" id="search" name="search" placeholder="Search" size="100" value="<?php echo $_GET["search"] ?>"/>
    <input type="submit" id="submit" name="submit" value="Search">
</form>
<h1> Create Movie </h1>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    (Required Fields): <br>
    <input type="text" id="title" name="title" placeholder="Movie Title" size="20" value="<?php echo isset($_POST['title']) ? $_POST['title'] : '' ?>"> <br> <br>
    <input type="number" id="year" name="year" placeholder="Movie Year" size="4" value="<?php echo isset($_POST['year']) ? $_POST['year'] : '' ?>"> <br> <br>
    Movie rating: <select name="rating">
        <option></option>
        <option value="G">G</option>
        <option value="PG">PG</option>
        <option value="PG-13">PG-13</option>
        <option value="R">R</option>
        <option value="NC-17">NC-17</option>
        <option value="NC-17">X</option>
    </select> <br>
    <input type="text" id="company" name="company" placeholder="Production Company" size="50" value="<?php echo isset($_POST['company']) ? $_POST['company'] : '' ?>"> <br> <br>
    Genre: 
    <input type="checkbox" name="genre[]" value="Action">Action
    <input type="checkbox" name="genre[]" value="Adult">Adult
    <input type="checkbox" name="genre[]" value="Adventure">Adventure
    <input type="checkbox" name="genre[]" value="Comedy">Comedy  <br>
    <input type="checkbox" name="genre[]" value="Crime">Crime
    <input type="checkbox" name="genre[]" value="Documentary">Documentary
    <input type="checkbox" name="genre[]" value="Drama">Drama
    <input type="checkbox" name="genre[]" value="Family">Family  <br>
    <input type="checkbox" name="genre[]" value="Horror">Horror
    <input type="checkbox" name="genre[]" value="Musical">Musical
    <input type="checkbox" name="genre[]" value="Mystery">Mystery
    <input type="checkbox" name="genre[]" value="Romance">Romance  <br>
    <input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi
    <input type="checkbox" name="genre[]" value="Short">Short
    <input type="checkbox" name="genre[]" value="Thriller">Thriller
    <input type="checkbox" name="genre[]" value="War">War
    <input type="checkbox" name="genre[]" value="Western">Western  <br>
    <input type="checkbox" name="genre[]" value="Other">Other <br><br><br>
    
    (Optional Fields): <br>
    IMDB Rating: <input type="text" name="imdb" maxlength="3" size="3" value="<?php echo isset($_POST['imdb']) ? $_POST['imdb'] : '' ?>"><br>
    Rotten Tomatoes Rating <input type="text" name="rotten" maxlength="3" size="3" value="<?php echo isset($_POST['rotten']) ? $_POST['rotten'] : '' ?>"><br>

    Tickets Sold: <input type="text" name="tickets" value="<?php echo isset($_POST['tickets']) ? $_POST['tickets'] : '' ?>"><br>
    Total Income: <input type="text" name="income" value="<?php echo isset($_POST['income']) ? $_POST['income'] : '' ?>"> <br><br>

    <input type="submit" value="Submit">
</form>

<?php

function validationErrors() {
    $year = $_POST["year"];
    $title = $_POST["title"];
    $rating = $_POST["rating"];
    $company = $_POST["company"];
    $genre = $_POST['genre'];
   
    return (empty($year) || empty($title) || empty($rating) || empty($company) || empty($genre));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (validationErrors()) {
        print "You did not fill out all of the required fields, so your request was not submitted.";
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

    $genres = $_POST['genre']; 
        $query = "INSERT INTO MovieGenre VALUES ";
    foreach ($genres as $genre) {
        $query .= "({$id}, '{$genre}'),";
    }
    $query = substr($query, 0, -1); // omits the last comma
    $sanitized_name = mysql_real_escape_string($name, $db_connection);
    $sanitized_query = sprintf($query, $sanitized_name);
    $rs = mysql_query($sanitized_query, $db_connection);

    $imdbRating = $_POST['imdb'];
    $rotRating = $_POST['rotten'];

    if (empty($imdbRating) || $imdbRating < 0)
        $imdbRating = NULL;
    if (empty($rotRating) || $rotRating < 0)
        $rotRating = NULL;
    $query= "INSERT INTO MovieRating VALUES ({$id}, {$imdbRating}, {$rotRating})";
    $sanitized_name = mysql_real_escape_string($name, $db_connection);
    $sanitized_query = sprintf($query, $sanitized_name);
    $rs = mysql_query($sanitized_query, $db_connection);    
    
    $tickets = $_POST['tickets'];
    $sales = $_POST['income'];

    if (empty($tickets))
        $tickets = 0;
    if (empty($sales))
        $sales = 0;

    $query = "INSERT INTO Sales VALUES ({$id}, {$tickets}, {$sales})";
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