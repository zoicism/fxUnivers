<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/register/connect.php');

if(isset($_POST['query']) && !empty($_POST['query'])) {
    $query = $_POST['query'];
    $search_q = "SELECT * FROM user WHERE (UPPER(username) LIKE UPPER('%$query%')) OR (UPPER(fname) LIKE UPPER('%$query%')) OR (UPPER(lname) LIKE UPPER('%$query%')) ORDER BY id DESC";
    $search_r = mysqli_query($connection, $search_q);

    
    
    if($search_r -> num_rows > 0) {
	$result = '<datalist id="fxUsersList">';
	while($fxuser = $search_r -> fetch_assoc()) {
	    $result .= '<option value="'.$fxuser['username'].'">';
	}
	$result .= '</datalist>';
	echo $result;
    } else {
	echo 0;
    }
} else {
    echo 0;
}
?>
