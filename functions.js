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
        document.getElementById('message').innerHTML = 'Passwords do NOT match. Please retype password';
        document.getElementById('sign-up-btn').disabled = true;
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