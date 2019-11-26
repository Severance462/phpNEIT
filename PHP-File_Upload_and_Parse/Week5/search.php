<html>
    <head>
        <meta charset="UTF-8">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		
        <title>View All Schools</title>
    </head>
    <body>
<?php include 'nav.php' ?>
        <div class="container">   

        <?php
            include '../Common/dbconnect.php';
            include '../Common/functions.php';
            
            $db = getDatabase();

			
            $sqlState = $db->prepare("Select * from schools");
			
		$results = array();
		if($sqlState->execute() && $sqlState-> rowCount() > 0)
		{
                    $results = $sqlState->fetchAll(PDO::FETCH_ASSOC);
		}
            
            ?>
        <div class="jumbotron">
            <h1>Schools</h1>
        </div>

            <br/>
            <br/>
            
			<div class="row">
				<div class="col-md-3">				
					<?php include './frmSearch1.php'; ?>
				</div>
				<div class="col-md-3">
				</div>
				<div class="col-md-6">
					<?php include './frmSearch2.php'; 
					
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
								
								$sqlState = $db->prepare("SELECT * FROM schools " . $completeString);													
							
								$results = array();
							
								if($sqlState->execute($binds) && $sqlState-> rowCount() > 0)
								{
									$results = $sqlState->fetchAll(PDO::FETCH_ASSOC);
								}	
							}
							else
							{
								$sqlState = $db->prepare("SELECT * FROM schools " . $completeString);													
							
							$results = array();
							
								if($sqlState->execute() && $sqlState-> rowCount() > 0)
								{
									$results = $sqlState->fetchAll(PDO::FETCH_ASSOC);
								}	
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
                            foreach ($results as $row): ?>
                                <tr class="row">   								
                                    <td class="col-sm-1"><?php echo $row['id']; ?></td>
                                    <td class="col-sm-5"><?php echo $row['name']; ?></td>
                                    <td class="col-sm-5"><?php echo $row['city']; ?></td>
                                    <td class="col-sm-4"><?php echo $row['state']; ?></td>
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


