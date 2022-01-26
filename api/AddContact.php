<?php

	$inData = json_decode(file_get_contents('php://input'), true);
	
	//$userID = $inData["ID"];
	$contactFirstName = $inData["contactFirstName"];
	$contactLastName = $inData["contactLastName"];
	$contactEmail = $inData["contactEmail"];
	
	// connect to mysql
	$conn = new mysqli("localhost", "DatabaseUser", "DatabasePassword", "COP4331");

	// check for connection error
	if ($conn->connect_error)
	{
		returnWithError($conn->connect_error);
	}
	else
	{
		// prepare sql statment for execution
		$stmt = $conn->prepare("INSERT into Contacts (FirstName,LastName,EMail) VALUES(?,?,?)"); 
		// bind parameters
		$stmt->bind_param("sss", $contactFirstName, $contactLastName, $contactEmail);
		// execute
		$stmt->execute(); // does not take parameters
		// close connections
		$stmt->close();
		$conn->close();
		returnWithError("");
	}
	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}

	function returnWithError($err)
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
?>

