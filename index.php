<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Title Here</title>
    <!--Jquery import-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="public/styles.css"/>
    <?php require('models/user.php'); ?>
</head>
<body>
<div class="form-container" id="registration-container">
    <h2>User Registration</h2>
    <form id="reg_form" action="">
        <input id="register_username" type="text" placeholder="Username" required>
        <input id="register_password" type="password" placeholder="Password" required>
        <input id="register_email" type="email" placeholder="Email" required>
        <input id="register_age" type="number" placeholder="Age" required>
        <input id="register_trigger" type="submit" value="Register">
    </form>
</div>

<div class="form-container" id="login_container" style="display:none;">
    <h2>User Login</h2>
    <form id="login_form" action="">
        <input id="login_username" type="text" placeholder="Username" required>
        <input id="login_password" type="password" placeholder="Password" required>
        <input id="login_trigger" type="submit" value="Login">
    </form>
</div>

<div class="toggle-button" id="toggle_login_reg">
    Already Have An Account? Click Here To Login!
</div>
    <script>
        let onRegister = true;

        //Ui references
        let toggleButton = $('#toggle_login_reg');
        let registrationContainer = $("#registration-container");
        let registrationForm = $("#reg_form")
        let loginContainer = $("#login_container");
        let loginForm = $("#login_form")
        // Registration Form Inputs
        let registerUsername = $("#register_username");
        let registerPassword = $("#register_password");
        let registerEmail = $("#register_email");
        let registerAge = $("#register_age");
        let registerTrigger = $("#register_trigger");

        // Login Form Inputs
        let loginUsername = $("#login_username");
        let loginPassword = $("#login_password");
        let loginTrigger = $("#login_trigger");

        /********Helper Functions*******/
        //status 1-check reg input status 2-check login input
        function validateInput(status){
            if(status===1){
                if(registerUsername.val()==="" || registerPassword.val()==="" || registerEmail.val()==="" || registerAge.val()===""){
                    alert('Please Fill Out The Entire Registration Form')
                    return false;
                }
                if(registerPassword.val().length<6){
                    alert('For Your Safety, Select A Password That Is At Least 6 Charachters Long');
                    return false;
                }
                return true;

            }else if(status===2){
                if(loginUsername==="" || loginPassword===""){
                    alert('Please Fill Out The Entire Login Form')
                    return false;
                }
                return true;
            }
        }
    

        /*********Asynch Functions***********/
        // Function to send user data via AJAX
         function sendUserData(username, password, email, age, isAdmin) {
             $.ajax({
                 type: 'POST',
                 url: "api/user_register.php",
                 data: {
                     username: username,
                     password: password,
                     email: email,
                     age: age,
                     isAdmin: isAdmin
                 },
                 success: function (response) {
                     // Handle success response
                     if(response.includes('Error')){
                        alert('Oops... Something went wrong.. Please Try Again')
                     }else{
                        window.location.href="content.php"
                     }
                 },
                 error: function (xhr, status, error) {
                     // Handle error
                     console.error(xhr.responseText);
                 }
             });

            }
            function loginUser(username, password) {
                $.ajax({
                    type: 'POST',
                    url: "api/login_user.php",
                    data: {
                        username: username,
                        password: password
                    },
                    success: function(response) {
                       if(response==="Invalid username or password"){
                        alert('Invalid username or password')
                       }else{
                        //push to content.php
                        console.log(response)
                        window.location.href='content.php'
                       }
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
            }
        /*********End Of Asynch Functions***********/




        /*****OnClickListeners*****/
        //toggle button (switches between login and reg form)
        toggleButton.off('click').on('click',function(){
            onRegister=!onRegister;
            registrationContainer.toggle();
            loginContainer.toggle();

            console.log(onRegister);

            if(onRegister===true){
                toggleButton.text('Already Have An Account? Click Here To Login!')
            }else{
                toggleButton.text('Dont Have An Account? Click Here To Register!')
            }        
        })

        $('document').ready(function(){
            //registration
            registrationForm.submit(function(e){
                e.preventDefault();
                if(validateInput(1)){
                    // Send user data to the server
                    sendUserData(registerUsername.val(), registerPassword.val(), registerEmail.val(), registerAge.val(), 0);  
                }
                })
            //login
            loginForm.submit(function(e){
                e.preventDefault();
                if(validateInput(2)){
                  loginUser(loginUsername.val(),loginPassword.val());
                }

            })
        })
        

    </script>
</body>
</html>
