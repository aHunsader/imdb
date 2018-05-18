<!-- addreview page -->

<!DOCTYPE html>

<html>
<head>
	<title>Add Review</title>

<?php 

include("header.php");

if (isset($_GET["id"])) {
	$id = $_GET["id"];
	$db = new mysqli('localhost', 'cs143', '', 'CS143');
	if($db->connect_errno > 0) {
		echo "<p>Unable to handle requests right now.</p>";
		exit();
	}
	$san_id = $db->real_escape_string($id);
	$query = "select * from Movie where id = $san_id;";
	if (!($result = $db->query($query))) {
		echo "<h1>Add Review</h1>";
		echo "<p>No such movie exists</p>";
		$db->close();
		exit(1);
	}
	if (!$result->num_rows) {
		echo "<h1>Add Review</h1>";
		echo "<p>No such movie exists</p>";
		$db->close();
		exit(1);
	}
	$row = $result->fetch_assoc();
	$db->close();
	$title = $row["title"] ? $row["title"] : "";
	
	echo <<<HTML
	<form method="GET">
		<div class="row">
			<div class="row" align="center">
				<h1>Add Review for {$title}</h1>
			</div>
			<br><br>
			<input type="text" name="id" value="{$san_id}" hidden>
			<div class="form-group" id="name-input">
				<div class="col-sm-3">
					<label for="name">Your Name:</label>
				</div>
				<div class="col-sm-6">
					<input type="text" class="form-control" placeholder="Name" name="name" id="name" required>
				</div>
					<div class="col-sm-3">
				</div>
			</div>
			<br><br>
			<div class="form-group" id="rating">
				<div class="col-sm-3">
					<label>Your Rating:</label>
				</div>
				<div class="col-sm-9">
					<label for="1">1</label>
					<input class="form-check" type="radio" name="rating" value="1" id="1" required>
					<label for="2">2</label>
					<input class="form-check" type="radio" name="rating" value="2" id="2">
					<label for="3">3</label>
					<input class="form-check" type="radio" name="rating" value="3" id="3">
					<label for="4">4</label>
					<input class="form-check" type="radio" name="rating" value="4" id="4">
					<label for="5">5</label>
					<input class="form-check" type="radio" name="rating" value="5" id="5"> 
				</div>
			</div>
			<br><br>
			<div class="form-group" id="review">
				<div class="col-sm-3">
					<label for="review">Your Review:</label>
				</div>
				<div class="col-sm-8">
					<textarea name="review" class="form-control" rows="8" id="review"></textarea>
				</div>
				<div class="col-sm-1">
				</div>
			</div>
		</div>
		<br><br>
		<div class="row">
		<div class="col-sm-3"></div>
		<div class="col-sm-9">
			<input type="submit" value="Submit" class="btn btn-primary">
		</div>
		</div>
	</form>
HTML;
	if (isset($_GET["name"]) && isset($_GET["rating"]) && isset($_GET["review"])) {
		$name = $_GET["name"];
		$rating = $_GET["rating"];
		$review = $_GET["review"];
		do_stuff($name, $id, $rating, $review);
		redirect("movie.php?id=$san_id");
	}
} else {
	echo "<h1>404: This page could not be found.</h1>";
}
function do_stuff($name, $id, $rating, $review) {
	if (strlen($review) > 500) {
		my_alert("Please enter a review that is fewer than 500 characters");
		exit();
	}
	if (strlen($name) > 20) {
		my_alert("Please enter a name that is fewer than 20 characters");
		exit();
	}
	$db = new mysqli('localhost', 'cs143', '', 'CS143');
	if($db->connect_errno > 0) {
		die('Unable to connect to databse [$db->connect_errno]');
	}
	$san_id = $db->real_escape_string($id);
	$san_name = $db->real_escape_string($name);
	$san_review = $db->real_escape_string($review);
	$san_rating = $db->real_escape_string($rating);
	$insert = generate_insert($san_id, $san_review, $san_rating, $san_name);
	if (!$db->query($insert)) {
		echo "<p>Unable to add review.</p>";
		$db->close();
		exit(1);
	}
	$db->close();
}
function generate_insert($id, $review, $rating, $name) {
	return "insert into Review values ('$name', NOW(), '$id', '$rating', '$review');";
}
function redirect($location) {
	header("Location: $location");
	exit();
}

function my_alert($alert_msg){
	echo '<script language="javascript">';
	echo 'alert("' . $alert_msg . '")';
	echo "</script>";
}
?>

</div>
</div>
</div>
</body>
</html>