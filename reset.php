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
	</style>
</head>
<body>
	<div class="container">
		<h2>Password Reset</h2>
		<form action="register.php" method="post">
			<div class="form-container">
				<label for="email">Email : </label>
				<input type="email" name="email" class="input">
				<button type="submit">Reset password</button>
				<div>Are you Registered user? <a href="index.php" class="btn">Login</a></div>
			</div>
		</form>
	</div>
</body>
</html>