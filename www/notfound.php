<!DOCTYPE html>
<html>
<title> Page not found - LMDb </title>
<body style="background-color:#CEDBED;">
<form method="GET" action="search.php">
    <input type="text" id="search" name="search" placeholder="Search" size="100" value="<?php echo $_GET["search"] ?>"/>
    <input type="submit" id="submit" name="submit" value="Search">
</form>
<h1> 404 - Page Not Found </h1>

<p>
    You have entered a URL that is invalid, or tried looking up a Movie, Actor, or Director that does not exist.
    Please search for another movie or actor
</p>

</body>
</html>