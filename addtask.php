<?php 
	session_start();
if(!isset($_SESSION['userid']))
{
	header('Location:index.php');
}

	if(isset($_POST['task']))
	{

		$task = htmlspecialchars(trim($_POST['task']));
		if($task=='')
		{
			$_SESSION['errors']= "Please fill task details!";
			header('Location:dashboard.php');
		}else{
			require_once 'Database.php';
			$dbconn = new Database();
			if($dbconn->insert($_SESSION['userid'],$task))
			{
				header('Location:dashboard.php');
			}
		}
	}else{
		//header('Location:dashboard.php');
	}

 ?>