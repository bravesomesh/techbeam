<?php
	require '../db.php';
	if ($_POST["action"] == "Load") {
		$heading = $_POST['heading'];
		$description = $_POST['description'];

		$folder = "../images/";
		move_uploaded_file($_FILES["main_image"]["tmp_name"] , "$folder".$_FILES["main_image"]["name"]);
		move_uploaded_file($_FILES["thumb_image"]["tmp_name"] , "$folder".$_FILES["thumb_image"]["name"]);

		$sql = "Insert into news (`heading`,`description`,`main_image`,`thumb_image`) 
				VALUES ('".$heading."','".$description."','".$_FILES['thumb_image']['name']."','".$_FILES['main_image']['name']."')";
		try {
			$db = getDB();
			$stmt = $db->prepare($sql);
			$get_id = $stmt->execute();
			print_r($get_id);  
			$db = null;
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}

	}
?>