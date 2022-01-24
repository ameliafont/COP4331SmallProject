<?php

	$inData = json_decode(file_get_contents('php://input'), true);
	
	$id = 0;
	$firstName = "";
	$lastName = "";
	
	$conn = new mysqli("localhost", "DatabaseUser", "DatabasePassword", "COP4331"); 
	
	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		// prepare prepares an SQL statement for execution
		$stmt = $conn->prepare("SELECT ID,FirstName,LastName FROM Users WHERE Login=? AND Password =?");
		// binds the parameters to the SQL query and tells the database what the parameters are
		// ss means the parameters data types are strings
		$stmt->bind_param("ss", $inData["Login"], $inData["Password"]);
		// executes the statement prepared by the prepare function 
		$stmt->execute();
		// Retrieves a result set from a prepared statement as a mysqli_result object
		// The data will be fetched from the MySQL server to PHP
		$result = $stmt->get_result();
		
		// Fetches one row of data from the result set and returns it as an associative array
		// Associative arrays are arrays that use named keys that you assign to them
		if( $row = $result->fetch_assoc()  )
		{
			// calls function further down with the info from row 
			returnWithInfo( $row['FirstName'], $row['LastName'], $row['ID'] );
		}
		// if there was nothing in the associative array then there is no record
		else
		{
			returnWithError("No Records Found");
		}
		
		// Closes a previously opened database connection
		$stmt->close();
		$conn->close();
	}
	
	function sendResultInfoAsJson( $obj )
	{
		// used to send a raw HTTP header
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $firstName, $lastName, $id )
	{
		$retValue = '{"id":' . $id . ',"firstName":"' . $firstName . '","lastName":"' . $lastName . '","error":""}';
		sendResultInfoAsJson( $retValue );
	}
?>