<?php 
$mysqli = new mysqli("localhost", "root", "", "uni");
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
$start = microtime(TRUE);
$sql = "SELECT * FROM post";
if($result = $mysqli->query($sql)){
    if($result->num_rows > 0){
        echo "<table>";

        while($row = $result->fetch_array()){
            echo "<tr>";
                echo "<td>" . $row['Post_ID'] . "</td>";
                echo "<td>" . $row['Title'] . "</td>";
                echo "<td>" . $row['Post_content'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        $result->free();
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
}
 $end = microtime(TRUE);
$duration = $end - $start;
                echo "<p>" . $start . "</p>";
                echo "<p>" . $end . "</p>";
				echo "<p>" . $duration . "</p>";
// Close connection

?>
<p>lalala </p><?php
$mysqli->close();
?>