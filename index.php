<?php
session_start();


if($_SERVER['REQUEST_METHOD']=="POST")
{

	
	$email = trim($_POST['email']);
	$password = md5($_POST['password']);
			require_once 'db.php';
			$prepared_statement = $conn->prepare("SELECT * FROM users WHERE email=:email and password=:password");
			$prepared_statement->bindParam(':email',$email);
			$prepared_statement->bindParam(':password',$password);
			try{
				$prepared_statement->execute();	
				$prepared_statement->setFetchMode(PDO::FETCH_ASSOC);
				$result =  $prepared_statement->fetch();
				if($prepared_statement->rowCount()>0)
				{
					$_SESSION['userid'] = $result['user_id'];

					header('Location:dashboard.php');
				}else{
					$error = "";
				}

	
			}catch(PDOException $e)
			{
				echo "Some Database Error",$e->getMessage();
				// code to log into log table
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

		.forgot{
			font-size: 0.8em;
			padding-bottom:8px;
		}

		.form-container div{
			text-align: center;
			margin-top:20px;
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
		}

		.form-container button:hover{
			background-color: #333;
			cursor: pointer;
			box-shadow: none;
			
		}

		.error{
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
		<h2>Login Form</h2>
		<form method="post">
			<div class="form-container">
				<?php if (isset($error)){ ?>
					<div class="error error-message">Invalid Username or password!</div>
				<?php } ?>
				<label for="email">Email : </label>
				<input type="email" name="email" class="input">
				<label for="password">Password : </label>
				<input type="password" name="password" class="input">
				<a class="btn forgot" href="reset.php">Forgot Password?</a>
				<button type="submit">Login</button>
				<div>Are you new user? <a href="register.php" class="btn">Register</a></div>
			</div>
		</form>
	</div>
</body>
</html>