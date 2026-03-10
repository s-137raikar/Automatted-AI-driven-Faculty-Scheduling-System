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
    background-color: #f4f4f4; /* Optional background color */
}

.heading-container {
    display: flex;
    justify-content: center; /* Center the heading horizontally */
    margin-top: 20px; /* Space from the top of the page */
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

.main-container {
    flex-grow: 1; /* Take the remaining space to ensure proper layout */
    display: flex;
    justify-content: center; /* Center columns horizontally */
    align-items: center; /* Center columns vertically */
    gap: 20px; /* Space between the columns */
}

.div {
    background-color: #50c878; /* Green background */
    width: 150px; /* Width of each column */
    height: 200px; /* Height of each column */
    color: white; /* Text color */
    display: flex;
    justify-content: center; /* Center text horizontally inside column */
    align-items: center; /* Center text vertically inside column */
    border-radius: 10px; /* Optional rounded corners */
    text-transform: uppercase; /* Make text uppercase */
    font-weight: bold;
    margin: 0 10px; /* Spacing between the columns */
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
    <div class="main-container">
        <a href="view_assignments.php"><div  class="columns-container">
        <div class="div">USERS</div>
        </div></a>
</body>

</html>

        