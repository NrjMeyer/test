
function cleanUpperCase(str){
	new_str = str.toLowerCase();
	new_str = new_str.replace(/[àâä]/gi,"a");
	new_str = new_str.replace(/[éèêë]/gi,"e");
	new_str = new_str.replace(/[îï]/gi,"i");
	new_str = new_str.replace(/[ôö]/gi,"o");
	new_str = new_str.replace(/[ùûü]/gi,"u");
	new_str = new_str.toUpperCase();
	return new_str;
}

function cleanFirstname(str)
{  
  var i, n, new_str;
  n = str.length;
  if (n==0) {
    return str;
  }
  for(i=0; i<n; i++)
  {
    if (i!=0)
    {
      if(str.charAt(i-1)=="-" || str.charAt(i-1)=="\'" || str.charAt(i-1)==" ") 
      {
       if(str.charAt(i+1)=="-" || str.charAt(i+1)=="\'" || str.charAt(i+1)==" ") 
	{
         new_str = new_str + str.charAt(i).toLowerCase();
	} else {
         new_str = new_str + str.charAt(i).toUpperCase();
	}
      } else {
       new_str = new_str + str.charAt(i).toLowerCase();
      }
    }
    else
      new_str = str.charAt(0).toUpperCase();
  }
return new_str;
}






// JSONscriptRequest -- a simple class for accessing Yahoo! Web Services
// using dynamically generated script tags and JSON
//
// Author: Jason Levitt
// Date: December 7th, 2005
//
// A SECURITY WARNING FROM DOUGLAS CROCKFORD:
// "The dynamic <script> tag hack suffers from a problem. It allows a page 
// to access data from any server in the web, which is really useful. 
// Unfortunately, the data is returned in the form of a script. That script 
// can deliver the data, but it runs with the same authority as scripts on 
// the base page, so it is able to steal cookies or misuse the authorization 
// of the user with the server. A rogue script can do destructive things to 
// the relationship between the user and the base server."
//
// So, be extremely cautious in your use of this script.
//

// Constructor -- pass a REST request URL to the constructor
//
function JSONscriptRequest(fullUrl) {
    // REST request path
    this.fullUrl = fullUrl; 
    // Keep IE from caching requests
    this.noCacheIE = '&noCacheIE=' + (new Date()).getTime();
    // Get the DOM location to put the script tag
    this.headLoc = document.getElementsByTagName("head").item(0);
    // Generate a unique script tag id
    this.scriptId = 'YJscriptId' + JSONscriptRequest.scriptCounter++;
}

// Static script ID counter
JSONscriptRequest.scriptCounter = 1;

// buildScriptTag method
//
JSONscriptRequest.prototype.buildScriptTag = function () {

    // Create the script tag
    this.scriptObj = document.createElement("script");
    
    // Add script object attributes
    this.scriptObj.setAttribute("type", "text/javascript");
    this.scriptObj.setAttribute("src", this.fullUrl + this.noCacheIE);
    this.scriptObj.setAttribute("id", this.scriptId);
}
 
// removeScriptTag method
// 
JSONscriptRequest.prototype.removeScriptTag = function () {
    // Destroy the script tag
    this.headLoc.removeChild(this.scriptObj);  
}

// addScriptTag method
//
JSONscriptRequest.prototype.addScriptTag = function () {
    // Create the script tag
    this.headLoc.appendChild(this.scriptObj);
}







// postalcodes is filled by the JSON callback and used by the mouse event handlers of the suggest box
var postalcodes;

// this function will be called by our JSON callback
// the parameter jData will contain an array with postalcode objects
function getLocation(jData) {
  if (jData == null) {
    // There was a problem parsing search results
    return;
  }

  // save place array in 'postalcodes' to make it accessible from mouse event handlers
  postalcodes = jData.postalcodes;
    	
  if (postalcodes.length > 1) {
    // we got several places for the postalcode
    // make suggest box visible
    document.getElementById('suggestBoxElement').style.visibility = 'visible';
    var suggestBoxHTML  = '';
    // iterate over places and build suggest box content
    for (i=0;i< jData.postalcodes.length;i++) {
      // for every postalcode record we create a html div 
      // each div gets an id using the array index for later retrieval 
      // define mouse event handlers to highlight places on mouseover
      // and to select a place on click
      // all events receive the postalcode array index as input parameter
      suggestBoxHTML += "<div class='suggestions' id=pcId" + i + " onmousedown='suggestBoxMouseDown(" + i +")' onmouseover='suggestBoxMouseOver(" +  i +")' onmouseout='suggestBoxMouseOut(" + i +")'> " + postalcodes[i].postalcode + '    ' + postalcodes[i].placeName  +'</div>';
    }
    // display suggest box
    document.getElementById('suggestBoxElement').innerHTML = suggestBoxHTML;
  } else {
    if (postalcodes.length == 1) {
      // exactly one place for postalcode
      // directly fill the form, no suggest box required 
      var placeInput = document.getElementById("f2992");
      placeInput.value = postalcodes[0].placeName;
    }
    closeSuggestBox();
  }
}


function closeSuggestBox() {
  document.getElementById('suggestBoxElement').innerHTML = '';
  document.getElementById('suggestBoxElement').style.visibility = 'hidden';
}


// remove highlight on mouse out event
function suggestBoxMouseOut(obj) {
  document.getElementById('pcId'+ obj).className = 'suggestions';
}

// the user has selected a place name from the suggest box
function suggestBoxMouseDown(obj) {
  closeSuggestBox();
  var placeInput = document.getElementById("placeInput");
  placeInput.value = postalcodes[obj].placeName;
}

// function to highlight places on mouse over event
function suggestBoxMouseOver(obj) {
  document.getElementById('pcId'+ obj).className = 'suggestionMouseOver';
}


// this function is called when the user leaves the postal code input field
// it call the geonames.org JSON webservice to fetch an array of places 
// for the given postal code 
function postalCodeLookup() {

  var country = document.getElementById("f2993").value;

  if (geonamesPostalCodeCountries.toString().search(country) == -1) {
     return; // selected country not supported by geonames
  }
  // display 'loading' in suggest box
  document.getElementById('suggestBoxElement').style.visibility = 'visible';
  document.getElementById('suggestBoxElement').innerHTML = '<small><i>loading ...</i></small>';

  var postalcode = document.getElementById("f2991").value;

  request = 'http://api.geonames.org/postalCodeLookupJSON?postalcode=' + postalcode  + '&country=' + country  + '&callback=getLocation&username=apcfc';

  // Create a new script object
  aObj = new JSONscriptRequest(request);
  // Build the script tag
  aObj.buildScriptTag();
  // Execute (add) the script tag
  aObj.addScriptTag();
}

// set the country of the user's ip (included in geonamesData.js) as selected country 
// in the country select box of the address form
function setDefaultCountry() {
  var countrySelect = document.getElementById("f2993");
  for (i=0;i< countrySelect.length;i++) {
    // the javascript geonamesData.js contains the countrycode
    // of the userIp in the variable 'geonamesUserIpCountryCode'
    if (countrySelect[i].value == geonamesUserIpCountryCode) {
      // set the country selectionfield
      countrySelect.selectedIndex = i;
    }
  }
}

