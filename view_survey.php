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
$is_open = false;

//Question//
$question_id = 0;
$question_title = "";
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
    echo "<h5>View Survey Page</h5>";
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

    


}
// finish off the HTML for this page:
require_once "footer.php";


?>