<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Faculty Scheduling System</title>

    <style>
      * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Open Sans", sans-serif;
}

body {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  width: 100%;
  padding: 0 10px;
  text-align: justify;
  font-style: italic;
}

body::before {
  content: "";
  position: absolute;
  width: 100%;
  height: 100%;
  background: url("image.jpg"), #000;
  background-position: center;
  background-size: cover;
}

.wrapper {
  width: 400px;
  border-radius: 8px;
  padding: 30px;
  text-align: center;
  border: 1px solid rgba(255, 255, 255, 0.5);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
}

form {
  display: flex;
  flex-direction: column;
}

h2 {
  font-size: 2rem;
  margin-bottom: 20px;
  color: #fff;
}

.input-field {
  position: relative;
  border-bottom: 2px solid #ccc;
  margin: 15px 0;
}

.input-field label {
  position: absolute;
  top: 50%;
  left: 0;
  transform: translateY(-50%);
  color: #fff;
  font-size: 16px;
  pointer-events: none;
  transition: 0.15s ease;
}

.input-field input {
  width: 100%;
  height: 40px;
  background: transparent;
  border: none;
  outline: none;
  font-size: 16px;
  color: #fff;
}

.input-field input:focus~label,
.input-field input:valid~label {
  font-size: 0.8rem;
  top: 10px;
  transform: translateY(-120%);
}


select {
  color:white;
  border: none; /* Remove default border */
  font-size:10px;
  background: transparent; /* Remove background color */
  outline: none; /* Remove focus outline */
  width: 100%; /* Optional: Match the input width */
  font-size: 16px; /* Match text size with input fields */
  padding: 5px 0; /* Adjust padding for alignment */
  padding-bottom: 20px;
  cursor: pointer; /* Change cursor to pointer */
  appearance: none; /* Remove default dropdown arrow (cross-browser) */
}

select:focus {
  border-bottom: 2px solid #007BFF; /* Highlight on focus */
}


select option:nth-child(1),
select option:nth-child(2),
select option:nth-child(3),
select option:nth-child(4),
select option:nth-child(5),select option:nth-child(6){
  color: black;
  background: white;
}
.custom-select{
  width:100%;
  border-bottom: 2px solid #ccc;
  display:inline-block;
}
/* Remove underline from the Sign-Up button and style it */
button {
  text-decoration: none; /* Removes underline */
  background: transparent;
  margin:15px;
  color: white; /* Button text color */
  border: solid; /* Removes border */
  padding: 5px 5px; /* Adjust padding for better spacing */
  font-size: 26px; /* Matches the text size */
  border-radius: 10px; /* Rounds corners */
  cursor: pointer; /* Adds pointer on hover */
}

/* Add hover effect to the button */
button:hover {
  background-color:#2b2525; /* Darken the button on hover */
}

/* Style the 'Already have an account?' link */
a {
  text-decoration: none; /* Removes underline */
  color: #007BFF; /* Matches the link color to the design */
  font-size: 14px; /* Matches the text size */
}

/* Add hover effect to the link */
a:hover {
  color: #0056b3; /* Darkens the link color on hover */
  text-decoration: underline; /* Adds underline on hover */
}
.twoText {
            display: flex;
            justify-content: space-between;
        }

    </style>

</head>

<body>

<?php
session_start();
include "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Set session variable
        $_SESSION['username'] = $username;
        header("Location: main.php"); // Redirect to the main page

    } else {
        echo "<script>alert('Invalid username or password');</script>";
    }
}
?>
 <center>
  <div class="wrapper">
      <h2>LOGIN</h2>
      <?php if (!empty($error)): ?>
        <p style="color: red; text-align: center;"><?= $error ?></p>
        <?php endif; ?>
        <form id="loginForm" method="POST" onsubmit="return validateForm()">
                   <div class="input-field">
                    <input type="text" name="username" id="" >
                    <label>username</label>
                  </div>
                    <div class="input-field">
                    <input type="password" name="password" >
                    <label>password</label>
                  </div>
                  <div class="twoText">
                        <div>
                            <input type="checkbox" name="remember" id="remember"> Remember me
                        </div>
                        <a href="#">Forgot password?</a><br>
      </div>
                    <div>
                      <a href="login.php">
                    <button type="submit">LOGIN</button>
</a>
</div>
                     <div>
                         <a href="signup.php">create an account</a>       
      </form>
</center>
</body>

</html>