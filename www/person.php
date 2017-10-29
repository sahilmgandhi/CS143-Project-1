<!DOCTYPE html>
<html>
<title> <?php echo $name ?> - LMDb </title>
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
$id = (int)$_GET["id"];
$query = "SELECT * FROM {$_GET["person_type"]} WHERE id={$id}";
$sanitized_name = mysql_real_escape_string($name, $db_connection);
$sanitized_query = sprintf($query, $sanitized_name);
$rs = mysql_query($sanitized_query, $db_connection);
$didFindPerson = mysql_num_rows($rs) != 0;
$actorrow = mysql_fetch_row($rs);
$name = $actorrow[2] . ' ' . $actorrow[1];
$hasSexField = $_GET["person_type"] == "Actor" ? 1 : 0;
$sex = $actorrow[3];
$dob = $actorrow[3 + $hasSexField];
$dod = $actorrow[4 + $hasSexField];

$query = "SELECT * FROM MovieActor AS ma, Movie AS m WHERE ma.aid={$id} AND m.id=ma.mid";
$sanitized_name = mysql_real_escape_string($name, $db_connection);
$sanitized_query = sprintf($query, $sanitized_name);
$moviers = mysql_query($sanitized_query, $db_connection);

// Free the result and close the connection to the database
mysql_free_result($rs);
mysql_close($db_connection);
?>
<h1> <?php echo $name ?> </h1>
<?php
if (empty($id) || !$didFindPerson) {
    header("Location: notfound.php"); // Redirect to display page
}
if ($_GET["person_type"] == "Actor") {
    echo "<h3>Sex: $sex</h3>";
}
$death = empty($dod) || $dod == '0000-00-00' ? "<i>Present</i>" : $dod;
echo "Alive from: $dob-$death<br>";
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
echo "<div class=\"row\">";
if (empty($movieHtml)) {
    $movieHtml = "<i>$name has not been in any movies yet</i>";
} else {
    echo "<div class=\"panel-body\">";
    echo "<table width=\"100%\" class=\"tabel table-striped table-bordered table-hover\" id=\"MovieTable\">\n";
    echo "<thead> <tr align=center>";
    $movieHtml = "<th>Movie</th><th>Role</th> </thead><tbody>" . $movieHtml;
    echo $movieHtml;
    echo "</tbody></table><br></div>";
}
echo "</div>";


?>
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
        $('#MovieTable').DataTable({
            responsive: true
        });
    });
    </script>
</body>
</html>