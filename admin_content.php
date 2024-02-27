<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Content</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="public/styles.css"/>
</head>
<body>
    <h1>Hello, admin!</h1>
    <!--This div gets dynamically filled with users fetched onPageLoad-->
    <div class="user_container" id="user_container">

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
        <h5 id="make_admin_header" class="form_label">Make Admin?</h5>
        <div id="radio-group" class="radio_group">
            <label for="make_admin" class="form_label">Yes</label>
            <input id="make_admin" type="radio" class="form_input" name="make_admin" value="Yes">
            <label for="not_admin" class="form_label">No</label>
            <input id="not_admin" type="radio" class="form_input" name="make_admin" value="No">
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
        let userContainer = $("#user_container");
        let editContainer = $("#edit_user_container")
        let closeButton = $("#close_btn")
       
        /*****Helper functions******/
        //gets activated when the edit button gets clicked for a user... displays the
        //edit container + sets all the onclicklisteners for the container
        function handleEditUser(user){
            console.log(user)
            editContainer.css('display','flex');
            $('#user_h').text("User: " + user.username)
            //set the values to the old value, so they can be sent as params to the patch
             $('#new_username_input').val(user.username);
             $('#new_age_input').val(user.age);
             $('#new_email_input').val(user.email);
             // Set the radio button for isAdmin based on the user's current isAdmin value
             if (user.isAdmin === 1) {
                 $('#make_admin').prop('checked', true);
             } else {
                 $('#not_admin').prop('checked', true);
             }
             //make the radio_group invisible if the admin is on his own account;
             if(sessionStorage.getItem('username')===$("#new_username_input").val()){
                $('#radio-group').css('display','none');
                $('#make_admin_header').css('display','none');
                $('#delete_user_toggle').css('display','none');
                $("#edit_trigger").css('display','none')
             }else{
                $('#radio-group').css('display','flex');
                $('#make_admin_header').css('display','block');
                $('#delete_user_toggle').css('display','block');
                $("#edit_trigger").css('display','block')

             }
             /*****Edit Form OnClickListeners****/
             //delete user logic
             $("#delete_trigger").off('click').on('click',function(e){
                deleteUser(user.id);
             });
             //edit password logic
             $("#change_pass_trigger").off('click').on('click',function(e){
                    if($("#new_pass").val()===""){
                        alert('Do Not Set An Empty String As A Password!')
                        e.preventDefault()
                        return;
                    }else{
                        changePassword(user.id,$("#new_pass").val());
                    }
                })
            //patch logic  (edits the user)
             $("#edit_trigger").off('click').on('click',function(e){
                let isAdminValue = $('input[name="make_admin"]:checked').val();
                if($("#new_username_input").val()==="" || $('#new_age_input').val()==="" || $("#new_email_input").val()==="" || $("input[name='make_admin']:checked").val()===undefined){
                    e.preventDefault();
                    alert('please do not submit an empty field');
                    return
                }else{
                    if(isAdminValue==="Yes"){
                        editUser(user.id,$("#new_username_input").val(),$("#new_email_input").val(),$('#new_age_input').val(),1)
                    }else{
                        editUser(user.id,$("#new_username_input").val(),$("#new_email_input").val(),$('#new_age_input').val(),0)
                    }
                }
                console.log(user.id +$("#new_username_input").val() +  $('#new_age_input').val() + $("#new_email_input").val() + $("input[name='make_admin']:checked").val())
             })
        }

        //render all users fetched by getAllUsers();
        function displayUsers(userData) {
            let users = JSON.parse(userData);
            users.forEach(function(user) {
            let userElement = document.createElement('div');
            userElement.className = 'user';
            if(user.isAdmin===0){
                console.log('not')
            }
            //Indicate to the admin which is his account;
            if(user.username===sessionStorage.getItem('username')){
                userElement.innerHTML = '<h3>Your Acount</h3>' +
                                '<p>Username: ' + user.username + '</p>' +
                                '<p>Email: ' + user.email + '</p>' +
                                '<p>Age: ' + user.age + '</p>' +
                                '<p>Admin: ' + (user.isAdmin==1 ? 'Yes' : 'No') + '</p>'; // Display 'Yes' if isAdmin is 1, 'No' otherwise
                                ;
            }else{
                userElement.innerHTML = '<p>Username: ' + user.username + '</p>' +
                                '<p>Email: ' + user.email + '</p>' +
                                '<p>Age: ' + user.age + '</p>' +
                                '<p>Admin: ' + (user.isAdmin==1 ? 'Yes' : 'No') + '</p>'; // Display 'Yes' if isAdmin is 1, 'No' otherwise
                                ;
            }

            // Create edit button
            let editButton = document.createElement('button');
            editButton.textContent = 'Edit';
            editButton.className = "submit_button"
            // Add click event listener to edit button
            editButton.addEventListener('click', function() {
                // Call a function to handle edit action for this user
                handleEditUser(user);
            });

            // Append edit button to user element
            userElement.append(editButton);

            // Append user element to container
            userContainer.append(userElement);
        });
    }


        /*****Asynch Functions*******/
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
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                }
            });
        }

        function getAllUsers() {
              $.ajax({
                  type: 'GET',
                  url: 'api/fetch_user_data.php',
                  success: function(response) {
                      // Handle success response
                      console.log(response);
                      //display the data
                      displayUsers(response);
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
                        alert('sucess')
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
            }

                /*****Global OnClickListeners******/
                closeButton.off('click').on('click',function(){
                    editContainer.toggle()
                })
                $("#change_pass_toggle").off('click').on('click',function(){
                    $("#change_pass_container").toggle()
                })
                $("#delete_user_toggle").off('click').on('click',function(){
                    $("#delete_trigger").toggle()
                })
               

            
          
        

    
    $('document').ready(function(){
        getAllUsers();
      
       
    })
    </script>
</body>
</html>