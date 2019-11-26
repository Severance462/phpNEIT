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
				<h1>Upload Files!</h1>
				<div class="row">			
				
			</div>
			<div class="col-md-11">
			</div>
			<div class="col-md-1">
					<input class="btn btn-primary" type="button" value="Log Out" />		
				</div>
			</div>
			
			
			<?php 	include '../Common/dbconnect.php';
					include '../Common/functions.php';
					
					session_start();
										
					if($_SESSION['loggedIn'] != 1 )
					{
						header('Location: login.php');						
					}
					else
					{
						echo "<h3>Welcome " . $_SESSION['username'] . "</h3>"; 
					}
					

			?>
			
			<?php

				 if (isset ($_FILES['file1'])) {
					$file1 = $_FILES['file1'];
					$results = uploadFile($file1);									
					tableFromFile();					
				}															
			?>


				
			

<br/>		
	<form action="../Week5/upload.php" method="post" enctype="multipart/form-data">
				
		<div class="row">
		
			<div class="col-md-3">
				<input type="file" name="file1" id="file1">
				</div>
		<div class="row">
			<div class="col-md-4">
				<input class="btn btn-primary" type="submit" value="Upload">
			</div>
		</div>				</form>
				
				<br/><br/>
				<input href="search.php" class="btn btn-primary" type="button" value="Search" />		
				
<?php
	
?>
				
			<?php  
			//display file if uploaded
				// $filename = './uploads/schools.csv';
			
				// if(file_exists($filename)){
				// $file = fopen ('./uploads/schools.csv', 'rb');

				
				
					
				// while (!feof($file)) {
					// $school = fgetcsv($file);	
					
				// echo "<div class='row'>";
					// echo "<div class='col-md-6'>";
					// echo ($school[0]);
					// echo "</div>";
					// echo "<div class='col-md-4'>";
					// echo ($school[1]);
					// echo "</div>";
					// echo "<div class='col-md-2'>";
					// echo ($school[2]);
					// echo "</div>";
				// echo "</div>";
				// }
				// }
				// else
				// {
					
				// }		
			// ?>
			
			
			<?php 
				
			?>
			<div class="row">
				<div class="col-md-4">
					
				</div>			
			</div>
			<br /><br /><br /><br />

			
			
		 		
		</div>

           
        
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
           
    </body>		
	<?php include '../Common/footer.php' ?>

</html>


