<?php

	$inData = getRequestInfo();
	
	$id = 0;
	$firstName = "";
	$lastName = "";

	// mysqli is a class, Represents a connection between PHP and a MySQL database
	// parameters: host, username, password, database name
	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331"); 
	// checks connection to MySQL, connect_error is class property
	if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		// prepare prepares an SQL statement for execution
		$stmt = $conn->prepare("SELECT ID,firstName,lastName FROM Users WHERE Login=? AND Password =?");
		// binds the parameters to the SQL query and tells the database what the parameters are
		// ss means the parameters data types are strings
		$stmt->bind_param("ss", $inData["login"], $inData["password"]);
	 
	 //checking if the user is already exist
	 $stmt = $conn->prepare("SELECT ID FROM Users WHERE login = ?");
	 $stmt->bind_param("ss", $login);
	 $stmt->execute();
	 $stmt->store_result();
	 
	 //if the user already exist in the database 
	 if($stmt->num_rows > 0){
		returnWithError("Already Exists")
		$response['message'] = 'User already registered';
		$stmt->close();
	 }
	 else{	 
		 //if user is new creating an insert query 
		 $stmt = $conn->prepare("INSERT INTO users (login, password) VALUES (?, ?)");
		 $stmt->bind_param("ssss", $login, $password);
	 
		 //if the user is successfully added to the database 
		 if($stmt->execute()){
		 
		 //fetching the user back 
		 $stmt = $conn->prepare("SELECT ID, id, login FROM users WHERE login = ?"); 
		 $stmt->bind_param("s",$login);
		 $stmt->execute();
		 $stmt->bind_result($userid, $id, $login);
		 $user = $stmt->fetch();
		 
		 $stmt->close();
		 
		 //adding the user data in response 
		 returnWithInfo( $user['firstName'], $user['lastName'], $user['ID'] );
		 }
		 }
		 
		 }else{
		 $response['error'] = true; 
		 $response['message'] = 'required parameters are not available'; 
		}
	function getRequestInfo()
	{
		// Takes a JSON encoded string and converts it into a PHP variable
		// When true, JSON objects will be returned as associative arrays; 
		// when false, JSON objects will be returned as objects
		// file_get_contents reads entire file into a string
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		// used to send a raw HTTP header
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $firstName, $lastName, $id )
	{
		$retValue = '{"id":' . $id . ',"firstName":"' . $firstName . '","lastName":"' . $lastName . '","error":""}';
		sendResultInfoAsJson( $retValue );
	}
?>