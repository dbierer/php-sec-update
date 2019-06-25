<?php
/**
 * PHP CSPRING Library Examples
 */

// Random bytes
echo "<h2>Random bytes</h2>";
$bytes = random_bytes(5);
echo "Random binary: $bytes";

echo "<h2>Random integers</h2>";
$int = random_int(500, 10000);
echo "Random integer: $int";