<?php
	$inData = json_decode(file_get_contents('php://input'), true);
	
	// string to append search results to and counter
	$searchRes = "";
	$sCount = 0;

	// new conntection to mysqli class
	$conn = new mysqli("cop4331-24.xyz", "DatabaseUser", "DatabasePassword", "COP4331");
	// check for connection error 
	if ($conn->connect_error)
	{
		returnWithError($conn->connection_error);
	}
	else
	{
		// search database
		$stmt = $conn->prepare("select Name from Contacts where Name like ? and UserID=?");
		$nameContact = "%" . $inData["search"] . "%";
		$stmt->bind_param("ss", $nameContact, $inData["ID"]);
		$stmt->execute();

		$res = $stmt->get_result();

		while ($row = $res->fetch_assoc())
		{
			if ($sCount > 0)
			{
				$searchRes .= ","
			}

			$sCount++;
			$searchRes .= '"' . $row["Name"] . '"';
		}

		if ($sCount == 0)
		{
			returnWithError("No Contacts Found");
		}
		else
		{
			returnWithInfo($searchResults);
		}

		$stmt->close();
		$conn->close();
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
		
	function returnWithError( $err )
	{
		$retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $searchResults )
	{
		$retValue = '{"results":[' . $searchResults . '],"error":""}';
		sendResultInfoAsJson( $retValue );
	}
?>
