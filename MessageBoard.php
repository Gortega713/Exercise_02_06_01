<!DOCTYPE html>
<html lang="en">

<head>
    <!-- 
     Author: Gabriel Ortega
     Date: 10.19.18
     
     Filename: MessageBoard.php
     -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Message Board </title>
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>

    <h1>Message Board</h1>
    
    <?php
    if (isset($_GET['action'])) {
        if (file_exists("messages.txt") && filesize("messages.txt") != 0) {
            $messageArray = file("messages.txt");
            switch ($_GET['action']) {
                case 'Delete First':
                    // Shrink the array. Delete the first element (0)
                    array_shift($messageArray);
                    break;
                case 'Delete Last':
                    // Shrink the array. Delete the last element (2)
                    array_pop($messageArray);
                    break;
                case 'Sort Ascending':
                    // Shrink the array. Delete the last element (2)
                    sort($messageArray);
                    break;
                case 'Sort Descending':
                    // Shrink the array. Delete the last element (2)
                    rsort($messageArray);
                    break;
                case 'Delete Message':
                    // Shrink the array. Delete a certain element
                     array_splice($messageArray, $_GET['message'], 1);
                    break;
                case 'Remove Duplicates':
                    // Delete duplicates
                    $messageArray = array_unique($messageArray);
                    $messageArray = array_values($messageArray);
                    break;
            }
            if (count($messageArray) > 0) {
                $newMessages = implode($messageArray);
                $fileHandle = fopen("messages.txt", "wb");
                if (!$fileHandle) {
                    echo "There was an error updating the message file.\n";
                } else {
                    fwrite($fileHandle, $newMessages);
                    fclose($fileHandle);
                }
            } else {
                // Remove file from disk
                unlink("messages.txt");
            }
        }
    }
    
    if (!file_exists("messages.txt") || filesize("messages.txt") == 0) {
        // Failure
        echo "<p>There are no messages posted.</p>\n";
    } else {
        // Success
        $messageArray = file("messages.txt");
        // Start of table
        echo "<table style=\"background-color: lightgray\" border=\"1\" width=\"100%\">\n";
        $count = count($messageArray);
        // Creates associative array
        for ($i = 0; $i < $count; $i++) {
            $curMessage = explode("~", $messageArray[$i]);
            // $keyMessageArray as subject => name~message
            $keyMessageArray[$curMessage[0]] = $curMessage[1] . "~" . $curMessage[2];
        }
        // Take the place of the $i
        $index = 1;
        $key = key($keyMessageArray);
        // Designed to iterate through previous array
        foreach ($keyMessageArray as $message) {
            $curMessage = explode("~", $message);
            echo "<tr>\n";
            echo "<td width=\"5%\" style=\"text-align: center; font-weight: bold\">" . $index . "</td>\n";
            // Subject
            echo "<td width=\"85%\"><span style=\"font-weight: bold\">Subject: </span>" . htmlentities($key) . "<br>\n";
            // Name
            echo "<span style=\"font-weight: bold\">Name: </span>" . htmlentities($curMessage[0]) . "<br>\n";
            // Message
            echo "<span style=\"text-decoration: underline; font-weight: bold\">Message: </span><br>\n" . htmlentities($curMessage[1]) . "</td>\n";
            echo "<td width=\"10%\" style=\"text-align: center\">" . "<a href='MessageBoard.php?" . "action=Delete%20Message&" . "message=" . ($index - 1) . "'>" . "Delete This Message</a><td>\n";
            echo "</tr>\n";
            ++$index;
            next($keyMessageArray);
            $key = key($keyMessageArray);
        }
        // End of table
        echo "</table>";
    }
    ?>
    
    <p>
        <a href="PostMessage.php">Post New Message</a><br>
        <a href="MessageBoard.php?action=Sort%20Ascending">Sort Subjects A-Z</a><br>
        <a href="MessageBoard.php?action=Sort%20Descending">Sort Subjects Z-A</a><br>
        <a href="MessageBoard.php?action=Delete%20First">Delete First Message</a><br>
        <a href="MessageBoard.php?action=Delete%20Last">Delete Last Message</a><br>
<!--        <a href="MessageBoard.php?action=Remove%20Duplicates">Remove Duplicates</a><br>-->
    </p>

</body>

</html>