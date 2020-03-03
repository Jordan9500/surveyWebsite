<?php

// read in the details of our MySQL server:
require_once "credentials.php";

// connect to the host:
$connection = mysqli_connect($dbhost, $dbuser, $dbpass);

// exit the script with a useful message if there was an error:
if (!$connection) {
	die("Connection failed: " . $mysqli_connect_error);
}
  
// build a statement to create a new database:
$sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) {
	echo "Database created successfully, or already exists<br>";
} 
else {
	die("Error creating database: " . mysqli_error($connection));
}

// connect to our database:
mysqli_select_db($connection, $dbname);

///////////////////////////////////////////
//////////// DROPPING TABLES //////////////
///////////////////////////////////////////

//////////// questionAnswer ///////////////
// if there's an old version of our table, then drop it:
$sql = "DROP TABLE IF EXISTS questionAnswer";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) {
	echo "Dropped existing table: questionAnswer<br>";
}
else {	
	die("Error checking for existing table: " . mysqli_error($connection));
}

//////////// surveyQuestion ///////////////
// if there's an old version of our table, then drop it:
$sql = "DROP TABLE IF EXISTS surveyQuestion";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) {
	echo "Dropped existing table: surveyQuestion<br>";
}
else {	
	die("Error checking for existing table: " . mysqli_error($connection));
}
////////////// USERS TABLE //////////////
// if there's an old version of our table, then drop it:
$sql = "DROP TABLE IF EXISTS users";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) {
	echo "Dropped existing table: users<br>";
}

else {	
	die("Error checking for existing table: " . mysqli_error($connection));
}

/////////////// question //////////////////
// if there's an old version of our table, then drop it:
$sql = "DROP TABLE IF EXISTS question";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) {
	echo "Dropped existing table: question<br>";
}
else {	
	die("Error checking for existing table: " . mysqli_error($connection));
}

//////////////// survey ///////////////////
// if there's an old version of our table, then drop it:
$sql = "DROP TABLE IF EXISTS survey";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) {
	echo "Dropped existing table: survey<br>";
}
else {	
	die("Error checking for existing table: " . mysqli_error($connection));
}

///////////////////////////////////////////
////////////// SURVEY TABLE ///////////////
///////////////////////////////////////////

$sql = "CREATE TABLE survey (
			surveyID INT(8),
			surveyCreator VARCHAR(16),
			surveyTitle VARCHAR(20),
			surveyDesc VARCHAR(200), 
			isOpen BOOLEAN,
			PRIMARY KEY(surveyID)
		);";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) {
	echo "Table created successfully: survey<br>";
}
else {
	die("Error creating table: " . mysqli_error($connection));
}

///////////////////////////////////////////
////////////// QUESTION TABLE /////////////
///////////////////////////////////////////
	
$sql = "CREATE TABLE question (
			questionID INT NOT NULL AUTO_INCREMENT,
			question VARCHAR(200),
			questionText VARCHAR(200),
			questionType VARCHAR(50), 
			PRIMARY KEY(questionID)
		);";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) {
	echo "Table created successfully: question<br>";
}
else {
	die("Error creating table: " . mysqli_error($connection));
}

///////////////////////////////////////////
//////// SURVEY QUESTION TABLE ////////////
///////////////////////////////////////////

$sql = "CREATE TABLE surveyQuestion (
			surveyID INT(8), 
			questionID INT(8), 
			PRIMARY KEY(surveyID, questionID),
			FOREIGN KEY (surveyID) REFERENCES survey (surveyID),
			FOREIGN KEY (questionID) REFERENCES question (questionID)	
		);";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) {
	echo "Table created successfully: surveyQuestion<br>";
}
else {
	die("Error creating table: " . mysqli_error($connection));
}

///////////////////////////////////////////
////////////// USERS TABLE //////////////
///////////////////////////////////////////

// make our table:
// notice that the username field is a PRIMARY KEY and so must be unique in each record
$sql = "CREATE TABLE users (
			username VARCHAR(16), 
			password VARCHAR(16), 
			firstName VARCHAR(32), 
			surname VARCHAR(64), 
			email VARCHAR(64), 
			DOB DATE, 
			phone VARCHAR(15),  
			PRIMARY KEY(username)
		)";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) {
	echo "Table created successfully: users<br>";
}

else {
	die("Error creating table: " . mysqli_error($connection));
}

///////////////////////////////////////////
////////////// ANSWER TABLE ///////////////
///////////////////////////////////////////

$sql = "CREATE TABLE questionAnswer (
			answerID INT NOT NULL AUTO_INCREMENT,
			surveyID INT(8),
			questionID INT(8),
			username VARCHAR(16),
			dateDone DATE,
			answerText VARCHAR(200),
			PRIMARY KEY(answerID, surveyID, questionID, username),
			FOREIGN KEY (surveyID) REFERENCES surveyQuestion (surveyID),
			FOREIGN KEY (questionID) REFERENCES surveyQuestion (questionID)
		);";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) {
	echo "Table created successfully: questionAnswer<br>";
}
else {
	die("Error creating table: " . mysqli_error($connection));
}
mysqli_close($connection);

// read in the details of our MySQL server:
require_once "credentials.php";

// connect to the host:
$connection = mysqli_connect($dbhost, $dbuser, $dbpass);

// exit the script with a useful message if there was an error:
if (!$connection) {
	die("Connection failed: " . $mysqli_connect_error);
}
// connect to our database:
mysqli_select_db($connection, $dbname);


///////////////////////////////////////////
////////////// SURVEY TABLE ///////////////
///////////////////////////////////////////

// put some data in our table:
// create an array variable for each field in the DB that we want to populate
$survey_id = 1; $survey_creator[] = 'fdawkes0'; $survey_title[] = 'Customer Survey'; $survey_desc[] = 'This is just a template'; $survey_is_open[] = true; 

// loop through the arrays above and add rows to the table:
echo "Start of survey table <br>";
for ($i=0; $i<count($survey_title); $i++) {
	// create the SQL query to be executed
    $sql = "INSERT INTO survey (surveyID, surveyCreator, surveyTitle, surveyDesc, isOpen) 
            VALUES ('$survey_id', '$survey_creator[$i]', '$survey_title[$i]', '$survey_desc[$i]', '$survey_is_open[$i]')";
	
	// run the above query '$sql' on our DB
    // no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql)) {
		echo "row inserted<br>";
	}

	else {
		die("Error inserting row: " . mysqli_error($connection));
	}
}
echo "End of survey table <br>";

///////////////////////////////////////////
//////////// QUESTION TABLE ///////////////
///////////////////////////////////////////

// create an array variable for each field in the DB that we want to populate
$question_id[] = 1; $question[] = 'How easy is it to navigate our website?'; $questionText[] = ""; $question_type[] = "slider"; 
$question_id[] = 2; $question[] = 'Were you able to find the information you were looking for on our website?'; $questionText[] = "Yes, No"; $question_type[] = "multiple";
$question_id[] = 3; $question[] = 'How much effort did you personally have to put forth to handle your request?'; $questionText[] = "A lot, Even, Minimal"; $question_type[] = "multiple";
$question_id[] = 4; $question[] = 'How did this effort compare to your expectations?'; $questionText[] = ""; $question_type[] = "paragraph";
$question_id[] = 5; $question[] = 'How responsive have we been to your questions or concerns about our products?'; $questionText[] = "Very, Usually, Not very"; $question_type[] = "multiple";
$question_id[] = 6; $question[] = 'Please state what area we need to improve on in a couple of words'; $questionText[] = ""; $question_type[] = "short";
$question_id[] = 7; $question[] = 'When did you join this website?'; $questionText[] = ""; $question_type[] = "date";

echo "Start of question table <br>";
for ($i=0; $i<count($question_id); $i++) {
	// create the SQL query to be executed
    $sql = "INSERT INTO question (questionID, question, questionText, questionType) 
            VALUES ('$question_id[$i]', '$question[$i]', '$questionText[$i]', '$question_type[$i]')";
	
	// run the above query '$sql' on our DB
    // no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql)) {
		echo "row inserted<br>";
	}

	else {
		die("Error inserting row: " . mysqli_error($connection));
	}
}
echo "End of question table <br>";
///////////////////////////////////////////
///////// surveyQuestion TABLE ////////////
///////////////////////////////////////////

echo "Start of surveyQuestion table <br>";
for ($i=0; $i<count($question_id); $i++) {
	// create the SQL query to be executed
    $sql = "INSERT INTO surveyQuestion (surveyID, questionID) 
            VALUES ('$survey_id', '$question_id[$i]')";
	
	// run the above query '$sql' on our DB
    // no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql)) {
		echo "row inserted<br>";
	}

	else {
		die("Error inserting row: " . mysqli_error($connection));
	}
}
echo "End of surveyQuestion table <br>";

///////////////////////////////////////////
////////////// USERS TABLE ////////////////
///////////////////////////////////////////
echo "Start of Users table <br>";
// put some data in our table:
// create an array variable for each field in the DB that we want to populate
$usernames[] = 'fdawkes0'; $passwords[] = 'mV19ky'; $firstName[] = 'Frasier'; $surname[] = 'Dawkes'; $emails[] = 'fdawkes0@foxnews.com'; $DOB[] = '2000-01-01'; $phone[] = '8028949677';
$usernames[] = 'jherreros1'; $passwords[] = 'tQQZFwb'; $firstName[] = 'Jens'; $surname[] = 'Herreros'; $emails[] = 'jherreros1@tripadvisor.com'; $DOB[] = '2000-01-02'; $phone[] = '6206967170';
$usernames[] = 'gmartynikhin2'; $passwords[] = 'y3j6TfxJCf'; $firstName[] = 'Ginevra'; $surname[] = 'Martynikhin'; $emails[] = 'gmartynikhin2@tumblr.com'; $DOB[] = '2000-01-03'; $phone[] = '6553340267';
$usernames[] = 'gcamerello3'; $passwords[] = 'tUmLfXtv66gm'; $firstName[] = 'Gabriele'; $surname[] = 'Camerello'; $emails[] = 'gcamerello3@alexa.com'; $DOB[] = '2000-01-04'; $phone[] = '4323834054';
$usernames[] = 'jlewsley4'; $passwords[] = 'r7vbbB'; $firstName[] = 'Joscelin'; $surname[] = 'Lewsley'; $emails[] = 'jlewsley4@behance.net'; $DOB[] = '2000-01-05'; $phone[] = '1846570634';
$usernames[] = 'admin'; $passwords[] = 'secret'; $firstName[] = 'Admin'; $surname[] = 'USER'; $emails[] = 'admin@admin.com'; $DOB[] = '2000-01-06'; $phone[] = '07777777777';


// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($usernames); $i++) {
	// create the SQL query to be executed
    $sql = "INSERT INTO users (username, password, firstName, surname, email, DOB, phone)
			VALUES ('$usernames[$i]', '$passwords[$i]', '$firstName[$i]', '$surname[$i]', '$emails[$i]', '$DOB[$i]', '$phone[$i]')";
	
	// run the above query '$sql' on our DB
    // no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql)) {
		echo "row inserted<br>";
	}

	else {
		die("Error inserting row: " . mysqli_error($connection));
	}
}
echo "End of Users table <br>";

///////////////////////////////////////////
////////////// ANSWER TABLE ///////////////
/////////////////////////////////////////// 
$answer_id = ''; 
// Seven Questions and 6 users all take the survey//

// Question 1 Answers = slider
$answer_text[] = '4'; $date_done[] = '2000-01-03'; 
$answer_text[] = '4'; $date_done[] = '2000-01-01'; 
$answer_text[] = '6'; $date_done[] = '2000-01-04'; 
$answer_text[] = '7'; $date_done[] = '2000-01-02'; 
$answer_text[] = '6'; $date_done[] = '2000-01-05';
$answer_text[] = '1'; $date_done[] = '2000-01-05';
echo "Start of Answer table <br>";
for($i=0; $i<count($answer_text); $i++) {
	// create the SQL query to be executed
	$sql = "INSERT INTO questionAnswer (answerID, surveyID, questionID, username, dateDone, answerText) 
			VALUES ('$answer_id', '$survey_id', '1', '$usernames[$i]', '$date_done[$i]', '$answer_text[$i]')";
	
	// run the above query '$sql' on our DB
	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql)) {
		echo "row inserted<br>";
	}

	else {
		die("Error inserting row: " . mysqli_error($connection));
	}
}

echo "End of Answer table <br>";
unset($answer_text);
unset($date);
// Question 2 Answers = Multiple
$answer_text[] = '0'; $date_done[] = '2000-01-03'; 
$answer_text[] = '1'; $date_done[] = '2000-01-01'; 
$answer_text[] = '1'; $date_done[] = '2000-01-04'; 
$answer_text[] = '1'; $date_done[] = '2000-01-02'; 
$answer_text[] = '1'; $date_done[] = '2000-01-05';
$answer_text[] = '0'; $date_done[] = '2000-01-05';
echo "Start of Answer table <br>";
for($i=0; $i<count($answer_text); $i++) {
	// create the SQL query to be executed
	$sql = "INSERT INTO questionAnswer (answerID, surveyID, questionID, username, dateDone, answerText) 
			VALUES ('$answer_id', '$survey_id', '2', '$usernames[$i]', '$date_done[$i]', '$answer_text[$i]')";
	
	// run the above query '$sql' on our DB
	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql)) {
		echo "row inserted<br>";
	}

	else {
		die("Error inserting row: " . mysqli_error($connection));
	}
}

echo "End of Answer table <br>";
unset($answer_text);
unset($date);
// Question 3 Answers = Multiple
$answer_text[] = '0'; $date_done[] = '2000-01-03'; 
$answer_text[] = '0'; $date_done[] = '2000-01-01'; 
$answer_text[] = '2'; $date_done[] = '2000-01-04'; 
$answer_text[] = '2'; $date_done[] = '2000-01-02'; 
$answer_text[] = '2'; $date_done[] = '2000-01-05';
$answer_text[] = '1'; $date_done[] = '2000-01-05';
echo "Start of Answer table <br>";
for($i=0; $i<count($answer_text); $i++) {
	// create the SQL query to be executed
	$sql = "INSERT INTO questionAnswer (answerID, surveyID, questionID, username, dateDone, answerText) 
			VALUES ('$answer_id', '$survey_id', '3', '$usernames[$i]', '$date_done[$i]', '$answer_text[$i]')";
	
	// run the above query '$sql' on our DB
	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql)) {
		echo "row inserted<br>";
	}

	else {
		die("Error inserting row: " . mysqli_error($connection));
	}
}

echo "End of Answer table <br>";
unset($answer_text);
unset($date);

// Question 4 Answers = paragraph
$answer_text[] = 'They didnt match at all i expected better';  $date_done[] = '2000-01-03';  
$answer_text[] = 'They were dreadful and i will be using a different software from now on';  $date_done[] = '2000-01-01'; 
$answer_text[] = 'Amazing'; $date_done[] = '2000-01-04'; 
$answer_text[] = 'Mid to high at best'; $date_done[] = '2000-01-05';
echo "Start of Answer table <br>";
for($i=0; $i<count($answer_text); $i++) {
	// create the SQL query to be executed
	$sql = "INSERT INTO questionAnswer (answerID, surveyID, questionID, username, dateDone, answerText) 
			VALUES ('$answer_id', '$survey_id', '4', '$usernames[$i]', '$date_done[$i]', '$answer_text[$i]')";
	
	// run the above query '$sql' on our DB
	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql)) {
		echo "row inserted<br>";
	}

	else {
		die("Error inserting row: " . mysqli_error($connection));
	}
}

echo "End of Answer table <br>";
unset($answer_text);
unset($date);

// Question 5 Answers = multiple
$answer_text[] = '0'; $date_done[] = '2000-01-03'; 
$answer_text[] = '0'; $date_done[] = '2000-01-01'; 
$answer_text[] = '0'; $date_done[] = '2000-01-04'; 
$answer_text[] = '1'; $date_done[] = '2000-01-02'; 
$answer_text[] = '1'; $date_done[] = '2000-01-05';
$answer_text[] = '2'; $date_done[] = '2000-01-05';
echo "Start of Answer table <br>";
for($i=0; $i<count($answer_text); $i++) {
	// create the SQL query to be executed
	$sql = "INSERT INTO questionAnswer (answerID, surveyID, questionID, username, dateDone, answerText) 
			VALUES ('$answer_id', '$survey_id', '5', '$usernames[$i]', '$date_done[$i]', '$answer_text[$i]')";
	
	// run the above query '$sql' on our DB
	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql)) {
		echo "row inserted<br>";
	}

	else {
		die("Error inserting row: " . mysqli_error($connection));
	}
}

echo "End of Answer table <br>";
unset($answer_text);
unset($date);
// Question 6 Answers = short
$answer_text[] = 'Simplify the website'; $date_done[] = '2000-01-01'; 
$answer_text[] = 'Nothing'; $date_done[] = '2000-01-04'; 
$answer_text[] = 'Your employees'; $date_done[] = '2000-01-02'; 
$answer_text[] = 'N/A'; $date_done[] = '2000-01-05';
echo "Start of Answer table <br>";
for($i=0; $i<count($answer_text); $i++) {
	// create the SQL query to be executed
	$sql = "INSERT INTO questionAnswer (answerID, surveyID, questionID, username, dateDone, answerText) 
			VALUES ('$answer_id', '$survey_id', '6', '$usernames[$i]', '$date_done[$i]', '$answer_text[$i]')";
	
	// run the above query '$sql' on our DB
	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql)) {
		echo "row inserted<br>";
	}

	else {
		die("Error inserting row: " . mysqli_error($connection));
	}
}

echo "End of Answer table <br>";
unset($answer_text);
unset($date);
// Question 7 Answers = date
$answer_text[] = '2005-03-28'; $date_done[] = '2000-01-03'; 
$answer_text[] = '2018-06-10'; $date_done[] = '2000-01-01'; 
$answer_text[] = '2019-09-25'; $date_done[] = '2000-01-04'; 
$answer_text[] = '2009-08-06'; $date_done[] = '2000-01-02'; 
$answer_text[] = '2011-02-15'; $date_done[] = '2000-01-05';
$answer_text[] = '2004-04-01'; $date_done[] = '2000-01-05';
echo "Start of Answer table <br>";
for($i=0; $i<count($answer_text); $i++) {
	// create the SQL query to be executed
	$sql = "INSERT INTO questionAnswer (answerID, surveyID, questionID, username, dateDone, answerText) 
			VALUES ('$answer_id', '$survey_id', '7', '$usernames[$i]', '$date_done[$i]', '$answer_text[$i]')";
	
	// run the above query '$sql' on our DB
	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql)) {
		echo "row inserted<br>";
	}

	else {
		die("Error inserting row: " . mysqli_error($connection));
	}
}

echo "End of Answer table <br>";
unset($answer_text);
unset($date);
mysqli_close($connection);

?>