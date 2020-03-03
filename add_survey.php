<?php

// default values we show in the form:
$add_question = false;
$show_survey_setup = true;
$survey_question_number = 0;
$question_count = 1;
//Survey//
$survey_id = 0;
$survey_title = "";
$survey_desc = "";
$survey_title_temp = "";
$survey_desc_temp = "";
$is_open = false;

//Question//
$question_id = 0;
$question_title = "";
$question_type = "";
$question = "";

// Survey Question //
// Defined Above  //

// offered answer //
$offered_answer_id = 0;
$answer_text = "";

// Survey Question Answer //
// Defined Above  //

// Survey User //
$username = "";
$firstName = "";
$surname = "";
$email = "";

// Question Answer //
$date_done = "";
$other_text = "";

// strings to hold any validation error messages:
$survey_question_number_val = 0;
//Survey//
$survey_id_val = 0;
$survey_title_val = "";
$survey_desc_val = "";
$is_open_val = false;

//Question//
$question_id_val = 0;
$question_title_val = "";
$question_val = "";

// Survey Question //
// Defined Above  //

// offered answer //
$offered_answer_id_val = 0;
$answer_text_val = "";

// Survey Question Answer //
// Defined Above  //

// Survey User //
$username_val = "";
$firstName_val = "";
$surname_val = "";
$email_val = "";

// Question Answer //
$date_done_val = "";
$other_text_val = "";

// Other Var //
$flag = true;
$errors = "";
$questionfinish = "";
$no_questions = false;
// execute the header script:
require_once "header.php";

// checks the session variable named 'loggedInSkeleton'
// take note that of the '!' (NOT operator) that precedes the 'isset' function
if (!isset($_SESSION['loggedInSkeleton'])) {
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}
else if (isset($_POST['titleSet'])) {
	$connection = credentialsFunction();
	// SANITISATION (see helper.php for the function definition)
	// Check that the two title are the same to validate the users input
	// take copies of the credentials the user submitted, and sanitise (clean) them:
	$survey_title = sanitise($_POST['surveyTitle'], $connection);
	$survey_desc = sanitise($_POST['surveyDesc'], $connection);
	// VALIDATION 
	$survey_title_val = validateString($survey_title, 1, 20);
	$survey_desc_val = validateString($survey_desc, 1, 200);
	// concatenate all the validation results together ($errors will only be empty if ALL the data is valid):
	$errors = $survey_title_val . $survey_desc_val;
	if ($errors == "") {
		$connection = credentialsFunction();
		mysqli_select_db($connection, $dbname);

		$query = "SELECT MAX(surveyID) FROM survey;";
		$results = mysqli_query($connection, $query);
		$row = mysqli_fetch_assoc($results);
		$survey_id = $row['MAX(surveyID)'];
		$survey_id += 1;

		$sql = "INSERT INTO survey (surveyID, surveyCreator, surveyTitle, surveyDesc, isOpen) 
            	VALUES ('$survey_id', '{$_SESSION['username']}', '$survey_title', '$survey_desc', 'false')"; 
		// run the above query '$sql' on our DB
		// no data returned, we just test for true(success)/false(failure):
		if (mysqli_query($connection, $sql)) {
			echo <<<_END
				<form method = 'post'>
					<p> survey title and description successfully added <p>
					<button type = "submit" value = $survey_id name = "surveyTableInserted"> NEXT </button>
				</form>
			_END;
		}
		else {
			die("Error inserting row: " . mysqli_error($connection));
		}
	}
	else {
		header("Refresh:0");
	}
}
else if (isset($_POST["surveyTableInserted"])) {
	$connection = credentialsFunction();
	mysqli_select_db($connection, $dbname);
	$survey_id = $_POST['surveyTableInserted'];
	echo "$survey_id";
	$query = "SELECT surveyTitle, surveyDesc FROM survey WHERE surveyID = $survey_id;";
	$results = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($results);
	echo <<<_END
		<form method = 'post'>
			<div class="jumbotron">
				<h5>Survey Title: {$row['surveyTitle']}</h5> 				
				<p class="lead">Survey: {$row['surveyDesc']}</p>
				<hr class="my-4">
				<h5> Select A Question Type </h5>
				<select class="custom-select" id="inputGroupSelect01" name = "questionType" value = "$question_type">
					<option selected>Choose...</option>
					<option value="short">Short</option>
					<option value="paragraph">Paragraph</option>
					<option value="slider">Slider</option>
					<option value="multiple">Multiple</option>
					<option value="date">Date</option>
				</select>
				<hr class="my-4">
				<button type = "submit" value = $survey_id name = "questionSubmit"> Submit Question Type </button>
				<hr class="my-4">
	_END;
	$connection = credentialsFunction();
	// connect to our database:
	mysqli_select_db($connection, $dbname);

	// bring all the surveys linked to the user:
	$query = "SELECT questionID FROM surveyQuestion WHERE surveyID ='$survey_id'";
	
	// this query can return data ($result is an identifier):
	$results = mysqli_query($connection, $query);
	// how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
	$n = mysqli_num_rows($results);
	if ($n > 0) {
		for ($i = 0; $n > $i; $i++) {
			$row = mysqli_fetch_assoc($results);
			$question_ids[] = $row['questionID'];
		}
		// bring all the surveys linked to the user:
		$query = "SELECT * FROM survey WHERE surveyID = '$survey_id'";
		
		// this query can return data ($result is an identifier):
		$results = mysqli_query($connection, $query);
		for ($i=0; $i<count($question_ids); $i++) {
			// create the SQL query to be executed
			$count = $i + 1;
			$query = "SELECT * FROM question WHERE questionID ='$question_ids[$i]'";
			$results = mysqli_query($connection, $query);
			$n = mysqli_num_rows($results);
			if ($n > 0) {
				// Producing the question form with the breakdown dependent on the type
				$row = mysqli_fetch_assoc($results);
				echo <<<_END
					<h5>Question $count</h5>
					<p class="lead">{$row['question']}</p>
					<hr class="my-4">
				_END;
				$question_type = $row['questionType'];
				switch ($question_type) {
					case "short":
						echo <<<_END
							<input name = "short" value = "$answer_text" class = "form-control" type = "text" placeholder = "Enter Answer Here" maxlength = 50 readonly>
						_END;
					break;
					case "paragraph": 
						echo <<<_END
							<textarea name = "paragraph" value = "$answer_text" class = "form-control" id = "exampleFormControlTextarea1" rows = "3" maxlength = 200 placeholder = "Enter Answer Here" readonly></textarea>
						_END;
					break;
					case "slider":
						echo <<<_END
							<input name = "slider" value = "$answer_text" type = "range" class = "custom-range" min = "0" max = "10" step="1" id="customRange3" readonly>
						_END;
					break;
					case "multiple":
						$question_text = explode(',', $row['questionText']);
						echo "<select class='custom-select' id='inputGroupSelect01' name = 'multiple$i' value = '$answer_text' readonly>";
						for($j = 0; $j<count($question_text); $j++) {
						echo <<<_END
								<option value = "$j"> $question_text[$j] </option>
						_END;
						}
						echo "</select>";
					break;
					case "date":
						echo <<<_END
							<input name = "date" value = "$answer_text" type="date" readonly>
						_END;
					break;
				}
				echo "<hr class='my-4'>";
			}
		}
	}
	else {
		echo "The survey selected no longer exists";
	}
	echo <<<_END
				<hr class="my-4">
				<div class="float-left">
					<button type = "submit" value = $survey_id name = "deleted"> Delete Survey </button>
				</div>
				<div class="float-right">
					<button type = "submit" name = "completed"> Submit Survey </button>
				</div>
			</div>
		</form>
	_END;	
}
else if (isset($_POST["questionSubmit"])) {
	$survey_id = $_POST["questionSubmit"];
	echo <<<_END
		<form method = 'post'>
			<div class="jumbotron">
			<h5> Whats The Question: </h5>
			<input name = "question" value = "$question" class = "form-control" type = "text" placeholder = "Enter Survey Title Here" maxlength = 200 requried> 
			$question_val
			<hr class="my-4">

	_END;
	$question_type = $_POST["questionType"];
	switch($question_type) {
		case "short":
			echo <<<_END
				<input name = "short" value = "$answer_text" class = "form-control" type = "text" placeholder = "Enter Answer Here" maxlength = 50 readonly>
			_END;
		break;
		case "paragraph":
			echo <<<_END
				<textarea name = "paragraph" value = "$answer_text" class = "form-control" id = "exampleFormControlTextarea1" rows = "3" maxlength = 200 placeholder = "Enter Answer Here" readonly></textarea>
			_END;
		break;
		case "slider":
			echo <<<_END
				<input name = "slider" value = "$answer_text" type = "range" class = "custom-range" min = "0" max = "10" step="1" id="customRange3" readonly>
			_END;
		break;
		case "multiple":
			echo <<<_END
				<input name = "multiple" value = "$answer_text" class = "form-control" type = "text" placeholder = "Enter Multiple Options: Seperate it with comma's" maxlength = 50>
			_END;
		break;
		case "date":
			echo <<<_END
				<input name = "date" value = "$answer_text" type="date" readonly>
			_END;
		break;
	}
	echo <<<_END
				<hr class="my-4">
				<div class="float-left">
					<button type = "submit" value = $survey_id name = "surveyTableInserted"> Back </button>
				</div>
				<div class="float-right">
					<button type = "submit" value = "$survey_id-$question_type" name = "questionFinish"> Confirm </button>
				</div>
			</div>
		</form>
	_END;
}
else if (isset($_POST["questionFinish"])) {
	$connection = credentialsFunction();

	$question_finish = $_POST["questionFinish"];
	list($survey_id, $question_type) = explode('-', $question_finish);
	//Sanitisation
	$question = sanitise($_POST['question'], $connection);
	
	//Validation
	$question_val = validateString($question, 1, 200);
	
	// concatenate all the validation results together ($errors will only be empty if ALL the data is valid):
	$errors = $question_val;
	if ($errors == "") {
			
		if ($question_type == "multiple"){ 
			$answer_text = $_POST["multiple"];
		}
		else {
			$answer_text = "";
		}
		$connection = credentialsFunction();

		mysqli_select_db($connection, $dbname);

		$sql = "INSERT INTO question (questionID, question, questionText, questionType) 
				VALUES ('', '{$_POST['question']}', '$answer_text', '$question_type')"; 
		// run the above query '$sql' on our DB
		// no data returned, we just test for true(success)/false(failure):
		if (mysqli_query($connection, $sql)) {
			$query = "SELECT MAX(questionID) FROM question;";
			$results = mysqli_query($connection, $query);
			$row = mysqli_fetch_assoc($results);
			$question_id = $row['MAX(questionID)'];
			
			$sql = "INSERT INTO surveyQuestion (surveyID, questionID) 
				VALUES ('$survey_id', '$question_id')"; 
			if (mysqli_query($connection, $sql)) {
				echo <<<_END
					<form method = 'post'>
						<p> Question successfully added <p>
						<button type = "submit" value = $survey_id name = "surveyTableInserted"> NEXT </button>
					</form>
				_END;
			}
			else {
				die("Error inserting row: " . mysqli_error($connection));		
			}
		}
		else {
			die("Error inserting row: " . mysqli_error($connection));
		}
	}
	else {
		echo <<<_END
			<form method = "post">
				<p> $errors </p>
				<p> Try Again </p>
				<button type = "submit" value = "$survey_id" name = "surveyTableInserted"> Confirm </button>
			</form>
		_END;
	}
}
else if (isset($_POST["deleted"])) {
	$survey_id = $_POST["deleted"];
	$connection = credentialsFunction();
	// connect to our database:
	mysqli_select_db($connection, $dbname);

	// bring all the surveys linked to the user:
	$query = "SELECT questionID FROM surveyQuestion WHERE surveyID ='$survey_id'";
	
	// this query can return data ($result is an identifier):
	$results = mysqli_query($connection, $query);
	// how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
	if (mysqli_num_rows($results)) {
		$n = mysqli_num_rows($results);
		for ($i = 0; $n > $i; $i++) {
			$row = mysqli_fetch_assoc($results);
			$question_ids2[] = $row['questionID'];
		}
	}
	else {
		$no_questions = true;
	}
	$sql = "DELETE FROM surveyQuestion WHERE surveyID = '$survey_id'";
	if (mysqli_query($connection, $sql)) {
		// bring all the surveys linked to the user:
		$sql = "DELETE FROM survey WHERE surveyID = '$survey_id'";
		if (mysqli_query($connection, $sql)) {
			if (!$no_questions) {
				// this query can return data ($result is an identifier):
				for ($i=0; $i<count($question_ids2); $i++) {
					// create the SQL query to be executed
					$question_id = $question_ids2[$i];
					$sql = "DELETE FROM question WHERE questionID = '$question_id'";
					if (mysqli_query($connection, $sql)) {
						echo "$question_id";
					}
					else {
						die("Error Deleting row: " . mysqli_error($connection));		
					}
				}
			}
			echo "All Deleted";
		}
		else {
			die("Error Deleting row: " . mysqli_error($connection));		
		}
	}
	else {
		die("Error Deleting row: " . mysqli_error($connection));		
	}
	echo <<<_END
		<a href="surveys_manage.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Delete Survey</a>
	_END;
}
else if (isset($_POST["completed"])) {
	echo <<<_END
		<a href="surveys_manage.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Add Survey</a>
	_END;
}
else {
	$flag = false;
	echo "<h5>Add Survey Page</h5>";
	echo <<<_END
		<form method = 'post'>
			<div class="jumbotron">
				<h5>Survey Title</h5> 				
				<input name = "surveyTitle" value = "$survey_title" class = "form-control" type = "text" placeholder = "Enter Survey Title Here" maxlength = 20 requried> 
				$survey_title_val
				<p class="lead">Survey Description</p>
				<input name = "surveyDesc" value = "$survey_desc" class = "form-control" type = "text" placeholder = "Enter Survey Description Here" maxlength = 200>
				$survey_desc_val
				<hr class="my-4">
				<button type = "submit" name = "titleSet"> Submit Title & Description </button>
			</div>
		</form>
	_END;

}
// finish off the HTML for this page:
require_once "footer.php";

?>