<?php
	require 'db.php';
	require 'Slim/Slim.php';
	\Slim\Slim::registerAutoloader();

	$app = new \Slim\Slim(array(
	    'debug' => true
	));

	$app->get('/','getNews');
	$app->get('/news','getNews');
	$app->get('/news/:news_id','getNewsDescription');
	$app->get('/news/limit/:limit/offset/:offset','getPagination');
	$app->get('/storenews','postNewsIndex');
	$app->post('news','postNews');


	// Test rest operation
	$app->get('/users','getUsers');
	$app->get('/updates','getUserUpdates');
	$app->post('/updates', 'insertUpdate');
	$app->delete('/updates/delete/:update_id','deleteUpdate');
	$app->get('/users/search/:query','getUserSearch');
	// End of Test Rest operation

	$app->run();

	function getNews(){
		header('Location: http://localhost/techbeam/controllers/getnews.php');
	}


	function getNewsDescription(){

	}

	function getPagination(){

	}

	function postNewsIndex(){
		echo '<form action=controllers/addnews.php method=post enctype="multipart/form-data">
		<table border="0" cellspacing="0" align=center cellpadding="3" bordercolor="#cccccc">
			<tr>
				<td><label>Heading</label></td>
				<td><textarea cols="38" rows="3" name="heading"></textarea></td>
			</tr>
			<tr>
				<td><label>Description</label></td>
				<td><textarea cols="38" rows="10" name="description"></textarea></td>
			</tr>
			<tr>
				<td><label>Thumb Image</label></td>
				<td><input type="file" name="thumb_image" size=45></td>
			</tr>
			<tr>
				<td><label>Main Image</label></td>
				<td><input type="file" name="main_image" size=45></td>
			</tr>
			<tr>
				<td colspan=2><p align=center>
					<input type=submit name=action value="Load">
				</td>
			</tr>
		</table>
		</form>';
	}

	function postNews(){
		
	}

	function getUsers() {
		$sql = "SELECT name,email,password,uname,post_id FROM users";
		try {
		$db = getDB();
		$stmt = $db->query($sql); 
		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"users": ' . json_encode($users) . '}';
		} catch(PDOException $e) {
		//error_log($e->getMessage(), 3, '/var/tmp/phperror.log'); //Write error log
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	// GET http://www.yourwebsite.com/api/updates
	function getUserUpdates() {
		$sql = "SELECT A.user_id, A.username, A.name, A.profile_pic, B.update_id, B.user_update, B.created FROM users A, updates B WHERE A.user_id=B.user_id_fk  ORDER BY B.update_id DESC";
		try {
		$db = getDB();
		$stmt = $db->prepare($sql);
		$stmt->execute();  
		$updates = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"updates": ' . json_encode($updates) . '}';
		} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	// DELETE http://www.yourwebsite.com/api/updates/delete/10
	function deleteUpdate($update_id) {
		$sql = "DELETE FROM updates WHERE update_id=:update_id";
		try {
		$db = getDB();
		$stmt = $db->prepare($sql); 
		$stmt->bindParam("update_id", $update_id);
		$stmt->execute();
		$db = null;
		echo true;
		} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
?>