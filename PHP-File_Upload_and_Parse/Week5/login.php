<html>
    <head>
        <meta charset="UTF-8">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		
        <title>View All Companies</title>
    </head>
    <body>
	
			<?php include '../Common/nav.php' ?>
        <div class="container">   
			<div class="jumbotron">
				<h1>Schools</h1>
			</div>
			
			<?php 	include '../Common/dbconnect.php';
					include '../Common/functions.php';
			?>
			

			<form action="#" method="POST">
			<div class="row">
				<div class="col-md-4" style="margin-left:50px">
				</div>
				<div class="col-md-4">
					<h3>Please log in: </h3>
				</div> 
			</div> 
			<br/>
			<div class="row">
				<div class="col-md-4">
				</div>
				<div class="col-md-4">
					Username: <input type="text" name="username" placeholder="Username" />
				</div>
			</div>
			<br />
			<div class="row">		
				<div class="col-md-4">
				</div>
				
				<div class="col-md-4">
					Password: <input type="password" name="password" placeholder="Password" />
				</div>				
			</div>
			<br /><br />
			<div class="row">
				<div class="col-md-4">
				</div>
				
				<div class="col-md-4" style="margin-left:100px">
			<input type="submit" value="Submit">
        </div>
		</form>
					<div class="row">
			<div class="col-md-4">
			</div>
			<div class="col-md-4">
				<?php 
				
				session_start();
				
				?>
				
				<?php 
				if (isPostRequest())
				{					
					//$salt = "saltyMFer";
					$username = $_POST['username'];										
					//$password = $salt . $_POST['password'];															
					//$password = sha1($password);
					$password = $_POST['password'];
					$password = sha1($password);					
					
		            $db = getDatabase();
					$binds = array(
								":username" => $username,								
								":password" => $password,
								);
																		
					$sqlState = $db->prepare("SELECT * FROM users WHERE 0=0 AND username like :username AND password like :password");
								
					$results = array();
					if($sqlState->execute($binds) && $sqlState-> rowCount() > 0)
					{
						$results = $sqlState->fetch(PDO::FETCH_ASSOC);
						$_SESSION["username"] = $username;
						$_SESSION["loggedIn"] = true;					
						//print_r($_SESSION);
						
						setcookie("loggedIn", true);
						setcookie("username", $username);

						header('Location: upload.php');
						echo "yes";
					}
					else
					{	
				echo "No";
						session_unset();
						session_destroy();
						header('Location: login.php');						
					}									
				}
				?>
			</div> 		
		</div>

           
        
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
           
    </body>		
<?php include '../Common/footer.php' ?>

</html>


