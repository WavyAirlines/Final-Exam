<?php
require('shared/auth');
$title = 'Edit your Post';
require('shared/header.php');
?>
    <main>
        <?php 
        $user = $_SESSION('username');
        try {
            // get the postId from the url parameter using $_GET
            $postId = $_GET['username'];
            if (empty($postId)) {
                header('location:404.php');
                exit();
            }

            // connect - we can re-use for the 2nd query later
            require('shared/db.php');

            // set up & run SQL query to fetch the selected post record.  fetch for 1 record only
            $sql = "SELECT * FROM examusers WHERE username = :username";
            $cmd = $db->prepare($sql);
            $cmd->bindParam(':username', $user, PDO::PARAM_INT);
            $cmd->execute();
            $post = $cmd->fetch();

            // check query returned a valid post record
            if (empty($post)) {
                header('location:404.php');
                exit();
            }
            //access control check : is logged in user the owner of this post?
            if($post['username'] != $_SESSION['username']){
                header('location:403.php'); //403 = HTTP Forbidden Error
                exit();
            }
        }
        catch (Exception $error) {
            header('location:error.php');
            exit();
        }
        ?>
        <h1>Goals Details</h1>
        <form action="update-goal.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <label for="body">Body:</label>
                <textarea name="body" id="body" required maxlength="4000"><?php echo $post['body']; ?></textarea>
            </fieldset>
            <fieldset>
                <label>Date Created:</label>
                <?php echo $post['dateCreated']; ?>
            </fieldset>
            <button class="btnOffset">Update</button>
            <input name="postId" id="postId" value="<?php echo $postId; ?>" type="hidden" />
            <input name="currentPhoto" value= "<?php echo $post['photo']?>" />
        </form>
    </main>
<?php require('shared/footer.php'); ?>