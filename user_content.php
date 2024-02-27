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
    <h1>Hello, user!</h1>
    <div id="user_data" class="user_data">

    </div>
    <script>
        //async Functions
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
               },
               error: function(xhr, status, error) {
                   // Handle error
                   console.error(xhr.responseText);
               }
           });
        }
        $('document').ready(function(){
            getUserData();
        })
    </script>
</body>
</html>