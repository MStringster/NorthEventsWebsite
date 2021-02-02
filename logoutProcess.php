<!-- logout process document -->
<!-- Developed by Michael Stringer - Student ID: W18019818-->

<!-- PHP to start a session and set the directory for the data to be saved -->
<?php
    ini_set("session.save_path", "/home/unn_w18019818/sessionData");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        
        <meta name="viewport" content="width=device-width">
        <meta charset="utf-8">
        <title> North Events </title>
        <link rel="stylesheet" href="stylesheet.css" type="text/css">
           
    </head>


    <body>
            <header> 
                
            
            </header>
        
            <main>
                <!-- PHP to destroy the session and then redirect the user to the home page -->
                <?php
                       session_start();
                       session_destroy();
                       header("location: index.php");
                       exit;
                ?>

            </main>
 
            <footer>
        
        
            </footer>
    </body>

</html>