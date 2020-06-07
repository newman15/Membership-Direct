/* 
Author:     Aaron Newman
Purpose:    Web Application JS Functions
Rights:     All rights reserved to Membership Direct Inc. 
Version:    1.0 
*/

// Test function
function login(){
    window.alert("Button has been clicked.");
}

// Changes Status Icon to Green to symbolize completion
function termsAgreeColor(){
    document.getElementById('terms-agreement').style.color='#05b80e';
}

// Changes status icon from warning to done
function termsAgreeIcon(){
    document.getElementById('terms-agreement').innerHTML='done_all';
}

// Function to confirm both passwords are the same in sign-up-page
function confirmPasswords(){
    if(document.getElementById('pswd').value == document.getElementById('pswd-verify').value){
        document.getElementById('message').style.color = 'green';
        document.getElementById('message').innerHTML = 'Passwords Match';
        document.getElementById('sign-up-btn').disabled = false;
    }
    else{
        document.getElementById('message').style.color = 'red';
        document.getElementById('message').innerHTML = 'Passwords do NOT match';
        document.getElementById('sign-up-btn').disabled = true;
    }
}

// Function that populates a drop down list of state names
function populateStates(){
    var states = ["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware",
                "Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky",
                "Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri",
                "Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina",
                "North Dakota","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota",
                "Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"];

    var select = document.getElementById('state');

    for(var i = 0; i < states.length; i++){
        var options = states[i];
        var element = document.createElement("option");
        element.textContent = options;
        element.value = options;
        select.appendChild(element);
    }
}

// Function that populates drop down of colors
function populateColors(){
    var colors = ["White", "Black", "Grey", "Yellow", "Red", "Blue", "Green",
                "Brown", "Pink", "Orange", "Purple"];

    var select = document.getElementById('vehicle-color');

    for(var i = 0; i < colors.length; i++){
        var options = colors[i];
        var element = document.createElement("option");
        element.textContent = options;
        element.value = options;
        select.appendChild(element);
    }
}

// jQuery for Terms and Conditions
function termsAndConditions(){
    $(document).ready(function(){
        $("#sign-up-btn").hide();
        $("#agree-btn").click(function(){
          $("#sign-up-btn").show();
        });
    });
}