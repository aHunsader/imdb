<!DOCTYPE html>
<html>
<head>
	<title>Search</title>
	<link href="css/equal-height-rows.css" rel="stylesheet">

<?php
	include("header.php");
?>
<div class="row" align="center" id="search_header">
	<h1>Search for Actor or Movie</h1>
</div>
<form method="GET">
	<div class="form-group row">
		<div class="col-sm-5" style="padding-right: 0px;">
		<input type="text" name="search_for" placeholder="Search.." class="form-control col-sm-5" required>
		</div>
		<div class="col-sm-2" style="padding-left: 0px;">
			<input type="submit" value="Submit" class="btn btn-primary">
		</div>
		<div class="col-sm-5"></div>
	</div>
</form>

<?php
	if (isset($_GET["search_for"])){
		$search_input = $_GET["search_for"];
		
		$db = new mysqli('localhost', 'cs143', '', 'CS143');
		if($db->connect_errno > 0){
			echo "<p>Unable to handle requests right now.</p>";
			exit();
		}
		$search_input = $db->real_escape_string($search_input);
		$search_input = "\"%$search_input%\"";
		echo "<div class='row row-eq-height row-eq-height'>";
		$actors_found = get_data("Actors", "select id, first, last from Actor where concat(first, ' ', last) like $search_input;", $db);
		$movies_found = get_data("Movies", "select id, title from Movie where title like $search_input;", $db);
		$db->close();
		echo "</div>";
	}
	function get_data($type, $query, $db){
		$result=execute_query($query, $db, "Failed to find $type");
		return print_results($type, $result);
	}
	function execute_query($query, $db, $my_error_msg) {
		if (!($result = $db->query($query))){
			echo "<p>$my_error_msg</p>";
			$db->close();
			exit(1);
		}
		return $result;
	}
	function print_results($type, $result){
		$initialized = False;
		echo "<div class='col-sm-6 actor_movie well' style='padding-top: 0px;'>";
		echo "<h3>$type:</h3>";
		while($row = $result->fetch_assoc()) {
			if ($initialized == False) {
				$colNames = array_keys($row);
				$initialized = True;
			}
			foreach ($colNames as $col_name) {
				switch($col_name) {
					case "id":
						$id = $row[$col_name];
						break;
					case "last":
						if ($row[$col_name] == NULL){
							$last = "NULL";
						}
						else {
							$last = $row[$col_name];
						}
						break;
					case "first":
						$first = $row[$col_name];
						break;
					case "title":
						$title = $row[$col_name];
						break;
				}
			}
			switch($type) {
				case "Actors":
					echo "<a href=\"actor.php?id=$id\">$first";
					if ($last != "NULL"){
						echo " $last";
					}
					echo "</a><br>";
					break;
				case "Movies":
					echo "<a href=\"movie.php?id=$id\">$title</a><br>";
					break;
			}
		}
		
		$result->free();
		if ($initialized){
			echo "</div>";
			return True;
		}
		echo "<p>No $type found</p>";
		echo "</div>";
		return False;
	}	
?>
</div>
</div>
<div class="col-sm-2"></div>
</div>
</body>
</html>