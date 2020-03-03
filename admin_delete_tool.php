<?php

$username_del = "";
$no_question = false;
// checks the session variable named 'loggedInSkeleton'
// take note that of the '!' (NOT operator) that precedes the 'isset' function
if (!isset($_SESSION['loggedInSkeleton'])) {
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}
// the user must be signed-in, show them suitable page content
else {
	// only display the page content if this is the admin account (all other users get a "you don't have permission..." message):
	if ($_SESSION['username'] == "admin") {
        $username_del = $_SESSION["username_del"];
        $connection = credentialsFunction();
        // connect to our database:
        mysqli_select_db($connection, $dbname);
        
        $query = "SELECT surveyID FROM survey WHERE surveyCreator = '$username_del'";
        $results = mysqli_query($connection, $query);
        if (mysqli_num_rows($results)) {
            $n = mysqli_num_rows($results);
            for ($i = 0; $i < $n; $i++) {
                $row = mysqli_fetch_assoc($results);
                $survey_id_array[] = $row['surveyID'];
            }
            for ($i = 0; $i < count($survey_id_array); $i++) {
                // bring all the surveys linked to the user:
                $query = "SELECT questionID FROM surveyQuestion WHERE surveyID ='$survey_id_array[$i]'";
                // this query can return data ($result is an identifier):
                $results = mysqli_query($connection, $query);
                // how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
                $n = mysqli_num_rows($results);
                if ($n > 0) {
                    $no_question = false;
                    for ($j = 0; $n > $j; $j++) {
                        $row = mysqli_fetch_assoc($results);
                        $question_ids[] = $row['questionID'];
                    }
                }
                else {
                    $no_question = true;
                }
                $sql = "DELETE FROM questionAnswer WHERE surveyID = '$survey_id_array[$i]'";
                if (mysqli_query($connection, $sql)) {
                    $sql = "DELETE FROM surveyQuestion WHERE surveyID = '$survey_id_array[$i]'";
                    if (mysqli_query($connection, $sql)) {
                        // bring all the surveys linked to the user:
                        $sql = "DELETE FROM survey WHERE surveyID = '$survey_id_array[$i]'";
                        if (mysqli_query($connection, $sql)) {
                            if (!$no_question) {
                                // this query can return data ($result is an identifier):
                                for ($j=0; $j<count($question_ids); $j++) {
                                    // create the SQL query to be executed
                                    $question_id = $question_ids[$j];
                                    $sql = "DELETE FROM question WHERE questionID = '$question_id'";
                                    if (mysqli_query($connection, $sql)) {
                                    }
                                    else {
                                        die("Error Deleting row: " . mysqli_error($connection));		
                                    }
                                }
                            }
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
        } 
        $sql = "DELETE FROM users WHERE username = '$username_del';";
        // check if the query runs and deletes the user and refreshes the page else if will refresh the page
        if (mysqli_query($connection, $sql)) {
            $results = mysqli_query($connection, $sql); 
        }
    }
    else {
        echo "You don't have permission to view this page...<br>";

    }
}

?>