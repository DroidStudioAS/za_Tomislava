<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Title Here</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Your HTML content here -->
    <h1>Hello, admin!</h1>
    <div id="user_container">

    </div>
    <script>
        let userContainer = $("#user_container");

        function displayUsers(userData){
            let users = JSON.parse(userData)
            users.forEach(function(user){
                let userElement = document.createElement('div');
                userElement.innerHTML = '<p>Username: ' + user.username + '</p>' +
                                        '<p>Email: ' + user.email + '</p>' +
                                        '<p>Age: ' + user.age + '</p>';
                userContainer.append(userElement);           

            })
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

    $('document').ready(function(){
        getAllUsers();
    })
    </script>
</body>
</html>