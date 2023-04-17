<?php
require('include/auth.php');
$title = 'Users';
require('include/header.php');
ini_set('display_errors',1); error_reporting(E_ALL);

try {
    // connect to db
    require('include/db.php');

    // set up the SQL SELECT command
    $sql = "SELECT * FROM examusers";

    // execute the select query
    $cmd = $db->prepare($sql);
    $cmd->execute();

    // store the query results in an array.
    $posts = $cmd->fetchAll();

foreach ($posts as $post) {
    echo '<article class="users">
    <p> username: ' . $post['username'] . '</p>';

    // if(empty($_SESSION['username'])){
    //     echo'THE SESSION IS NOT GRABBING THE username';
    // }
    
    if ($post['username'] == $_SESSION['username']) {
        echo '<a href="user-details.php?username='. $post['username'] . '">Edit </a>';
    }
}
echo'</article>';
                '<a href="user-details.php?username=' . $post['username'] . '">Edit</a>
                </article>';
                $db = null;
}
                catch (Exception $error) {
                    header('location:error.php');
                    exit();

}

?>