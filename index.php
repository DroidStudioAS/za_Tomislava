<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Title Here</title>
    <!--Jquery import-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php require('models/user.php'); ?>
</head>
<body>
    <div id="registration-container">
    <form id="reg_form" action="">
        <input id="register_username" type="text" placeholder="username"/>
        <input id="register_password" type="password" placeholder="Password"/>
        <input id="register_email" type="email" placeholder="Email"/>
        <input id="register_age" type="number" placeholder="Age"/>
        <input id="register_trigger" type="submit" value="Submit">
    </form>
    </div>

    <div style="display:none;" id="login_container">
    <form action="">
        <input id="login_username" type="text" placeholder="username"/>
        <input id="login_password" type="password" placeholder="Password"/>
        <input id="login_trigger" type="submit" value="Submit">
    </form>

    </div>

    <div id="toggle_login_reg">Already Have An Account? Click Here To Login!</div>
    <script>
        let onRegister = true;

        //Ui references
        let toggleButton = $('#toggle_login_reg');
        let registrationContainer = $("#registration-container");
        let registrationForm = $("#reg_form")
        let loginContainer = $("#login_container");
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

        //asynch functions
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
                     console.log(response);
                 },
                 error: function (xhr, status, error) {
                     // Handle error
                     console.error(xhr.responseText);
                 }
             });
}


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
            registrationForm.submit(function(e){
                e.preventDefault();
                let user = {
                    username: registerUsername.val(),
                    password: registerPassword.val(),
                    email: registerEmail.val(),
                    age: registerAge.val(),
                    isAdmin: 0
                };
                // Send user data to the server
                sendUserData(registerUsername.val(), registerPassword.val(), registerEmail.val(), registerAge.val(), 0);
                console.log('obradi reg')
            })
        })
        

    </script>
</body>
</html>
