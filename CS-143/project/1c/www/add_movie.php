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
				<h2>Add a New Movie</h2>
				<form action="add_movie.php" method="GET">
					Title:<br>
					<input type="text" name="title"><br>
					Company:<br>
					<input type="text" name="company"><br>
					Year:<br>
					<input type="text" name="year"><br>
					MPAA rating:<br>
					<input type="text" name="rating"><br>
					Genre:<br>
					<input type="checkbox" name="genre[]" value="Drama">Drama
					<input type="checkbox" name="genre[]" value="Comedy">Comedy
					<input type="checkbox" name="genre[]" value="Romance">Romance
					<input type="checkbox" name="genre[]" value="Crime">Crime
					<br>
					<input type="checkbox" name="genre[]" value="Horror">Horror
					<input type="checkbox" name="genre[]" value="Mystery">Mystery
					<input type="checkbox" name="genre[]" value="Thriller">Thriller
					<input type="checkbox" name="genre[]" value="Action">Action
					<br>
					<input type="checkbox" name="genre[]" value="Adventure">Adventure
					<input type="checkbox" name="genre[]" value="Fantasy">Fantasy
					<input type="checkbox" name="genre[]" value="Documentary">Documentary
					<input type="checkbox" name="genre[]" value="Family">Family
					<br>
					<input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi
					<input type="checkbox" name="genre[]" value="Animation">Animation
					<input type="checkbox" name="genre[]" value="Musical">Musical
					<input type="checkbox" name="genre[]" value="War">War
					<br>
					<input type="checkbox" name="genre[]" value="Western">Western
					<input type="checkbox" name="genre[]" value="Adult">Adult
					<input type="checkbox" name="genre[]" value="short">Short
					<br>
					<button type="submit" name="submit">Add!</button>
				</form>

				<?php
					if(isset($_GET['title']) && isset($_GET['company']) && isset($_GET['year']) && isset($_GET['rating']) && isset($_GET['genre']))
					{
						$con = mysqli_connect("localhost", "cs143", "", "CS143");
						if (!$con) {
					        echo "Error: Unable to connect to MySQL." . PHP_EOL;
					        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
					        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
					        exit;
					    }

					    $title = $_GET['title'];
					    $company = $_GET['company'];
					    $year = $_GET['year'];
					    $rating = $_GET['rating'];
					    $genre = $_GET['genre'];

					    // Get the ID and update
					    $query = "SELECT id FROM MaxMovieID;";
					    $result = mysqli_query($con, $query);
					    $row = $result->fetch_assoc();
					    $ID = $row["id"] + 1;
					   	$query = "UPDATE MaxMovieID SET id = ".$ID.";";
					   	$result = mysqli_query($con, $query);

					   	$query = "INSERT INTO Movie VALUES (".$ID.",'".$title."', ".$year.", '".$rating."', '".$company."');";
					   	$result = mysqli_query($con, $query);
					    
					    if(!empty($genre)){
					    	foreach($genre as $val){
					    		$query = "INSERT INTO MovieGenre VALUES (".$ID.", '".$val."');";
					    		$result = mysqli_query($con, $query);
					    		//echo "Insert ".$val." Successfully: ".$result;
					    	}
					    }
					    mysqli_close($con);
					    if ($result)
					    	echo "You have successfully added a movie: ".$title;
					}

				?>

			</div>
        </div>
      </div>
    </div>

</body>
</html>

