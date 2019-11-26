
<html>
    <head>
        <meta charset="UTF-8">
		
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		
        <title>John Lougee - PHP projects</title>
		
    </head>
    <body>
	
	<?php include 'nav.php'?>
<div class="container">

        
		<div class="jumbotron">
			<h1>PHP Projects</h1>
			<br/>
        </div> 
		
        <h2>Assignments</h2> 
		<div class="container-fluid" >
			<div class="row">
				<div class="col-md-2">
					<div class="list-group">
					  <h4 class="list-group-item">Week 1</h4> 
					  <a class="list-group-item" href="./Week1/creditCard.php">Credit Card</a>					  
					  <a class="list-group-item" href="./Week1/creditCard.zip">Zip File</a>					  
					</div>							
				</div>
				<div class="col-md-2">
					<div class="list-group">
						<h4 class="list-group-item">Week 2</h4> 
						<a class="list-group-item" href="./Week2/actorIndex.php">Actor Database</a>
						<a class="list-group-item" href="./Week2/lab2.zip">Zip File</a>
					</div>
				</div>
				<div class="col-md-2">
					<div class="list-group">
						<h4 class="list-group-item">Week 3</h4> 
						<a class="list-group-item" href="./Week3/view-all.php">Companies</a>
						<a class="list-group-item" href="./Week3/lab3.zip">Zip File</a>
					</div>
				</div>
				<div class="col-md-2">
					<div class="list-group">
						<h4 class="list-group-item">Week 4</h4> 
						<a class="list-group-item" href="./Week4/view-all.php">Companies 2</a>
						<a class="list-group-item" href="./Week4/lab4.zip">Zip File</a>
					</div>
				</div>
			</div>
		</div> 		
		  
		<a class="btn btn-default" href="https://github.com/Severance462/phpNEIT">
			Github Repository
		</a>
		
        <h2>Learning Resources</h2> 
		<div class="container-fluid" >
			<div class="row">
				<div class="col-md-3">
					<div class="list-group">
					  <a href="http://php.net/" class="list-group-item">PHP Documentation</a>
					  <a href="https://www.w3schools.com/php/default.asp" class="list-group-item ">W3 Schools</a>
					  <a href="http://www.phptherightway.com/" class="list-group-item ">PHP the right way</a>
					  <a href="https://www.learn-php.org/" class="list-group-item ">Learn php</a>
					</div>		
				</div>
			</div>
		</div>
	

        

		
		
		<div >
			<?php
				$file = "index.php";
				$mod_date=date("F d Y h:i:s A", filemtime($file));

				echo "Last modified $mod_date";
			?>
		</div>
		<br/><br/><br/><br/><br/>
	<footer class="footer navbar-fixed-bottom" style="margin-bottom:2em; background-color:black">
		<div class="container">
			<div class="row mb-3 text-center d-flex justify-content-center">
				<div class="col-md-4 mb-3">
				</div>				
				<div class="col-md-4 mb-3">
					<h6 class="text-uppercase font-weight-bold">
						<a class="btn btn-outline-secondary" href="./index.php">Back to Home</a>
					</h6>
				</div>				
				<div class="col-md-4 mb-3">
				</div>					
			</div>
		</div>	
	</footer>
	
		
        
		
	
</div>
	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
    </body>
</html>


