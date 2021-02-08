<?php 
	if($_SERVER['REQUEST_METHOD']=="POST")
	{

		$errors = array();

		$username = trim($_POST['username']);
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);	
		
		if(strlen($username)<3)
		{
			$errors['username']="Please Enter a Valid username!";
		}

		if(!(strlen($password)>=8 && strlen($password)<=16))
		{
			$errors['password']= "Password Must be more 8 chars"; 
		}

		if(count($errors)==0)
		{
			require_once 'db.php';
			$ps = $conn->prepare('SELECT * FROM users WHERE email=:email');
			$ps->bindParam(':email',$email);
			try{
				$ps->execute();	
				if($ps->rowCount()==0)
				{
					$prepared_statement = $conn->prepare("INSERT INTO users (username,email,password) VALUES (:username,:email,:password)");
						$prepared_statement->bindParam(':username',$username);
						$prepared_statement->bindParam(':email',$email);
						$password = md5($password);
						$prepared_statement->bindParam(':password',$password);
						try{
							$prepared_statement->execute();	
							header('Location:index.php');
						}catch(PDOException $e)
						{
							echo "Some Database Error",$e->getMessage();
							// code to log into log table
						}
				}else{
					echo "<script>alert('Email Already Registered!');</script>";
				}
			}catch(PDOException $e)
			{
				echo "Some Database Error",$e->getMessage();
				// code to log into log table
			}

			
			
		}

		// echo "<pre>",var_dump($errors),"</pre>";
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
		}

		.container{
			background-color: #f9f9f9;
			padding: 1.5em;
			border-radius: 0.8em;
			box-shadow: 0px 0px 5px #f9f9f9;
		}

		.form-container{
			display: flex;
			flex-direction: column;
			gap:0.5em;
		}

		.container h2{
			text-align: center;
			padding: 1em;
			font-weight:600;
			font-size: 2em;
		}


		/* styling form elements */
		.input{
			padding:0.2em 0.8em;
			border:2px solid lightgray;
			border-radius: 0.5em;
		}

		.form-container label{
			font-weight: 600;
		}

		.form-container a{
			text-decoration: none;	
		}

		.form-container div{
			text-align: center;
			
		}

		.form-container button{
			padding: 0.5em;
			border:none;
			border-radius: 0.5em;
			background-color: #666;
			color:#f9f9f9;
			font-weight: 600;
			border:2px solid #444;
			box-shadow: 0px 2px 5px gray;
			transition: 0.3s all;
			margin:1em 0;
		}

		.form-container button:hover{
			background-color: #333;
			cursor: pointer;
			box-shadow: none;
			
		}

		.errors{
			background-color: rgba(255, 0, 0, 0.2);
			border:2px solid rgba(255, 0, 0, 0.3);
			
		}

		.form-container .error-message{
			color: red;
			font-size: 0.8em;
			padding: 0.2em;
		}
	</style>
</head>
<body>
	<div class="container">
		<h2>New User</h2>
		<form action="register.php" method="post">
			<div class="form-container">
				<label for="username">Username : </label>
				<input type="text" name="username" class="input <?php echo isset($errors['username']) ?  'errors' : "";?>">
				<?php echo isset($errors['username']) ? "<span class='error-message'><i class=\"fas fa-exclamation-circle\"></i> {$errors['username']}</span>" : ""; ?>
				<label for="email">Email : </label>
				<input type="email" name="email" class="input <?php echo isset($errors['email']) ?  'errors' : "";?>" >
				<label for="password">Password : </label>
				<input type="password" name="password" class="input <?php echo isset($errors['password']) ?  'errors' : "";?>">
				<?php echo isset($errors['password']) ? "<span class='error-message'><i class=\"fas fa-exclamation-circle\"></i> {$errors['password']}</span>" : ""; ?>
				<button type="submit">register</button>
				<div>Are you Registered user? <a href="index.php" class="btn">Login</a></div>
			</div>
		</form>
	</div>
</body>
</html>