<!DOCTYPE html>
<html>
<head>
	<title>Add an actor or director</title>

<?php
	include("header.php");
?>
<form method="GET">
	<div class="row">
		<div class="row" align="center">
			<h1>Add Actor or Director</h1>
		</div>
		<div class="form-group" id="type">
			<div class="col-sm-3">
			</div>
			<div class="col-sm-3">
				<label for="actor">Actor</label>
				<input class="form-check" type="radio" name="relation" value="Actor" id="actor" checked>  
			</div>
			<div class="col-sm-3">
				<label for="director">
					Director
				</label>
				<input class="form-check" type="radio" name="relation" value="Director" id="director"> 
			</div>
			<div class="col-sm-3">
			</div>
		</div>
		<br><br>
		<div class="form-group" id="name-input">
			<div class="col-sm-3">
				<label for="first">First Name:</label>
			</div>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="first" name="firstname" placeholder="first" required>
			</div>
			<div class="col-sm-1">
			</div>
		</div>
		<br><br>
		<div class="form-group" id="name-input">
			<div class="col-sm-3">
				<label for="last">Last Name:</label>
			</div>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="last" name="lastname" placeholder="last" required>
			</div>
			<div class="col-sm-1">
			</div>
		</div>
		<br><br>
		<div class="form-group" id="sex">
			<div class="col-sm-3">
				<label for="sex">Sex:</label>
			</div>
			<div class="col-sm-3">
				<label for="male">Male</label>
				<input class="form-check" type="radio" name="sex" value="male" id="male" checked>  
			</div>
			<div class="col-sm-3">
				<label for="female">Female</label>
					<input class="form-check" type="radio" name="sex" value="female" id="female"> 
			</div>
			<div class="col-sm-3">
			</div>
		</div>
		<br><br>
		<div class="form-group" id="dob">
			<div class="col-sm-3">
				<label for="dob">Date of Birth:</label>
			</div>
			<div class="col-sm-8">
				<input type="date" class="form-control" name="dob" id="dob" required>  
			</div>
			<div class="col-sm-1">
			</div>
		</div>
		<br><br>
		<div class="form-group" id="dod">
			<div class="col-sm-3">
				<label for="dod">Date of Death:</label>
			</div>
			<div class="col-sm-8">
				<input type="date" class="form-control" name="dod" value="dod" id="dod"> 
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

<?php
	if(isset($_GET["relation"]) && isset($_GET["firstname"]) && isset($_GET["lastname"]) && isset($_GET["sex"]) && isset($_GET["dob"]) && isset($_GET["dod"])){
		$relation = $_GET["relation"];
		$firstname = $_GET["firstname"];
		$lastname = $_GET["lastname"];
		$sex = $_GET["sex"];
		$dob = $_GET["dob"];
		$dod = $_GET["dod"];
		$db = new mysqli('localhost', 'cs143', '', 'CS143');
		if (strlen($firstname) > 20){
			my_alert("Please enter a first name that is fewer than 21 characters");
			$db->close();
			exit(1);
		}
		$firstname = $db->real_escape_string($firstname);
		$fullname = $firstname;
		$firstname = "\"$firstname\"";
		if (strlen($sex) > 6){
			my_alert("Please enter a sex that is fewer than 7 characters");
			$db->close();
			exit(1);
		}
		$sex = $db->real_escape_string($sex);
		$sex = "\"$sex\"";
		$dob = $db->real_escape_string($dob);
		$dob = "\"$dob\"";
		if ($dod == ""){
			$dod = "NULL";
		}
		else {
			$dod = $db->real_escape_string($dod);
			$dod = "\"$dod\"";
		}
		if ($lastname == "") {
			$lastname = "NULL";
		}
		else {
			if (strlen($lastname) > 20){
				my_alert("Please enter a last name that is fewer than 20 characters");
				$db->close();
				exit(1);
			}
			$lastname = $db->real_escape_string($lastname);
			$fullname = $fullname . " " . $lastname;
			$lastname = "\"$lastname\"";
		}
		if($db->connect_errno > 0){
			echo "<p>Unable to handle requests right now.</p>";
			exit();
		}
		$id = getID("select id from MaxPersonID", $db, "MaxPersonID", "Failed to add $fullname");
		if ($relation == "Actor"){
			check_duplicate("select id from Actor where last=$lastname and first=$firstname", $db, $fullname);
			execute_query("insert into Actor values($id,$lastname,$firstname,$sex,$dob,$dod)", $db, "Failed to add actor");
		}
		else {
			check_duplicate("select id from Director where last=$lastname and first=$firstname", $db, $fullname);
			execute_query("insert into Director values($id,$lastname,$firstname,$dob,$dod)", $db, "Failed to add director");
		}
		my_alert("$fullname added to database");
		$db->close();
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
	function execute_query($query, $db, $my_error_msg) {
		if (!($result = $db->query($query))){
			my_alert($my_error_msg);
			$db->close();
			exit(1);
		}
		return $result;
	}
	function check_duplicate($query, $db, $name){
		$result = execute_query($query, $db, "Failed to add $name");
		if (($row=$result->fetch_assoc()) != NULL){
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
?>
</div>
</div>
</body>
</html>