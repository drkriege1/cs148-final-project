<?php
/* The purpose of this file to establish the connection between your php page
 * and the database. On successfull completion you will have a variable $db 
 * that is your database connection ready to use.
 */

// get variables $db_prefix, $db_writer_user, and $db_writer_pass
// initialize $db_name to "assignment7.1"
// initialize $dsn to "mysql:host=webdb.uvm.edu;dbname="
include("/usr/local/uvm-inc/drkriege.inc");
$dsn = 'mysql:host=webdb.uvm.edu;dbname=';
$db_name = "assignment7.1";


function dbConnect(){
    global $dsn, $db_prefix, $db_name, $db_writer_user, $db_writer_pass;

    $db = new PDO($dsn . $db_prefix . $db_name, $db_writer_user, $db_writer_pass);
    return $db;
} 

// create the PDO object
try { 	
    $db=dbConnect();
    if($debug) echo '<p>A You are connected to the database!</p>';
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    if($debug) echo "<p>An error occurred while connecting to the database: $error_message </p>";
}
?>