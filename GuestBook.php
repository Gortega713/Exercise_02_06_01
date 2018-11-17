<!DOCTYPE html>
<html lang="en" style="background-color: antiquewhite">

<head>
    <!-- 
    
    Author: Gabriel Ortega
    Date: 10.24.18
    
    Filename: GuetsBook.php
    
    -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Guest Book </title>
    <script src="modernizr.custom.65897.js"></script>
    <link href="GuestBook.css" rel="stylesheet">
</head>

<body>

    <h2>Guest Book</h2>
    
    <?php
    // If we got to this page by clicking a link with a GET action, run code
    if (isset($_GET['action'])) {
        if (file_exists("Guests.txt") && filesize("Guests.txt") != 0) {
            $guestFile = file("Guests.txt");
            switch ($_GET['action']) {
                case 'Delete First':
                    // Shrink the array. Delete the first element (0)
                    array_shift($guestFile);
                    break;
                case 'Delete Last':
                    // Shrink the array. Delete the last element (2)
                    array_pop($guestFile);
                    break;
                case 'Sort Ascending':
                    // Shrink the a$guestFilerray. Delete the last element (2)
                    sort($guestFile);
                    break;
                case 'Sort Descending':
                    // Shrink the array. Delete the last element (2)
                    rsort($guestFile);
                    break;
                case 'Delete Message':
                    // Shrink the array. Delete a certain element
                    array_splice($guestFile, $_GET['message'], 1);
                    break;
            }
            if (count($guestFile) > 0) {
                $newGuests = implode($guestFile);
                $fileHandle = fopen("Guests.txt", "wb");
                if (!$fileHandle) {
                    echo "There was an error signing someone in.\n";
                } else {
                    fwrite($fileHandle, $newGuests);
                    fclose($fileHandle);
                }
            } else {
                // Remove file from disk
                unlink("Guests.txt");
            }
        }
    }

    
    // Check if there is data to post
    if (!file_exists("Guests.txt") || filesize("Guests.txt") < 0) {
        echo "No guests are currently signed in";
    } else {
        echo "<table style=\"background-color: black\" border=\"1\" width=\"100%\">\n";
        echo "<tr>";
        echo "<td width=\"15%\" style=\"text-align: center; background-color: rgba(32, 168, 217, 0.77)\">" . "Visitor #</td>\n";
        echo "<td width=\"75%\" style=\"text-align: center; background-color: rgba(32, 168, 217, 0.77)\">" . "Visitor Information</td>\n";
        echo "<td width=\"10%\" style=\"text-align: center; background-color: rgba(32, 168, 217, 0.77)\">" . "Sign Out</td>\n";
        // Data to post? Process by reading the file and putting each line in an array
        $guestFile = file("Guests.txt");
        $count = count($guestFile);
        for ($i = 0; $i < $count; $i++) {
            $guestData = explode("-", $guestFile[$i]);
            // $keyMessageArray as subject => name~message
            $keyMessageArray[$guestData[0]] = $guestData[1];
        }
        // Take the place of the $i
        $index = 1;
        $key = key($keyMessageArray);
        // Designed to iterate through previous array
        foreach ($keyMessageArray as $message) {
            $curMessage = explode("~", $message);
            // Put each element into a part of the table
            echo "<tr>\n";
            echo "<td style=\"background-color: rgba(32, 168, 217, 0.77); text-align: center; font-weight: bold\" width=\"15%\">" . $index . "</td>\n";
            // Subject
            echo "<td style=\"background-color: rgba(32, 168, 217, 0.77)\"width=\"75%\"><span style=\"font-weight: bold;\">Visitor Name: </span>" . htmlentities($key) . "<br>\n";
            // Name
            echo "<span style=\"font-weight: bold\">Email: </span>" . htmlentities($curMessage[0]) . "<br>\n";
            // Message
            echo "<td width=\"10%\" style=\"text-align: center; background-color: rgba(32, 168, 217, 0.77)\">" . "<a href='GuestBook.php?" . "action=Delete%20Message&" . "message=" . ($index - 1) . "'>" . "Sign Out</a><td>\n";
            echo "</tr>\n";
            ++$index;
            next($keyMessageArray);
            $key = key($keyMessageArray);
        }
        // End of table
        echo "</table>";
        
    }
    ?>
    
    <p>Need to sign in? Click <a href="PostGuest.php">here</a>!<br>
    
        <a href="GuestBook.php?action=Sort%20Ascending">Sort Visitors A-Z</a><br>
        <a href="GuestBook.php?action=Sort%20Descending">Sort Visitors Z-A</a><br>
        <a href="GuestBook.php?action=Delete%20First">Sign Out First Guest</a><br>
        <a href="GuestBook.php?action=Delete%20Last">Sign Out Last Guest</a><br>
        
        </p>
    
</body>

</html>