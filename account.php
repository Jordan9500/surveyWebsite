<?php

// Things to notice:
// The main job of this script is to execute a SELECT statement to find the user's profile information (then display it)

// execute the header script:
require_once "header.php";


// checks the session variable named 'loggedInSkeleton'
// take note that of the '!' (NOT operator) that precedes the 'isset' function
if (!isset($_SESSION['loggedInSkeleton'])) {
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}

// the user must be signed-in, show them suitable page content
else {    
    // user is already logged in, read their username from the session:
	$username = $_SESSION["username"];
	
	// now read their account data from the table...
	// connect directly to our database (notice 4th argument - database name):
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	// if the connection fails, we need to know, so allow this exit:
	if (!$connection) {
		die("Connection failed: " . $mysqli_connect_error);
	}
	
	// check for a row in our profiles table with a matching username:
	$query = "SELECT * FROM users WHERE username='$username'";
	
	// this query can return data ($result is an identifier):
	$result = mysqli_query($connection, $query);
	
	// how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
	$n = mysqli_num_rows($result);
		
	// if there was a match then extract their profile data:
	if ($n > 0) {
		// use the identifier to fetch one row as an associative array (elements named after columns):
		$row = mysqli_fetch_assoc($result);
		// display their profile data:
		$email = $row['email'];
		$username = $row['username'];
		$password = $row['password'];
		$firstName = $row['firstName'];
		$surname = $row['surname'];
		$DOB = $row['DOB'];
		$phone = $row['phone'];
		echo <<<_END
			<table>
				<tr>
					<th scope = "row">
						First Name:
					</th>
					<td>
						$firstName
					</td>
				</tr>
				<tr>
					<th scope = "row">
						Surname: 
					</th>
					<td>
						$surname
					</td>
				</tr>
				<tr>
					<th scope = "row">
						Date Of Birth:
					</th>
					<td>
						$DOB
					</td>
				</tr>
				<tr>
					<th scope = "row">
						Phone Number:
					</th>
					<td>
						$phone
					</td>
				</tr>
				<tr>
					<th scope = "row">
						Username:
					</th>
					<td>
						$username
					</td>
				</tr>
				<tr>
					<th scope = "row">
						Email:
					</th>
					<td>
						$email 
					</td>
				</tr>
				<tr>
					<th scope = "row">
						Password:
					</th>
					<td>
						$password
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<a class = "btn btn-primary" href='account_set.php'>update</a>
					</td>
				</tr>
			<table>
		_END;
	}

	else {
		// no match found, prompt user to set up their profile:
		echo "You still need to set up a profile!<br>";
	}
	
	// we're finished with the database, close the connection:
	mysqli_close($connection);		
}

// finish off the HTML for this page:
require_once "footer.php";
?>