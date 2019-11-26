<?php

/**
 * A method to check if a Post request has been made.
 *    
 * @return boolean
 */
function isPostRequest() {
    return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' );
}

function runSql(){
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

function uploadFile($file1)
{

		
	if (isset ($_FILES['file1'])) {
	$tmp_name = $_FILES['file1']['tmp_name'];
	$path = getcwd() .DIRECTORY_SEPARATOR . 'uploads';
	
	$new_name = $path . DIRECTORY_SEPARATOR . $_FILES['file1']['name'];

	move_uploaded_file($tmp_name, $new_name);
	echo "File uploaded!";
	}

}

function tableFromFile(){
	$db = getDatabase();
	$sqlState = $db->prepare("TRUNCATE TABLE schools;");
	if($sqlState->execute())
	{
		
		$file = fopen ('./uploads/schools.csv', 'rb');

		while (!feof($file)) 
		{			
			$school = fgetcsv($file);	
			
			$name = $school[0];
			$city = $school[1];
			$state = $school[2];					
			
			if(($school[0] != "INSTNM"))
			{
				$sqlState = $db->prepare("INSERT INTO schools SET name = :name, city = :city, state = :state");
				
				$binds = array(
					":name" => $name,
					":city" => $city,
					":state" => $state
				);

			if($sqlState->execute($binds))
				{
					$results = 'School Added!';					
				}
				else
				{
					$results = 'nope';
				}
			}
		}
	}
	
	
}

