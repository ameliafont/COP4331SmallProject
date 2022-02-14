const urlBase = 'http://COP4331-24.xyz';
const extension = '.php';

var userId = 0;
var firstName = "";
var lastName = "";
var searchPlaceholder = "";

function doLogin()
{
	userId = 0;
	firstName = "";
	lastName = "";
	
	let login = document.getElementById("loginName").value;
	let password = document.getElementById("loginPassword").value;
//	var hash = md5( password );
	
	document.getElementById("loginResult").innerHTML = "";

	let tmp = {Login:login,Password:password};
//	var tmp = {login:login,password:hash};
	let jsonPayload = JSON.stringify( tmp );
	
	let url = urlBase + '/LAMPAPI/Login' + extension;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				let jsonObject = JSON.parse( xhr.responseText );
				userId = jsonObject.id;

				if( userId < 1 )
				{		
					document.getElementById("loginResult").innerHTML = "User/Password combination incorrect";
					return;
				}
		
				firstName = jsonObject.firstName;
				lastName = jsonObject.lastName;

				saveCookie();
	
				window.location.href = "contacts.html";
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("loginResult").innerHTML = err.message;
	}
	

}

function saveCookie()
{
	let minutes = 20;
	let date = new Date();
	date.setTime(date.getTime()+(minutes*60*1000));	
	document.cookie = "firstName=" + firstName + ",lastName=" + lastName + ",userId=" + userId + ";expires=" + date.toGMTString();
}

function readCookie()
{
	userId = -1;
	let data = document.cookie;
	let splits = data.split(",");
	for(var i = 0; i < splits.length; i++) 
	{
		let thisOne = splits[i].trim();
		let tokens = thisOne.split("=");
		if( tokens[0] == "firstName" )
		{
			firstName = tokens[1];
		}
		else if( tokens[0] == "lastName" )
		{
			lastName = tokens[1];
		}
		else if( tokens[0] == "userId" )
		{
			userId = parseInt( tokens[1].trim() );
		}
	}
	
	if( userId < 0 )
	{
		window.location.href = "contacts.html";
	}
	else
	{
		document.getElementById("userName").innerHTML = "Welcome, " + firstName + ".";
	}
}

function doLogout()
{
	userId = 0;
	firstName = "";
	lastName = "";
	document.cookie = "firstName= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	window.location.href = "index.html";
}

function doRegister(){
	userId = 0;
	firstName = "";
	lastName = "";

	let login = document.getElementById('newUsername').value;
	let password = document.getElementById('newPassword').value;
	let firstN = document.getElementById('newFirstName').value;
	let lastN = document.getElementById('newLastName').value;

	if(login == '' || password == '' || firstN == '' || lastN == ''){
		document.getElementById("registerResult").innerHTML = "One or More Fields are Empty";
		if(firstN == ''){
				document.getElementById("errorFirst").innerHTML = "First Name Required";
		}
		if(lastN == ''){
			document.getElementById("errorLast").innerHTML = "Last Name Required";
		}
		if(login == ''){
			document.getElementById("errorUser").innerHTML = "Username Required";
		}
		if(password == ''){
			document.getElementById("errorPass").innerHTML = "Password Required";
		}
	}
	else{
		let tmp = {Login:login,Password:password,FirstName:firstN,LastName:lastN};
		let jsonPayload = JSON.stringify( tmp );
		
		let url = urlBase + '/LAMPAPI/Register' + extension;

		let xhr = new XMLHttpRequest();
		xhr.open("POST", url, true);
		xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

		try
		{
			xhr.onreadystatechange = function() 
			{
				if (this.readyState == 4 && this.status == 200) 
				{
					document.getElementById("registerResult").innerHTML = "Successfully Registered!";

					let jsonObject = JSON.parse( xhr.responseText );
					
					userId = jsonObject.id;

					firstName = jsonObject.FirstName;
					lastName = jsonObject.LastName;

					saveCookie();
		
					window.location.href = "index.html";
				}
			};
			xhr.send(jsonPayload);
		}
		catch(err)
		{
			document.getElementById("registerResult").innerHTML = err.message;
		}
	}

}

function addContact()
{
	
		console.log("works");

		var fname = document.getElementById('contactFirstName').value;
   	var lname = document.getElementById('contactLastName').value;
   	var email = document.getElementById('contactEmail').value;
   	var phone = document.getElementById('contactPhone').value;
   	document.getElementById('addContactResult').innerHTML = "";

   	if(fname == '' && lname == '' && email == '' && phone == ''){
			document.getElementById("addContactResult").innerHTML = "Please Fill One or More Fields";
		}
		else{
	   	let tmp = {UserID:userId,FirstName:fname,LastName:lname,EMail:email,Phone:phone};
			let jsonPayload = JSON.stringify( tmp );

			let url = urlBase + '/LAMPAPI/AddContact' + extension;

			let xhr = new XMLHttpRequest();
			xhr.open("POST", url, true);
			xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	   	//var payload = '{"FirstName" : "' + fname + '", "LastName" : "' + lname + '", "Phone" : "' + phone + '", "EMail" : "' + email + '"}';

	   	/*var xhr = new XMLHttpRequest();
	   	xhr.open("POST", baseURL + "/LAMPAPI/CreateContact.php", true);
	   	xhr.setRequestHeader("Content-type", "application/json; charset = UTF-8");*/

	   	
	   	try {
	   		xhr.onreadystatechange = function(){
	   			if (xhr.readyState === 4){


	   				document.getElementById('addContactResult').innerHTML = "Successfully Added!";

	  			 	document.getElementById('contactFirstName').value = '';
	  			 	document.getElementById('contactLastName').value = '';
	  			 	document.getElementById('contactEmail').value = '';
	  			 	document.getElementById('contactPhone').value = '';
	  				clearfields();
	   			}
	   		};
	      	xhr.send(jsonPayload);
	   	}
	   	catch(err) {
	      	document.getElementById('addContactResult').innerHTML = err.message;
	   	}
	  }
}

function clearfields()
{
	document.getElementById('contactFirstName').value = '';
	document.getElementById('contactLastName').value = '';
	document.getElementById('contactEmail').value = '';
	document.getElementById('contactPhone').value = '';

}

function init()
{
	var srch = document.getElementById('searchText').value;

	document.getElementById('contactSearchResult').innerHTML = "";
	
	let contactList = "";

	let tmp = {UserID:userId,Search:srch};
	let jsonPayload = JSON.stringify(tmp);

	let url = urlBase + '/LAMPAPI/SearchContacts' + extension;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				document.getElementById("contactSearchResult").innerHTML = "Contacts Retrieved:";
				let jsonObject = JSON.parse( xhr.responseText );
				
				for( let i=0; i<5; i++ )
				{

					if(jsonObject.results[i] != ""){
						document.getElementById(i).innerHTML += jsonObject.results[i];
					}
					else{
						document.getElementById(i).innerHTML += "Empty";
					}
					

					if( i < jsonObject.results.length - 1 )
					{
						contactList += "<br />\r\n";
					}
				}
				
				document.getElementsByTagName("p")[0].innerHTML = contactList;
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("contactSearchResult").innerHTML = err.message;
	}
	
}

// Function to search for a contact
function searchContact()
{
	var srch = document.getElementById('searchText').value;

	document.getElementById('contactSearchResult').innerHTML = "";
	
	let contactList = "";

	let tmp = {UserID:userId,Search:srch};
	let jsonPayload = JSON.stringify(tmp);

	let url = urlBase + '/LAMPAPI/SearchContacts' + extension;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				document.getElementById("contactSearchResult").innerHTML = "Contacts Retrieved:";
				let jsonObject = JSON.parse( xhr.responseText );
				
				for( let i=0; i<jsonObject.results.length; i++ )
				{
					contactList += jsonObject.results[i];
					if( i < jsonObject.results.length - 1 )
					{
						contactList += "<br />\r\n";
					}
				}
				
				document.getElementsByTagName("p")[0].innerHTML = contactList;
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("contactSearchResult").innerHTML = err.message;
	}
	
}

// Function to delete a contact
function deleteContact()
{
		let dFirst = document.getElementById("deleteFirst").value;
		let dLast = document.getElementById("deleteLast").value;
		let dEmail = document.getElementById("deleteEmail").value;
		let dPhone = document.getElementById("deletePhone").value;

    document.getElementById("contactDeleteResult").innerHTML = "";

    let tmp = {UserID:userId,FirstName:dFirst,LastName:dLast,EMail:dEmail,Phone:dPhone};
		let jsonPayload = JSON.stringify( tmp );

		let url = urlBase + '/LAMPAPI/Delete' + extension;

		let xhr = new XMLHttpRequest();
		xhr.open("DELETE", url, true);
		xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

   	try
    {
      xhr.onreadystatechange = function()
      {
        if(this.readyState == 4 && this.status == 200)
        {
        	document.getElementById('deleteFirst').value = '';
  			 	document.getElementById('deleteLast').value = '';
  			 	document.getElementById('deleteEmail').value = '';
  			 	document.getElementById('deletePhone').value = '';

          document.getElementById("contactDeleteResult").innerHTML = "Contact has been deleted";
        }
      };
      xhr.send(jsonPayload);
    }
    catch (err)
    {
      document.getElementById("contactDeleteResult").innerHTML = err.message;
    }
}

// Function to edit a contact
function editContact()
{
	console.log("test");

	var oldFirst = document.getElementById("firstOld").value;
	var oldLast = document.getElementById("lastOld").value;
	var oldEmail = document.getElementById("emailOld").value;
	var oldPhone = document.getElementById("phoneOld").value;

	var newFirst = document.getElementById("firstNew").value;
	var newLast = document.getElementById("lastNew").value;
	var newEmail = document.getElementById("emailNew").value;
	var newPhone = document.getElementById("phoneNew").value;

  document.getElementById("contactEditResult").innerHTML = "";

  let tmp = {UserID:userId,OldFirstName:oldFirst,OldLastName:oldLast,OldEMail:oldEmail,OldPhone:oldPhone,FirstName:newFirst,LastName:newLast,EMail:newEmail,Phone:newPhone};
	let jsonPayload = JSON.stringify( tmp );

	let url = urlBase + '/LAMPAPI/EditContact' + extension;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	console.log("test");

  try
  {
    xhr.onreadystatechange = function()
    {
      if (this.readyState == 4 && this.status == 200)
      {
      	document.getElementById("firstOld").value = "";
				document.getElementById("lastOld").value = "";
				document.getElementById("emailOld").value = "";
				document.getElementById("phoneOld").value = "";

				document.getElementById("firstNew").value = "";
				document.getElementById("lastNew").value = "";
				document.getElementById("emailNew").value = "";
				document.getElementById("phoneNew").value = "";

        document.getElementById("contactEditResult").innerHTML = "Contact Successfully Edited!";
      }
    };
    xhr.send(jsonPayload);
  }
  catch (err)
  {
    document.getElementById("contactEditResult").innerHTML = err.message;
  }
}
