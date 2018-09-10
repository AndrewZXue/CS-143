<!DOCTYPE html>
<html lang="en">
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
        <div class="col-sm-4 col-md-3 sidebar">
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
        <div class="col-sm-8 col-sm-offset-3 col-md-9 col-md-offset-2 main">
             <div>
                <h2>Welcome to MyMovie Database</h2>
            </div>

        </div>
      </div>
    </div>
  

</body>
</html>
