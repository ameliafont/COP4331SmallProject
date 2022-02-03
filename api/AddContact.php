<?php

	$inData = json_decode(file_get_contents('php://input'), true);
	
	$userID = $inData["UserID"];
	$contactFirstName = $inData["FirstName"];
	$contactLastName = $inData["LastName"];
	$contactEmail = $inData["EMail"];
	$contactPhone = $inData["Phone"];
	
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
		$stmt = $conn->prepare("INSERT into Contacts (UserID,FirstName,LastName,EMail, Phone) VALUES(?,?,?,?,?)"); 
		// bind parameters
		$stmt->bind_param("isssi", $userID, $contactFirstName, $contactLastName, $contactEmail, $contactPhone);
		// execute
		$stmt->execute(); // does not take parameters
		// close connections
		$stmt->close();
		$conn->close();
		returnWithError("Added");
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

