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

				<h2>Actor Information Page:</h2>
				<form action="search.php" method="GET">
					<button type="submit" name="submit">Search Keywords</button>
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

					    $query = "SELECT* FROM Actor WHERE ID = ".$ID.";";
					    $result = mysqli_query($con, $query);
					    $row = $result->fetch_assoc();
					    $lastname = $row['last'];
					    $firstname = $row['first'];
					    $name = $firstname." ".$lastname;
					    $sex = $row['sex'];
					    $dob = $row['dob'];
					    $dod = $row['dod'];
					    if($dod == NULL)
					    	$dod = "N/A";
					    
					    echo "<h3>Actor Information:</h3>";
					    echo "<table class='table table-bordered'>";
					    echo "<thead><tr><th>Name</th><th>Sex</th><th>Date of Birth</th><th>Date of Death</th></tr></thead>";
					    echo "<tbody><tr><td>".$name."</td><td>".$sex."</td><td>".$dob."</td><td>".$dod."</td></tr></tbody>";
					    echo "</table>";
					    echo "<br>";
					    $query = "SELECT role, title, id FROM MovieActor INNER JOIN Movie ON MovieActor.mid = Movie.id WHERE aid = ".$ID.";";
					    //echo $query;
					    $result = mysqli_query($con, $query);
					    echo "<h3>Actor's Movie and Role:</h3>";
					    echo "<table class='table table-bordered'>";
					    echo "<thead><tr><th>Role</th><th>Movie Title</th></tr></thead>";
					    echo "<tbody>";
					    while($row = $result->fetch_assoc()){
					    	$reference = "show_movie.php?ID=".$row['id'];
					    	//echo $reference;
					    	echo "<tr><td>".$row['role']."</td><td><a href=\"".$reference."\">".$row['title']."</td></tr>";
					    }
					    echo "</tbody>";
					    echo "</table>";

					    mysqli_close($con); 
					}
				?>
			</div>
        </div>
      </div>
    </div>

</body>
</html>