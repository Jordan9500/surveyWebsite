<?php

// Things to notice:
// The main job of this script is to execute an INSERT statement to add the submitted username, password and email address
// However, the assignment specification tells you that you need more fields than this for each user.
// So you will need to amend this script to include them. Don't forget to update your database (create_data.php) in tandem so they match
// This script does client-side validation using "password","text" inputs and "required","maxlength" attributes (but we can't rely on it happening!)
// we sanitise the user's credentials - see helper.php (included via header.php) for the sanitisation function
// we validate the user's credentials - see helper.php (included via header.php) for the validation functions
// the validation functions all follow the same rule: return an empty string if the data is valid...
// ... otherwise return a help message saying what is wrong with the data.
// if validation of any field fails then we display the help messages (see previous) when re-displaying the form

// execute the header script:
require_once "header.php";

// default values we show in the form:
$username = "";
$password = "";
$password_confirm = "";
$firstName = "";
$surname = "";
$email = "";
$DOB = "";
$phone = "";


// strings to hold any validation error messages:
$username_val = "";
$password_val = "";
$password_confirm_val = "";
$firstName_val = "";
$surname_val = "";
$email_val = "";
$DOB_val = "";
$phone_val = "";

// should we show the signup form?:
$show_signup_form = false;
// message to output to user:
$message = "";

// checks the session variable named 'loggedInSkeleton'
if (isset($_SESSION['loggedInSkeleton'])) {
	// user is already logged in, just display a message:
	echo "You are already logged in, please log out if you wish to create a new account<br>";
	
}

elseif (isset($_POST['username'])) {
	// user just tried to sign up:
	
	// connect directly to our database (notice 4th argument) we need the connection for sanitisation:
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	// if the connection fails, we need to know, so allow this exit:
	if (!$connection) {
		die("Connection failed: " . $mysqli_connect_error);
	}	
	
	// SANITISATION (see helper.php for the function definition)
    // Check that the two passwords are the same to validate the users input
    // take copies of the credentials the user submitted, and sanitise (clean) them:
    $username = sanitise($_POST['username'], $connection);
    $password = sanitise($_POST['password'], $connection);
    $password_confirm = sanitise($_POST['passwordConfirm'], $connection);
    $firstName = sanitise($_POST['firstName'], $connection);
    $surname = sanitise($_POST['surname'], $connection);
    $email = sanitise($_POST['email'], $connection);
    $DOB = sanitise($_POST['DOB'], $connection);
    $phone = sanitise($_POST['phone'], $connection);
    // VALIDATION (see helper.php for the function definitions)
    // now validate the data (both strings must be between 1 and 16 characters long):
    // (reasons: we don't want empty credentials, and we used VARCHAR(16) in the database table for username and password)
    // firstname is VARCHAR(32) and lastname is VARCHAR(64) in the DB
    // email is VARCHAR(64) and telephone is VARCHAR(16) in the DB
    $username_val = validateString($username, 1, 16);
    $password_val = validateString($password, 1, 16);
    $password_confirm_val = validateString($password, 1, 16);
    $firstName_val = validateString($firstName, 1, 32);
    $surname_val = validateString($surname, 1, 64);
    //Phone numbers can be from 5 - 15 but nothing longer or smaller
    $phone_val = validateString($phone, 5, 15);
    $DOB_val = validateDate($DOB);
    $email_val = validateEmail($email, 1, 64);
    
    // concatenate all the validation results together ($errors will only be empty if ALL the data is valid):
    $errors = $username_val . $password_val . $password_confirm_val . $firstName_val . $surname_val . $email_val . $phone_val;
    // check that all the validation tests passed before going to the database:
    if (($errors == "") && ($password == $password_confirm)) {
        // try to insert the new details:
        $query = "INSERT INTO users (username, password, firstName, surname, email, DOB, phone) 
            VALUES ('$username', '$password', '$firstName', '$surname', '$email', '$DOB', '$phone');";
        $result = mysqli_query($connection, $query);
        // no data returned, we just test for true(success)/false(failure):
        if ($result) {
                // show a successful signup message:
                $message = "Signup was successful, please sign in<br>";
        } 
        else {
            // show the form:
            $show_signup_form = true;
            // show an unsuccessful signup message:
            $message = "Sign up failed, please try again<br>";
        }
    }
    else {
        // validation failed, show the form again with guidance:
        $show_signup_form = true;
        // show an unsuccessful signin message:
        $message = "Sign up failed, please check the errors shown above and try again<br> Check the passwords";

    }
	// we're finished with the database, close the connection:
    mysqli_close($connection);
}

else {
	// just a normal visit to the page, show the signup form:
	$show_signup_form = true;	
}

if ($show_signup_form) {
    // show the form that allows users to sign up
    // Note we use an HTTP POST request to avoid their password appearing in the URL:	
    echo <<<_END
        <form action="" method="post">
            <table>
                <tr>
                    <td>
                        First Name:
                    </td>
                    <td>
                        <input class="form-control" type="text" name="firstName" maxlength="32" value="$firstName" required> 
                        $firstName_val
                    </td>
                    <td>
                        Surname:
                    </td>
                    <td>
                        <input class="form-control" type="text" name="surname" maxlength="64" value="$surname" required> 
                        $surname_val
                    </td>
                </tr>
                <tr>
                    <td>
                        Date Of Birth:
                    </td>
                    <td>
                        <input class="form-control" type="date" name="DOB" value="$DOB" required> 
                        $DOB_val
                    </td>
                    <td>
                        Phone Number:
                    </td>
                    <td>
                        <input class="form-control" type="text" name="phone" maxlength="15" value="$phone" required> 
                        $phone_val
                    </td>
                </tr>
                <tr>
                    <td>
                        Username:
                    </td>
                    <td>
                        <input class="form-control" type="text" name="username" maxlength="16" value="$username" required> 
                        $username_val
                    </td>
                </tr>
                <tr>
                    <td>
                        Email:
                    </td>
                    <td>
                        <input class="form-control" type="email" name="email" maxlength="64" value="$email" required> 
                        $email_val    
                    </td>
                </tr>
                <tr>
                    <td>
                        Password:
                    </td>
                    <td>
                        <input class="form-control" type="password" name="password" maxlength="16" value="$password" required>
                        $password_val
                    </td>
                    <td>
                        Confirm:
                    </td>
                    <td>
                        <input class="form-control" type="password" name="passwordConfirm" maxlength="16" value="$password_confirm" required>
                        $password_confirm_val
                    </td>
                </tr>
            </table>
            <input class="btn btn-primary" type="submit" value="Submit">
        </form>	
    _END;
}

// display our message to the user:
echo $message;

// finish off the HTML for this page:
require_once "footer.php";

?>