<!DOCTYPE html>
<html>
<body>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  Calculator: <input type="text" name="expression">
  <input type="submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $expr = $_POST['expression']; 
    //echo $expr;
    if (preg_match([0-9+-*/]*, $expr)) {
        //echo "valid";
    } else {
        //echo "invalid";
    }
}
?>

</body>
</html>