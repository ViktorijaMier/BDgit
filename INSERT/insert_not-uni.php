<?php

$connection=Mysqli_connect('localhost','root','');
    if(!$connection){
        echo 'connection is invalid';
    }else{
        Mysqli_select_db($connection, 'uni_not(500000)');
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
		
		$total =166666;
		
		$total_num =33834;
		$table = '3';
		//1-image,
		//2-event,
		//3-news,
		//4-article
		while ($total_num <= $total){	
		if ($table == '2'){
			
			if ($result1 = mysqli_query($connection, "SELECT Event_ID FROM event")) {
				$row_cnt1 = mysqli_num_rows($result1);	
						if ($result = mysqli_query($connection, "SELECT Image_ID FROM image")) {
							$row_cnt = mysqli_num_rows($result);
							mysqli_free_result($result);
						}				
				if ($row_cnt1 < $total_num){
					$count = $total_num - $row_cnt1;
					for($i=0; $i< $count; $i++){
												
						$string = generateRandomStringSet(). "_";
						$number = rand(1,1000000). "_";
						$category_rand = rand(1,4);
						$content_rand = generateRandomStringContent();
						$month_rand = rand(1,12);
						$day_rand = rand(1,29);
						$end_day = $day_rand + rand(0,5);
						$event_upload = $day_rand - 5;
						$year_rand = rand(1999,2017);
						$image_id_rand = rand(1,$row_cnt);
						$price_rand = rand(0,1000);
						
						$sql = "INSERT INTO event (Event_category_id, Event_image_id, Event_title,Event_content, Event_place, Event_organizer, Event_start_date, Event_end_date, Event_price, Event_participants_max, Event_upload_date)
								VALUES ('$category_rand', '$image_id_rand', '$string event title', '$content_rand', '$string place', '$string organizer', TIMESTAMP(' $year_rand-$month_rand-$day_rand 14:53:27'), TIMESTAMP(' $year_rand-$month_rand-$end_day 14:53:27'), '$price_rand', '$price_rand', TIMESTAMP(' $year_rand-$month_rand-$event_upload 14:53:27'))";
						
						if (mysqli_query($connection, $sql)) {
							echo "New record created successfully";
						} else {
							echo "Error: " . $sql . "<br>" . mysqli_error($connection);
						}
					}
				}else{ echo "All rows are inserted";}
			} 				
			
		}else if ($table == '3'){
		
			if ($result1 = mysqli_query($connection, "SELECT News_ID FROM news")) {
				$row_cnt1 = mysqli_num_rows($result1);	
				
				if ($row_cnt1 < $total_num){
					$count = $total_num - $row_cnt1;
					if ($result = mysqli_query($connection, "SELECT Image_ID FROM image")) {
							$row_cnt = mysqli_num_rows($result);
							mysqli_free_result($result);
						}				
					for($i=0; $i< $count; $i++){
								
						$string = generateRandomStringSet(). "_";
						$number = rand(1,1000000). "_";
						$category_rand = rand(1,4);
						$content_rand = generateRandomStringContent();
						$month_rand = rand(1,12);
						$day_rand = rand(1,29);
						$end_day = $day_rand + rand(0,5);
						$event_upload = $day_rand - 5;
						$year_rand = rand(1999,2017);
						$image_id_rand = rand(1,$row_cnt);
						$price_rand = rand(0,1000);			
						
						$sql = "INSERT INTO news (News_category_id, News_image_id, News_title, News_content, News_upload_date)
								VALUES ('$category_rand', '$image_id_rand', '$string news title', '$content_rand', TIMESTAMP(' $year_rand-$month_rand-$day_rand 14:53:27'))";

						if (mysqli_query($connection, $sql)) {
							echo "New record created successfully \n";
						} else {
							echo "Error: " . $sql . "<br>" . mysqli_error($connection);
						}												
					}
				}
			} else{ echo "All rows are inserted";}	
		
		}else if ($table == '4'){
			
			if ($result1 = mysqli_query($connection, "SELECT Article_ID FROM article")) {
				$row_cnt1 = mysqli_num_rows($result1);	
				
				if ($row_cnt1 < $total_num){
					$count = $total_num - $row_cnt1;
					for($i=0; $i< $count; $i++){
						
						if ($result = mysqli_query($connection, "SELECT Image_ID FROM image")) {
							$row_cnt = mysqli_num_rows($result);
							mysqli_free_result($result);
						}
						
						$string = generateRandomStringSet(). "_";
						$number = rand(1,1000000). "_";
						$category_rand = rand(1,4);
						$content_rand = generateRandomStringContent();
						$month_rand = rand(1,12);
						$day_rand = rand(1,29);
						$end_day = $day_rand + rand(0,5);
						$event_upload = $day_rand - 5;
						$year_rand = rand(1999,2017);
						$image_id_rand = rand(1,$row_cnt);
						$price_rand = rand(0,1000);
						
						$sql = "INSERT INTO article (Article_category_id, Article_image_id, Article_title, Article_content, Article_upload_date ) 
								VALUES ('$category_rand', '$image_id_rand', '$string article title', '$content_rand', TIMESTAMP(' $year_rand-$month_rand-$day_rand 14:53:27'))";
						
						if (mysqli_query($connection, $sql)) {
							echo "New record created successfully \n ";
						} else {
							echo "Error: " . $sql . "<br>" . mysqli_error($connection);
						}	
					}
				}else{ echo "All rows are inserted";}	
			} 
		
		}else if ($table == '1'){
			
			if ($result1 = mysqli_query($connection, "SELECT Image_ID FROM image")) {
				$row_cnt1 = mysqli_num_rows($result1);	
				
				if ($row_cnt1 < $total_num){
					$count = $total_num - $row_cnt1;
					for($i=0; $i< $count; $i++){
						
						$string = generateRandomStringSet(). "_";
						
						$sql = "INSERT INTO image (Image, Image_title) 
								VALUES ('images\ $string image.jpg', '$string image')";	
								
						if (mysqli_query($connection, $sql)) {
							echo "New record created successfully <br> ";
						} else {
							echo "Error: " . $sql . "<br>" . mysqli_error($connection);
						}
					}
				}else{ echo "All rows are inserted";}
			} 
		
		} 				
		$total_num = $total_num+500;
		sleep(0.005);
		}
mysqli_close($connection);
?>