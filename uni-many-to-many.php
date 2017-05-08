<html>

<head>
<title>Universal database structure</title>
</head>
<body>
<form method='get'>
<?PHP
	$file = fopen('uni-many-to-many-rezultatai.txt', 'a');
	$total = 10;
	$current = 1;
	$sum = 0;
	$sum2 = 0;
	$sum3 = 0;
	while($current <= $total){
		$connection=Mysqli_connect('localhost','root','');
		if(!$connection){
			echo 'connection is invalid';
		}else{
			Mysqli_select_db($connection, 'uni_many-to-many(1000)');
		}

		if (!isset($_GET['startrow']) or !is_numeric($_GET['startrow'])) {
		  $startrow = 0;
		} else {
		  $startrow = (int)$_GET['startrow'];
		}
		//pradedamas skaičiuoti laikas
		
//1 selectas:
		$start = microtime(TRUE);
		$fetch = mysqli_query($connection, "SELECT post.Post_upload_date, type.Type_name, post.Title, image.Image, field_value.Value ". 
					"FROM post ".
					"INNER JOIN image ON post.Image_id = image.Image_ID ".
					"INNER JOIN category_type_relationship ON post.Relationship_id = category_type_relationship.Cat_type_ID ".
					"INNER JOIN type ON category_type_relationship.Type_id = type.Type_ID ".
					"INNER JOIN category ON category_type_relationship.Category_id = category.Category_ID ".
					"LEFT JOIN field_value ON post.Post_ID = field_value.Post_id ".
					"WHERE  category.Category_name = 'IT' AND ( field_value.Post_field_id = 1 OR field_value.Post_field_id = 2 OR field_value.Value IS NULL ) ".
					"ORDER BY Post_upload_date DESC ". 
					"LIMIT $startrow, 10 ")or die(mysqli_error($connection));
		$end = microtime(TRUE);
		$duration = $end - $start;
		echo "<p>" . $start . "</p>";
		echo "<p>" . $end . "</p>";
		echo "<p>" . $duration . "</p>"; 
					
//2 selectas:
		$start2 = microtime(TRUE);
		$fetch2 = mysqli_query($connection, "SELECT post.Post_upload_date, type.Type_name, post.Title, image.Image, field_value.Value ". 
					"FROM post ".
					"INNER JOIN image ON post.Image_id = image.Image_ID ".
					"INNER JOIN category_type_relationship ON post.Relationship_id = category_type_relationship.Cat_type_ID ".
					"INNER JOIN type ON category_type_relationship.Type_id = type.Type_ID ".
					"INNER JOIN category ON category_type_relationship.Category_id = category.Category_ID ".
					"LEFT JOIN field_value ON post.Post_ID = field_value.Post_id ".
					"WHERE  type.Type_ID = 3 AND  field_value.Post_field_id = 2 AND field_value.Value = 'Vilnius' ".
					"ORDER BY Post_upload_date DESC ". 
					"LIMIT $startrow, 10 ")or die(mysqli_error($connection));					
		$end2 = microtime(TRUE);
		$duration2 = $end2 - $start2;
		echo "<p>" . $start2 . "</p>";
		echo "<p>" . $end2 . "</p>";
		echo "<p>" . $duration2 . "</p>";
//3 selectas:
		$start3 = microtime(TRUE);
		$fetch3 = mysqli_query($connection, "SELECT post.Post_upload_date, type.Type_name, post.Title, image.Image, field_value.Value ". 
					"FROM post ".
					"INNER JOIN image ON post.Image_id = image.Image_ID ".
					"INNER JOIN category_type_relationship ON post.Relationship_id = category_type_relationship.Cat_type_ID ".
					"INNER JOIN type ON category_type_relationship.Type_id = type.Type_ID ".
					"INNER JOIN category ON category_type_relationship.Category_id = category.Category_ID ".
					"LEFT JOIN field_value ON post.Post_ID = field_value.Post_id ".
					"WHERE (post.Post_upload_date >= ( CURDATE() - INTERVAL 3 DAY )) AND (post.Post_upload_date <= CURDATE() ) AND ( field_value.Post_field_id = 1 OR field_value.Post_field_id = 2 OR field_value.Value IS NULL ) ".
					"ORDER BY Post_upload_date DESC ". 
					"LIMIT $startrow, 10 ")or die(mysqli_error($connection));
		$end3 = microtime(TRUE);
		$duration3 = $end3 - $start3;
		echo "<p>" . $start3 . "</p>";
		echo "<p>" . $end3 . "</p>";
		echo "<p>" . $duration3 . "</p>";					

	   $num=Mysqli_num_rows($fetch2);
			if($num>0){
			  
				for($i=0;$i<$num;$i++){					
					$row = mysqli_fetch_row($fetch2);		
					echo "<img src={$row[3]} width='auto' height='100'><br>";
					echo "Title : {$row[2]} <br> ". 
						 "Post upload date :{$row[0]}  <br> ".
						 "Post type: {$row[1]} <br> ". 
						"Additional row: {$row[4]} <br> ".					 
						 "--------------------------------<br>";
				}
			}
		$prev = $startrow - 10;
		if ($prev >= 0)
			echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.$prev.'">Previous</a>';      
		echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.($startrow+10).'">Next</a>';
		mysqli_close($connection);	
	
	fwrite($file, "Nr. " . $current . " -- 1 SELECT: " . $duration . "\n" . "Nr. " . $current . " -- 2 SELECT: " . $duration2 . "\n" . "Nr. " . $current . " -- 3 SELECT: " . $duration3 . "\n");
	$sum += $duration; 
	$sum2 += $duration2;
	$sum3 += $duration3;
	$current++;
	//sleep(0.05);
	}
	$average = $sum / $total;
	$average2 = $sum2 / $total;
	$average3 = $sum3 / $total;
	fwrite($file, "1 SELECT vidutiniškai: " . $average . "\n" . "2 SELECT vidutiniškai: " . $average2 . "\n" . "3 SELECT vidutiniškai: " . $average3 . "\n");
	fclose($file);	
?>
</form>
</body>
</html>
	 
