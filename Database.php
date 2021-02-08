<?php 

class Database{
	private static $conn=null;
      

	public function __construct()
	{
		if(!Database::$conn)
		{
			try {
				Database::$conn = new PDO("mysql:host=127.0.0.1;dbname=myapp", "root", "");
				// set the PDO error mode to exception
				Database::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				// echo "Connected successfully";
			} catch(PDOException $e) {
				echo "Connection failed: " . $e->getMessage();
			}
		}
	}


	public function insert($userid,$task)
	{
			$prepared_statement = Database::$conn->prepare("INSERT INTO tasks (user_id,task) VALUES (:userid,:task)");
			$prepared_statement->bindParam(':userid',$userid);
			$prepared_statement->bindParam(':task',$task);
			try{
				$prepared_statement->execute();	
				return true;
			}catch(PDOException $e)
			{
				echo "Some Database Error",$e->getMessage();
				// code to log into log table
			}
		 return false;
	}
 }

 
 ?>
