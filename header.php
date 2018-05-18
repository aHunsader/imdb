	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>

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
<body>
	<div class="topnav" id="myTopnav">
	  <a href="index.php" class="active" id="home">IMDb</a>
	  <a href="addmovie.php">Add Movie Info</a>
	  <a href="addperson.php">Add Actor/Director</a>
	  <a href="javascript:void(0);" class="icon" onclick="myFunction()"></a>
	</div>
<div class="container main">
	<div class="col-sm-2 side"></div>
	<div class="col-sm-8 outer_middle">
	<div class="middle">