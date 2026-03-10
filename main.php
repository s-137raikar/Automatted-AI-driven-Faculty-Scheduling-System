<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Scheduling System</title>
    <style>
        body {
            margin: 0;
            height: 100vh; /* Full viewport height */
            display: flex;
            flex-direction: column; /* Stack the heading and columns vertically */
            background: url("image.jpg"), #000;
            background-position: center;
            background-size: cover;
        }

        .heading-container {
            display: flex;
            justify-content: center; /* Center the heading horizontally */
            margin-top: 20px; /* Space from the top of the page */
            font-size: 18px;
            font-style: italic;
            color: blue; /* Updated font color to blue */
            background-colo1r:rgb(168, 190, 188);

        }

        .heading {
            font-size: 2em;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
        }

        .columns-container {
            flex-grow: 1; /* Take the remaining space to ensure proper centering */
            display: flex;
            justify-content: center; /* Center columns horizontally */
            align-items: center; /* Center columns vertically */
          
       

        }

        .div {
            
            width:350px; /* Increased width */
            height: 450px; /* Increased height */
            color: white; /* Text color */
            display: flex;
            justify-content: center; /* Center text horizontally inside column */
            align-items: center; /* Center text vertically inside column */
            border-radius: 10px; /* Optional rounded corners */
            text-transform: uppercase; /* Make text uppercase */
            font-weight: bold;
            margin: 0 20px; /* Increased spacing between the columns */
            border: 1px solid rgba(255, 255, 255, 0.5);
          backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  font-size: 38px;
  font-style: italic;
  overflow: fit;
        }

        a:link, a:visited, a:hover, a:active {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php
         include "db.php";
    ?>
    <div class="heading-container">
        <h1 class="heading">SCHEDULING</h1>
    </div>
    <div class="columns-container">
        <a href="adminsignin.php">
            <div class="div"><h1>ADMIN</h1>
            <!-- <hr>
            <ul>
            <li>Faculty</li>
            <li>Batches</li>
            <li>Schedule</li>
            <li>view_Assignments</li>

        </ul> -->
        </div>
        
        </a>
        <a href="user.php">
            <div class="div"><h1>USERS</h1></div>
        </a>
    </div>
</body>
</html>