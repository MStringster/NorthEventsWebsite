//Javascript Document
//Developed by: Michael Stringer

//everything on the page will be loaded when the user opens the window
window.addEventListener('load', function()
{
    //use of strict javascsript
    "use strict";
    
    //entire form variable
    const _form = document.getElementById('bookingForm');
    
    //Variables holding terms checkbox and text
    const _termsChkbx = document.querySelector("input[name='termsChkbx']");
    const _termsText = document.getElementById("termsText");
    
    //Variable holding submit button
    const _submitBtn = document.querySelector("input[name='submit']");
    
    //Variables holding the customer type select box and the two divs containing first name, surname (ret) and company name (trd)
    const _custType = document.querySelector("select[name='customerType']");
    const _retCust = document.getElementById("retCustDetails");
    const _trdCust = document.getElementById("tradeCustDetails");
    
    //Variables used to pull out the input fields for forename, surname and company name
    const _custFName = document.querySelector("input[name='forename']");
    const _custSName = document.querySelector("input[name='surname']");
    const _custCompany = document.querySelector("input[name='companyName']");

    //Variable used to pull all the events into an array
    const _events = document.querySelectorAll(".chosen input[type=checkbox]");
    
    //Variable used to control the collection section and the value stored within the delivery type
    const _collection = document.getElementById("collection");
    var _deliverType = _form.deliveryType.value;
    
    //Variables used for calculating and displaying the total price
    var _total = 0
    const _totaltxt = document.querySelector("input[name='total']");
    
    //variable for knowing how many events the user has selected
    var _totalSelected = 0;
    
    //Set forename and surname to hidden by default, thus forcing the user to select the customer type 
    _retCust.style.visibility = "hidden";
    
    //Intial value of total, as by default Home is the selected radio button by default
    _total = _total + 5.99;
    _totaltxt.value = _total.toFixed(2);
    
    //TASK D: used to change the amount displayed in total according to the collection method selected by the user. If user selects home then 5.99 will be added if they select pickup then the 5.99 will be removed (5.99 is an inital value stored within the total box so removing it should not cause issue, unless the default selection is removed)
    _collection.addEventListener('change', function()
    {
        _deliverType = _form.deliveryType.value;
        if(_deliverType == "home")
        {
            _total = _total + 5.99;
            _totaltxt.value = _total.toFixed(2);
        }
        else
        {
            _total = _total - 5.99;
            _totaltxt.value = _total.toFixed(2);
        }
    }); //Function End
    
    //TASK D: Function for calculating the total in a float formate restricted to 2 decimal places. This will pull back the data-price from the selected checkbox and then add it to a total which will then be converted into a 2 decimal place float and passed into the textbox displaying the total price. if the user unselects a checkbox then the same thing happens in inverse, removing the price rather than adding it
    var runningTotal = function()
    {
        var data = parseFloat(this.getAttribute("data-price"));
    
        if(this.checked)
            {
                _total = _total + data;
                _totaltxt.value = _total.toFixed(2);
                _totalSelected = _totalSelected + 1;
            }
        else
            {
                _total = _total - data;
                _totaltxt.value = _total.toFixed(2);
                _totalSelected = _totalSelected - 1;
            }
    }; //Function end
    
    //TASK D: Loop to add event listeners to all of the event checkboxes which will then run the running total function found above
    for (var i = 0; i < _events.length; i++)
        {
            _events[i].addEventListener('click', runningTotal, false);    
        }; //Loop end

    
    //TASK A: Event listener added to the terms checkbox which will activate a function that will change the colour of the text to black and set the font weight to normal, it will also run a function that will validate and ensure all the fields required to continue are filled otherwise the terms text will be returned to default and the box unchecked
    _termsChkbx.addEventListener('change', function() 
    {
        if(_termsChkbx.checked)
        {
            _termsText.style.color="black";
            _termsText.style.fontWeight="normal";
            
            validateForm();
        }
        else
        {
            uncheckbox(); 
        }
    }) //function End
    
    //TASK E: event listener added to the customer type select box which will then display the forename, surname inputs and hide the company name input if the user selects customer, if the user selects trade then the inverse will happen, forename and surname will be hidden while company name will be displayed. should the user select neither then all fields will be hidden.
    _custType.addEventListener('change', function()
    {
        if(_custType.value == "ret") //customer selected
            {
                _trdCust.style.visibility = "hidden";
                _retCust.style.visibility = "visible";
            }
        else if(_custType.value == "trd") //trade selected
            {
                _retCust.style.visibility = "hidden";
                _trdCust.style.visibility = "visible";
            }
        else
            {
                _retCust.style.visibility = "hidden";
                _trdCust.style.visibility = "hidden";
            }
    })
    //function End
    
    //Function to return the input boxes to White if the user forget to enter details before checking the terms box or clicking the submit button thus turning them red, this is not towards any task and is simply used to guide the user towards what they have forgotten
    _custFName.addEventListener('click', function()
    {
        _custFName.style.backgroundColor = "white"; //forename
    }) //Function end
    _custSName.addEventListener('click', function()
    {
        _custSName.style.backgroundColor = "white"; //surname
    }) //Function end
    _custCompany.addEventListener('click', function()
    {
        _custCompany.style.backgroundColor = "white"; //company name
    }) //Function end
    _custType.addEventListener('click', function()
    {
        _custType.style.backgroundColor = "white"; //customer type
    }) //Function End
    
    //Event listener used to ensure that the form is valid before submitting, failsafe in the event that the user should inspect element and force the submit button to become enabled
    _submitBtn.addEventListener('click', function()
    {
        validateForm();
    })
    
    //TASK B+C: function to ensure that the fields that need to be filled are filled, should the user not have selected a customer type, or not filled in the details required then the empty details, it will also run a function that will return the checkbox and text to its default state if data is missing or if the user has not selected any events. This code will also run should the user enable the submit box using inspect element
    function validateForm()
    {
    
        if(_custType.value == "ret")
            {
                if(_custFName.value.trim() == "")
                    {
                        uncheckbox();
                        alert("Error, forename missing");
                        _custFName.style.backgroundColor = "red";
                    }
                else if(_custSName.value.trim() == "")
                    {
                        uncheckbox()
                        alert("Error, Surname Missing");
                        _custSName.style.backgroundColor = "red";                      
                    }
                else
                    {
                        _submitBtn.disabled = false;
                    }
            }
        else if(_custType.value == "trd")
            {
                if(_custCompany.value.trim() == "")
                {
                    uncheckbox();
                    alert("Error, Company Name Missing");
                    _custCompany.style.backgroundColor = "red";
                }
                else
                    {
                        submitBtn.disabled = false;
                    }
            }
        else
            {
                uncheckbox();
                alert("Please select Customer Type");
                _custType.style.backgroundColor = "red";
            }
        //ensures user has selected an event
        if(_totalSelected == 0)
            {
                uncheckbox();
                alert("Please select an event using the checkboxes");
            }
    }
    //function End
    
    //function to uncheck the checkbox and return the terms text to default if something is missing from the form, thus disabling the submit button and resetting the terms text to its default style
    function uncheckbox()
    {
            _termsChkbx.checked = false;
            _termsText.style.color="red";
            _termsText.style.fontWeight="bold";    
            _submitBtn.disabled = true;
    }
    //function End
        
})
//Javascript End

