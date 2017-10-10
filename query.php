<!DOCTYPE html>
<html>
<body>

<?php

$comment = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
  }

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
  Comment: <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>

  <input type="submit" name="submit" value="Submit">  
</form>

<?php
echo $comment;
?>

</body>
</html>