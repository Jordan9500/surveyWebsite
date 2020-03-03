<?php

require_once "header.php";

// default values we show in the form:
$username = "";
$password = "";
$passwordVal = "";
$firstName = "";
$surname = "";
$email = "";
$DOB = "";
$phone = "";
//The users username that is going to be edited 
$username_edit = "";
// strings to hold any validation error messages:
$username_val = "";
$password_val = "";
$firstName_val = "";
$surname_val = "";
$email_val = "";
$DOB_val = "";
$phone_val = "";

// message to output to user:
$message = "";

// showing the edit table
$show_edit_form = false;

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
        if(isset($_POST['submit'])) {
            // admin just tried to update the users profile

            // connect directly to our database (notice 4th argument) we need the connection for sanitisation:
            $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
            
            // if the connection fails, we need to know, so allow this exit:
            if (!$connection) {
                die("Connection failed: " . $mysqli_connect_error);
            }
            //SANITATION check helper.php for more info
            $username = sanitise($_POST['username'], $connection);
            $password = sanitise($_POST['password'], $connection);
            $firstName = sanitise($_POST['firstName'], $connection);
            $surname = sanitise($_POST['surname'], $connection);
            $email = sanitise($_POST['email'], $connection);
            $DOB = sanitise($_POST['DOB'], $connection);
            $phone = sanitise($_POST['phone'], $connection);
            //VALIDATION
            $username_val = validateString($username, 1, 16);
            $password_val = validateString($password, 1, 16);
            $firstName_val = validateString($firstName, 1, 32);
            $surname_val = validateString($surname, 1, 64);
            //Phone numbers can be from 5 - 15 but nothing longer or smaller
            $phone_val = validateString($phone, 5, 15);
            $DOB_val = validateDate($DOB);
            $email_val = validateEmail($email, 1, 64);

            //Output the errors that occur if any
            $errors = $username_val . $password_val . $firstName_val . $surname_val . $email_val . $phone_val;            
            // check that all the validation tests passed before going to the database:
            if ($errors == "") {		
                // read their username from the session:
                $username_edit = $_SESSION["username_edit"];
                
                // now write the new data to our database table...
                // Bring the selected users data from the table:
                $query = "SELECT * FROM users WHERE username='$username_edit'";
                
                // this query can return data ($result is an identifier):
                $result = mysqli_query($connection, $query);
                
                // how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
                $n = mysqli_num_rows($result);
                    
                // if there was a match then UPDATE their profile data, otherwise INSERT it:
                if ($n > 0) {
                    // we need an UPDATE:
                    $query = "UPDATE users 
                                SET username = '$username',
                                    password = '$password',
                                    firstName = '$firstName',
                                    surname = '$surname',
                                    email = '$email',
                                    DOB = '$DOB',
                                    phone = '$phone' 
                                WHERE username = '$username_edit'";
                    $result = mysqli_query($connection, $query);
                    echo "<br>Update successful <a class = 'btn btn-success' href='admin.php'>return here</a>.<br>";		
                }
            }   
        }
        else {
            // user has arrived at the page for the first time, show any data already in the table:
            
            // read the username from the session:
            $username_edit = $_SESSION["username_edit"];
            
            // now read their profile data from the table...
            
            // connect directly to our database (notice 4th argument):
            $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
            
            // if the connection fails, we need to know, so allow this exit:
            if (!$connection) {
                die("Connection failed: " . $mysqli_connect_error);
            }
            
            // check for a row in our profiles table with a matching username:
            $query = "SELECT * FROM users WHERE username = '$username_edit'";
            
            // this query can return data ($result is an identifier):
            $result = mysqli_query($connection, $query);
            
            // how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
            $n = mysqli_num_rows($result);
                
            // if there was a match then extract their profile data:
            if ($n > 0) {
                // use the identifier to fetch one row as an associative array (elements named after columns):
                $row = mysqli_fetch_assoc($result);
                // extract their profile data for use in the HTML:
                $email = $row['email'];
                $username = $row['username'];
                $password = $row['password'];
                $firstName = $row['firstName'];
                $surname = $row['surname'];
                $DOB = $row['DOB'];
                $phone = $row['phone'];
            }
            
            // show the set profile form:
            $show_edit_form = true;
            
            // we're finished with the database, close the connection:
            mysqli_close($connection);
        }
    }
    if ($show_edit_form) {
        echo <<<_END
            <h2>User Edit: $username_edit</h2><br>
            <form action = "admin_edit_tool.php" method="post">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope = "col">
                                    First Nane
                                </th>
                                <th scope = "col">
                                    Surname
                                </th>
                                <th scope = "col">
                                    Date Of Birth
                                </th>
                                <th scope = "col">
                                    Phone Number
                                </th>
                                <th scope = "col">
                                    Username
                                </th>
                                <th scope = "col">
                                    Email
                                </th>
                                <th scope = "col">
                                    Password
                                </th>
                                <th scope = "col">
                                    Edit Confirm
                                </th>
                            </tr>
                        </thead>
                        <tr>
                            <td>
                                <input class="form-control" type="text" name="firstName" maxlength="32" value="$firstName" required> $firstName_val
                            </td>
                            <td>
                                <input class="form-control" type="text" name="surname" maxlength="64" value="$surname" required> $surname_val
                            </td>
                            <td>
                                <input class="form-control" type="date" name="DOB" value="$DOB" required> $DOB_val
                            </td>
                            <td>
                                <input class="form-control" type="text" name="phone" maxlength="15" value="$phone" required> $phone_val
                            </td>
                            <td>
                                <input class="form-control" type="text" name="username" maxlength="16" value="$username" required> $username_val
                            </td>
                            <td>
                                <input class="form-control" type="email" name="email" maxlength="64" value="$email" required> $email_val    
                            </td>
                            <td>
                                <input class="form-control" type="password" name="password" maxlength="16" value="$password" required> $password_val
                            </td>
                            <td>
                                <input class="btn btn-success" type="submit" name = "submit" value="Submit">
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
        _END;
    }
    else {
        echo "You don't have permission to view this page...<br>";
    }
}


require_once "footer.php";


?>