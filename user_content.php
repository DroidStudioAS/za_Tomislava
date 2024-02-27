<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Title Here</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="public/styles.css"/>
</head>
<body>
    <!-- Your HTML content here -->
    <h1>Hello, user!</h1>
    <div id="user_data" class="user_data">

    </div>
    <div style="display: none;" id="edit_user_container" class="edit_user_container">
        <img id="close_btn" class="close_button" src="public/resources/close.png"/>
        <h6>Enter Your New Information</h6>
         <form class="edit_form">
            <h1 id="user_h"></h1>
            <input id="new_username_input" type="text" placeholder="Enter New Username">
            <input id="new_age_input" type="text" placeholder="Enter New Age"/>
            <input id="new_email_input" type="text" placeholder="Enter New Email"/>
            <input type="submit">
         </form>
         <div id="change_pass_toggle">Change Users Password</div>
         <div style="display: none;" id="change_pass_container" class="change_pass_container">
                <input id="new_pass" type="password">
                <input id="change_pass_trigger" type="submit">
            </div>
            <div id="delete_user_toggle">Delete User</div>
            <input style="display: none;" id="delete_trigger" type="submit" value="Are You Sure?"/>
    </div>
    <script>
        let closeButton = $("#close_btn")

        function handleEditClick(user){
            $("#edit_user_container").css('display','flex');

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
                        alert('Do Not Set An Empty String As A Password!')
                        return;
                    }else{
                        changePassword(user.id,$("#new_pass").val());
                    }
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
        })
    </script>
</body>
</html>