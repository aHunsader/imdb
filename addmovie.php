<!DOCTYPE html>
<html>
<head>
	<title>Enter movie information</title>

<?php
	include("header.php");
?>

<form method="GET">
	<div class="row" align="center">
		<h1>Add Movie</h1>
	</div>
	<div class="form-group" id="movie-input">
			<div class="col-sm-3">
				<label for="title">Title:</label>
			</div>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="title" name="title" placeholder="title" required>
			</div>
			<div class="col-sm-1">
		</div>
	</div>

	<br><br>
	<div class="form-group" id="movie-input">
		<div class="col-sm-3">
			<label for="year">Year:</label>
		</div>
		<div class="col-sm-8">
			<input type="number" class="form-control" id="year" name="year" placeholder="year">
		</div>
		<div class="col-sm-1">
		</div>
	</div>
	<br><br>
	<div class="form-group" id="movie-input">
		<div class="col-sm-3">
			<label for="rating">MPAA Rating:</label>
		</div>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="rating" name="rating" placeholder="rating">
		</div>
		<div class="col-sm-1">
		</div>
	</div>
	<br><br>
	<div class="form-group" id="movie-input">
		<div class="col-sm-3">
			<label for="company">Production Company:</label>
		</div>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="company" name="company" placeholder="company">
		</div>
		<div class="col-sm-1">
		</div>
	</div>
	<br><br>
	<div class="form-group" id="movie-input">
		<div class="col-sm-3">
			<label for="genre">Genre:</label>
		</div>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="genre" name="genre" placeholder="genre1, genre2, ...">
		</div>
		<div class="col-sm-1">
		</div>
	</div>
	<br><br>
	<div class="form-group" id="movie-input">
		<div class="col-sm-3"></div>
		<div class="col-sm-9">
		<button name="submit" type="submit" value="add_movie" class="btn btn-primary">Add Movie</button>
		</div>
	</div>
	<br><br>
</form>
<form method="GET">
	<div class="row" align="center">
		<h1>Add Actor to a Movie</h1>
	</div>
	<div class="form-group" id="actor-input">
		<div class="col-sm-3">
			<label for="atitle">Movie title:</label>
		</div>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="atitle" name="actor_movie_title" placeholder="title" required>
		</div>
		<div class="col-sm-1">
		</div>
	</div>
	<br><br>
	<div class="form-group" id="actor-input">
		<div class="col-sm-3">
			<label for="afirst">First Name:</label>
		</div>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="afirst" name="actor_first_name" placeholder="first" required>
		</div>
		<div class="col-sm-1">
		</div>
	</div>
	<br><br>
	<div class="form-group" id="actor-input">
		<div class="col-sm-3">
			<label for="alast">Last Name:</label>
		</div>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="alast" name="actor_last_name" placeholder="last" required>
		</div>
		<div class="col-sm-1">
		</div>
	</div>
	<br><br>
	<div class="form-group" id="actor-input">
		<div class="col-sm-3">
			<label for="role">Role:</label>
		</div>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="role" name="actor_role" placeholder="role">
		</div>
		<div class="col-sm-1">
		</div>
	</div>
	<br><br>
	<div class="form-group">
		<div class="col-sm-3"></div>
		<div class="col-sm-9">
		<button name="submit" type="submit" value="add_actor" class="btn btn-primary">Add Actor</button>
		</div>	
	</div>
	<br><br>
</form>
<form method="GET">
	<div class="row" align="center">
		<h1>Add Director to a Movie</h1>
	</div>
	<div class="form-group" id="director-input">
		<div class="col-sm-3">
			<label for="dtitle">Movie title:</label>
		</div>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="dtitle" name="director_movie_title" placeholder="title" required>
		</div>
		<div class="col-sm-1">
		</div>
	</div>
	<br><br>
	<div class="form-group" id="director-input">
		<div class="col-sm-3">
			<label for="dfirst">First Name:</label>
		</div>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="dfirst" name="director_first_name" placeholder="first" required>
		</div>
		<div class="col-sm-1">
		</div>
	</div>
	<br><br>
	<div class="form-group" id="director-input">
		<div class="col-sm-3">
			<label for="dlast">Last Name:</label>
		</div>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="dlast" name="director_last_name" placeholder="last" required>
		</div>
		<div class="col-sm-1">
		</div>
	</div>
	<br><br>
	<div class="form-group">
		<div class="col-sm-3"></div>
		<div class="col-sm-9">
		<button name="submit" type="submit" value="add_director" class="btn btn-primary">Add Director</button>
		</div>
	</div>
	<br><br>
</form>

<?php
	$db = new mysqli('localhost', 'cs143', '', 'CS143');
	if($db->connect_errno > 0){
		echo "<p>Unable to handle requests right now.</p>";
		exit();
	}
	switch($_REQUEST['submit']) {
		case 'add_movie': 
			if(isset($_GET["title"]) && isset($_GET["year"]) && isset($_GET["rating"]) && isset($_GET["company"]) && isset($_GET["genre"])){
				$title = $_GET["title"];
				$year = $_GET["year"];
				$rating = $_GET["rating"];
				$company = $_GET["company"];
				$genre = $_GET["genre"];
				if (strlen($title) > 100){
					my_alert("Please enter a title that is fewer than 101 characters");
					$db->close();
					exit(1);
				}
				$title = $db->real_escape_string($title);
				$print_title = $title;
				$title = "\"$print_title\"";
				if ($year == "") {
					$year = "NULL";
				}
				else {
					$year = $db->real_escape_string($year);
					$year = "\"$year\"";
				}
				if ($rating == "") {
					$rating = "NULL";
				}
				else {
					if (strlen($rating) > 10){
						my_alert("Please enter a rating that is fewer than 11 characters");
						$db->close();
						exit(1);
					}
					$rating = $db->real_escape_string($rating);
					$rating = "\"$rating\"";
				}
				if ($company == "") {
					$company = "NULL";
				}
				else {
					if (strlen($company) > 50){
						my_alert("Please enter a company that is fewer than 51 characters");
						$db->close();
						exit(1);
					}
					$company = $db->real_escape_string($company);
					$company = "\"$company\"";
				}
				
				if ($genre != ""){
					$genre_list = explode(", ", $genre);
					foreach ($genre_list as $g) {
						if (strlen($g) > 20){
							my_alert("Please enter genres that are fewer than 21 characters");
							$db->close();
							exit(1);
						}
					}
				}
				$mid = getID("select id from MaxMovieID", $db, "MaxMovieID", "Failed to add $print_title");
				check_duplicate("select title from Movie where title=$title",$db, $print_title);
				execute_query("insert into Movie values ($mid, $title, $year, $rating, $company)", $db, "Failed to add $print_title");
				my_alert("$print_title added");
				if ($genre != ""){
					foreach ($genre_list as $g) {
						if (strlen($g) > 0) {
							$g = "\"$g\"";
							execute_query("insert into MovieGenre values($mid,$g)", $db, "Failed to add genre $g to $print_title");
						}
					}
				}
			}
			break;
		case 'add_actor':
			if(isset($_GET["actor_movie_title"]) && isset($_GET["actor_first_name"]) && isset($_GET["actor_last_name"]) && isset($_GET["actor_role"])){
				$actor_movie_title = $_GET["actor_movie_title"];
				$actor_first_name = $_GET["actor_first_name"];
				$actor_last_name = $_GET["actor_last_name"];
				$actor_role = $_GET["actor_role"];
				$actor_movie_title = $db->real_escape_string($actor_movie_title);
				$actor_movie_print_title = $actor_movie_title;
				$actor_movie_title = "\"$actor_movie_print_title\"";
				$actor_first_name = $db->real_escape_string($actor_first_name);
				$actor_full_name = $actor_first_name;
				$actor_first_name  = "\"$actor_first_name\"";
				
				if ($actor_role == ""){
					$actor_role = "NULL";
				}
				else {
					if (strlen($actor_role) > 50){
						my_alert("Please enter a role that is fewer than 51 characters");
						$db->close();
						exit(1);
					}
					$actor_role = $db->real_escape_string($actor_role);
					$actor_role = "\"$actor_role\"";
				}
				$mid = find_id("select id from Movie where title = $actor_movie_title", $db, "$actor_movie_print_title not found in database");
				if ($actor_last_name == ""){
					$aid = find_id("select id from Actor where first = $actor_first_name and last = \"NULL\"", $db, "$actor_first_name not found in database");
				}	
				else {
					$actor_last_name = $db->real_escape_string($actor_last_name);
					$actor_full_name = $actor_full_name . " " . $actor_last_name;
					$actor_last_name = "\"$actor_last_name\"";
					$aid = find_id("select id from Actor where first = $actor_first_name and last = $actor_last_name", $db, "$actor_full_name not found in database");
				}
				execute_query("insert into MovieActor values($mid,$aid,$actor_role)", $db, "Failed to add $actor_full_name to $actor_movie_print_title");
				my_alert("$actor_full_name added to $actor_movie_print_title");
			}
			break;
		case 'add_director':
			if(isset($_GET["director_movie_title"]) && isset($_GET["director_first_name"]) && isset($_GET["director_last_name"])){
				$director_movie_title = $_GET["director_movie_title"];
				$director_first_name = $_GET["director_first_name"];
				$director_last_name = $_GET["director_last_name"];
				$director_movie_title = $db->real_escape_string($director_movie_title);
				$director_movie_print_title = $director_movie_title;
				$director_movie_title = "\"$director_movie_title\"";
				$director_first_name = $db->real_escape_string($director_first_name);
				$director_full_name = $director_first_name;
				$director_first_name = "\"$director_first_name\"";
					
				$mid = find_id("select id from Movie where title = $director_movie_title", $db, "$director_movie_print_title not found in database");
				if ($director_last_name == ""){
					$did = find_id("select id from Director where first = $director_first_name and last = \"NULL\"", $db, "$director_first_name not found in database");
				}	
				else {
					$director_last_name = $db->real_escape_string($director_last_name);
					$director_full_name = $director_full_name . " " . $director_last_name;
					$director_last_name = "\"$director_last_name\"";
					$did = find_id("select id from Director where first = $director_first_name and last = $director_last_name", $db, "$director_full_name not found in database");
				}
				check_duplicate("select mid from MovieDirector where mid=$mid and did=$did", $db, $director_full_name);
				execute_query("insert into MovieDirector values($mid,$did)", $db, "Failed to add $director_full_name to $director_movie_print_title");
				my_alert("$director_full_name added to $director_movie_print_title");
			}
			break;
	}
	function find_id($query, $db, $my_error_msg) {
		$result = execute_query($query, $db, $my_error_msg);
		if ($row = $result->fetch_assoc()){
			return $row["id"];
		}
		my_alert("$my_error_msg");
		$db->close();
		exit(1);
	}
	function execute_query($query, $db, $my_error_msg) {
		if (!($result = $db->query($query))){
			my_alert("$my_error_msg");
			$db->close();
			exit(1);
		}
		return $result;
	}
	function check_duplicate($query, $db, $name){
		$result = execute_query($query, $db, "Failed to add $name");
		if ($result->fetch_assoc() != NULL){
			my_alert("$name already added");
			$db->close();
			exit(1);
		}
	}
	function my_alert($alert_msg){
		echo '<script language="javascript">';
		echo 'alert("' . $alert_msg . '")';
		echo "</script>";
	}
	function getID($idquery, $db, $relation, $my_error_msg) {
		$result = execute_query($idquery, $db, "Query for max ID failed");
		$data = $result->fetch_assoc();
		$newid = $data["id"] + 1;
		if (is_null($newid)) {
			my_alert($my_error_msg);
			$db->close();
			exit(1);
		}
		execute_query("update $relation set id=$newid", $db, $my_error_msg);
		$result->free();
		return $newid;
	}
?>
</div>
</div>
</body>
</html>