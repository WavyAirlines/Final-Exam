<?php
require('include/auth');
$title = 'Edit-Username';
require('include/header.php');
?>
    <main>
        <?php 
        try {
            // get the postId from the url parameter using $_GET
            $user = $_GET['username'];
            
            if (empty($user)) {
                header('location:error.php');
                exit();
            }

            // connect - we can re-use for the 2nd query later
            require('include/db.php');

            // set up & run SQL query to fetch the selected post record.  fetch for 1 record only
            $sql = "SELECT * FROM examusers WHERE username = :username";
            $cmd = $db->prepare($sql);
            $cmd->bindParam(':username', $user, PDO::PARAM_INT, 20);
            $cmd->execute();
            $post = $cmd->fetch();

            //access control check : is logged in user the owner of this post?
            if($post['username'] != $_SESSION['username']){
                header('location:error.php');
                exit();
            }
        }
        catch (Exception $error) {
            header('location:error.php');
            exit();
        }
        ?>
        <h1>Username Change</h1>
        <form action="save-user.php" method="post">
            <fieldset>
                <label for="username">Username:</label>
                <textarea name="username" id="username" required maxlength="4000"><?php echo $post['username']; ?></textarea>
            </fieldset>
        </form>
    </main>