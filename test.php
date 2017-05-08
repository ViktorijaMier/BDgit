<html>

<head>
<title>NOT universal database structure</title>
</head>
<body>
<form method='get'>
<?PHP
$start = microtime(TRUE);
$connection=Mysqli_connect('localhost','root','');
    if(!$connection){
        echo 'connection is invalid';
    }else{
        Mysqli_select_db($connection, 'uni_not');
    }
	
	if (!isset($_GET['startrow']) or !is_numeric($_GET['startrow'])) {
	  $startrow = 0;
	} else {
	  $startrow = (int)$_GET['startrow'];
	}
/*
$start = microtime(TRUE);*/

	$fetch = mysqli_query($connection ,"SELECT Article_upload_date, Article_title, image.Image, 'Article' as Source, Article_author ". 
				"FROM article ".
	/*			"INNER JOIN category ON post.Category_id = category.Category_ID ".*/
				"INNER JOIN image ON article.Article_image_id = image.Image_ID ".
	/*			"WHERE  category.Category_name = 'IT' ".*/
				"UNION ALL ".
				"SELECT Event_upload_date, Event_title, image.Image, 'Event' as Source, Event_place ". 
				"FROM event ".
				"INNER JOIN image ON event.Event_image_id = image.Image_ID ".
				"UNION ALL ".
				"SELECT News_upload_date, News_title, image.Image, 'News' as Source, News_title ". 
				"FROM news ".
				"INNER JOIN image ON news.News_image_id = image.Image_ID ".				
				"ORDER BY Article_upload_date DESC ". 
				"LIMIT $startrow, 10")or die(mysqli_error($connection));
/*
$end = microtime(TRUE);
$duration = $end - $start;
echo "<p>" . $start . "</p>";
echo "<p>" . $end . "</p>";
echo "<p>" . $duration . "</p>";  
*/ 
   $num=Mysqli_num_rows($fetch);
        if($num>0){
          
			for($i=0;$i<$num;$i++){
				
				$row = mysqli_fetch_row($fetch);		
				echo "<img src={$row[2]} width='auto' height='100'><br>";
				echo "Title : {$row[1]} <br> ". 
					 "Post upload date :{$row[0]}  <br> ".
					 "Post type: {$row[3]} <br> ".
					 "Additional row: {$row[4]} <br> ".
					 "--------------------------------<br>";
		  }
		}
$end = microtime(TRUE);

$duration = $end - $start;
echo "<p>" . $start . "</p>";
echo "<p>" . $end . "</p>";
echo "<p>" . $duration . "</p>"; 	
	$prev = $startrow - 10;
	if ($prev >= 0)
		echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.$prev.'">Previous</a>';      
	echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.($startrow+10).'">Next</a>';

?>
</form>
</body>
</html>
	 
