<?php 
session_start();
$user = "";
if(!isset($_SESSION['userid']))
{
	header('Location:index.php');
}else{
			require_once 'db.php';
			$prepared_statement = $conn->prepare("SELECT * FROM users WHERE user_id=:userid");
			$prepared_statement->bindParam(':userid',$_SESSION['userid']);
			try{
				$prepared_statement->execute();	
				$prepared_statement->setFetchMode(PDO::FETCH_ASSOC);
				$user =  $prepared_statement->fetch();
				
			}catch(PDOException $e)
			{
				echo "Some Database Error",$e->getMessage();
				// code to log into log table
				die();
			}
}


// if we recive task id
if(isset($_GET['taskid']))
{
			require_once 'db.php';
			$ps = $conn->prepare("SELECT * FROM tasks WHERE task_id=:taskid and user_id=:user_id");
			$ps->bindParam(':taskid',$_GET['taskid']);
			$ps->bindParam(':user_id',$_SESSION['userid']);
			// $ps->bindParam(':userid',$_SESSION['userid']);
			
			try{
				$ps->execute();	
				$ps->setFetchMode(PDO::FETCH_ASSOC);
				$task =  $ps->fetch();
				
			}catch(PDOException $e)
			{
				echo "Some Database Error",$e->getMessage();
				// code to log into log table
				die();
			}
}
			



 ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Code Win | Smiplifying your programming Experience</title>
	<link rel="stylesheet" href="reset.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
	<style type="text/css">
		*{
			font-family: 'Poppins', sans-serif;
		}

		body{
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			background-color: #FDFAF3;
		}

		.container{
			
			padding: 1.5em;
			width: 600px;
			border-radius: 0.8em;
			box-shadow: 0px 0px 5px lightgray;
			display: flex;
			flex-direction: column;
			gap:20px;
		}

		

		.header{
			width: 100%;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		.header div{
			display: flex;
			align-items: center;
			font-size: 2em;	
		}

		.form-container form{
			display: flex;
			justify-content: space-between;
		}



		/* styling form elements */
		.input{
			padding:0.2em 0.8em;
			border:2px solid lightgray;
			border-radius: 0.5em;
			width: 448px;
		}

		.error{
			background-color: rgba(255, 0, 0, 0.2);
			border:2px solid rgba(255, 0, 0, 0.3);
			
		}

		.form-container button{
			height: 30px;
			border:none;
			border-radius: 30px;
			background-color: #666;
			color:#f9f9f9;
			border:2px solid #444;
			box-shadow: 0px 2px 5px gray;
			transition: 0.3s all;
		}

		.form-container button:hover{
			background-color: #333;
			cursor: pointer;
			box-shadow: none;
			
		}
		
		.form-container .error-message{
			color: red;
			font-size: 0.8em;
			padding: 0.2em;
		}

		.tasks-container{
			display: flex;
			flex-direction: column;
			/* gap:8px; */
			/* background-color: #f9f9f9; */
		}

		.task{
			display: flex;
			justify-content: space-between;
			align-items: center;
			height: 30px;
			padding: 0px 12px;
			border-top:2px solid lightgray;
			border-bottom:1px solid lightgray;
		}

		.task:nth-child(even){
			/* background-color: lightgray; */
		}

		.fa-trash{
			color:#EA1601;
		}

		.fa-edit{
			color:#64bc26;
		}

		.tasks-container .fa{
			/* background-color: lightgray; */
			padding: 0.5em;
			/* border-radius:100%; */
		}

		.completed{
			color: gray;
			text-decoration:line-through;

		}	

nav a{
	text-decoration: none;
	padding: 0.3em 0.5em;
	border-radius:20px;
	color: #111;
	transition: 0.3s all;
	border: 2px solid #333;
}



nav a:hover{
	background-color: #111;
	color: #fff;
}
	</style>
</head>
<body>
	<div class="container">
		<div class="header">
			<div><i class="fa fa-user-circle"></i> &nbsp; <?=$user['username'] ?></div>
			<nav>					
				<a href="logout.php"><i class="fa fa-lock"></i> &nbsp;Logout</a>
			</nav>
		</div>
		<hr>

		<div class="form-container">
			<form action="<?php echo isset($_GET['taskid']) ? 'update-task.php' : 'addtask.php' ?>" method="post">
				<div>
					<?php if(isset($_GET['taskid'])) { ?>
					<input type="hidden" value="<?=$_GET['taskid']?>" name="taskid">
					<?php } ?>
					<input type="text" name="task" placeholder="Enter Task" class="input <?php echo isset($_SESSION['errors']) ? 'error' : ''; ?>" value='<?php echo isset($_GET['taskid'])? $task['task'] : ''; ?>'><br>
					<?php
					if(isset($_SESSION['errors'])){
					?>
					<span class="error-message"><i class="fas fa-exclamation-circle"></i> <?= $_SESSION['errors']?> </span>
					<?php
					unset($_SESSION['errors']);
				}
					?>
				</div>
				<?php if(isset($_GET['taskid'])) {?>
					<button type="submit"><i class="fa fa-recycle"></i> update</button>
				<?php }else{ ?>
				<button type="submit"><i class="fa fa-plus-circle"></i> New Task</button>
			<?php } ?>
			</form>
		</div>
		<!-- /.form-container -->


		<div class="tasks-container">
			<?php 
			require_once 'db.php';
			$prepared_statement = $conn->prepare("SELECT * FROM tasks WHERE user_id=:userid");
			$prepared_statement->bindParam(':userid',$_SESSION['userid']);
		
			try{
				$prepared_statement->execute();	
				$prepared_statement->setFetchMode(PDO::FETCH_ASSOC);
				$tasks =  $prepared_statement->fetchAll();
				foreach ($tasks as $task) {
					?>
				<div class="task">

					<p class="<?php echo $task['is_completed'] 	? 'completed' : ''; ?>"><?=$task['task']?></p>
					<div class="action">
						<!--all the button code goes here -->
						<?php if($task['is_completed']){ ?>
						<a href="undo-task.php?taskid=<?=$task['task_id'] ?>"><i class="fa fa-times-circle"></i></a>
					<?php }else{ ?>
						<a href="complete-task.php?taskid=<?=$task['task_id'] ?>"><i class="fa fa-check"></i></a>
					<?php } ?>

						<a href="delete-task.php?taskid=<?=$task['task_id'] ?>"><i class="fa fa-trash"></i></a>
						<a href="dashboard.php?taskid=<?=$task['task_id'] ?>"><i class="fa fa-edit"></i></a>
					</div>
				</div>
					<?php
				}
				

	
			}catch(PDOException $e)
			{
				echo "Some Database Error",$e->getMessage();
				// code to log into log table
			}

			 ?>
			
			

			<!-- <div class="task">
				<p>Complete the following Task</p>
				<div class="action">
					<a href=""><i class="fa fa-check"></i></a>
					<a href=""><i class="fa fa-trash"></i></a>
					<a href=""><i class="fa fa-edit"></i></a>
				</div>
			</div>


			<div class="task">
				<p class="completed">Complete the following Task</p>
				<div class="action">
					<a href=""><i class="fa fa-times-circle"></i></a>
					<a href=""><i class="fa fa-trash"></i></a>
					<a href=""><i class="fa fa-edit"></i></a>
				</div>
			</div>


			<div class="task">
				<p class="completed">Complete the following Task</p>
				<div class="action">
					<a href=""><i class="fa fa-check"></i></a>
					<a href=""><i class="fa fa-trash"></i></a>
					<a href=""><i class="fa fa-edit"></i></a>
				</div>
			</div> -->
		</div>
	<!-- /.task-containr -->
	</div>

	
</body>
</html>