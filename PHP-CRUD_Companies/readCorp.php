<html>
    <head>
        <meta charset="UTF-8">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		
        <title>Read Company</title>
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
            
            $result = '';
            if(isPostRequest()) {
                $id = filter_input(INPUT_POST, 'id');                
                $corp = filter_input(INPUT_POST, 'corp');
                $incorp_dt = filter_input(INPUT_POST, 'incorp_dt');
                $email = filter_input(INPUT_POST, 'email');
                $zipcode = filter_input(INPUT_POST, 'zipcode');
                $owner = filter_input(INPUT_POST, 'owner');  
                $phone = filter_input(INPUT_POST, 'phone');                           
                
                $sqlState = $db->prepare("UPDATE corps SET corp = :corp, email = :email, zipcode = :zipcode, owner = :owner, phone = :phone WHERE id = :id");
                $binds = array(
                        ":id" => $id,                        
                        ":corp" => $corp,
                        ":incorp_dt" => $incorp_dt,
                        ":email" => $email,
                        ":zipcode" => $zipcode,
                        ":owner" => $owner,
                        ":phone" => $phone
                );   
                
                if($sqlState->execute($binds) && $sqlState->rowCount() > 0)
                {
                    $results = 'Company Updated!';
                }
            }else{
                $id = filter_input(INPUT_GET, 'id');
                $sqlState = $db->prepare("SELECT id, corp, incorp_dt, email, zipcode, owner, phone FROM corps WHERE id = :id");
                $binds = array(
                    ":id" => $id
                );
                if($sqlState->execute($binds) && $sqlState->rowCount() > 0){
                    $results = $sqlState->fetch(PDO::FETCH_ASSOC);
                }
                if(!isset($id)){
                    die('Record not found');
                }
                $id = $results['id'];
                $corp = $results['corp'];
                $incorp_dt = $results['incorp_dt'];
                $email = $results['email'];
                $zipcode = $results['zipcode'];
                $owner = $results['owner'];
                $phone = $results['phone'];
            }
            ?>                        
            
        <div class="jumbotron">
            <h1>Read Company</h1>

        </div>
            
		<div class="container">
			<form method="post" action="addCorp.php">
			<div class="row">
                            <div class="col-md-3">
					<div class="form-group" method="post" action="#">
						<input type="hidden" class="form-control" name="id" value = "<?php echo $id; ?>" placeholder="Company ID">						
					</div>	
				</div>         
                        </div>
                            
                        <div class="row">        
				<div class="col-md-3">
					<div class="form-group">
						<label for="corp">Company Name</label>
						<input type="text" class="form-control" name="corp" value = "<?php echo $corp; ?>" placeholder="Company Name">
						<small id="corpHelp" class="form-text text-muted">Company name</small>
					</div>	
				</div>                            
				<div class="col-md-2">
					<div class="form-group">
						<label for="incorp_dt">Incorporation Date</label>
						<input type="text" class="form-control" name="incDate" value = "<?php echo $incorp_dt; ?>" placeholder="Company Incorporation Date">
						<small id="incDateHelp" class="form-text text-muted">Ex: 1/01/2000</small>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" name="email" value = "<?php echo $email; ?>" placeholder="Company Email Address">
						<small id="emailHelp" class="form-text text-muted">Company contact's email address</small>
					</div>	
				</div>
                            
                            
				<div class="col-md-2">
					<div class="form-group">
						<label for="zipcode">Zip Code</label>
						<input type="text" class="form-control" name="zipcode" value = "<?php echo $zipcode; ?>"  placeholder="Enter Zip Code">
						<small id="zipcodeHelp" class="form-text text-muted">Zip Code</small>
					</div>	
				</div>
                        </div>
                        <div class="row">
                                <div class="col-md-3">
					<div class="form-group">
						<label for="owner">Owner</label>
						<input type="text" class="form-control" name="owner" value = "<?php echo $owner; ?>" placeholder="Enter Company Owner">
						<small id="ownerHelp" class="form-text text-muted">First and last name of the company owner</small>
					</div>	
				</div>
                                <div class="col-md-3">
					<div class="form-group">
						<label for="phone">Phone</label>
						<input type="text" class="form-control" name="phone" value = "<?php echo $phone; ?>" placeholder="Company Phone Number">
						<small id="phoneHelp" class="form-text text-muted">Ex: 1-555-555-5555</small>
					</div>	
				</div>                            

			</div>
			<br />
			<div class="row">
				<div class="col-md-2">
					<a style="width:150px" class='btn btn-primary' href='updateCorp.php?id=<?php echo $id; ?>'>Update company</a>					
				</div>
				<div class="col-md-2">				
					<a class="btn btn-info" href="view-all.php">View All Companies</a>											
				</div>
				<div class="col-md-2">
					<a class='btn btn-danger' href='deleteCorp.php?id=<?php echo $row['id']; ?>'>Delete company</a>
				</div>	
				</div>
			</div>
			</form>
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
        </div>
        
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
           
    </body>
</html>


