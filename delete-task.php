<?php 

session_start();
if(!isset($_SESSION['userid']))
{
	header('Location:index.php');
}

if(isset($_GET['taskid']))
{
	$taskid = $_GET['taskid'];
	require_once 'db.php';
			$prepared_statement = $conn->prepare("DELETE FROM tasks WHERE task_id=:taskid and user_id=:userid");
			$prepared_statement->bindParam(':taskid',$taskid);
			$prepared_statement->bindParam(':userid',$_SESSION['userid']);
			try{
				$prepared_statement->execute();	
				header('Location:dashboard.php');
			}catch(PDOException $e)
			{
				echo "Some Database Error",$e->getMessage();
				// code to log into log table
			}
}
 ?>