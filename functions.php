<?php
//Home Page
//Developed By Michael Stringer

//PHP to start a session and set the directory for the data to be saved 
function getConnection()
{
    try
    {
        $connection = new PDO("mysql:host=localhost;dbname=unn_w18019818", 
                                "unn_w18019818", "OTDDNUZF");
        $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    }
    catch (Exception $e)
    {
        throw new Exception("Connection error". $e->getMessage(), 0, $e);
        
    }

} 
?>