<!-- actor browsing file -->
<!DOCTYPE html>
<html>
<head>
	<title>Actor page</title>
	

<?php

include("header.php");

if (isset($_GET["id"])) {
	$id = $_GET["id"];
	do_stuff($id);
} else {
	echo "<h1>404: This page could not be found.</h1>";
}

function do_stuff($id) {
	$db = new mysqli('localhost', 'cs143', '', 'CS143');

	if($db->connect_errno > 0) {
		echo "<p>Unable to handle requests right now.</p>";
		exit();
	}

	$actor_query = "select * from Actor where id = $id;";
	$movie_query = "select MovieActor.mid as mid, Movie.title as title, MovieActor.role as role from Actor inner join MovieActor on Actor.id = MovieActor.aid inner join Movie on MovieActor.mid = Movie.id where Actor.id = $id;";
	$last_name = "";
	$first_name = "";
	$sex = "";
	$dob = "";
	$dod = "";

	if (!($result = $db->query($actor_query))) {
		$errmsg = $db->error;
		echo "<h1>404: This page could not be found.</h1>";
		echo $errmsg;
		$db->close();
		exit(1);
	}
	
	if ($row = $result->fetch_assoc()) {
		$last_name = $row["last"] ? $row["last"] : "";
		$first_name = $row["first"] ? $row["first"] : "";
		$sex = $row["sex"] ? $row["sex"] : "";
		$dob = ($row["dob"] == "0000-00-00" || !$row["dob"]) ? "" : $row["dob"];
		$dod = ($row["dod"] == "0000-00-00" || !$row["dod"]) ? "N/A" : $row["dod"];
		$result->free();
	} else {
		$result->free();
		echo "<h1>404: This page could not be found.</h1>";
		exit(1);
	}

	if ($first_name != ""){
		if ($last_name != "")
			echo "<h1>$first_name $last_name</h1>";
		else 
			echo "<h1>$first_name</h1>";
	} else {
		echo "<h1>404: This page could not be found.</h1>";
		exit();
	}
	if ($sex != "")
		echo "<p>Sex: $sex</p>";
	if ($dob != "")
		echo "<p>Date of Birth: $dob</p>";
	if ($dod != "")
		echo "<p>Date of Death: $dod</p>";

	if(!($result = $db->query($movie_query))) {
		$errmsg = $db->error;
		echo "<p>Unable to find $first_name $last_name" . "'s movies</p>";
		echo $errmsg;
		$db->close();
		exit(1);
	}

	if ($result->num_rows > 0)
		echo "<h2>Movies in which $first_name $last_name starred</h2>";
	while ($row = $result->fetch_assoc()) {
		$mid = $row["mid"];
		$title = $row["title"];
		if ($mid && $title){
			$role = ($row["role"] && $row["role"] != "") ? ": " . $row["role"] : "";
			echo "<p><a href='movie.php?id=$mid'>$title</a>$role</p>";
		}
	}
	$result->free();
	$db->close();
}

?>
</div>
</div>
<div class="col-sm-2 side"></div>
</div>
</body>
</html>
