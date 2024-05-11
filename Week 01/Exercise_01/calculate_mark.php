<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve marks from the form
    $cw1 = $_POST["cw1"];
    $cw2 = $_POST["cw2"];

    // Check if the marks are within the valid range (0-100)
    if ($cw1 >= 0 && $cw1 <= 100 && $cw2 >= 0 && $cw2 <= 100) {
        // Calculate the overall module mark
        $overallMark = ($cw1 * 0.4) + ($cw2 * 0.6);
        // Display the result to the user
        echo "<h2>Your Overall Module Mark:</h2>";
        echo "<p><strong>Coursework 1 Mark:</strong> $cw1</p>";
        echo "<p><strong>Coursework 2 Mark:</strong> $cw2</p>";
        echo "<p><strong>Overall Module Mark:</strong> $overallMark</p>";
    } else {
        // Display an error message if the input is invalid
        echo "<h2>Error:</h2>";
        echo "<p>Invalid input. Marks must be between 0 and 100.</p>";
    }

}


