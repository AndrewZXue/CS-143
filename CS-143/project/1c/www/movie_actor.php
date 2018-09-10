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
                <h2>Add a New Movie/Actor Relation</h2>
                <small>Note: Please specify the exact movie/actor names</small><br>
                <form action="movie_actor.php" method="get">
                	Movie:<br>
                    <textarea name="movie_name" cols="60" rows="1"></textarea><br/>
                    Actor:<br>
                    <textarea name="actor_name" cols="60" rows="1"></textarea><br/>
                    Role:<br>
                    <textarea name="role_name" cols="60" rows="1"></textarea><br/>
                <input type="submit">
                </form>

                <br>
                <?php
                    if(isset($_GET['movie_name']) || isset($_GET['actor_name']) || isset($_GET['role_name'])){

                        $con = mysqli_connect("localhost", "cs143", "", "CS143");

                        $movie_name = $_GET['movie_name']; 
                        $actor_name = $_GET['actor_name']; 
                        $role_name = $_GET['role_name']; 

                        if(!$movie_name){
                            echo "Please specify the movie in the relation";
                            exit;
                        }

                        if(!$actor_name){
                            echo "please specify the actor in the relation";
                            exit;
                        }

                        if(!$role_name){
                            echo "Must specify the name of role to create a relation";
                            exit;
                        }

                        if (!$con) {
                        echo "Error: Unable to connect to MySQL." . PHP_EOL;
                        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                        exit;
                        }

                        $movie_query = "SELECT id, title FROM Movie WHERE title='" . $movie_name . "';";
                        $actor_query = "SELECT id, CONCAT(first, ' ', last) AS name FROM Actor WHERE CONCAT(first, ' ', last)='" . $actor_name . "';";

                        // echo $movie_query; 
                        // echo "<br>";
                        // echo $actor_query; 
                        // echo "<br>";

                        $movie_info = mysqli_query($con,$movie_query);

                        if ($movie_info->num_rows == 0)
                        {
                            echo "Movie not in the database.";
                            exit;
                        }
                        $movie_id = mysqli_fetch_row($movie_info)[0];

                        $actor_info = mysqli_query($con,$actor_query);

                        if ($actor_info->num_rows == 0)
                        {
                            echo "Actor not in the database.";
                            exit;
                        }
                        echo mysqli_fetch_row($movie_info)[1];
                        $actor_id = mysqli_fetch_row($actor_info)[0];

                        // echo $movie_id;
                        // echo"<br>";
                        // echo $actor_id;
                        // echo"<br>";

                        $insert_query = "INSERT INTO MovieActor (mid, aid, role) VALUES (" . $movie_id. "," . $actor_id . ",'" . $role_name . "');";

                        $result = mysqli_query($con, $insert_query);
                        // echo $insert_query;
                        // echo "<br>";
                        mysqli_close($con);

                    }
                ?>
            </div>
        </div>
      </div>
    </div>

</body>
</html>