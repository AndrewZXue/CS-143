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
                <h2>Add a Comment</h2>
                <form action="add_comment.php" method="get">
                	Movie:<br>
                    <textarea name="movie_name" cols="60" rows="1"></textarea><br/>
                    Your name:<br>
                    <textarea name="username" cols="60" rows="1"></textarea><br/>
                    Your rating:<br>
                    <select name="score">
                    	<option value ="1">1</option>
                    	<option value ="2">2</option>
                    	<option value ="3">3</option>
                    	<option value ="4">4</option>
                    	<option value ="5">5</option>
                    </select><br>
                    Your comment:<br>
                    <textarea name="comment" cols="60" rows="10"></textarea><br/>
                <input type="submit">
                </form>
                <?php
                	if(isset($_GET['movie_name']) || isset($_GET['username']) || isset($_GET['score']) || isset($_GET['comment']))
                	{
                        if (!($_GET['movie_name']))
                        {
                            echo "Please specify a movie name.";
                            echo "<br>";
                            exit;
                        }
                        if (!($_GET['username']))
                        {
                            echo "Please specify your name.";
                            echo "<br>";
                            exit;
                        }
                        if (!($_GET['comment']))
                        {
                            echo "Please do not leave empty comment.";
                            echo "<br>";
                            exit;
                        }
                		$con = mysqli_connect("localhost", "cs143", "", "CS143");
                        if (!$con) {
                            echo "Error: Unable to connect to MySQL." . PHP_EOL;
                            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                            exit;
                        }

                        $movie_name = $_GET['movie_name'];
                		$username = $_GET['username'];
                		$score = $_GET['score'];
                		$comment = $_GET['comment'];

                        $movie_query = "SELECT id, title FROM Movie WHERE title='" . $movie_name . "';";
                        //echo $movie_query;
                        $movie_info = mysqli_query($con,$movie_query);
                        if ($movie_info->num_rows == 0){
                            echo "Movie not in the database.";
                            exit;
                        }
                        $movie_id = mysqli_fetch_row($movie_info)[0];
                        $time = time();
                        $timestamp = date('Y-m-d H:i:s', $time);

                        $insert_query = "INSERT INTO Review VALUES ('".$username."', '".$timestamp."',".$movie_id.",".$score.", '".$comment."');";
                        //echo $insert_query;
                        $insert_result = mysqli_query($con,$insert_query);
                        if($insert_result){
                            echo "Comment successfully.";
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