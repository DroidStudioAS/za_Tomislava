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
    <script>

        /*****Asynch Functions*******/
        function getAllUsers() {
              $.ajax({
                  type: 'GET',
                  url: 'api/fetch_user_data.php',
                  success: function(response) {
                      // Handle success response
                      console.log(response);
                      // Process the data as needed
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