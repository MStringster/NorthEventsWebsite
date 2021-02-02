<!-- Edit Event Form Page -->
<!-- Developed By Michael Stringer  -->

<!-- PHP to start a session and set the directory for the data to be saved -->
<?php
    ini_set("session.save_path", "/home/unn_w18019818/sessionData");
    session_start();
?>
<!DOCTYPE HTML>
<html>
    
    <head>
        <meta charset="utf-8">
        <title> North Events </title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css" >
        
        <!-- fonts used within the page taken from googleapis --> 
        <link href='https://fonts.googleapis.com/css?family=Cinzel Decorative' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
        <script type="text/javascript" src="change.js"> </script>
        
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
            <a href='logoutProcess.php' class='navBtns'> Logout </a>
        </nav>
        
        <main>
            
            <!-- PHP STARTS HERE -->
<?php
//Check to see if user is logged in, if they arent redirect them
if(!isset($_SESSION["logged-in"]))
{
    header ("location: events.php");
}
//try connecting to the Database, if it doesnt work then display error           
try
{
    require_once("functions.php");
    $dbConn = getConnection();
    
    //Variables
    $eventID = $_GET['eventID'];
    $category = $_GET['catDesc']; 
    $venue = $_GET['venueName'];
    $_SESSION["eventID"] = "$eventID";
            
    //Select those categorys from the table events and then join venue on the IDs and then do the same thing on Category, finishing up by only displaying the information that is relevent to the event ID
    $sqlQuery = "SELECT eventID, eventTitle, eventDescription, venueName, location, catDesc, eventStartDate, eventEndDate, eventPrice 
                 FROM NE_events
                 INNER JOIN NE_venue
                 ON NE_events.venueID = NE_venue.venueID
                 INNER JOIN NE_category
                 ON NE_events.catID = NE_category.catID
                 WHERE eventID = $eventID";
        
    $queryResult = $dbConn->query($sqlQuery);
		
    $rowObj = $queryResult->fetchObject();
    
    //Start Generating HTML page which will print the details of the event to be edited by the user
    echo"
        <h2> UPDATE ' {$rowObj-> eventTitle} ' </h2>
            
        <form action='update.php' method='post'>
                
            <fieldset>
                
                <h2> Event ID: $eventID </h2>
                    
                <legend> Edit Event Details </legend>
                    
            
                <label for='eventTitle'> EVENT TITLE 
                    <input type='text' value='{$rowObj->eventTitle}' id='eventTitle' name='eventTitle'>
                </label>"; //End Echo
                
                
                //Select venue from venue table where the venue name is NOT EQUAL to the currently stored venue
                $sqlQueryVenue = "SELECT venueID, venueName
                                  FROM NE_venue
                                  WHERE venueName != '$venue'";
    
                $queryResultVenue = $dbConn->query($sqlQueryVenue);
                $rowObjVenue = $queryResultVenue->fetchObject();
                    
    echo"       
                <label for='eventVenue'> EVENT VENUE
                    <select id='eventVenue' name='eventVenue' onchange='onChange()'>
                        <option value='$venue'> $venue </option>
                        
                        <option value='$rowObjVenue->venueName'> {$rowObjVenue->venueName} </option>"; //End Echo
        
                        while($rowObjVenue = $queryResultVenue->fetchObject()) //while there are rows in the database keep adding the data to the select box
                        {
                            echo "<option value='{$rowObjVenue->venueName}'> {$rowObjVenue->venueName} </option>";
                        }
                                  
    echo"           </select>";
                
            
                //Select category from category table where the category name is NOT EQUAL to the currently stored category
                $sqlQueryCategory = "SELECT catID, catDesc
                                     FROM NE_category 
                                     WHERE catDesc != '$category'";
            
                $queryResultCategory = $dbConn->query($sqlQueryCategory);
                $rowObjCategory = $queryResultCategory->fetchObject();
        
    echo"  
                <label for='catDesc'> EVENT CATEGORY
                    <select id='eventCat' name='eventCat'>
                        <option value='$category'> $category </option>
                        
                        <option value=#'{$rowObjCategory->catDesc}'> {$rowObjCategory->catDesc} </option>";  //end Echo
                                                                    
                        while($rowObjCategory = $queryResultCategory->fetchObject()) //while there are rows in the database keep adding the data to the select box
                        {
                            echo "<option value='{$rowObjCategory->catDesc}'> {$rowObjCategory->catDesc} </option>";
                        } 
            
    echo"  
                    </select>
                </label>
                
                <label for='eventStartDate'> START DATE 
                    <input type='date' id='eventStart' name='eventStart' value='{$rowObj->eventStartDate}'>
                </label>
                
                <label for='eventEndDate'> END DATE 
                    <input type='date' id='eventEnd' name='eventEnd'value='{$rowObj->eventEndDate}'>
                </label>
                
                <label for='eventPrice'> EVENT PRICE 
                    <input type='text' id=''eventPrice name='eventPrice' value='{$rowObj->eventPrice}'>
                </label>
                
                <label for='eventDesc'> EVENT DESCRIPTION 
                    <textarea id='eventDesc' name='eventDesc' type='text'>{$rowObj->eventDescription} </textarea>
                </label>
                
                <a href='events.php' class='button' style='vertical-align:middle'>
                    <span> Go Back </span> 
                </a>
                                        
                <input type='submit' class='button' value='SAVE' name='submit'> 
                
            </fieldset> 
                
        </form>"; //End echo + form

}//End Try
   
catch (Exception $e)
{
    echo "<p>Query failed: ".$e->getMessage()."</p>\n";
}
        
?>
            
            
        </main>
    </body>
</html>