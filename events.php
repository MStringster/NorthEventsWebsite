<!-- Events Page -->
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
//If the session is logged in then display the logout button else display the login button
    if(isset($_SESSION["logged-in"]))
    {
        echo "<a href='logoutProcess.php' class='navBtns'> Logout </a>";
    }
    else
    {
        echo "<a id='loginBtn' class='navBtns'> Login </a>";
    }
?>

            </nav>

            <main>
            
                     
<!-- PHP SCRIPT STARTS HERE -->     
<?php
try
{
    require_once("functions.php"); //Pulling the function required to connect to the Database
    $dbConn = getConnection();
        
    //SQL query that will pull back all information about the events and order them by eventTitle
    $sqlQuery = "SELECT eventID, eventTitle, eventDescription, venueName, location, catDesc, eventStartDate, eventEndDate, eventPrice 
                 FROM NE_events
                 left JOIN NE_venue
                 ON NE_events.venueID = NE_venue.venueID
                 left JOIN NE_category
                 ON NE_events.catID = NE_category.catID
                 ORDER BY eventTitle";
    $queryResult = $dbConn->query($sqlQuery);
        
    //HTML of the Table created with 'divs' starts here. resp-table holds the tables while the table header holds all the column names as the cells within it.
    echo" 
        <div id='resp-table'>
                
            <div id='resp-table-header'> 
                <div class='table-header-cell'>Event Title </div>
                <div class='table-header-cell'>Venue </div>
                <div class='table-header-cell'>Location </div>
                <div class='table-header-cell'>Category </div>
                <div class='table-header-cell'>Start Date </div>
                <div class='table-header-cell'>End Date </div>
                <div class='table-header-cell'>Event Price </div>"; //End Echo
        
                //if the user is logged in then display the edit button
                if(isset($_SESSION["logged-in"]))
                {
                    echo "<div class='table-header-cell'>Edit </div>";
                }
    echo"
                    </div> 
                    <div id='resp-table-body'>"; //end Echo
                    //Headers of the Table end here and the populating of the table itself is generated from the database.
        
                        while($rowObj = $queryResult->fetchObject()) //While there are still objects in the database rows, keep repeating
                        {
                            echo"
                            <div class='resp-table-row'>
                        
                                <div class='table-body-cell'> 
                                    {$rowObj->eventTitle} 
                                </div>
                
                                <div class='table-body-cell'>
                                    {$rowObj->venueName}
                                </div>
                            
                                <div class='table-body-cell'>
                                    {$rowObj->location}
                                </div>
                                
                                <div class='table-body-cell'>
                                    {$rowObj->catDesc}
                                </div>
                                
                                <div class='table-body-cell'>
                                    {$rowObj->eventStartDate}
                                </div>
                                
                                <div class='table-body-cell'>
                                    {$rowObj->eventEndDate}
                                </div>
                            
                                <div class='table-body-cell'>
                                    £{$rowObj->eventPrice}
                                </div>"; 
                                
                                //If the user is logged in then display the echo button which will pass the details into the url to be used on the update page should the user click the link
                                if(isset($_SESSION['logged-in']))
                                {
                                    echo"
                                        <div class='table-body-cell'>
                                        <a href='editEventForm.php?eventID={$rowObj->eventID}&catDesc={$rowObj->catDesc}&venueName={$rowObj->venueName}' class='button' style='vertical-align:middle'>
                                            <span> Edit </span>
                                        </a>               
                                        </div>";
                                }
                        
                            echo "</div>"; 
                        } 
        

echo"
    </div> 
    </div>"; 
        
}
catch(Exception $e)
{
    echo "<p> Query Failed: ".$e->getMessage()."</p>\n";
}
      
?>
  
                                                
            </main>
 
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
        
    </body>

</html>
