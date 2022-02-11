<?php
	$inData = getRequestInfo();
	
	$firstName = $inData["FirstName"];
	$lastName = $inData["LastName"];
	$login = $inData["Login"];
	$password = $inData["Password"];
	
	if ($firstName == "" || $lastName == "" || $login == "" || $password == "")
	{
		returnWithError("Ensure all fields are filled");
	}

	else 
	{
		$conn = new mysqli("localhost", "DatabaseUser", "DatabasePassword", "COP4331");
		if ($conn->connect_error) 
		{
			returnWithError( $conn->connect_error );
		} 
		else
		{
			$check =  $conn->prepare("SELECT Login FROM Users WHERE Login =?");
			$check->bind_param("s", $login);
			$check->execute();
			$res = $check->get_result();
			$row = $res->fetch_assoc();
			$check->close();
			$exists = $conn->query("SELECT * FROM Users WHERE Login = '$login'");
			if(mysqli_num_rows($exists)>0)
			{
				returnWithError("Login already exists");
			}
			else {
			$stmt = $conn->prepare("INSERT INTO Users (FirstName, LastName, Login, Password) VALUES(?, ?, ?, ?)");
			$stmt->bind_param("ssss", $firstName, $lastName, $login, $password);
			$stmt->execute();
			$stmt->close();
			$conn->close();
			returnWithError("Successfully completed");
			}
		}
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