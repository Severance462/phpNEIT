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
