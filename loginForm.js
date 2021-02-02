//Javascript Document
//Developed By Michael Stringer

// Variables to control the contact popup box including the popbox, button and close button
var loginPop = document.getElementById('login');
var loginBtn = document.getElementById("loginBtn");
var loginClose = document.getElementsByClassName("close")[0];
    
    //Use Strict Javascript
    "use strict"

    // When the user clicks the button, open the popup
    loginBtn.onclick = function() 
    {

            //display the contact popup box that has been hidden
            loginPop.style.display = "block";
          
    }

    // closes the popup if the user presses the close button
    loginClose.onclick = function() 
    {
        loginPop.style.display = "none";
    }

    // if the user clicks anywhere outside of the popup, close it
    window.onclick = function(event) 
    {
        if (event.target == loginPop) 
            {
                loginPop.style.display = "none";
            }
    }










	