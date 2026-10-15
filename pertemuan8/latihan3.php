<?php

function repeat($text, $num = 10)
{
    echo "<ol>";

    for ($i = 0; $i < $num; $i++) {
        echo "<li>$text</li>";
    }

    echo "</ol>";
}

// Dengan 2 parameter
repeat("I'm the best", 15);

// Dengan 1 parameter
repeat("You're the man");

?>