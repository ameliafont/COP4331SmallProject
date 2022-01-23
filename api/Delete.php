<?php
	$inData = getRequestInfo();
	
	$color = $inData["color"];
	$userId = $inData["userId"];

	$conn = new mysqli("cop4331-24.xyz", "DatabaseUser", "DatabasePassword", "COP4331");
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$stmt = $conn->prepare("DELETE FROM Contacts WHERE firstName = ? AND lastName = ?)");
		$stmt->bind_param("ss", $firstName, $lastName);
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