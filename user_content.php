<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Content</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="public/styles.css"/>
</head>
<body>
    <h1>Hello, user!</h1>
    <!--Filled with the users data during runtime-->
    <div id="user_data" class="user_data">

    </div>
    <!--This Is the container for editing users, visible only if the dynamically generated edit button gets clicked-->
    <div style="display: none;" id="edit_user_container" class="edit_user_container">
    <img id="close_btn" class="close_button" src="public/resources/close.png"/>
    <form class="edit_form">
        <h1 id="user_h" class="user_heading"></h1>
        <div class="form_group">
            <label for="new_username_input" class="form_label">Enter New Username</label>
            <input id="new_username_input" type="text" class="form_input" placeholder="Enter New Username">
        </div>
        <div class="form_group">
            <label for="new_age_input" class="form_label">Enter New Age</label>
            <input id="new_age_input" type="number" class="form_input" placeholder="Enter New Age"/>
        </div>
        <div class="form_group">
            <label for="new_email_input" class="form_label">Enter New Email</label>
            <input id="new_email_input" type="email" class="form_input" placeholder="Enter New Email"/>
        </div>       
        <input id="edit_trigger" type="submit" class="submit_button" value="Edit"/>
        <div id="change_pass_toggle" class="form_label">Change Users Password</div>
        <div style="display: none;" id="change_pass_container" class="change_pass_container">
            <input id="new_pass" type="password" class="form_input">
            <input id="change_pass_trigger" type="submit" class="submit_button" value="Confirm">
        </div>
        <div id="delete_user_toggle" class="form_label">Delete User</div>
        <input style="display: none;" id="delete_trigger" type="submit" class="submit_button" value="Are You Sure?"/>
    </form>
    </div>
    <script>
        let closeButton = $("#close_btn")
        /*****Helper functions******/
        //gets activated when the edit button gets clicked for a user... displays the
        //edit container + sets all the onclicklisteners for the container
        function handleEditClick(user){
            $("#edit_user_container").css('display','flex');
            //set the input values to the users old data
            $('#new_username_input').val(user.username);
            $('#new_age_input').val(user.age);
            $('#new_email_input').val(user.email);
             //delete user logic
             $("#delete_trigger").off('click').on('click',function(e){
                deleteUser(user.id);
             });
             //edit password logic
             $("#change_pass_trigger").off('click').on('click',function(e){
                    e.preventDefault()
                    if($("#new_pass").val()===""){
                        //prevent sending empty new password
                        alert('Do Not Set An Empty String As A Password!')
                        return;
                    }else{
                        changePassword(user.id,$("#new_pass").val());
                    }
                })
            //edit user logic
            $("#edit_trigger").off('click').on('click',function(e){
                let isAdminValue = $('input[name="make_admin"]:checked').val();
                //prevent sending empty params
                if($("#new_username_input").val()==="" || $('#new_age_input').val()==="" || $("#new_email_input").val()===""){
                    e.preventDefault()
                    alert('please do not submit an empty field');
                    return
                }   
                //if this line is reached, no empty fields are present             
                editUser(user.id,$("#new_username_input").val(),$("#new_email_input").val(),$('#new_age_input').val(),0)  
                //reset this to fetch the user data on refresh    
                sessionStorage.setItem('username',$("#new_username_input").val())                
             })

        }
        //async Functions
        function changePassword(userId, newPassword) {
                $.ajax({
                    type: 'POST',
                    url: 'api/change_password.php',
                    data: {
                        userId: userId,
                        newPassword: newPassword
                    },
                    success: function(response) {
                        // Handle success response
                        alert('sucess');
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
            }
        function deleteUser(userId) {
            $.ajax({
                type: 'POST',
                url: 'api/delete_user.php',
                data: {
                    userId: userId
                },
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    window.location.href="index.php"
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                }
            });
        }
        function getUserData(userId) {
           $.ajax({
               type: 'GET',
               url: 'api/fetch_single_user.php',
               data: {
                   username: sessionStorage.getItem('username')
               },
               success: function(response) {
                   // Handle success response
                   console.log(response);
                   // Process the user data here
                   displayUserData(response);
               },
               error: function(xhr, status, error) {
                   // Handle error
                   console.error(xhr.responseText);
               }
           });
        }
        function editUser(userId, newUsername, newEmail, newAge, newIsAdmin) {
            $.ajax({
                type: 'POST',
                url: 'api/patch_user.php',
                data: {
                    userId: userId,
                    newUsername: newUsername,
                    newEmail: newEmail,
                    newAge: newAge,
                    newIsAdmin: newIsAdmin
                },
                success: function(response) {
                    // Handle success response
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                }
            });
        }
        function endAllSessions() {
        $.ajax({
            type: 'GET',
            url: 'api/end_session.php',
            success: function(response) {
                // Handle success response
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            }
        });
    }
        //helper functions
        function displayUserData(userData) {
            // Parse the JSON response
            const user = JSON.parse(userData);
            // Get the user data container
            const userDataContainer = $('#user_data');

            // Clear any existing content
            userDataContainer.empty();

            // Create HTML content to display user data
            const userDataHTML = `
                <p>Username: ${user.username}</p>
                <p>Email: ${user.email}</p>
                <p>Age: ${user.age}</p> `;

            // Append the HTML content to the user data container
            userDataContainer.append(userDataHTML);
            let editButton = document.createElement('button');
            editButton.textContent = 'Edit';
            // Add click event listener to edit button
            editButton.addEventListener('click', function() {
                // Call a function to handle edit action for this user
               handleEditClick(user);
            });

            // Append edit button to user element
            userDataContainer.append(editButton);
        }
        /****OnClickListeners******/
         /*****OnClickListeners******/
        closeButton.off('click').on('click',function(){
                    $("#edit_user_container").toggle()
                })
        $("#change_pass_toggle").off('click').on('click',function(){
                    $("#change_pass_container").toggle()
                })
        $("#delete_user_toggle").off('click').on('click',function(){
                    $("#delete_trigger").toggle()
                })
        $('document').ready(function(){
            getUserData();
            // Add event listener for beforeunload event
         
        })
    </script>
</body>
</html>