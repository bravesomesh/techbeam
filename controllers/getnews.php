<?php 
	require '../db.php';
	$sql = "SELECT id, heading, thumb_image, main_image from news";
	try {
		$db = getDB();
		$stmt = $db->query($sql); 
		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"users": ' . json_encode($users) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
 ?>