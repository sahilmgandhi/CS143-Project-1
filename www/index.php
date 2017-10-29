<!DOCTYPE html>
<html>
<title> CS 143 Project 1B </title>
<body style="background-color:#CEDBED;">

<h1> CS 143 Project 1B </h1>
<h3> By Sahil Gandhi and Vansh Gandhi </h3>
<h4> Welcome to the second part of project 1 for CS143. Take a look around to find out about some of the movies, actors
    and directors that interest you! </h4>
<p> Some of the things that this webpage can do are: </p> <br>

<!-- TODO: Format this page better, add links to the different other php pages and also add the other things that this page can support -->
<p>Find a movie of your choice or actor/actress of your choice: </p> <br>
<form method="GET" action="search.php">
    <input type="text" id="search" name="search" placeholder="Search" size="100" value="<?php echo $_GET["search"] ?>"/>
</form>


<p>Add a new actor or director of your choice:</p> <br>
<p>Add a movie of your choice:</p> <br>

<p>Add an actor to a movie relation of your choice:</p> <br>
<p>Add a director to a movie relation of your choice:</p> <br>


</body>
</html>