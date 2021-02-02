//Offer Script
//Developed By Michael Stringer

//load everything when the user opens the window
window.addEventListener('load', function()
{
    //use strict javascript
   "use strict";
    
    //get the offer page and the XML version
    const URL_OFFERS = 'getOffers.php';
    const URL_OFFERS_XML = 'getOffers.php?useXML';
    
    //function starts here with Element, url and display, these are passed in by other piece of code to allow for reuse of code
    function fetchOffer(element, url, method)
    {
        //fetch the URL, then return the response as text, then log the data and display the element and data and if theres an error comes up then display the error
        fetch(url)
            .then
                ( 
                    function(response) 
                    { 
                        return response.text();
                    }
                )
            .then
                (
                    function(data) 
                    {
                        method(element, data);  
                    }
                ) 
            .catch
                (
                    function(err) 
                    {
                        document.getElementById(element).innerHTML = ("Something went wrong.", err); 
                    }
                );
    }
    
    //This code will change the offer ID into whatever the data returns
    let offerHTML = function(element, data)
    {
        document.getElementById(element).innerHTML = data;
    }
    
    //This code will use the XML document to display one of the offers
    let offerXML = function(element, data)
    {
        //parser and the XML document itself
        let parser = new DOMParser();
        let XMLDocument = parser.parseFromString(data, "text/xml");
        console.log(XMLDocument);
        //Three variables that will contain the data to be printed
        let eventTitle = XMLDocument.getElementsByTagName("eventTitle")[0].firstChild.data;
        
        let Category = XMLDocument.getElementsByTagName("catDesc")[0].firstChild.data;
        
        let price = XMLDocument.getElementsByTagName("eventPrice")[0].firstChild.data;
        
        document.getElementById(element).innerHTML = ("<h2>" + eventTitle + "</h2><p> Category: " + Category + "</p><p> Price: £" + price + "</p>");
    }
    //Code that calls back to the code and inserts the ID that will be changed, the variable containing the link to a page and finally which function to run. 
    fetchOffer("offers", URL_OFFERS, offerHTML);
    fetchOffer("XMLoffers", URL_OFFERS_XML, offerXML);
    
    //Timer to change the offers ID whenever 5 seconds pass
    setInterval( function(){ fetchOffer("offers", URL_OFFERS, offerHTML)}, 5000);

});