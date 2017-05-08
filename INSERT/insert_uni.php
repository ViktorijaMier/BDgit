<?php

$connection=Mysqli_connect('localhost','root','');
    if(!$connection){
        echo 'connection is invalid';
    }else{
        Mysqli_select_db($connection, 'testas');
    }

	function generateRandomStringSet($length = 6) {
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomStringSet = '';
			for ($i = 0; $i < $length; $i++) {
				$randomStringSet .= $characters[rand(0, $charactersLength - 1)];
			}
		return $randomStringSet; 
	}
	
	function generateRandomStringContent($length = 300) {
		$randomStringContent = '';
			for ($i = 0; $i < $length; $i++) {
				$randomStringContent .= generateRandomStringSet(). " ";
			}
		return $randomStringContent; 
	}
		$total = 100000;		
		$total_num = 10000;
		$table = '3';
		//1-image,
		//2-post,
		//3-field_value
while ($total_num <= $total){
		if ($table == '1'){
			
			if ($result1 = mysqli_query($connection, "SELECT Image_ID FROM image")) {
				$row_cnt1 = mysqli_num_rows($result1);	
				
				if ($row_cnt1 < $total_num){
					$count = $total_num - $row_cnt1;
					for($i=0; $i< $count; $i++){
						
						$string = generateRandomStringSet(). "_";
						
						$sql = "INSERT INTO image (Image, Image_title) 
								VALUES ('images\ $string image.jpg', '$string image')";	
								
						if (mysqli_query($connection, $sql)) {
							echo $i."<br>";
						} else {
							echo "Error: " . $sql . "<br>" . mysqli_error($connection);
						}
					}
				}else{ echo "All rows are inserted";}
			} 			
		}else if ($table == '2'){	
			
			if ($result1 = mysqli_query($connection, "SELECT Post_ID FROM post")) {
				$row_cnt1 = mysqli_num_rows($result1);	
						if ($result = mysqli_query($connection, "SELECT Image_ID FROM image")) {
							$row_cnt = mysqli_num_rows($result);
							mysqli_free_result($result);
						}				
				if ($row_cnt1 < $total_num){
					$count = $total_num - $row_cnt1;
					for($i=0; $i< $count; $i++){
						echo $i."<br>";
						
						$string = generateRandomStringSet(). "_";
						$number = rand(1,1000000). "_";
						$category_rand = rand(1,4);
						$type_rand = rand(1,3);
						$content_rand = generateRandomStringContent();
						$month_rand = rand(1,12);
						$day_rand = rand(1,29);
						$end_day = $day_rand + rand(0,5);
						$event_upload = $day_rand - 5;
						$year_rand = rand(1999,2017);
						$image_id_rand = rand(1,$row_cnt);
						$price_rand = rand(0,1000);
						
						$sql = "INSERT INTO post (Category_id, Type_id, Image_id, Title, Post_content, Post_upload_date)
								VALUES ('$category_rand', '$type_rand', '$image_id_rand', '$string Post title', '$content_rand', TIMESTAMP(' $year_rand-$month_rand-$day_rand 14:53:27'))";
						
						if (mysqli_query($connection, $sql)) {
							echo "New record created successfully" . "<br>" ;
						} else {
							echo "Error: " . $sql . "<br>" . mysqli_error($connection);
						}
					}
				}else{ echo "All rows are inserted";}
			} 				
			
		}else if ($table == '3'){
			
			if ($result1 = mysqli_query($connection, "SELECT Post_ID FROM post")) {
				$row_cnt1 = mysqli_num_rows($result1);	
				$fetch = mysqli_query($connection, "SELECT post.Type_id, post.Post_ID 
												FROM post 
												LEFT OUTER JOIN field_value 
												ON (post.Post_ID=field_value.Post_id) 
												WHERE field_value.Post_id IS NULL");
					
				for($i=0; $i< $row_cnt1; $i++){	
					
					$type_ID = mysqli_fetch_row($fetch);
					$post_id = $type_ID['1'];
					if ($type_ID['0'] == '1'){
						$string = generateRandomStringSet(). "_";						
						$sql ="INSERT INTO field_value (Post_id , Post_field_id, Value) 
								VALUES ('$post_id', '1', '$string') ";		
						if (mysqli_query($connection, $sql)) {
							echo "New record created successfully";
						} else {
							echo "Error: " . $sql . "<br>" . mysqli_error($connection);
						}						
								echo "insertino<br>";
					}else if ($type_ID['0'] == '3'){
						$place = generateRandomStringSet(). "_";						
						$organizer = generateRandomStringSet(). "_";
						$year_rand = rand(1999,2017);
						$month_rand = rand(1,12);
						$day_rand = rand(1,29);
						$end_day = $day_rand + rand(0,5);
						$price_rand = rand(0,1000);	
						$number = rand(1,1000000);							
						
						$sql = "INSERT INTO field_value (Post_id , Post_field_id, Value) 
								SELECT '$post_id', '2', '$place place'  
								UNION ALL 
								SELECT '$post_id', '3', '$organizer organizer'
								UNION ALL 
								SELECT '$post_id', '4', TIMESTAMP(' $year_rand-$month_rand-$day_rand 14:53:27') 
								UNION ALL
								SELECT '$post_id', '5', TIMESTAMP(' $year_rand-$month_rand-$end_day 14:53:27') 
								UNION ALL
								SELECT '$post_id', '6', '$price_rand' 
								UNION ALL 
								SELECT '$post_id', '7', '$number' ";
									
						if (mysqli_query($connection, $sql)) {
							echo "New record created successfully";
						} else {
							echo "Error: " . $sql . "<br>" . mysqli_error($connection);
						}								
						
					}						
				}				
			}						
		} 
$total_num = $total_num+500;
sleep(0.005);		
}		
mysqli_close($connection);
?>