<!-- HTML DOCUMENT -->
<!-- Developed By Michael Stringer -->

<!-- PHP to start a session and set the directory for the data to be saved -->
<?php
     ini_set("session.save_path", "/home/unn_w18019818/sessionData");
    session_start();
?>
<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <title> North Events </title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css" >
        <link href='https://fonts.googleapis.com/css?family=Cinzel Decorative' rel='stylesheet'>
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
            <a href='logoutProcess.php' class='navBtns'> Logout </a>
        </nav>
        
        <main>
            <div id="container">
<!-- START OF PHP SCRIPT -->
            
<?php 
list($input, $errors) = validate_input();
if($errors)
{
    echo show_errors($errors);
}
            
function validate_input()
{
    //check if the user is logged in, if not redirect to events page
    if(!isset($_SESSION["logged-in"]))
    {
        header ("location: events.php");
    }
    if(isset($_POST['submit']))
    {
    
        //Variables being passed and checked 
        $eventID = $_SESSION['eventID'];
        $eventTitle = filter_has_var(INPUT_POST, 'eventTitle') ? $_POST['eventTitle'] : null;
        $eventVenue = filter_has_var(INPUT_POST, 'eventVenue') ?$_POST['eventVenue'] : null;
        $eventCat = filter_has_var(INPUT_POST, 'eventCat') ? $_POST['eventCat'] : null;
        $eventStart = filter_has_var(INPUT_POST,'eventStart') ?$_POST['eventStart'] : null;
        $eventEnd = filter_has_var(INPUT_POST, 'eventEnd') ? $_POST['eventEnd'] : null;
        $eventPrice = filter_has_var(INPUT_POST, 'eventPrice') ? $_POST['eventPrice'] : null;
        $eventDesc = filter_has_var(INPUT_POST, 'eventDesc') ? $_POST['eventDesc'] : null;
    
        //Variables for event venue and event cat IDs
        $venueID = NULL;
        $catID = NULL;

        //Sanitizing the variables to prevent attacks on site
        $eventTitle = filter_var($eventTitle, FILTER_SANITIZE_SPECIAL_CHARS);
        $eventVenue = filter_var($eventVenue, FILTER_SANITIZE_SPECIAL_CHARS);
        $eventCat = filter_var($eventCat, FILTER_SANITIZE_SPECIAL_CHARS);
        $eventStart = filter_var($eventStart, FILTER_SANITIZE_SPECIAL_CHARS);
        $eventEnd = filter_var($eventEnd, FILTER_SANITIZE_SPECIAL_CHARS);
        $eventPrice = filter_var($eventPrice, FILTER_SANITIZE_SPECIAL_CHARS);
        $eventDesc = filter_var($eventDesc, FILTER_SANITIZE_SPECIAL_CHARS);
        
        //Prepare the ID for category to be imported into the database
        switch($eventCat)
        {
            case("Carnival"):
                $catID = "c1";
            break;
            case("Theatre"):
                $catID = "c2";
            break;
            case("Comedy"):
                $catID = "c3";
            break;
            case("Exhibition"):
                $catID = "c4";
            break;
            case("Festival"):
                $catID = "c5";
            break;
            case("Family"):
                $catID = "c6";
            break;
            case("Music"):
                $catID = "c7";
            break;
            case("Sport"):
                $catID = "c8";
            break;
            case("Dance"):
                $catID = "c9";
            break;
            default:
            break;
        }
    
        //Prepare the ID for venue to be imported into the database
        switch($eventVenue)
        {
            case("Theatre Royal"):
                $venueID = "v1";
            break;
            case("BALTIC Centre for Contemporary Art"):
                $venueID = "v2";
            break;
            case("Laing Art Gallery"):
                $venueID = "v3";
            break;
            case("The Biscuit Factory"):
                $venueID = "v4";
            break;
            case("Discovery Museum"):
                $venueID = "v5";
            break;
            case("HMS Calliope"):
                $venueID = "v6";
            break;
            case("Utilita Arena Newcastle"):
                $venueID = "v7";
            break;
            case("Mill Volvo Tyne Theatre"):
                $venueID = "v8";
            break;
            case("PLAYHOUSE Whitley Bay"):
                $venueID = "v9";
            break;
            case("Shipley Art Gallery"):
                $venueID = "v10";
            break;
            case("Seven Stories"):
                $venueID = "v11";
            break;
            default:
            break;
        }   
        
        //if CatID and venueID are null display an error, else prepare the inputs by trimming them to ensure no white space
        if($catID == null || $venueID == null)
        {
            echo 
                "<h2> Error </h2>
                <p> Something went wrong... Please go back and ensure that all fields are filled in. </p>";
        }
        else
        {
            $input = array($eventID, $eventTitle, $venueID, $catID, $eventStart, $eventEnd, $eventPrice, $eventDesc);
            $trimmedInput = array_map('trim', $input);
            $errors = array();
            $trimmedErrors = array_map('trim', $errors);
    
        //code that will check all the data entered by the user to be inserted into the database
        try
        {
            require_once("functions.php");
            $dbConn = getConnection();
                
            $sqlUpdate = "UPDATE NE_events
              SET eventTitle = :eventTitle, venueID = :venueID, catID = :catID, eventStartDate = :eventStart, eventEndDate = :eventEnd, eventPrice = :eventPrice, eventDescription = :eventDesc
              WHERE eventID = $eventID;";
            
            $stmt = $dbConn -> prepare($sqlUpdate);
        
            //if any of the entered details are empty then display the error that something is missing. Else run the code that will preform the update statement
            if(empty($eventTitle) || empty($eventStart) || empty($eventEnd) ||  empty($eventPrice) || empty($eventDesc))
            {
                echo "<h2> Error </h2> 
                     <p> Details Missing Please go Back and ensure that every field is complete </p>";
            }
            else
            {
            $stmt -> execute(array(':eventTitle' => $eventTitle, ':venueID' => $venueID, ':catID' => $catID, ':eventStart' => $eventStart, ':eventEnd' => $eventEnd, ':eventPrice' => $eventPrice, ':eventDesc' => $eventDesc));
            
            //Should the update go though then the all information the user entered will be printed to confirm to the user that it has updated successfully
            echo
            "<h2> Event ID: $eventID Successfully Updated </h2>
            <p> Title: $eventTitle </br> Venue: $eventVenue </br> Category: $eventCat </br> Start Date: $eventStart </br> End Date: $eventEnd </br> Price: &pound$eventPrice <br> Description: $eventDesc </p>
            ";
            }
        }
        catch(Exception $e)
        {
            echo "There was a problem: " . $e->getMessage();
        }
        }
        
    }
    else
    {
        echo "error";
    }
   echo "<a href='events.php' class='button'> Go Back </a>";
}
?>
            </div>        
        </main>
    </body>
</html>