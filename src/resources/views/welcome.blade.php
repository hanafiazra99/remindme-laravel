<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Login Page</title>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form id="loginForm">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="login()">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function login() {
        var username = $("#username").val();
        var password = $("#password").val();

        $.ajax({
            type: "POST",
            url: "/api/session", // Replace with your server-side script URL
            data: { email: username, password: password },
            success: function(response) {
                res = response;
                if (res.data.token) {
                    
                    // Save the token to localStorage or sessionStorage
                    localStorage.setItem('token', res.data.token);
                    
                    
                    document.location.href = '{{url("/reminder")}}'
                } else {
                    alert("Login failed. Please check your credentials.");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseJSON.message)
                
            }
        });
    }
</script>

</body>
</html>
