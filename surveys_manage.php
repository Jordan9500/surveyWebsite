<?php

// Things to notice:
// This is the page where each user can MANAGE their surveys
// As a suggestion, you may wish to consider using this page to LIST the surveys they have created
// Listing the available surveys for each user will probably involve accessing the contents of another TABLE in your database
// Give users options such as to CREATE a new survey, EDIT a survey, ANALYSE a survey, or DELETE a survey, might be a nice idea
// You will probably want to make some additional PHP scripts that let your users CREATE and EDIT surveys and the questions they contain
// REMEMBER: Your admin will want a slightly different view of this page so they can MANAGE all of the users' surveys

// default values we show in the form:
$add_question = false;
$show_survey_setup = true;
$survey_question_number = 0;
$question_count = 1;
//Survey//
$survey_id = 0;
$survey_creator = "";
$survey_title = "";
$survey_desc = "";
$is_open = false;

//Question//
$question_id = "";
$question_title = "";
$question_type = "";
$question = "";

// Survey Question //
// Defined Above  //

// Survey Question Answer //
// Defined Above  //

// Survey User //
$username = "";
$firstName = "";
$surname = "";
$email = "";

// Question Answer //
$date_done = "";
$answer_text = "";
$answer_number = 0;

// strings to hold any validation error messages:
$survey_question_number_val = 0;
//Survey//
$survey_id_val = 0;
$survey_creator_val = "";
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

// OTHER //
$upload_questions = true;

// execute the header script:
require_once "header.php";

// checks the session variable named 'loggedInSkeleton'
// take note that of the '!' (NOT operator) that precedes the 'isset' function
if (!isset($_SESSION['loggedInSkeleton'])) {
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}
//Submit all the questions answered in the preview section
else if (isset($_POST["submit_Questions"])) {
	$survey_id = $_POST["submit_Questions"];
	$username = $_SESSION["username"];	

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
			$question_id_submit[] = $row['questionID'];
		}
		for ($i=0; $i<count($question_id_submit); $i++) {
			// create the SQL query to be executed
			$query = "SELECT * FROM question WHERE questionID ='$question_id_submit[$i]'";
			$results = mysqli_query($connection, $query);
			$n = mysqli_num_rows($results);
			if ($n > 0) {
				// breakdown the form dependent on the type and submit it 
				$row = mysqli_fetch_assoc($results);
				$question_type = $row['questionType'];
				switch ($question_type) {
					case "short": 
						$answer_text = $_POST["short$i"];
						if ($answer_text == "") {
							$upload_questions = false;
						}
						else {
							$upload_questions = true;
						}
					break;
					case "paragraph": 
						$answer_text = $_POST["paragraph$i"];
						if ($answer_text == "") {
							$upload_questions = false;
						}
						else {
							$upload_questions = true;
						}
					break;
					case "slider": 
						$answer_text = $_POST["slider$i"];
						if ($answer_text == "") {
							$upload_questions = false;
						}
						else {
							$upload_questions = true;
						}
					break;
					case "multiple": 
						$answer_text = $_POST["multiple$i"];
						if ($answer_text == "") {
							$upload_questions = false;
						}
						else {
							$upload_questions = true;
						}
					break;
					case "date":
						$answer_text = $_POST["date$i"];
						if ($answer_text == "") {
							$upload_questions = false;
						}
						else {
							$upload_questions = true;
						}
					break;
				}
				if ($upload_questions) {
					// create the SQL query to be executed
					$sql = "INSERT INTO questionAnswer (answerID, surveyID, questionID, username, dateDone, answerText) 
					VALUES ('', '$survey_id', '$question_id_submit[$i]', '$username', '', '$answer_text')";
					// run the above query '$sql' on our DB
					// no data returned, we just test for true(success)/false(failure):
					if (mysqli_query($connection, $sql)) {
						header("Refresh:0");
					}
					else {
						die("Error inserting row: " . mysqli_error($connection));
					}
				}
			}
		}
	}
}
//Changes the survey selected from closed to open or the other way round
else if (isset($_POST["is_open"])) {
	$survey_id = $_POST["is_open"];
	$connection = credentialsFunction();
	mysqli_select_db($connection, $dbname);
	// bring all the surveys linked to the user:
	$query = "SELECT isOpen FROM survey WHERE surveyID = '$survey_id'";
	// this query can return data ($result is an identifier):
	$results = mysqli_query($connection, $query);
	// how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
	$n = mysqli_num_rows($results);
	if ($n > 0) {
		$row = mysqli_fetch_assoc($results);
		$is_open = $row['isOpen'];
		if ($is_open == 1) {
			$is_open = 0;
		}
		else {
			$is_open = 1;
		}
		$sql = "UPDATE survey SET isOpen = $is_open WHERE surveyID = $survey_id";
		if (mysqli_query($connection, $sql)) {
			header("Refresh:0");
		}
		else {
			die("Error Updating row: " . mysqli_error($connection));		
		}
	}	
	else {
		echo "Survey no longer exists...";
	}
}
//Displays the questions and allows the user to answer them section
else if (isset($_POST["Preview"])) {
	$survey_id = $_POST["Preview"];	
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
			$question_id_preview[] = $row['questionID'];
		}
		// bring all the surveys to the user:
		$query = "SELECT * FROM survey WHERE surveyID = '$survey_id'";
		
		// this query can return data ($result is an identifier):
		$results = mysqli_query($connection, $query);
		
		// how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
		$n = mysqli_num_rows($results);
		if ($n > 0) {
			$row = mysqli_fetch_assoc($results);
			echo <<<_END
				<h4>{$row['surveyTitle']}</h4>
				<h5>{$row['surveyDesc']}</h5>
			_END;
		}
		echo "<form method = 'post'>";
		for ($i=0; $i<count($question_id_preview); $i++) {
			// create the SQL query to be executed
			$query = "SELECT * FROM question WHERE questionID ='$question_id_preview[$i]'";
			$results = mysqli_query($connection, $query);
			$n = mysqli_num_rows($results);
			if ($n > 0) {
				// Producing the question form with the breakdown dependent on the type
				$row = mysqli_fetch_assoc($results);
				echo <<<_END
					<div class="jumbotron">
						<h5>Question</h5>
						<p class="lead">{$row['question']}</p>
						<hr class="my-4">
				_END;
				$question_type = $row['questionType'];
				switch ($question_type) {
					case "short":
						echo <<<_END
							<input name = "short$i" value = "$answer_text" class = "form-control" type = "text" placeholder = "Enter Answer Here" maxlength = 50>
						_END;
					break;
					case "paragraph": 
						echo <<<_END
							<textarea name = "paragraph$i" value = "$answer_text" class = "form-control" id = "exampleFormControlTextarea1" rows = "3" maxlength = 200 placeholder = "Enter Answer Here" value = "$answer_text".$i></textarea>
						_END;
					break;
					case "slider":
						echo <<<_END
							<input name = "slider$i" value = "$answer_text" type = "range" class = "custom-range" min = "0" max = "10" step="1" id="customRange3">
						_END;
					break;
					case "multiple":
						$question_text = explode(',', $row['questionText']);
						echo "<select class='custom-select' id='inputGroupSelect01' name = 'multiple$i' value = '$answer_text' >";
						for($j = 0; $j<count($question_text); $j++) {
						echo <<<_END
								<option value = "$j"> $question_text[$j] </option>
						_END;
						}
						echo "</select>";
					break;
					case "date":
						echo <<<_END
							<input name = "date$i" value = "$answer_text" type="date">
						_END;
					break;
				}
				echo "</div>";
			}
		}
		echo  <<<_END
				<button type = "submit" name = "submit_Questions" value = "$survey_id"> Submit </button>
			</form>
		_END;
	}
	else {
		echo "The survey selected no longer exists";
	}
}
//Displays the Management section
else if (isset($_POST["Manage"])){
	$survey_id = $_POST["Manage"];
	$connection = credentialsFunction();
	mysqli_select_db($connection, $dbname);
	echo <<<_END
		<form method = 'post'>
			<div>
				<button type = "submit" class = 'btn btn-danger' value = $survey_id name = "deleted"> Delete Survey </button>
			</div>

		</form>
	_END;
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
	$n = mysqli_num_rows($results);
	if ($n > 0) {
		for ($i = 0; $n > $i; $i++) {
			$row = mysqli_fetch_assoc($results);
			$question_ids[] = $row['questionID'];
		}
	}
	$sql = "DELETE FROM questionAnswer WHERE surveyID = '$survey_id'";
	if (mysqli_query($connection, $sql)) {
		$sql = "DELETE FROM surveyQuestion WHERE surveyID = '$survey_id'";
		if (mysqli_query($connection, $sql)) {
			// bring all the surveys linked to the user:
			$sql = "DELETE FROM survey WHERE surveyID = '$survey_id'";
			if (mysqli_query($connection, $sql)) {
				// this query can return data ($result is an identifier):
				for ($i=0; $i<count($question_ids); $i++) {
					// create the SQL query to be executed
					$question_id = $question_ids[$i];
					$sql = "DELETE FROM question WHERE questionID = '$question_id'";
					if (mysqli_query($connection, $sql)) {
						header("Refresh:0");
					}
					else {
						die("Error Deleting row: " . mysqli_error($connection));		
					}
				}
				header("Refresh:0");
			}
			else {
				die("Error Deleting row: " . mysqli_error($connection));		
			}
		}
		else {
			die("Error Deleting row: " . mysqli_error($connection));		
		}
	}
}
//Displays the responses section 
else if (isset($_POST["Responses"])){
	$connection = credentialsFunction();
	mysqli_select_db($connection, $dbname);
	$survey_id = $_POST["Responses"];

	//Calculate the amount of questions in the survey
	$query = "SELECT COUNT(questionID) FROM surveyquestion WHERE surveyID = '$survey_id'";
	$results = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($results);
	$question_count = $row['COUNT(questionID)'];

	//Calculate the amount of responses to the entire survey
	$query = "SELECT COUNT(username) FROM questionanswer WHERE surveyID = '$survey_id'";
	$results = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($results);
	$survey_total_responses = $row['COUNT(username)'];

	//Calculate the amount of responses to the entire survey
	echo <<<_END
		<h5><u>Number of responses: </u></h5>
		<table class="table table-hover">
			<thead class = "thead-dark">
				<tr>
					<th scope = "col">
						#
					</th>
					<th scope = "col">
						Question
					</th>
					<th scope = "col">
						Number of Responses
					</th>
				</tr>
			</thead>
	_END;
	$question_count = 0;
	$query = "SELECT questionID FROM surveyQuestion WHERE surveyID ='$survey_id'";
	// this query can return data ($result is an identifier):
	$results = mysqli_query($connection, $query);
	// how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
	$n = mysqli_num_rows($results);
	if ($n > 0) {
		for ($i = 0; $n > $i; $i++) {
			$row = mysqli_fetch_assoc($results);
			$question_id_array[] = $row['questionID'];
		}
		for ($i = 0; $i < count($question_id_array); $i++) {
			// Selects the total responses using the question ID
			$query = "SELECT COUNT(questionID) FROM questionanswer WHERE questionID = '$question_id_array[$i]'";
			$results = mysqli_query($connection, $query);
			$row = mysqli_fetch_assoc($results);
			$question_responses = $row['COUNT(questionID)'];

			// Selects the type and any text using the questionID
			$query = "SELECT question, questionType, questionText FROM question WHERE questionID = '$question_id_array[$i]'";
			$results = mysqli_query($connection, $query);
			$row = mysqli_fetch_assoc($results);
			$question_type_array[] = $row['questionType'];
			$question_text_array[] = $row['questionText'];
			$question_array[] = $row['question'];
			$question_count += 1;
			echo <<<_END
				<tr>
					<th scope="row">
						$question_count
					</th>
					<td>
						$question_array[$i]
					</td>
					<td>
						$question_responses
					</td>
				</tr>
			_END;
		}
		echo <<<_END
				<tr>
					<td>
					</td>
					<th scope="row">
						Total Responses
					</th>
					<td>
						$survey_total_responses
					</td>
				</tr>
			</table>
		_END;
		$query = "SELECT questionID, answerText FROM questionanswer WHERE surveyID = '$survey_id'";
		$results = mysqli_query($connection, $query);
		$n = mysqli_num_rows($results);
		if ($n > 0) {		
			for ($i = 0; $n > $i; $i++) {
				$row = mysqli_fetch_assoc($results);
				$question_id_answer_array[] = $row['questionID'];
				$answer_text_array[] = $row['answerText'];
			}
			echo <<<_END
					<h5><u>Question responses: </u></h5>
					<table class="table table-hover">
						<thead class = "thead-dark">
							<tr>
								<th scope = "col">
									#
								</th>
								<th scope = "col">
									Question
								</th>
								<th scope = "col">
									Responses
								</th>
							</tr>
						</thead>

				_END;
			$question_count = 0;
			for ($i = 0; count($question_array) > $i; $i++) {
				$question_count = $i + 1;
				if ($question_count <= count($question_id_array)) {
					echo <<<_END
						<tr>
							<td>
								$question_count
							</td>
							<td>
								$question_array[$i]
							</td>
							<td>
					_END;
					for ($j = 0; count($question_id_answer_array) > $j; $j++) {
						$answer_text = $answer_text_array[$j];
						if ($question_id_array[$i] == $question_id_answer_array[$j]) {
							if ($question_type_array[$i] == "multiple") {
								$question_text = explode(',' ,$question_text_array[$i]);
								echo "$question_text[$answer_text] <br>";
							}
							else {
								echo "$answer_text <br>";
							}
						}
					}
					echo "</td> </tr>";
				}
			}
			echo "</table>";
			//Summary Table That Can Output Charts
			unset($answer_text_array);
			unset($question_id_array);
			$query_1 = "SELECT surveyID, questionID, COUNT(answerText)'COUNT', answerText
						FROM questionanswer
						WHERE surveyID = $survey_id
						GROUP BY questionID, answerText";

			$query_2 = "SELECT qa.surveyID'sID', qa.questionID'qID', COUNT(*)'IGNORE', q.question, q.questionType
						FROM questionanswer qa
						INNER JOIN surveyquestion
						USING(surveyID)
						INNER JOIN question q
						ON q.questionID = qa.questionID
						WHERE surveyID = $survey_id
						GROUP BY qa.questionID, answerText";

			$results_1 = mysqli_query($connection, $query_1);
			$results_2 = mysqli_query($connection, $query_2);

			$n_1 = mysqli_num_rows($results_1);
			$n_2 = mysqli_num_rows($results_2);

			if (($n_1 > 0) || ($n_2 > 0)) {
				for ($i = 0; $n_1 > $i; $i++) {
					$row_1 = mysqli_fetch_assoc($results_1);
					$row_2 = mysqli_fetch_assoc($results_2);
					$question_type = $row_2['questionType'];
					if ($question_type == "slider" || $question_type == "multiple") {
						$question_id_array[] = $row_2['qID'];
						$answer_text_array[] = $row_1['answerText'];
						$count_array[] = $row_1['COUNT'];
					}	
				}
				////////////////////
				//SLIDER PIE CHART//
				////////////////////
				$query = "SELECT DISTINCT qa.questionID, q.question, q.questionType, q.questionText
						FROM questionanswer qa
						INNER JOIN surveyquestion
						USING(surveyID)
						INNER JOIN question q
						ON q.questionID = qa.questionID
						WHERE surveyID = $survey_id
						GROUP BY q.question";
				$results = mysqli_query($connection, $query);
				$n = mysqli_num_rows($results);
				if ($n > 0) {
					echo "<h5><u>Summary And Charts:</u></h5>";
					for($i = 0; $i < $n; $i ++) {
						$row = mysqli_fetch_assoc($results);
						if ($row['questionType'] == 'slider' || $row['questionType'] == 'multiple') {
							$question_id = $row['questionID'];
							echo $question_id;
							$question = $row['question'];
							echo <<<_END
								<table class="table table-hover">
									<thead class = "thead-dark">
										<tr>
											<th scope = "col">
												#
											</th>
											<th scope = "col">
												Question
											</th>
											<th scope = "col">
												Summary
											</th>
										</tr>
									</thead>
									<tr>
										<td>
											$question_id
										</td>
										<td>
											$question
										</td>
										<td>
								_END;
							///////////////////////////////////////////////
							// SUMMARY OF THE SLIDER AND MULTIPLE CHOICE //
							///////////////////////////////////////////////
							for ($j = 0; $j < count($question_id_array); $j++) {
								if ($question_id == $question_id_array[$j]) {
									echo "$count_array[$j] ";
									if ($count_array[$j] > 1) {
										echo "user's";
									}
									else {
										echo "user";
									}
									if ($row['questionType'] == 'multiple') {
										$answer_text = $answer_text_array[$j];
										$question_text = explode(',' , $row['questionText']);
										echo " answered $question_text[$answer_text], <br>";
									}
									else {
										echo " answered $answer_text_array[$j], <br>";
									}
								}
							}
							echo <<<_END
										</td>
									<tr>
								</table>
								<br>
							_END;

							echo <<<_END
								<script type="text/javascript">
							
								// Load the Visualization API and the corechart package - notice the 'controls' portion added
								google.charts.load('current', {'packages':['corechart', 'controls']});
							
								// Set a callback to run when the Google Visualization API is loaded.
								google.charts.setOnLoadCallback(drawChart);
							
								// Callback that creates and populates a data table,
								// instantiates the pie chart, passes in the data and
								// draws it.
								function drawChart() {
									// Create the data table.
									var data = new google.visualization.DataTable();
									data.addColumn('string', 'Answer');
									data.addColumn('number', 'Number of responses');
									data.addRows([                     
							_END;

							for ($j = 0; $j < count($question_id_array); $j++) {
								if ($question_id == $question_id_array[$j]) {
									if ($row['questionType'] == 'multiple') {
										$answer_text = $answer_text_array[$j]; 
										echo "['$question_text[$answer_text]', $count_array[$j]],";
									}
									else {
										echo "['$answer_text_array[$j]', $count_array[$j]],";
									}
								}
							}
							
							echo "]);";
							if ($row['questionType'] == 'multiple') {
								echo <<<_END
									// Set chart options
									var options = {'title':'Responses',
												'width':600,
												'height':300,
												legend: {position: "left"},
												};
												
									// Instantiate and draw our chart, passing in some options.
									// this creates the normal bar chart
									var chart = new google.visualization.BarChart(document.getElementById('chart_div$i'));
									chart.draw(data, options);
								_END;
							}
							else {
								echo <<<_END
									//////////////////////////////
									// CREATION OF THE PIE CHART
									//////////////////////////////
									
									// Create a dashboard.
										var dashboard = new google.visualization.Dashboard(
										document.getElementById('dashboard_div$i'));
								
									// Create a range slider, passing some options
										var slider = new google.visualization.ControlWrapper({
											'controlType': 'NumberRangeFilter',
											'containerId': 'filter_div$i',
											'options': {
											'filterColumnLabel': 'Number of responses'
											}
										});
									
									// set pie chart options
									var pieChart = new google.visualization.ChartWrapper({
										'chartType': 'PieChart',
										'containerId': 'pie_div$i',
										'options': {
											'title':'Responses',
											'width': 600,
											'height': 300,
											'pieSliceText': 'value',
											'legend': 'right'
										}
									}); 
									
									// Establish dependencies, declaring that 'filter' drives 'pieChart',
									// so that the pie chart will only display entries that are let through
									// given the chosen slider range.
									dashboard.bind(slider, pieChart);
									dashboard.draw(data);
								_END;
							}
							echo <<<_END
										}
									</script>
								</head>
								<body>
									<table bgcolor='#ffffff' cellspacing='0' cellpadding='2'>
										<tr>
											<!--Divs that will hold the bar charts-->
											<td>
												<div id="chart_div$i"></div>
											</td>
											<!-- divs to hodl the pie chart -->
											<td>
												<div id="dashboard_div$i">
												<div id="filter_div$i"></div>
												<div id="pie_div$i"></div>
												</div>
											</td>
										</tr>
									</table>
							_END;
						}
					}
				}
			}
		}
	}
}
// Displays all the available surveys and allows the user to preview open surveys and manage their own
else {
	echo <<<_END
	<p>Use this space to allow your users to create and manage their surveys<br>
	At present, there are no surveys to display</p>
	<a href="add_survey.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Add Survey</a>
	<br>
	<br>
	_END;
	
	$connection = credentialsFunction();
	mysqli_select_db($connection, $dbname);
	// bring all the surveys linked to the user:
	$query = "SELECT * FROM survey WHERE surveyCreator = '{$_SESSION['username']}'";
	// this query can return data ($result is an identifier):
	$results = mysqli_query($connection, $query);
	// how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
	$n = mysqli_num_rows($results);

	echo "<h5> View Your Surveys </h5>";
	if ($n > 0) {
		echo  <<<_END
			<form method="post">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th scope = "col">
									Creator
								</th>
								<th scope = "col">
									Title
								</th>
								<th scope = "col">
									Description
								</th>
								<th scope = "col">
									Is It Public?
								</th>
								<th scope = "col">
									Take the survey
								</th>
								<th scope = "col">
									Manage
								</th>
								<th scope = "col">
									Responses
								</th>
							</tr>
						</thead>
		_END;
		for ($i = 0; $n > $i; $i++) {
			$row = mysqli_fetch_assoc($results);
			$survey_id = $row['surveyID'];
			$survey_creator = $row['surveyCreator'];
			$survey_title = $row['surveyTitle'];
			$survey_desc = $row['surveyDesc'];
			$is_open = $row['isOpen'];
			echo <<<_END
				<tr>
					<td>
						$survey_creator
					</td>
					<td>
						$survey_title
					</td>
					<td>
						$survey_desc
					</td>
					<td>
					<form method = "post">
			_END;
			if ($is_open == 1) {
				echo "<button type='submit' name = 'is_open' value = '$survey_id' class='btn btn-success'>Public</button>";
			}
			else {
				echo "<button type='submit' name = 'is_open' value = '$survey_id' class='btn btn-danger'>Closed</button>";
			}
			echo <<<_END
					</form>
					</td>
					<td>
						<button type = "submit" class="btn btn-primary" name = "Preview" value = "$survey_id"> Preview </button>
					</td>
					<td>
						<button type = "submit" class="btn btn-primary" name = "Manage" value = "$survey_id"> Manage </button>
					</td>
					<td>
						<button type = "submit" class="btn btn-primary" name = "Responses" value = "$survey_id"> Responses </button>
					</td>
				</tr>
			_END;
		}
		echo"</table> </div>";
	}
	else {
		echo "you have not created a survey...";
	}

	$connection = credentialsFunction();
	mysqli_select_db($connection, $dbname);
	$usernameSurvey = $_SESSION['username'];
	if ($_SESSION['username'] == "admin") {
		echo "<h5><em>ADMIN CAN MANAGE AND VIEW ALL SURVEYS</em></h5>";
		$query = "SELECT * FROM survey WHERE surveyCreator != '$usernameSurvey'";
	}
	else {
		// bring all the surveys linked to the user:
		$query = "SELECT * FROM survey WHERE surveyCreator != '$usernameSurvey' AND isOpen = 1";
	}
	// this query can return data ($result is an identifier):
	$results = mysqli_query($connection, $query);
	// how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
	$n = mysqli_num_rows($results);
	
	echo "<h5> View Public Surveys </h5>";
	if ($n > 0) {
		echo  <<<_END
			<form method="post">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th scope = "col">
									Creator
								</th>
								<th scope = "col">
									Title
								</th>
								<th scope = "col">
									Description
								</th>
								<th scope = "col">
									Is It Public?
								</th>
								<th scope = "col">
									Take the survey
								</th>
		_END;
		//ADDS MANAGAMENT TAB FOR THE ADMIN AS WELL
		if ($_SESSION['username'] == "admin") {
			echo <<<_END
				<th scope = "col">
					MANAGE
				</th>
				<th scope = "col">
					RESPONSES
				</th>
			_END;
		}
		echo <<<_END
							</tr>
						</thead>
		_END;
		for ($i = 0; $n > $i; $i++) {
			$row = mysqli_fetch_assoc($results);
			$survey_id = $row['surveyID'];
			$survey_creator = $row['surveyCreator'];
			$survey_title = $row['surveyTitle'];
			$survey_desc = $row['surveyDesc'];
			$is_open = $row['isOpen'];
			echo <<<_END
				<tr>
					<td>
						$survey_creator
					</td>
					<td>
						$survey_title
					</td>
					<td>
						$survey_desc
					</td>
					<td>
			_END;
			if ($_SESSION['username'] == "admin") {
				if ($is_open == 1) {
					echo "<button type='submit' name = 'is_open' value = '$survey_id' class='btn btn-success'>Public</button>";
				}
				else {
					echo "<button type='submit' name = 'is_open' value = '$survey_id' class='btn btn-danger'>Closed</button>";
				}
			}
			else {
				if ($is_open) {
					echo "<button type='button' class='btn btn-success'>PUBLIC</button>";
				}
				else {
					echo "<button type='button' class='btn btn-danger'>CLOSED</button>";
				}
			}
			echo <<<_END
					</td>
					<td>
						<button type = "submit" class="btn btn-primary" name = "Preview" value = "$survey_id"> Preview </button>
					</td>
			_END;
			if ($_SESSION['username'] == "admin") {
				echo <<<_END
					<td>
						<button type = "submit" class="btn btn-primary" name = "Manage" value = "$survey_id"> Manage </button>
					</td>
					<td>
						<button type = "submit" class="btn btn-primary" name = "Responses" value = "$survey_id"> Responses </button>
					</td>
				_END;
			}
			echo "</tr>";
		}
		echo"</table> </div>";
	}
	else {
		echo "There is no other public surveys...";
	}
	
	// a little extra text that only the admin will see:

    
}

// finish off the HTML for this page:
require_once "footer.php";

?>