<?php
// default values for Xampp when accessing your MySQL database:
    function selectAllByIdQuery($varname, $dbSelectName, $dbid, $id, $flag) {
        $connection = credentialsFunction();
        $dbname  = 'skeleton';

        // connect to our database:
        mysqli_select_db($connection, $dbname);
        // bring all the surveys linked to the user:
        if ($flag){
            $query = "SELECT $varname FROM $dbSelectName WHERE $dbid = '$id'";
        }
        else {
            $query = "SELECT $varname FROM $dbSelectName WHERE $dbid != '$id'";
        }
        // this query can return data ($result is an identifier):
        $results = mysqli_query($connection, $query);

        return $results;
    }

    function credentialsFunction() {
        $dbhost  = 'localhost';
        $dbuser  = 'root';
        $dbpass  = '';  
        $connection = mysqli_connect($dbhost, $dbuser, $dbpass);
        // exit the script with a useful message if there was an error:
        if (!$connection) {
            die("Connection failed: " . $mysqli_connect_error);
        }
        else {
            return $connection;
        }
    }

    function TopConstuctGoogleAPI() {
        
    }

?>