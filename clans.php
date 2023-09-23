<?php
require "core.php";
head();

if (isset($_GET['clan-id']) && is_numeric($_GET['clan-id'])) {
    $clanId = (int)$_GET['clan-id'];

    // Query clan information
    $clanQuery = mysqli_query($connect, "SELECT * FROM `clans` WHERE id='$clanId' LIMIT 1");
    $clanInfo = mysqli_fetch_assoc($clanQuery);

    if ($clanInfo) {
        // Query clan members
        $clanMembersQuery = mysqli_query($connect, "SELECT * FROM `players` WHERE clan_id='$clanId'");

        echo '<div id="wrap">';
        echo '<div class="row well">';
        echo '<h2>' . $clanInfo['name'] . '</h2>';
        echo '<img src="' . $clanInfo['avatar'] . '" width="100px" alt="' . $clanInfo['name'] . ' Avatar">';
        echo '<p>Leader: ' . $clanInfo['leader_username'] . '</p>';
        echo '</div>';

        echo '<div class="row well">';
        echo '<h3>Clan Members</h3>';

        

        echo '</div>';

        echo '</div>'; // Closing wrap div
    } else {
        echo '<p>Clan not found.</p>';
    }
} else {
    echo '<p>Invalid clan ID.</p>';
}

footer();
?>