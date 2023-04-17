<?php
require('include/header');
?>
<body>
    <?php
    // reference the uploaded file
    $userFile = $_FILES['photo'];

    // file name
    $name = $userFile['username'];
    echo 'username: ' . $name . '<br />';

    // size in bytes (1 kb = 1024 bytes)
    $size = $userFile['size'];
    echo 'Size: ' . $size . '<br />';

    // temp location in server cache
    $tmp_name = $userFile['tmp_name'];
    echo 'Temp Name: ' . $tmp_name . '<br />';

    // file type
    //$type = $userFile['type']; // dangerous - do not use (can be fooled)
    $type = mime_content_type($tmp_name);
    echo 'Type: ' . $type . '<br />';

    // use the session object to create a unique name. eg. photo1.png => as98df723-photo1.png
    session_start();
    $name = session_id() . '-' . $name;

    // move file to uploads folder
    move_uploaded_file($tmp_name, 'img/headerimg'. $name);

    // show the caption entered by the user in the form
    $caption = $_POST['caption'];
    echo 'Caption: ' . $caption . '<br />';

    ?>
</body>
</html>