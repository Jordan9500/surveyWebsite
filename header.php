<?php

// Things to notice:
// This script is called by every other script (via require_once)
// It begins the HTML output, with the customary tags, that will produce each of the pages on the web site
// It starts the session and displays a different set of menu links depending on whether the user is logged in or not...
// ... And, if they are logged in, whether or not they are the admin
// It also reads in the credentials for our database connection from credentials.php

// database connection details:
require_once "credentials.php";

// our helper functions:
require_once "helper.php";
require_once "helper_survey.php";
// start/restart the session:
// this allows use to make use of session variables
session_start();
echo <<<_END
		<!DOCTYPE html>
		<html>
			<head>
				<title>A Survey Website</title>
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<link rel = "stylesheet" href = "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity = "sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin = "anonymous">		
				<link rel = "stylesheet" href = "main.css">
				<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			</head>
			<body>
_END;
// checks the session variable named 'loggedInSkeleton'
if (isset($_SESSION['loggedInSkeleton'])) {
	// THIS PERSON IS LOGGED IN
	// show the logged in menu options:
	echo <<<_END
		<ul class = "nav nav-tabs">
			<li class = "nav-item">
				<a class = "nav-link" href = "about.php">About</a>
			</li>
			<li class = "nav-item">
				<a class = "nav-link" href = "account.php">My Account</a>
			</li>
			<li class = "nav-item">
				<a class = "nav-link" href = "surveys_manage.php">My Surveys</a>
			</li>
			<li class = "nav-item">
				<a class = "nav-link" href = "competitors.php">Design and Analysis</a>
			</li>
			<li class = "nav-item">
				<a class = "nav-link" href = "sign_out.php">Sign Out ({$_SESSION['username']})</a>
			</li>
	_END;
	// add an extra menu option if this was the admin:
	// this allows us to display the admin tools to them only
	if ($_SESSION['username'] == "admin") {
		echo "  
			<li class = 'nav-item'>
				<a class = 'nav-link' href = 'admin.php'>Admin Tools</a>
			</li> ";
		
	}
	echo "</ul>";
}
else {
	// THIS PERSON IS NOT LOGGED IN
	// show the logged out menu options:
	echo <<<_END
		<ul class = "nav nav-tabs">
			<li class = "nav-item">
				<a class = "nav-link" href = "about.php">About</a>
			</li>
			<li class = "nav-item">
				<a class = "nav-link" href = "sign_up.php">Sign Up</a>
			</li>
			<li class = "nav-item">
				<a class = "nav-link" href = "sign_in.php">Sign In</a>
			</li>
		</ul>
	_END;
}

echo <<<_END
<br>
<h3>2CWK50: A Survey Website</h3>
_END;
?>