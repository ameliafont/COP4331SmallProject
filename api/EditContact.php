<?php
	
	$inData = json_decode(file_get_contents('php://input'), true);
	
	$userID = $inData["UserID"];
	$contactFirstName = $inData["FirstName"];
	$contactLastName = $inData["LastName"];
	$contactEmail = $inData["EMail"];
	$contactPhone = $inData["Phone"];
	
	$fieldToChange = $inData["Change"];
	$newFieldData = $inData["Edit"];
	
	// connect to mysql
	$conn = new mysqli("localhost", "DatabaseUser", "DatabasePassword", "COP4331");
	
	// check for connection error
	if ($conn->connect_error)
	{
		returnWithError($conn->connect_error);
	}
	else
	{
		if ($fieldToChange == "FirstName")
		{
			$stmt = $conn->prepare("UPDATE Contacts SET FirstName =? WHERE UserID =? AND FirstName =? AND LastName =? AND EMail =? AND Phone =?"); 
			$stmt->bind_param("sissss", $newFieldData, $userID, $contactFirstName, $contactLastName, $contactEmail, $contactPhone);
		}
		elseif ($fieldToChange == "LastName")
		{
			$stmt = $conn->prepare("UPDATE Contacts SET LastName =? WHERE UserID =? AND FirstName =? AND LastName =? AND EMail =? AND Phone =?");
			$stmt->bind_param("sisssi", $newFieldData, $userID, $contactFirstName, $contactLastName, $contactEmail, $contactPhone);			
		}
		elseif ($fieldToChange == "EMail")
		{
			$stmt = $conn->prepare("UPDATE Contacts SET EMail =? WHERE UserID =? AND FirstName =? AND LastName =? AND EMail =? AND Phone =?");
			$stmt->bind_param("sisssi", $newFieldData, $userID, $contactFirstName, $contactLastName, $contactEmail, $contactPhone);
		}
		elseif ($fieldToChange == "Phone")
		{
			$stmt = $conn->prepare("UPDATE Contacts SET Phone =? WHERE UserID =? AND FirstName =? AND LastName =? AND EMail =? AND Phone =?");
			$stmt->bind_param("iisssi", $newFieldData, $userID, $contactFirstName, $contactLastName, $contactEmail, $contactPhone);
		}
		else
		{
			returnWithError("Invalid change");
		}
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