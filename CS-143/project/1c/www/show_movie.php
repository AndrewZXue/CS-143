<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CS143 p1c</title>

    <!-- Bootstrap -->
    <link href="bootstrap.css" rel="stylesheet">
<body>
	<nav class="navbar navbar-fixed-top">
      <div class="container">
        <div class="navbar-header navbar-defalt">
          <a class="navbar-brand" href="index.php">CS143 MyMovie Homepage</a>
        </div>
      </div>
    </nav>

    <div class="container">
      <div class="row">
        <div class="col-sm-3 col-md-3 sidebar">
          <ul class="nav nav-sidebar">
            <p><h5>Add New Content:</h5></p>
            <li><a href="add_personal_info.php">Add Actor/Director</a></li>
            <li><a href="add_movie.php">Add Movie Information</a></li>
            <li><a href="movie_actor.php">Add Actor to Movie</a></li>
            <li><a href="movie_director.php">Add Director to Movie</a></li>
            <li><a href="add_comment.php">Add Comment</a></li>
          </ul>
          <br>
          <br>
          <ul class="nav nav-sidebar">
            <p><h5>Search Interface:</h5></p>
            <li><a href="search.php">Search Movie/Actor</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-2 main">
            <div>

				<h2>Movie Information Page:</h2>
				<form action="search.php" method="GET">
					<button type="submit" name="submit">Search Keywords</button>
					<br>
					<br>
				</form>
				<?php
					if(isset($_GET['ID']))
					{
						$con = mysqli_connect("localhost", "cs143", "", "CS143");
						if (!$con) {
					        echo "Error: Unable to connect to MySQL." . PHP_EOL;
					        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
					        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
					        exit;
					    }
					    $ID = $_GET['ID'];

					    $query = "SELECT* FROM Movie WHERE ID = ".$ID.";";
					    $result = mysqli_query($con, $query);
					    $row = $result->fetch_assoc();
					    $title = $row['title'];
					    $year = $row['year'];
					    $rating = $row['rating'];
					    $company = $row['company'];
					    
					    $query = "SELECT did, last, first, dob FROM MovieDirector INNER JOIN Director ON MovieDirector.did = Director.id WHERE mid = ".$ID.";";
					    //echo $query;
					    $result = mysqli_query($con, $query);
					    $row = $result->fetch_assoc();
					    $did = $row['did'];
					    $lastname = $row['last'];
					    $firstname = $row['first'];
					    $name = $firstname." ".$lastname;
					    $dob = $row['dob'];

					   	$query = "SELECT genre FROM MovieGenre WHERE mid = ".$ID.";";
					   	//echo $query;
					    $result = mysqli_query($con, $query);
					    $genre = "";
					    while($row = $result->fetch_assoc()){
					    	$genre .= $row['genre'].", ";
					    }
					    $genre_new = substr($genre, 0, -2);

					    echo "<h4>Movie Information:</h4>";
					    echo "Title: ".$title." (".$year.")<br>";
					    echo "Producer: ".$company."<br>";
					    echo "MPAA Rating: ".$rating."<br>";
					    if ($dob)
					    	echo "Director: ".$name."(".$dob.")<br>";
					    else
					    	echo "Director: ".$name.$dob."<br>";
					    echo "Genre: ".$genre_new."<br><br>";

					    $query = "SELECT last,first,role,id FROM MovieActor INNER JOIN Actor ON MovieActor.aid = Actor.id WHERE mid = ".$ID.";";
					    //echo $query;
					    $result = mysqli_query($con, $query);
					    echo "<h4>Actors in this Movie:</h4>";
					    echo "<table class='table table-bordered'>";
					    echo "<thead><tr><th>Name</th><th>Role</th></tr></thead>";
					    echo "<tbody>";
					    while($row = $result->fetch_assoc()){
					    	$reference = "show_actor.php?ID=".$row['id'];
					    	$lastname = $row['last'];
					    	$firstname = $row['first'];
					    	$name = $firstname." ".$lastname;
					    	//echo $reference;
					    	echo "<tr><td><a href=\"".$reference."\">".$name."</td><td>".$row['role']."</td></tr>";
					    }
					    echo "</tbody>";
					    echo "</table>";
					    echo "<br>";

					    $general_info_query = "SELECT AVG(rating) as average, COUNT(comment) as total FROM Review WHERE mid = ".$ID.";";
					    //echo $general_info_query;
					    $review_query = "SELECT* FROM Review WHERE mid = ".$ID.";";
					    //echo $review_query;

					    $general_info_result = mysqli_query($con, $general_info_query);
					    $general_info_row = $general_info_result->fetch_assoc();
					    $total = $general_info_row['total'];
					    $average = $general_info_row['average'];

					    $review_result = mysqli_query($con, $review_query);

					    echo "<h4>User Review:</h4>";
					    if($total == 0){
					    	echo $total." people reviewed this movie.";
					    }
					    else{
					    	echo $total." people reviewed this movie. Average score: ".$average.".<br>";
					    }
					    echo "<br>";
					    echo "<a href=\"add_comment.php\">Click me to add reviews!</a>";
					    echo "<br>";
					    echo "<br>";
					    while($row = $review_result->fetch_assoc()){
					    	$username = $row['name'];
					    	$time = $row['time'];
					    	$rating = $row['rating'];
					    	$comment = $row['comment'];
					    	echo $username."    ".$time."   Rating: ".$rating;
					    	echo "<br>";
					    	echo $comment;
					    	echo "<br>";
					    	echo "<br>";
					    }
					    mysqli_close($con); 
					}
				?>

			</div>
        </div>
      </div>
    </div>


</body>
</html>

