<!DOCTYPE html>
<html>
<title> Create Person - LMDb </title>

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
        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Create a new person.</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
        <div class=row>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Create new actors or directors!
                        </div>
                        <div class="panel-body">
                            <p>Modify the form below to create a new actor or director. If you are using Firefox, please use the proper format for the dates!</p>
                        </div>
                        <div class="panel-footer">
                        </div>
                </div>
                </div>

<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
        Fill out the following details for the person:
        </div>
    <div class="panel-body">

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="radio" id="actor" name="persontype" value="actor"> <label for="actor">Actor</label>
    <input type="radio" id="director" name="persontype" value="director"> <label for="director">Director</label><br>
    <br>
    <input type="text" id="first" name="first" placeholder="First Name" size="20" maxlength="20"
           value="<?php echo isset($_POST['first']) ? $_POST['first'] : '' ?>"> <br> <br>
    <input type="text" id="last" name="last" placeholder="Last Name" size="20" maxlength="20"
           value="<?php echo isset($_POST['last']) ? $_POST['last'] : '' ?>"> <br> <br>

    If using Firefox, please use the format (yyyy-mm-dd) for dates: <br>
    <input type="date" id="dob" name="dob" placeholder="Birthday" size="20"
           value="<?php echo isset($_POST['dob']) ? $_POST['dob'] : '' ?>"> <br> <br>
    <input type="date" id="dod" name="dod" placeholder="Deathday" size="20"
           value="<?php echo isset($_POST['dod']) ? $_POST['dod'] : '' ?>"> <br> <br>
    <input type="radio" id="male" name="sex" value="male"> <label for="male">Male</label>
    <input type="radio" id="female" name="sex" value="female"> <label for="female">Female</label> <br> <br>
    <input type="submit" value="Submit">
</form>
</div>
</div>
<?php

function validationErrors()
{
    $tablename = $_POST["persontype"];
    $last = $_POST["last"];
    $first = $_POST["first"];
    $sex = $_POST["sex"];
    $dob = $_POST["dob"];
    return (empty($last) || empty($first) || empty($dob) || empty($tablename) || ($tablename == "actor" && empty($sex)));
}

function validateDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (validationErrors()) {
        print "Please fill out all fields";
        exit(1);
    }
    if (!validateDate($_POST['dob']) || strtotime($_POST['dob']) > time()) {
        print "Please input the date of birth correctly and less than today's date!";
        exit(1);
    }
    if ((!empty($_POST['dod']) && !validateDate($_POST['dod'])) || (!empty($_POST['dod']) && $_POST['dod'] == 0)) {
        print "Please input the date of death correctly, or leave it blank if the person is still alive";
        exit(1);
    }
    if ((!empty($_POST['dod']) && $_POST['dod'] != 0) && (strtotime($_POST['dod']) < strtotime($_POST['dob']))){
        print "Please make sure that the date of death is AFTER the date of birth";
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

    $id_update_query = mysql_real_escape_string("UPDATE MaxPersonID SET id=id+1", $db_connection);
    $id_rs = mysql_query($id_update_query, $db_connection);
    $id_query = mysql_query("SELECT id FROM MaxPersonID", $db_connection);
    $id = (int)mysql_fetch_row($id_query)[0];
    $tablename = ucfirst($_POST["persontype"]); // Capitalize first letter of table name
    $last = $_POST["last"];
    $first = $_POST["first"];
    $sex = $_POST["sex"];
    $dob = $_POST["dob"];
    $dod = $_POST["dod"];
    if ($tablename == "Actor") {
        $query = "INSERT INTO {$tablename} VALUES ({$id}, '{$last}', '{$first}', '{$sex}', '{$dob}', '{$dod}')";
    } else {
        $query = "INSERT INTO {$tablename} VALUES ({$id}, '{$last}', '{$first}', '{$dob}', '{$dod}')"; // No sex
    }
    print $query;
    $sanitized_name = mysql_real_escape_string($name, $db_connection);
    $sanitized_query = sprintf($query, $sanitized_name);
    $rs = mysql_query($sanitized_query, $db_connection);
    if (mysql_affected_rows() == 0)
        print "Could not insert into database due to connection issues, please try again";

    // Free the result and close the connection to the database
    mysql_free_result($rs);
    mysql_close($db_connection);
    header("Location: person.php?person_type={$tablename}&id={$id}"); // Redirect to display page

}
?>
 </div>
</body>
</html>