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

    </style>

</head>

<body>

<?php
include "db.php";
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmpassword = trim($_POST['confirmpassword']);

    // Validate inputs
    if (empty($username) || empty($password)  || empty($name) || empty($email) || empty($confirmpassword)) {
        echo "<script>alert('All fields are required!'); window.location.href='signup.php';</script>";
        exit();
    } else if (strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters long!'); window.location.href='signup.php';</script>";
        exit();
    }
    else if ($password != $confirmpassword){
        echo "<script>alert('Password and Confirm password doesnt match !'); window.location.href='signup.php';</script>";
        exit();
    }

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username already exists. Please choose another!')</script>";
    } else {
        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO user (id ,name,email, username, password) VALUES (?,?, ?, ?, ?)");
        $stmt->bind_param("issss",$id,$name , $email, $username, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Registered Successfully !!!'); window.location.href='login.php';</script>";
        exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }



}
    ?>
 <center>
  <div class="wrapper">

      <h2>SIGNUP</h2>
      <form method="Post" action="">
        <div class="input-field">
                    <input type="text" name="name" >
                    <label>Name</label>
                </div>
                <div class="input-field">
                    <input type="email" id="email" name="email" >
                    <label>email</label>
                    </div>
                    <div class="input-field">
                    <input type="text" name="username" >
                    <label>username</label>
                    </div>
                    <div class="input-field">
                    <input type="password" name="password" >
                    <label>password</label>
                    </div>
                    <div class="input-field">
                    <input type="password" name="confirmpassword" >
                    <label>confirmpassword</label></div>
                    <!--  
                    <div class="custom-select" style="width:200px;">
                      <select name="usertype">
                        <option value="Designation">Designation:</option>
                       <option value="hod">HOD</option>
                        <option value="prof">Proffesor</option>
                        <option value="aprof">Associate Proffesor</option>
                        <option value="asprof">Assistant Proffesor</option>
                        <option value="stud">Student</option>
                      </select>
                    </div>-->
                    <div>
                    <button type="submit">Sign Up</button>
                    </div>
                    </form>
                     <div>
                         <a href="login.php">Already have an account?</a>       
                      </div>
                    </div>
                  </div>
               

            </div>

    

        </div>

    </div>
</div>
</center>
</body>

</html>