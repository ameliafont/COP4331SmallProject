<?php

	$inData = json_decode(file_get_contents('php://input'), true);
	
	$userID = $inData["userID"];
	// TODO: any additional variables for contact info
	$contactFirstName = $inData["contactFirstName"];
	$contactLastName = $inData["contactLastName"];
	$contactPhoneNumber = $inData["contactPhoneNumber"];
	$contactEmail = $inData["contactEmail"];
	
	// connect to mysql
	$conn = new mysqli(/*host*/, $userID, /*user password*/, /*database*/); // TODO: add parameters

	// check for connection error
	if ($conn->connect_error)
	{
		returnWithError($conn->connect_error);
	}
	else
	{
		// prepare sql statment for execution
		$stmt = $conn->prepare("INSERT into Contacts () VALUES()"); // TODO: add parameters to parentheses
		// bind parameters
		$stmt->bind_param("sssis", $userID, $contactFirstName, $contactLastName, $contactPhoneNumber, $contactEmail); // TODO: add parameters
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

