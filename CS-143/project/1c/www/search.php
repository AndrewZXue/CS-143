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

				<h2>Search in MyMovie Database</h2>
				<form action="search.php" method="get">
					Search:<br>
				    <textarea name="search_name" cols="60" rows="1"></textarea><br/>
				<input type="submit">
				</form>

				<br>
				<?php
					if(isset($_GET['search_name']))
					{
						$search_name = $_GET['search_name'];
						$keywords = explode(" ", $search_name);

						$con = mysqli_connect("localhost", "cs143", "", "CS143");
						if (!$con) {
				        echo "Error: Unable to connect to MySQL." . PHP_EOL;
				        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
				        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
				        exit;
				        }

				       	$select_movie_query = "SELECT id, title FROM Movie WHERE ";
				       	foreach ($keywords as $word) {
							$select_movie_query = $select_movie_query . "(title LIKE '%" . $word . "%') AND";
						}
						$select_movie_query = $select_movie_query . " 1;";

						$movie_info = mysqli_query($con,$select_movie_query);

				        $select_actor_query = "SELECT id, CONCAT(first, ' ', last) AS name FROM Actor WHERE ";
				        foreach ($keywords as $word){
				        	$select_actor_query = $select_actor_query . "(CONCAT(first, ' ', last) LIKE '%" . $word . "%') AND";
				        }
				        $select_actor_query = $select_actor_query . " 1;";

				        $actor_info = mysqli_query($con,$select_actor_query);

				        if ($movie_info->num_rows == 0 && $actor_info->num_rows == 0)
				        {
				        	echo "Keywords not found!";
				            exit;
				        }

				        if ($movie_info->num_rows > 0) {
				            echo "Movies:"; //for debug
				            echo "<br>";
				            echo "<table class='table table-bordered'><thead><tr>";
				            $col = 0;
				            while($col < mysqli_num_fields($movie_info))
				            {
				                echo "<th>".mysqli_fetch_field($movie_info)->name."</th>";
				                $col = $col + 1;
				            }
				            echo "</tr></thead>";

				            echo "<tbody>";
				            while ($row=mysqli_fetch_row($movie_info))
				            {
				                echo "<tr>";
				                $i = 0;
				                while ($i < mysqli_num_fields($movie_info))
				                {
				                    if ($row[$i] == null)
				                    {
				                        echo "<td>N/A</td>";
				                    }
				                    else
				                    {
				                    	$reference = "show_movie.php?ID=".$row[0];
				                        echo "<td><a href='".$reference."'>". $row[$i]."</a>"."</td>";        
				                    }
				                    $i = $i + 1;
				                }
				                echo "</tr>";
				            }

				            echo "</tbody>";
				            echo "</table>";
				            echo "<br>";
				            echo "<br>";
				        }

				        if ($actor_info->num_rows > 0) {
				            echo "Cast:"; 
				            echo "<br>";
				            echo "<table class='table table-bordered'><thead><tr>";
				            $col = 0;
				            while($col < mysqli_num_fields($actor_info))
				            {
				                echo "<th>".mysqli_fetch_field($actor_info)->name."</th>";
				                $col = $col + 1;
				            }
				            echo "</tr></thead>";

				            echo "</tbody>";
				            while ($row=mysqli_fetch_row($actor_info))
				            {
				                echo "<tr>";
				                $i = 0;
				                while ($i < mysqli_num_fields($actor_info))
				                {
				                    if ($row[$i] == null)
				                    {
				                        echo "<td>N/A</td>";
				                    }
				                    else
				                    {
				                        $reference = "show_actor.php?ID=".$row[0];
				                        echo "<td><a href='".$reference."'>". $row[$i]."</a>"."</td>";
				                    }
				                    $i = $i + 1;
				                }
				                echo "</tr>";
				            }
				            echo "</tbody>";
				            echo "</table>";
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