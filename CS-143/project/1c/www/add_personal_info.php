<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CS143 p1c</title>

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
				<h2>Add a New Actor/Director</h2>
				<form action="add_personal_info.php" method="GET">
					<input type="radio" name="job" value="Actor"> Actor<br>
					<input type="radio" name="job" value="Director"> Director<br>
					First Name:<br>
					<input type="text" name="firstname"><br>
					Last Name:<br>
					<input type="text" name="lastname"><br>
					<input type="radio" name="gender" value="Male"> Male<br>
					<input type="radio" name="gender" value="Female"> Female<br>
					Date of birth:<br>
					<input type="text" name="dob">ie: 1997-10-05<br>
					Date of die:<br>
					<input type="text" name="dod">(Leave blank if alive now)<br>
					<button type="submit" name="submit">Add!</button>
				</form>
				<?php

					if(isset($_GET['job']) && isset($_GET['firstname']) && isset($_GET['lastname'])  && isset($_GET['dob']))
					{
						$con = mysqli_connect("localhost", "cs143", "", "CS143");
						if (!$con) {
					        echo "Error: Unable to connect to MySQL." . PHP_EOL;
					        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
					        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
					        exit;
					    }

					    $job = $_GET['job'];
					    $firstname = $_GET['firstname'];
					    $lastname = $_GET['lastname'];

					    if($job == "Actor" && !isset($_GET['gender'])){
					    	echo "Please select the gender.<br>";
					    	exit;
					    }

					    $gender = $_GET['gender'];
					    $dob = $_GET['dob'];
					    $dod = $_GET['dod'];

					    // Get the ID and update
					    $query = "SELECT id FROM MaxPersonID;";
					    $result = mysqli_query($con, $query);
					    $row = $result->fetch_assoc();
					    $ID = $row["id"] + 1;
					   	$query = "UPDATE MaxPersonID SET id = ".$ID.";";
					   	$result = mysqli_query($con, $query);

					    if($job == "Actor"){
					   		if($dod == "")
								$query = "INSERT INTO Actor (id, last, first, sex, dob) VALUES (".$ID.",'".$lastname."','".$firstname."','".$gender."','".$dob."');";
							else
								$query = "INSERT INTO Actor (id, last, first, sex, dob, dod) VALUES (".$ID.",'".$lastname."','".$firstname."','".$gender."','".$dob."','".$dod."');";
						}
						else if($job == "Director"){
							if($dod == ""){
								$query = "INSERT INTO Director (id, last, first, dob) VALUES (".$ID.",'".$lastname."','".$firstname."','".$dob."');";
								//echo $query;
							}
							else{
								$query = "INSERT INTO Director (id, last, first, dob, dod) VALUES (".$ID.",'".$lastname."','".$firstname."','".$dob."','".$dod."');";
								//echo $query;
							}
						}
					    $add_result = mysqli_query($con, $query);
					    if ($add_result)
					    	echo "You have successfully added an ".$job.": ".$firstname." ".$lastname."!";
					    mysqli_close($con);
					}
				?>

			</div>
        </div>
      </div>
    </div>

</body>
</html>

