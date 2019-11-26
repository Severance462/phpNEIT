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
<?php include 'nav.php' ?>
        <div class="container">   

        <?php
            include 'dbconnect.php';
            include 'functions.php';
            
            $db = getDatabase();

			
            $sqlState = $db->prepare("Select id, corp from corps");
			
			$results = array();
			if($sqlState->execute() && $sqlState-> rowCount() > 0)
			{
						$results = $sqlState->fetchAll(PDO::FETCH_ASSOC);
			}

            ?>
			
        <div class="jumbotron">
            <h1>Companies</h1>
        </div>
            
            <div class="row">
				<div class="col-md-2">
					<a class='btn btn-primary' href='addCorp.php'>Add a company</a>
				</div>
				<div class="col-md-8">
				</div>
				<div class="col-md-2">
					<a class='btn btn-info' href='view-all-full.php'>Search/Sort full details</a>
				</div>
			</div>
            <br/>
            <br/>
            
			<div class="row">
				<div class="col-md-3">				
					<?php include './form1.php'; ?>
				</div>
				<div class="col-md-3">
				</div>
				<div class="col-md-6">
				
					<?php include './form2.php'; 
					
					if (isPostRequest())
						{
							$db = getDatabase();
							$column = $_POST['column'];										
							$sort = $_POST['sortDir'];	
							$search = $_POST['search'];
							$searchStr = '%' . $search . '%';
							$searchSRTBY = $_POST['searchSRT1'];
														
							if($column == "none")
							{
								$sqlColumn = "";
							}
							else 
							{
								$sqlColumn = " ORDER BY $column $sort ";
							}
													
							//do like instead of = and bind the search box and create bind either way on catch
							if($search != "" || $search != null)
							{
								$completeString = " WHERE $searchSRTBY LIKE :searchStr $sqlColumn "; 
							}
							else
							{
								$completeString = " $sqlColumn "; 
							}
						
							if($search != "")
							{
								$binds = array(
								":searchStr" => $searchStr,								
								);
							}
							$sqlState = $db->prepare("SELECT * FROM corps " . $completeString);													
							
							$results = array();
							
							if($sqlState->execute($binds) && $sqlState-> rowCount() > 0)
							{
								$results = $sqlState->fetchAll(PDO::FETCH_ASSOC);
							}																		
						}
							
						?>
				</div>	
			</div>
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"><?php echo ""?></th>
                            <th scope="col"><?php echo "Company"?></th>
                        </tr>
                    </thead> 
				
                    <tbody>
                        
                        
                        <?php 
							foreach($results as $countR)
							{
								$count++;				
							}
							echo "Rows affected:" . $count;
							?>
                        <?php 
						$count = 0;
                            foreach ($results as $row): ?>
                                <tr>                         									
                                    <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['corp']; ?></td>
                                        <td><a class='btn btn-info' href='readCorp.php?id=<?php echo $row['id']; ?>'>Read company</a></td>
                                        <td><a class='btn btn-primary' href='updateCorp.php?id=<?php echo $row['id']; ?>'>Update company</a></td>
                                        <td><a class='btn btn-danger' href='deleteCorp.php?id=<?php echo $row['id']; $count++;?>'>Delete company</a></td>								
                                    </tr>
                        <?php endforeach;?>                
                    </tbody>
				
                </table>
				<br /><br /><br /><br /><br />
            </div>  
    
	
        </div>
        
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
           
    </body>		
	<footer class="footer navbar-fixed-bottom" style="margin-bottom:2em; background-color:black">
		<div class="container">
			<div class="row mb-3 text-center d-flex justify-content-center">
				<div class="col-md-4 mb-3">
				</div>				
				<div class="col-md-4 mb-3">
					<h6 class="text-uppercase font-weight-bold">
						<a class="btn btn-outline-secondary" href=".././index.php">Back to Home</a>
					</h6>
				</div>				
				<div class="col-md-4 mb-3">
				</div>					
			</div>
		</div>	
	</footer>

</html>


