/* 
Author:     Aaron Newman
Purpose:    Web Application JS Functions
Rights:     All rights reserved to Membership Direct Inc. 
Version:    2.0 
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

// function checkTermsAgreement(){

// }