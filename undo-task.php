<?php 

session_start();

// check if user is logged in or not
if(!isset($_SESSION['userid']))
{
	// if user is not logged in send back to login page
	header('Location:index.php');
}
$taskid = $_GET['taskid'];

require_once 'db.php';
			$prepared_statement = $conn->prepare("UPDATE tasks SET is_completed=0 WHERE task_id=:taskid AND user_id=:userid");
			$prepared_statement->bindParam(':taskid',$taskid);
			$prepared_statement->bindParam(':userid',$_SESSION['userid']);
			try{
				$prepared_statement->execute();	
				header('Location:dashboard.php');
			}catch(PDOException $e){
				echo $e->getMessage();
				die();
			}
 ?>