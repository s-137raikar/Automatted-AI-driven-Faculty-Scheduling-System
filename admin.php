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
    flex-direction: column; /* Stack the heading and main content vertically */
    background-color: #f4f4f4; /* Optional background color */
    background: url("image.jpg"), #000;
            background-position: center;
            background-size: cover;
}

.heading-container {
    display: flex;
    justify-content: center; /* Center the heading horizontally */
    margin-top: 20px; /* Space from the top of the page */
    backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  font-size: 18px;
  font-style: italic;
  overflow: fit;
  text-align:center;
  color:black;
}

.heading {
    font-size: 2em;
    font-weight: bold;
    color: #333;
    text-transform: uppercase;
}

.main-container {
    flex-grow: 1; /* Take the remaining space to ensure proper layout */
    display: flex;
    justify-content: center; /* Center columns horizontally */
    align-items: center; /* Center columns vertically */
    gap: 20px; /* Space between the columns */
}

.div {
   
    width: 250px; /* Width of each column */
    height: 500px; /* Height of each column */
    color: white; /* Text color */
    display: flex;
    justify-content: center; /* Center text horizontally inside column */
    align-items: center; /* Center text vertically inside column */
    border-radius: 10px; /* Optional rounded corners */
    font-weight: bold;
    backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  font-size: 38px;
  font-style: italic;
  overflow: fit;
  text-align:center;
  
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
        <h1 class="heading">Faculty Scheduling System</h1>
    </div>
    <div class="main-container">
        <a href="faculty.php"><div class="columns-container">
            <div class="div">Faculty</div>
        </div></a>
        <a href="batches.php"><div class="columns-container">
            <div class="div">Batches</div>
        </div></a>
        <a href="schedule_faculty.php"><div  class="columns-container">
        <div class="div">Schedule Faculty</div>
        </div></a>
        <a href="view_assignments.php"><div  class="columns-container">
        <div class="div">View Assignments</div>
        </div></a>
        
</body>
</html>