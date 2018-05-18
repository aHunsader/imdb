<!DOCTYPE html>
<html>
<head>
	<title>IMDb</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/index-style.css" rel="stylesheet">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

	<script>
		function myFunction() {
		    var x = document.getElementById("myTopnav");
		    if (x.className === "topnav") {
		        x.className += " responsive";
		    } else {
		        x.className = "topnav";
		    }
		}
	</script>
</head>

<body>


<div class="topnav" id="myTopnav">
	  <a href="index.php" class="active" id="home">IMDb</a>
	  <a href="addmovie.php">Add Movie Info</a>
	  <a href="addperson.php">Add Actor/Director</a>
	  <a href="javascript:void(0);" class="icon" onclick="myFunction()"></a>
	</div>
<div class="main">


<div class="main">
	<h1>IMDb</h1>
	<form method="GET" class="form-inline" role="form">
		<div class="form-group has-feedback">
			<label class="control-label" for="search_input"></label>
	  		<input id="search_input" type="text" class="form-control" placeholder="Search.." name="search_input" required />
	  		<span class="glyphicon glyphicon-search form-control-feedback"></span>
		</div>
	</form>

	<?php

		if (isset($_GET["search_input"])){
			$term = $_GET["search_input"];
			$dest = "search.php?search_for=$term";
			header("location: $dest");
			exit();
		}	
	?>
</div>
</body>
</html>
