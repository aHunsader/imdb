<!-- Movie page -->
<!DOCTYPE html>
<html>

<head>
	<title>Movie Page</title>

<?php 
include("header.php");

if(isset($_GET["id"])) {
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

	$movie_query = "select * from Movie where id = $id;";
	$actor_query = "select Actor.first as first, Actor.last as last, Actor.id as aid, MovieActor.role as role from MovieActor inner join Actor on MovieActor.aid = Actor.id where MovieActor.mid = $id;";
	$rating_query = "select round(avg(rating), 2) as average from Review where mid = $id group by mid;";
	$comment_query = "select rating, name, comment, DATE_FORMAT(time,'%m/%d/%Y') as time from Review where mid = $id order by time desc;";
	$genre_query = "select * from MovieGenre where mid = $id;";
	$director_query = "select Director.first as first, Director.last as last from MovieDirector inner join Director on MovieDirector.did = Director.id where MovieDirector.mid = $id;";

	$movie_title = "";
	$average_score = "";
	$year = "";
	$rating = "";
	$company = "";
	$genres = "";

	if (!($result = $db->query($movie_query))) {
		$errmsg = $db->error;
		echo "<h1>404: This page could not be found.</h1>";
		echo $errmsg;
		$db->close();
		exit(1);
	}

	if ($row = $result->fetch_assoc()) {
		$movie_title = $row["title"] ? $row["title"] : "";
		$year = $row["year"] ? $row["year"] : "";
		$rating = $row["rating"] ? $row["rating"] : "";
		$company = $row["company"] ? $row["company"] : "";
		$result->free();
	} else {
		$result->free();
		echo "<h1>404: This page could not be found.</h1>";
		$db->close();
		exit(1);
	}

	if (!($result = $db->query($genre_query))) {
		$errmsg = $db->error;
		echo "<p>Unable to get genres</p>";
		echo $errmsg;
		$db->close();
		exit(1);
	}

	$counter = 1;
	$length = $result->num_rows;
	while ($row = $result->fetch_assoc()) {
		$genres .= $row["genre"] ? $row["genre"] : "";
		$genres .= $counter < $length ? ", " : "";
		$counter++;
	}
	$result->free();

	if (!($result = $db->query($rating_query))) {
		$errmsg = $db->error;
		echo "<p>Unable to get average score.</p>";
		echo $errmsg;
		$db->close();
		exit(1);
	}

	if ($row = $result->fetch_assoc()) {
		$average_score = $row["average"] ? $row["average"] : "";
	}
	$result->free();

	if ($movie_title != "")
		echo "<h1>$movie_title</h1>";
	else
		echo "<h1>404: This page could not be found.</h1>";
	if ($rating != "")
		echo "<p>MPAA Rating: $rating</p>";
	if ($average_score != "")
		echo "<p>Average Viewer Rating: $average_score / 5.00</p>";
	if ($year != "") 
		echo "<p>Year of Production: $year</p>";
	if ($company != "")
		echo "<p>Production Company: $company</p>";
	if ($genres != "")
		echo "<p>Genre: $genres</p>";

	//echo "<p><a href='addreview.php?id=$id'>Add a Review</a></p>";
	echo <<<HTML
	<button type='submit' class='btn btn-primary' onclick="window.location.href = 'addreview.php?id=$id'">Add Review</div>
HTML;
	
	if (!($result = $db->query($director_query))) {
		$errmsg = $db->error;
		echo "<p>Unable to find directors</p>";
		echo $errmsg;
		$db->close();
		exit(1);
	}

	if ($result->num_rows)
		echo "<h2>Directors</h2>";
	while ($row = $result->fetch_assoc()) {
		$first_name = $row["first"] ? $row["first"] : "";
		$last_name = ($row["last"] && $row["last"] != "") ? " " . $row["last"] : "";
		echo "<p>$first_name$last_name</p>";
	}
	$result->free();

	if (!($result = $db->query($actor_query))) {
		$errmsg = $db->error;
		echo "<p>Unable to find actors</p>";
		echo $errmsg;
		$db->close();
		exit(1);
	}

	if ($result->num_rows)
		echo "<h2>Actors</h2>";
	while ($row = $result->fetch_assoc()) {
		$first = $row["first"] ? $row["first"] : "";
		$last = ($row["last"] && $row["last"] != "") ? " " . $row["last"] : "";
		$aid = $row["aid"] ? $row["aid"] : "";
		$role = ($row["role"] && $row["role"] != "") ? ": " . $row["role"] : "";

		echo "<p><a href='actor.php?id=$aid'>$first$last</a>$role</p>";
	}
	$result->free();
	
	if (!($result = $db->query($comment_query))) {
		$errmsg = $db->error;
		echo "<p>Unable to find reviews</p>";
		echo $errmsg;
		$db->close();
		exit(1);
	}

	if ($result->num_rows)
		echo "<h2>User Reviews</h2>";
	while ($row = $result->fetch_assoc()) {
		$score = $row["rating"] ? $row["rating"] : "";
		$commenter = $row["name"] ? $row["name"] : "";
		$review = $row["comment"] ? $row["comment"] : "";
		$time = $row["time"] ? $row["time"] : "";

		echo "<div style='border-style: solid; border-color: #f4c741; border-width: 2px; border-radius: 5px;''>";
		if ($commenter != "")
			echo "<p style='font-weight: bold; margin-left: 10px;'>$commenter</p>";
		if ($time != "")
			echo "<p style='margin-left: 10px;'>Time posted: $time</p>";
		if ($score != "") 
			echo "<p style='margin-left: 10px;'>Score: $score / 5</p>";
		if ($review != "")
			echo "<p class='well'>$review</p>";
		echo "</div>";
	}
	$result->free();

	$db->close();
}

function addreview($id) {
	redirect("Location: addreview.php?id=$id");
	exit();
}

?>
</div>
</div>
<div class="col-sm-2 side"></div>
</div>
</body>
</html>