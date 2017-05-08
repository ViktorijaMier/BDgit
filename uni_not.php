<html>

<head>
<title>NOT universal database structure</title>
</head>
<body>
<form method='get'>
<?PHP
	$file = fopen('uni-not-rezultatai.txt', 'a');
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
			Mysqli_select_db($connection, 'uni_not(10)');
		}
		
		if (!isset($_GET['startrow']) or !is_numeric($_GET['startrow'])) {
		  $startrow = 0;
		} else {
		  $startrow = (int)$_GET['startrow'];
		}
	/*
	$start = microtime(TRUE);*/
	//1 selectas:
		$start = microtime(TRUE);
		$fetch = mysqli_query($connection, 
					"SELECT Article_upload_date, Article_title, image.Image, 'Article' as Source, Article_author ". 
					"FROM article ".
					"INNER JOIN image ON article.Article_image_id = image.Image_ID ".
					"INNER JOIN category ON article.Article_category_id = category.Category_ID ".
					"WHERE category.Category_name = 'IT' ".					
					"UNION ALL ".
					"SELECT Event_upload_date, Event_title, image.Image, 'Event' as Source, Event_place ". 
					"FROM event ".
					"INNER JOIN image ON event.Event_image_id = image.Image_ID ".
					"INNER JOIN category ON event.Event_category_id = category.Category_ID ".
					"WHERE category.Category_name = 'IT' ".					
					"UNION ALL ".
					"SELECT News_upload_date, News_title, image.Image, 'News' as Source, NULL ". 
					"FROM news ".
					"INNER JOIN image ON news.News_image_id = image.Image_ID ".	
					"INNER JOIN category ON news.News_category_id = category.Category_ID ".	
					"WHERE category.Category_name = 'IT' ".	
					"ORDER BY Article_upload_date DESC ". 
					"LIMIT $startrow, 10")or die(mysqli_error($connection));
		$end = microtime(TRUE);
		$duration = $end - $start;
		echo "<p>" . $start . "</p>";
		echo "<p>" . $end . "</p>";
		echo "<p>" . $duration . "</p>"; 
	//2 selectas:			
		$start2 = microtime(TRUE);
		$fetch2 = mysqli_query($connection, 
					"SELECT Event_upload_date, Event_title, image.Image, 'Event' as Source, Event_place ". 
					"FROM event ".
					"INNER JOIN image ON event.Event_image_id = image.Image_ID ".
					"INNER JOIN category ON event.Event_category_id = category.Category_ID ".
					"WHERE Event_place = 'Vilnius' ".					
					"ORDER BY Event_upload_date DESC ". 
					"LIMIT $startrow, 10")or die(mysqli_error($connection));	
		$end2 = microtime(TRUE);
		$duration2 = $end2 - $start2;
		echo "<p>" . $start2 . "</p>";
		echo "<p>" . $end2 . "</p>";
		echo "<p>" . $duration2 . "</p>";					
	//3 selectas:
		$start3 = microtime(TRUE);
		$fetch3 = mysqli_query($connection, 
					"SELECT Article_upload_date, Article_title, image.Image, 'Article' as Source, Article_author ". 
					"FROM article ".
					"INNER JOIN image ON article.Article_image_id = image.Image_ID ".
					"INNER JOIN category ON article.Article_category_id = category.Category_ID ".
					"WHERE category.Category_name = 'IT' ".					
					"UNION ALL ".
					"SELECT Event_upload_date, Event_title, image.Image, 'Event' as Source, Event_place ". 
					"FROM event ".
					"INNER JOIN image ON event.Event_image_id = image.Image_ID ".
					"INNER JOIN category ON event.Event_category_id = category.Category_ID ".
					"WHERE category.Category_name = 'IT' ".					
					"UNION ALL ".
					"SELECT News_upload_date, News_title, image.Image, 'News' as Source, NULL ". 
					"FROM news ".
					"INNER JOIN image ON news.News_image_id = image.Image_ID ".	
					"INNER JOIN category ON news.News_category_id = category.Category_ID ".	
					"WHERE (News_upload_date >= ( CURDATE() - INTERVAL 3 DAY )) AND (News_upload_date <= CURDATE()) ".	
					"ORDER BY Article_upload_date DESC ". 
					"LIMIT $startrow, 10")or die(mysqli_error($connection));	
		$end3 = microtime(TRUE);
		$duration3 = $end3 - $start3;
		echo "<p>" . $start3 . "</p>";
		echo "<p>" . $end3 . "</p>";
		echo "<p>" . $duration3 . "</p>";					

	   $num=Mysqli_num_rows($fetch2);
			if($num>0){
			  
				for($i=0;$i<$num;$i++){
					
					$row = mysqli_fetch_row($fetch2);		
					echo "<img src={$row[2]} width='auto' height='100'><br>";
					echo "Title : {$row[1]} <br> ". 
						 "Post upload date :{$row[0]}  <br> ".
						 "Post type: {$row[3]} <br> ".
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
	 
