<?php
	$inData = getRequestInfo();
	
	$userId = $inData["UserID"];
	$firstName = $inData["FirstName"];
	$lastName = $inData["LastName"];
	$email = $inData["EMail"];

	$conn = new mysqli("localhost", "DatabaseUser", "DatabasePassword", "COP4331");
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$stmt = $conn->prepare("DELETE FROM Contacts WHERE UserID =? AND FirstName =? AND LastName =? AND EMail =?");
		$stmt->bind_param("isss", $userId, $firstName, $lastName, $email);
		$stmt->execute();
		$stmt->close();
		$conn->close();
		returnWithError("Record Deleted");
	}

	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
?>