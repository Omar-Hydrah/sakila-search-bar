<?php
$pdo = new PDO("mysql:host=localhost; dbname=sakila", "root", ""); 

// Handling the request of finding actors.
if(isset($_GET['actor_name'])){
	$actor_name = $_GET['actor_name'];
	$offset     = (int)$_GET["offset"];
	
	// If the supplied name only has one or less spaces.
	if(substr_count($actor_name, " ") < 2){
		$first_name = explode(" ", $actor_name)[0] . "%" ;
		$last_name  = substr_count($actor_name, " ") > 0 ? explode(" ", $actor_name)[1] . '%' : "%"; 

		$statement = "SELECT * from actor where first_name like :first_name and last_name like :last_name limit 5 ";
		$statement .= " offset :offset";
		$query = $pdo->prepare($statement);
		$query->bindParam(":offset", $offset, PDO::PARAM_INT);
		$query->bindParam(":first_name", $first_name);
		$query->bindParam(":last_name", $last_name);
		$query->execute();
		$actors = $query->fetchAll(PDO::FETCH_ASSOC);

		// Formatting the names to be displayed in capital cased words.
		for($i = 0; $i < count($actors); $i++){
			$actors[$i]["first_name"] = ucwords(strtolower($actors[$i]["first_name"]));
			$actors[$i]["last_name"]  = ucwords(strtolower($actors[$i]["last_name"]));
 		}

 		// To know how many actors match the supplied keywork. No limit or offset keyword is used.
 		$count_statement = "SELECT count(*) as count from actor where first_name like :first_name";
 		$count_statement .= " and last_name like :last_name";
 		$count_query = $pdo->prepare($count_statement);
 		$count_query->execute([
 			":first_name" => $first_name,
 			":last_name"  => $last_name
		]);
		$count = $count_query->fetchAll(PDO::FETCH_ASSOC)[0];

		// Appending the count variable to the actors array.
		// It will be extracted from the array in JavaScript.
		$actors[] = $count;
		
		echo json_encode($actors);

	}
	// This is required to prevent loading HTML code.
	die();
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="initial-scale=1, width=device-width" />
	<meta charset="utf-8" />
	<title>Search the Sakila Database</title>
	<link rel="stylesheet" type="text/css" href="ajax_search.css" />
</head>
<body>
<header>Search the Sakila</header>
<div class="container">
	<div id="search-container">
		<div id="search-bar"><input type="text" name="find_actor" placeholder="Find actor"/></div>

		<div id="actors">
			<!-- <div class="actor">
				<img src="actor_photo.png" />
				<div class="actor-details">
					<h2>John Smith</h2>
					<p>Night at the musuem, Go Home, Finding Nemo, Getting the job done</p>
				</div>			
			</div> -->
		</div>
		<div class="pagination">
			<ul id="pagination-ul"></ul>
		</div>
	
	</div>
</div>
<script type="text/javascript" src="../../jquery.js"></script>
<script type="text/javascript" src="ajax_search.js"></script>
</body>
</html>