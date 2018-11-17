<!DOCTYPE html>
<html lang="en">

<head>
    <!-- 
     Author: Gabriel Ortega
     Date: 10.19.18
     
     Filename: PostMessage.php
     -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Post New Message </title>
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>

    <?php
    // Entry Point
    // Purpose: Data submitted? Yes - Process, No - Display form
    if (isset($_POST['submit'])) {
        $subject = stripslashes($_POST['subject']);
        $name = stripslashes($_POST['name']);
        $message = stripslashes($_POST['message']);
        $subject = str_replace("~", "-", $subject);
        $name = str_replace("~", "-", $name);
        $message = str_replace("~", "-", $message);
        $existingSubjects = array();
        if (file_exists("messages.txt") && filesize("messages.txt") > 0) {
            $messageArray = file("messages.txt");
            $count = count($messageArray);
            for ($i = 0; $i < $count; $i++) {
                $currMessage = explode("~", $messageArray[$i]);
                $existingSubjects[] = $currMessage[0];
            }
        }
        // in_array is designed to test for keys, not values
        if (in_array($subject, $existingSubjects)) {
            echo "<p>The subject <em>\"$subject\"</em> you entered already exists!<br>\n";
            echo "Please enter a new subject and try again.<br>\n";
            echo "Your message was not saved.</p>";
            $subject = "";
        } else {
            $messageRecord = "$subject~$name~$message\n";
            $fileHandle = fopen("messages.txt", "ab");
            if (!$fileHandle) {
                echo "There was an error saving your message!\n";
            } else {
                fwrite($fileHandle, $messageRecord);
                fclose($fileHandle);
                echo "Your message has been saved.\n";
                $subject = "";
                $message = "";
                $name = "";
            }
        }
    } else {
        $subject = "";
        $name = "";
        $message = "";
    }
    ?>
    
    <h1>Post New Message</h1>
    <hr>
    
    <!--  HTML Form  -->
    <form action="PostMessage.php" method="post">
        <!--  Subject  -->
        <span style="font-weight: bold">Subject: <input text="text" name="subject" value="<?php echo $subject; ?>"></span>
        <!--  Name of poster  -->
        <span style="font-weight: bold">Name: <input text="text" name="name" value="<?php echo $name; ?>"></span><br>
        <!--  Message  -->
        <textarea name="message" rows="6" cols="80" style="margin: 10px 5px 5px"><?php echo $message; ?></textarea><br>
        <!--  Reset Button  -->
        <input type="reset" name="reset" value="Reset Form">
        <!--  Submit Button  -->
        <input type="submit" name="submit" value="Post Message">
    </form>
    <hr>
    <p>
        <a href="MessageBoard.php">View Messages</a>
    </p>
</body>

</html>
