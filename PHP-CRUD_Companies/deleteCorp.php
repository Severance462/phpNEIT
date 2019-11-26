<html>
    <head>
        <meta charset="UTF-8">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		
        <title>Delete Companies</title>
    </head>
    <body>
	
<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
		<div class="navbar-header" style="height:5em">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span> 
		  </button>
		  <a class="navbar-brand" href=".././index.php">John Lougee</a>
		</div>
			<div class="collapse navbar-collapse" id="myNavbar">
			  <ul class="nav navbar-nav">
				<li class="active"><a href=".././index.php">Home</a></li>				
				<li class="dropdown">
				  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Resources<span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="http://php.net/">PHP Documentation</a></li>
					<li><a href="https://www.w3schools.com/php/default.asp">W3 Schools</a></li>					
					<li><a href="http://www.phptherightway.com/">PHP the right way</a></li>
					<li><a href="https://www.learn-php.org/">Learn php</a></li>
				  </ul>
				</li>          
				<li class="dropdown">
				  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Assignments<span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="../Week1/creditCard.php">Week 1 - Credit Payoff Calculator</a></li>
					<li><a href="../Week2/actorIndex.php">Week 2 - Actor Database</a></li>
					<li><a href="../Week3/view-all.php">Week 3 - Companies Database</a></li>
				  </ul>
				</li> 				
			  </ul>
			  <ul class="nav navbar-nav navbar-right">
				<li><a href="https://github.com/Severance462/phpNEIT"><button type="button" class="btn btn-default">Github Repository</button></a></li>
			  </ul
			</div>
			
		</div>
	</nav>			
        <div class="container">        

            <?php
            include 'dbconnect.php';
            include 'functions.php';

                $db = getDatabase();

                $id = filter_input(INPUT_GET, 'id');

                $sqlState = $db->prepare("DELETE FROM corps WHERE id = :id");

                $binds = array(
                        ":id" => $id
                        );

                $isDeleted = false;                
                if ($sqlState->execute($binds) && $sqlState->rowCount() > 0) {
                    $isDeleted = true;
                } 
                

                ?>


            <div class="jumbotron">
                <h1>Record <?php echo $id; ?>
                <?php if(!$isDeleted): ?>
                    Not
                    <?php endif; ?>
                Deleted</h1>                                
            </div>
			
			<a class="btn btn-info" href="view-all.php">View All Companies</a>												
        
        </div>
       <footer class="footer navbar-fixed-bottom" style="margin-bottom:2em; background-color:black">
		<div class="container">
			<div class="row mb-3 text-center d-flex justify-content-center">
				<div class="col-md-4 mb-3">
				</div>				
				<div class="col-md-4 mb-3">
					<h6 class="text-uppercase font-weight-bold">
						<a class="btn btn-outline-secondary" href="../index.php">Back to Home</a>
					</h6>
				</div>				
				<div class="col-md-4 mb-3">
				</div>					
			</div>
		</div>	
	</footer>         
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
           
    </body>
</html>


