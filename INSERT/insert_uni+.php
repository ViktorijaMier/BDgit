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
		$total = 50000;		
		$total_num = 11970;
		$table = '3';

		//1-image,
		//2-post,
		//3-field_value
while ($total_num <= $total){
	echo $total_num . "\n";
		if ($table == '1'){			
			if ($result1 = mysqli_query($connection, "SELECT Image_ID FROM image")) {
				$row_cnt1 = mysqli_num_rows($result1);	
				
				if ($row_cnt1 < $total_num){
					$count = $total_num - $row_cnt1;
					$inserts ="";
					for($i=0; $i< $count; $i++){
						
						$string = generateRandomStringSet(). "_";
						$inserts [] = "('images\ $string image.jpg', '$string image')";
					}
						$sql = "INSERT INTO image (Image, Image_title) 
								VALUES ".implode(',', $inserts);	
								
						if (mysqli_query($connection, $sql)) {
							echo $i."<br>";
						} else {
							echo "Error: " . $sql . "<br>" . mysqli_error($connection);
						}					
				}else{ echo "All rows are inserted";}
			} 	
		}else if ($table == '2'){			
			if ($result1 = mysqli_query($connection, "SELECT Post_ID FROM post")) {
				$row_cnt1 = mysqli_num_rows($result1);	
						if ($result = mysqli_query($connection, "SELECT Image_ID FROM image")) {
							$row_cnt = mysqli_num_rows($result);
						mysqli_free_result($result);}						
				$inserts = '';
				if ($row_cnt1 < $total_num){
					$count = $total_num - $row_cnt1;
					for($i=0; $i< $count; $i++){
						echo $i."<br>";
						$category_id= array('1', '2', '1', '3', '1', '4', '2', '3', '1', '4');
						for ($j=0; $j <10;$j++){
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
							$inserts [] ="('$category_id[$j]', '$type_rand', '$image_id_rand', '$string Post title', '$content_rand', TIMESTAMP(' $year_rand-$month_rand-$day_rand 14:53:27'))";								
							
						}
						$sql = "INSERT INTO post (Category_id, Type_id, Image_id, Title, Post_content, Post_upload_date) 
								VALUES " .implode(',', $inserts);
						if (mysqli_query($connection, $sql)) {
							echo "New record created successfully" . "\n" ;
						} else {
							echo "Error: " . $sql . "<br>" . mysqli_error($connection);
						}					
					}
				}else{ echo "All rows are inserted";}
			} 							
		}else if ($table == '3'){
// Field value lentelės užpildymas 			
				$inserts ="";
//kadangi field value lentelė pildoma priklausomai nuo to koks Post tipas,
// jei Tipas (tipo nr. 3)- event, pridedami field value laukai: vieta, organizatorius, renginio pradžia, pabaiga ir t.t.
// jei Tipas(tipo nr. 1)-article pridedamas tik autorius

//Išrenkame kiek yra įrašų, kuriems nėra pagal tipą sukurtos  reikšmės field_value lentelėje:
				$fetch_id3 = mysqli_query($connection, "SELECT post.Type_id, post.Post_ID 
												FROM post 
												LEFT OUTER JOIN field_value 
												ON (post.Post_ID=field_value.Post_id) 
												WHERE (field_value.Post_id IS NULL) AND (post.Type_id = 3)"); // išrenkami visi 3-ią tipą atitinkantys įrašai
				$fetch_id1 = mysqli_query($connection, "SELECT post.Type_id, post.Post_ID 
												FROM post 
												LEFT OUTER JOIN field_value 
												ON (post.Post_ID=field_value.Post_id) 
												WHERE (field_value.Post_id IS NULL) AND (post.Type_id = 1)");// išrenkami visi 3-ią tipą atitinkantys įrašai												
				$row_id3 = mysqli_num_rows($fetch_id3);
				$row_id1 = mysqli_num_rows($fetch_id1);		
				
				for($i=0; $i< $row_id3; $i++){	
					
					$type_ID = mysqli_fetch_row($fetch_id3);
					$post_id = $type_ID['1'];
						$place = generateRandomStringSet(). "_";						
						$organizer = generateRandomStringSet(). "_";
						$year_rand = rand(1999,2017);
						$month_rand = rand(1,12);
						$day_rand = rand(1,29);
						$end_day = $day_rand + rand(0,5);
						$price_rand = rand(0,1000);	
						$number = rand(1,1000000);							
//nežinau kaip visas šitas reikšmes sudėti į masyvą kad ciklo pabaigoje priskirti prie $sql
// (kai eventui reikia įrašyti 6 skirtingas reikšmes su atitinkamais post_field_id -2,3,4,5,6,7)iš Post_field lentelės								
						$inserts []= "SELECT '$post_id', '2', '$place place'  
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
				}	
						$sql = "INSERT INTO field_value (Post_id , Post_field_id, Value) VALUES ".implode(',', $inserts); // čia implode ir ',' tikrai negerai 
									
						if (mysqli_query($connection, $sql)) {
							echo "New record created successfully";
						} else {
							echo "Error: " . $sql . "<br>" . mysqli_error($connection);
						}	
				$inserts_id1 = "";
				
				for($i=0; $i< $row_id1; $i++){	
					$type_ID1 = mysqli_fetch_row($fetch_id1);				
					$post_id1 = $type_ID1['1'];				
						$string = generateRandomStringSet(). "_";	
						$inserts_id1[] ="('$post_id1', '1', '$string') ";	 // 1- tai post_field_id iš Post_field lentelės					
				}
						$sql ="INSERT INTO field_value (Post_id , Post_field_id, Value) 
								VALUES ".implode(',', $inserts_id1);		
						if (mysqli_query($connection, $sql)) {
							echo "New record created successfully";
						} else {
							echo "Error: " . $sql . "<br>" . mysqli_error($connection);
						}						
								echo "insertino<br>";										
		} 
//vienu kartu įrašoma 200 į INSERT		
$total_num = $total_num+200;
sleep(0.05);		
}		
mysqli_close($connection);
?>