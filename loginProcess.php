<!-- Login Process Script -->
<!-- Developed By Michael Stringer -->

<!-- PHP to start a session and set the directory for the data to be saved -->
<?php
    ini_set("session.save_path", "/home/unn_w18019818/sessionData");
    session_start();

    list ($input, $errors) = validate_logon();
    if($errors) 
    {
        echo show_errors($errors);    
    }

    
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
                <!-- PHP STARTS HERE -->
                <?php
                   function validate_logon() //Function to validate the users login
                {

                    //Check the User has entered a Username and Password
                    $username = filter_has_var(INPUT_POST, 'username') ? $_POST['username'] : null;
                    $password = filter_has_var(INPUT_POST, 'password') ? $_POST['password'] : null;
                
                    //Take the input from the User and then trim it to eleminate white space, do the same with the errors
                    $input = array($username, $password);
                    $trimmed_input = array_map('trim', $input);
                    $errors = array();
                    $trimmed_errors = array_map('trim', $errors);
                       
                    try
                    {
                        //database connection 
                        require_once("functions.php"); 
                        $dbConn = getConnection();
                        
                        //select the password hash to be checked, from the NE_users table, where the username is the same as the entered username
                        $querySQL = "SELECT passwordHash 
                                     FROM NE_users 
                                     WHERE username = :username";
                        
                        $stmt = $dbConn -> prepare($querySQL);
                        $stmt -> execute(array(':username' => $username));
                        $user = $stmt->fetchObject();
                        
                        //if username exists then check if the password the user entered matches the hash, if it does then set the session to logged in variable to true and redirect them to the events page, if the user or password doesnt match up then redirect to the index page
                        if($username)
                        {
                            $passwordHash = $user->passwordHash;
                            
                            if(password_verify($password, $passwordHash))
                            {
                                header("location: events.php");
                                $_SESSION["logged-in"] = "true";
                            }
                            else
                            {
                                header("location: index.php");
                            }
 
                            
                        }
                        else
                        {
                            header("location: index.php");
                        }
                           
                        }
                 catch (Exception $e)
                            {
                                echo "There was a problem: " . $e->getMessage();
                            }
                    
                }
                    function show_errors()
                    {
                        echo $errors;
                        
                        
                    }
                    
           
                ?>
                

            </main>
 
            <footer>
        
        
            </footer>
    </body>

</html>