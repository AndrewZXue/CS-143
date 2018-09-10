<!DOCTYPE html>
<html>
<body>

<form action="query.php" method="get">
	Type an SQL query in the following box:<br>
    <br>
    Example: SELECT * FROM Actor WHERE id=10;<br>
    <br>
    <textarea name="query" cols="60" rows="8"></textarea><br />
<input type="submit">
</form>
<br>
<small>Note: tables and fields are case sensitive. Run "show tables" to see the list of available tables.</small>
<br>
<?php
    if(isset($_GET['query'])){
        $con = mysqli_connect("localhost", "cs143", "", "CS143");

        $query = $_GET['query']; 

        if (!$con) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
        }

        $ret = mysqli_query($con,$query);
               
        //}
        

        echo "<h3>Result from MySQL:<br><h3>";
        if(!$ret){
            echo("Error description: " . mysqli_error($con));
            echo "<br>";
        }

        mysqli_close($con);

        // if ($ret->num_rows <= 0)
        // {
        //     echo "row failed<br>";  //for debug
        // }

        // if (mysqli_num_fields($ret) <= 0)
        // {
        //     echo "col failed<br>";  //for debug
        // }


        if ($ret->num_rows > 0) {
            //echo "yes<br>"; //for debug
            echo "<table><tr>";
            $col = 0;
            while($col < mysqli_num_fields($ret))
            {
                echo "<th>".mysqli_fetch_field($ret)->name."</th>";
                $col = $col + 1;
            }
            echo "</tr>";


            while ($row=mysqli_fetch_row($ret))
            {
                echo "<tr>";
                $i = 0;
                while ($i < mysqli_num_fields($ret))
                {
                    if ($row[$i] == null)
                    {
                        echo "<td>N/A</td>";
                    }
                    else
                    {
                        echo "<td>".$row[$i]."</td>";          
                    }
                    $i = $i + 1;
                }
                echo "</tr>";
            }

            echo "</table>";
        }
    }
?>

</body>
</html>