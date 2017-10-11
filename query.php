<!DOCTYPE html>
<html>
<body>

<?php
$query = "";
$result = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $db_connection = mysql_connect("localhost", "cs143", "");
  
  if(!$db_connection) {
    $errmsg = mysql_error($db_connection);
    // print "Connection failed: $errmsg" <br/>;
    exit(1);
  }

  mysql_select_db("TEST", $db_connection);
  $query = test_input($_POST["query"]);
  $sanitized_name = mysql_real_escape_string($name, $db_connection);
  $query_to_issue = sprintf($query, $sanitized_name);
  $rs = mysql_query($query_to_issue, $db_connection);
  $result = "";
  while($row = mysql_fetch_row($rs)) {
    // $sid = $row[0];
    // $name = $row[1];
    // $email = $row[2];
    $result .= $row[0].' ';
    // print "$sid, $name, $email<br/>";
  }
  
  mysql_close($db_connection);
}

echo "Welcome to Sahil and Vansh's Project 1A for CS 143. Please enter a SQL query below in order to get started!";

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

<h2>Enter your SQL Query here:</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <br><br>
  Query: <textarea name="query" rows="5" cols="40"><?php echo $query;?></textarea>

  <input type="submit" name="submit" value="Submit">  
</form>

<?php print "<br><br>$query<br><br>"; ?>
<?php print "<br><br>$result<br><br>"; ?>

</body>
</html>