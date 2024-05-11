<?php

$studentMarks = array(
    "Samwise Gamgee" => 88,
    "Frodo Baggins" => 56,
    "Elrond Half-Elven" => 92,
    "Gandalf Mithrandir" => 35,
    "Merry Brandybuck" => 41,
    "Pippin Took" => 25,
    "Legolas Greenleaf" => 67
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve entered mark from the form
    $enteredMark = $_POST["enteredMark"];

    // Display students who got the entered mark and above
    echo "<h2>Students with Marks $enteredMark and Above:</h2>";
    echo "<ul>";
    foreach ($studentMarks as $student => $mark) {
        if ($mark >= $enteredMark) {
            echo "<li>$student - $mark</li>";
        }
    }
    echo "</ul>";

}
