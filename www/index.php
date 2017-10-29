<!DOCTYPE html>
<html>
<title> CS 143 Project 1B </title>

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

<body">

<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.html">LMDb - Localhost Movie Database</a>
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
                            <!-- /input-group -->
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
            <h1> CS 143 Project 1B </h1>
            <h3> By Sahil Gandhi and Vansh Gandhi </h3>
            <h4> Welcome to the second part of project 1 for CS143. Take a look around to find out about some of the movies, actors
                and directors that interest you! </h4>
            <p> Some of the things that this webpage can do are: </p> <br>

     </div>
</body>
</html>