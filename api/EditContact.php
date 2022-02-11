<?php
	
	$inData = json_decode(file_get_contents('php://input'), true);
	
	$userID = $inData["UserID"];
	
	$contactFirstNameOld = $inData["OldFirstName"];
	$contactLastNameOld = $inData["OldLastName"];
	$contactEmailOld = $inData["OldEMail"];
	$contactPhoneOld = $inData["OldPhone"];
	
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
		$stmt = $conn->prepare("UPDATE Contacts SET FirstName =?, LastName =?, EMail =?, Phone =? WHERE UserID =? AND FirstName =? AND LastName =? AND EMail =? AND Phone =?"); 
		// bind parameters
		$stmt->bind_param("ssssissss", $contactFirstName, $contactLastName, $contactEmail, $contactPhone, $userID, $contactFirstNameOld, $contactLastNameOld, $contactEmailOld, $contactPhoneOld);
		// execute
		$stmt->execute(); // does not take parameters
		// close connections
		$stmt->close();
		$conn->close();
		returnWithError("Editted");
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