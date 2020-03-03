<?php

// Things to notice:
// You need to add code to this script to implement the admin functions and features
// Notice that the code not only checks whether the user is logged in, but also whether they are the admin, before it displays the page content
// When an admin user is verified, you can implement all the admin tools functionality from this script, or distribute them over multiple pages - your choice

// execute the header script:
require_once "header.php";

$username_edit = "";
$username_del = "";
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
        
        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        // if the connection fails, we need to know, so allow this exit:
        if (!$connection) {
            die("Connection failed: " . $mysqli_connect_error);
        }	
        else if ((isset($_POST["delete"])) && (isset($_POST["edit"]))) {
            // SANITISATION (see helper.php for the function definition)
            $username_del = sanitise($_POST['delete'], $connection);
            $username_edit = sanitise($_POST['edit'], $connection);

            $_SESSION["username_del"] = $username_del;
            $_SESSION["username_edit"] = $username_edit;
            
            require_once "admin_delete_tool.php";
            if ($username_edit != $username_del) {
                require_once "admin_edit_tool.php";
            }
        
        }
        // if the user has selected a user to be edited it will run the admin_edit_tool.php
        else if (!(isset($_POST["delete"])) && (isset($_POST["edit"]))) {
            $username_edit = sanitise($_POST['edit'], $connection);
            $_SESSION["username_edit"] = $username_edit;
            require_once "admin_edit_tool.php";
        }
        else if ((isset($_POST["delete"])) && !(isset($_POST["edit"]))) {
            $username_del = sanitise($_POST['delete'], $connection);
            $_SESSION["username_del"] = $username_del;
            require_once "admin_delete_tool.php";
            header("Refresh:0");
        }
        // load the table with all the user data and provide a radio box to decide on which user to edit or delete
        else {       
            echo  <<<_END
                <h2>User Management:</h2><br>
                <a class = 'btn btn-success' href='admin_add_tool.php'>Add Users</a>
                <form action = "admin.php" method="post">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope = "col">
                                        Username
                                    </th>
                                    <th scope = "col">
                                        First Name
                                    </th>
                                    <th scope = "col">
                                        Surname
                                    </th>
                                    <th scope = "col">
                                        Birth Date
                                    </th>
                                    <th scope = "col">
                                        Phone
                                    </th>
                                    <th scope = "col">
                                        Email
                                    </th>
                                    <th scope = "col">
                                        Password
                                    </th>
                                    <th scope = "col">
                                        Edit
                                    </th>
                                    <th scope = "col">
                                        Delete
                                    </th>
                                </tr>
                            </thead>
            _END;
            $query = "SELECT * FROM users;";
            if (mysqli_query($connection, $query)) {
                $results = mysqli_query($connection, $query);
                $n = mysqli_num_rows($results);

                for($i = 0; $i < $n; $i++) {
                    $row = mysqli_fetch_assoc($results);
                    $username_del = $row["username"];
                    $username_edit = $row["username"];
                    echo "<tr><td>". 
                        $row["username"].
                        "</td><td>". 
                        $row["firstName"].
                        "</td><td>".
                        $row["surname"].
                        "</td><td>".
                        $row["DOB"].
                        "</td><td>".
                        $row["phone"].
                        "</td><td>".
                        $row["email"].
                        "</td><td>".
                        $row["password"];
                    echo <<<_END
                        </td><td>
                        <input type = "radio" name = "edit" value = "$username_edit"> 
                        </td><td>
                        <input type = "radio" name = "delete" value = "$username_del"> 
                        </td></tr>
                    _END;
                }
                echo <<<_END
                            <tr> 
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <input class="btn btn-success" type = "submit" name = "Confirm" value = "Confirm Selected">
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
                _END;
            }
    
        }
    }
	else {
		echo "You don't have permission to view this page...<br>";
    }
    
}   
require_once "footer.php";


// finish off the HTML for this page:
?>