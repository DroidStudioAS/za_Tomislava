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
    <h1>Hello, admin!</h1>
    <div class="user_container" id="user_container">

    </div>
    <div style="display: none;" id="edit_user_container" class="edit_user_container">
        <img id="close_btn" class="close_button" src="public/resources/close.png"/>
        <form class="edit_form">
            <h1 id="user_h"></h1>
            <input id="new_username_input" type="text" placeholder="Enter New Username">
            <input id="new_age_input" type="text" placeholder="Enter New Age"/>
            <input id="new_email_input" type="text" placeholder="Enter New Email"/>
            <h5 style="text-align:center">Make Admin?</h5>
            <div class="radio-group">
                <label for="make_admin"> Yes </label>
                <input id="make_admin" type="radio" name="make_admin" value="Yes">
                <label for="not_admin"> No </label>
                <input id="not_admin" type="radio" name="make_admin" value="No">
            </div>
            <input type="submit"/>
            <div>Change Users Password</div>
            <div>Delete User</div>
        </form>
    </div>
    <script>
        let userContainer = $("#user_container");
        let editContainer = $("#edit_user_container")
        let closeButton = $("#close_btn")
       
        /*****Helper functions******/
        function handleEditUser(user){
            console.log(user)
            editContainer.css('display','flex');
            $('#user_h').text("User: " + user.username)


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
            userElement.innerHTML = '<p>Username: ' + user.username + '</p>' +
                                '<p>Email: ' + user.email + '</p>' +
                                '<p>Age: ' + user.age + '</p>' +
                                '<p>Admin: ' + (user.isAdmin==1 ? 'Yes' : 'No') + '</p>'; // Display 'Yes' if isAdmin is 1, 'No' otherwise
;

            // Create edit button
            let editButton = document.createElement('button');
            editButton.textContent = 'Edit';
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
        /*****OnClickListeners******/
        closeButton.off('click').on('click',function(){
            editContainer.toggle()
        })
          
        

    
    $('document').ready(function(){
        getAllUsers();
       
    })
    </script>
</body>
</html>