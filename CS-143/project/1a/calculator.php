<!DOCTYPE html>
<html>
<body>

<form action="calculator.php" method="get">
	Expression: <input type="text" name="expression"><br>
<input type="submit">
</form>

</body>
</html>

<?php
	if(isset($_GET['expression'])){
	    $expr = $_GET['expression']; 
	    //$pattern = '/-?\d+(\.\d+)?([+\-\\*]-?\d+(\.\d+)?)?/';
	    $pattern = '/^-?\d+(\.\d+)?([+\-\/*]-?\d+(\.\d+)?)*$/';
        $zero_pattern = '/^-?00+(\.\d+)?([+\-\/*]-?00+(\.\d+)?)*$/';
	    if (preg_match($zero_pattern, $expr)){
        	echo "Invalid expression!";
    	}
    	else if (preg_match($pattern, $expr)){
    		echo $expr.'=';
        	eval('$expr = '.$expr.';');
        	echo $expr;
    	} else {
        	echo "Invalid expression!";
    	}
	}
?>