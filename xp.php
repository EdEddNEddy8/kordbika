<?php
// XP formula parameters
$baseXP = 100;
$exponent = 2.5;

// Generate XP table
$xpTable = [];
for ($level = 0; $level <= 1000; $level++) {
    $xpRequired = round($baseXP * pow($level, $exponent));
    $xpTable[$level] = $xpRequired;
}

// Print XP table
echo " `level`, `min_respect`\n";
echo "-------------------\n";
foreach ($xpTable as $level => $xpRequired) {
    echo sprintf("[ %5d, %11d\n]", $level, $xpRequired);
}
?>
