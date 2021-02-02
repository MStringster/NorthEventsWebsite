<!-- Home Page -->
<!-- Developed By Michael Stringer -->

<!-- PHP to start a session and set the directory for the data to be saved -->
<?php
    ini_set("session.save_path", "/home/unn_w18019818/sessionData");
    session_start();
?>
<!DOCTYPE html>

<html lang="en"> 

    <head> 
        <meta charset="utf-8">
        <title> North Events </title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css" >
        
        <!-- fonts used within the page taken from googleapis --> 
        <link href='https://fonts.googleapis.com/css?family=Cinzel+Decorative' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
           
    </head>

    <body>
            <header> 
                <h1> North Events </h1>
                <div id="tagline"> Events in the North </div>
            </header>
        <!-- The Navigation Bar -->
            <nav>
                
                <a href="index.php" class='navBtns'> Home </a>
                <a href="events.php" class='navBtns'> Events </a>
                <a href="bookEventsForm.php" class='navBtns'> Book Events </a>
                <a href="credits.php" class='navBtns'> Credits </a>
                
<!-- PHP SCRIPT STARTS HERE -->
<?php
//If the user is logged in then display the logout button else display the login button
    if(isset($_SESSION["logged-in"]))
    {
        echo "<a href='logoutProcess.php' class='navBtns'> Logout </a>";
    }
    else
    {
        echo "<a id='loginBtn' class='navBtns'> Login </a>";
    }
?>
<!-- END OF PHP HERE -->

            </nav>
        
            <main>
                        
            </main>
            
            <!-- offers will update every 5 seconds and refers to the javascript called offerscript.js -->
            <aside>
                <p id="offers"></p>
        
            </aside>
        
            <!-- Offer that will be displayed randomly but will not change unless the user refreshes, using XML wihin the offerscript.js -->
            <aside>
                <p id="XMLoffers"> </p>
                
            </aside>
        
            <footer>        
        
                <!-- Popup box for login are stored here. These are hidden by default only being displayed when a login button is pressed --!>
        
           <!-- The Login Box -->
<div id="login" class="login">

  <!-- Login Box Content -->
  <div class="loginContent">
    <div class="loginHeader">
      <span class="close">&times;</span>
      <h2>Login</h2>
    </div>
      
       <!-- Form that contains the input boxes for username and password that will pass them over to the loginProcess.php to be checked when the user clicks the login button -->
        <form method="post" action="loginProcess.php">
        
            Username: <input name="username" type="text"> <br>
            Password: <input type="password" name="password"> <br>
            <input type="submit" value="Login"> 
            
        </form>
           
  </div>
</div>             
            </footer>
        
        <script type="text/javascript" src="loginForm.js"> </script> <!-- login form script -->
        <script type="text/javascript" src="offersScript.js"></script> <!-- Offers script -->
        
    </body>

</html>
