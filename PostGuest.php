<!DOCTYPE html>
<html lang="en">

<head>
    <!-- 
    
    Author: Gabriel Ortega
    Date: 10.24.18
    
    Filename: PostGuest.php
    
    -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Sign In </title>
    <link href="PostGuest.css" rel="stylesheet">
</head>

<body>

    <?php
    // Entry Point: Did we come from some other source or not
    // isset? Process data
    if (isset($_POST['submit'])) {
        $visitor = stripslashes($_POST['visitor']);
        $email = stripslashes($_POST['email']);
        $guestRecord = "$visitor-" . "$email" . "\n";
        if (file_exists("Guests.txt") && filesize("Guests.txt") > 0) {
            $fileHandle = fopen("Guests.txt", "ab");
            if (!$fileHandle) {
                echo "File handle error";
            } else {
                fwrite($fileHandle, $guestRecord);
                fclose($fileHandle);
                echo "Thank you " . "<em>$visitor</em>" . " for signing in!";
            }
            
        } else {
            $fileHandle = fopen("Guests.txt", "ab");
            fwrite($fileHandle, $guestRecord);
            fclose($fileHandle);
            echo "Thank you " . "<em>$visitor</em>" . " for signing in!";
        }
    } else {
        // First time? Ask to fill out form 
    }
    
    ?>
    
    <h2>Visitor Sign In</h2>
    <hr>
    <!--  Web Form  -->
    <form action="PostGuest.php" method="post"><br>
    <!--  Visitor Name  -->
    <span style="font-weight: bold;">Visitor: <input type="text" name="visitor"></span><br><br>
    <!--  Email  -->
    <span style="font-weight: bold;">E-mail: <input type="email" name="email"></span><br><br>
    <!--  Reset Form  -->
    <input type="reset" value="Reset Form"> &nbsp; &nbsp;
    <!--  Submit Form  -->
    <input type="submit" name="submit" value="Sign In">
    </form>
    <hr>
    
    <a href="GuestBook.php">View Guests</a>

</body>

</html>
