<!DOCTYPE html>
<html>
<title> CS 143 Project 1A </title>
<body style="background-color:#CEDBED;">
	<h1> CS 143 Project 1A </h1>
	<h3> By Sahil Gandhi and Vansh Gandhi </h3>
	<h4> This is the web page for the first part of CS 143 Project 1 </h4>
	<p> Please enter a SQL query below in order to get started! </p> <br>
	<?php $query = "";?>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<textarea name="query" rows="5" cols="40"><?php print $_POST['query'] ?></textarea>
		<input type="submit" name="submit" value="Submit">  
	</form>

	<?php

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$db_connection = mysql_connect("localhost", "cs143", "");
	  
		if(!$db_connection) {
			$errmsg = mysql_error($db_connection);
			print "Connection failed: $errmsg Exiting the program. <br>";
			exit(1);
		}

		$db_selected = mysql_select_db("CS143", $db_connection);

		if (!db_selected){
			$errmsg = mysql_error($db_selected);
			print "Unable to select the database specified. Exiting program.";
			exit(1);
		}

		$query = trim($_POST["query"]);
		$sanitized_name = mysql_real_escape_string($name, $db_connection);
		$query_to_issue = sprintf($query, $sanitized_name);
		$rs = mysql_query($query_to_issue, $db_connection);

		// Creating the table to show the data
		echo "<h3>The results from the database are:</h3>\n";
		echo "<table border=1 cellspacing=1 cellpadding=2>\n";
		echo "<tr align=center>";
		for ($i = 0; $i < mysql_num_fields($rs); $i++) {
			$field = mysql_fetch_field($rs, $i);
			echo "<th>" . $field->name . "</th>";
		}
		echo "</tr>\n";
		while ($row = mysql_fetch_row($rs)) {
			echo "<tr align=center>";
			for ($i = 0; $i < mysql_num_fields($rs); $i++) {
				$val = $row[$i];
				if (is_null($val))
					$val = "N/A";
				echo "<td>" . htmlspecialchars($val) . "</td>";
			}
			echo "</tr>\n";
		}    
		echo "</table>\n";

		// Free the result and close the connection to the database
		mysql_free_result($rs);
		mysql_close($db_connection);
	}
	?>
</body>
</html>