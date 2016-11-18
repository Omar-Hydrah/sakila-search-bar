<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="initial-scale=1, width=device-width" />
	<meta charset="utf-8" />
	<title>The factory</title>
	<style>
	body{margin:0; padding:40px;}
	*{box-sizing:border-box;}
	.container{ height:100px;}
	.right-box{background-color: #9dcfff; padding:5px; float:left; width:50%; position:relative;}
	.left-box{background-color: #85a44a; padding:5px; float:left; width:50%; position:relative;}
	.right-box p, .left-box p{margin-left:55px;}
	img{position:absolute; left:1%; top:10%; }
	.clear-fix::after{content:""; display:block; clear:both;}
	
	@media screen and (max-width:700px){
	.right-box, .left-box{width:100%;}

	}
	</style>
</head>
<body>


<div class="container">
	<div class="right-box clear-fix">
		<img src="actor_photo.png" />
		<p>Content of the right box</p>
	</div>
	<div class="left-box clear-fix">
		<img src="actor_photo.png" />
		<p>Content of the left box</p>
	</div>
</div>
<?php 
$pdo = new PDO("mysql:host=localhost; dbname=sakila", "root", "");
$first_name = "an%";
$offset = 2;
$statement = "SELECT * from actor where first_name like :first_name limit 5 offset :offset ";
$query = $pdo->prepare($statement);
$query->bindParam(":offset", $offset, PDO::PARAM_INT);
$query->bindParam(":first_name", $first_name);
$query->execute();

$result = $query->fetchAll(PDO::FETCH_ASSOC);
echo '<pre>';
print_r($result);
echo '</pre>';
?>

<br />
<hr />
SELECT  ( SELECT COUNT(*) FROM   user_table ) AS tot_user, 
( SELECT COUNT(*) FROM   cat_table ) AS tot_cat, 
( SELECT COUNT(*) FROM   course_table ) AS tot_course


</body>
</html>