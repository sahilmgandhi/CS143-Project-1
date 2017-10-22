<!DOCTYPE html>
<html>
<title> Create Person - LMDb </title>
<body style="background-color:#CEDBED;">
<h1> Create Person </h1>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="radio" id="actor" name="persontype" value="actor"> <label for="actor">Actor</label>
    <input type="radio" id="director" name="persontype" value="director"> <label for="director">Director</label><br> <br>
    <input type="text" id="first" name="first" placeholder="First Name" size="20"> <br> <br>
    <input type="text" id="last" name="last" placeholder="Last Name" size="20"> <br> <br>
    <input type="date" id="dob" name="dob" placeholder="Birthday" size="20"> <br> <br>
    <input type="date" id="dod" name="dod" placeholder="Deathday" size="20"> <br> <br>
    <input type="radio" id="male" name="gender" value="male"> <label for="male">Male</label>
    <input type="radio" id="female" name="gender" value="female"> <label for="female">Female</label> <br> <br>
    <input type="submit" name="submit" value="Submit">
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

    $query = trim($_POST["submit"]);
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