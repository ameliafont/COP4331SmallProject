<?php
	$inData = getRequestInfo();
	
	$firstName = $inData["FirstName"];
	$lastName = $inData["LastName"];
	$login = $inData["Login"];
	$password = $inData["Password"];
	
	if(empty($inData["FirstName"]) 
	   || empty($inData["LastName"])
	   || empty($inData["Login"])
	   || empty($inData["Password"])) 
	{returnWithError("Ensure all fields are filled");}

	
			 
	$conn = new mysqli("localhost", "DatabaseUser", "DatabasePassword", "COP4331");
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$exists = mysql_query($conn, "SELECT * FROM Users WHERE Login = '$login'"); 
		if(mysql_num_rows($exists)>0)
		{
			returnWithError("Login already exists");
		}
		$stmt = $conn->prepare("INSERT INTO Users (FirstName, LastName, Login, Password) VALUES(?, ?, ?, ?)");
		$stmt->bind_param("ssss", $firstName, $lastName, $login, $password);
		$stmt->execute();
		$stmt->close();
		$conn->close();
		returnWithError("Successfully completed");
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
