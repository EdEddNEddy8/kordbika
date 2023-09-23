<?php
require "core.php";
head();
$uname = $_SESSION['username'];
$suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];


$currentDatetime = date('Y-m-d H:i:s');

// Check if the tournament is active
$tournamentQuery = mysqli_query($connect, "SELECT id, end_datetime FROM tournaments WHERE is_active = 1");
$tournamentData = mysqli_fetch_assoc($tournamentQuery);

if ($tournamentData && $currentDatetime > $tournamentData['end_datetime']) {
    // Tournament has ended, update status
    mysqli_query($connect, "UPDATE tournaments SET is_active = 0 WHERE id = " . $tournamentData['id']);

    // Retrieve top players
    $topPlayersQuery = mysqli_query($connect, "SELECT id, username FROM players WHERE reward_given = 0 ORDER BY points DESC LIMIT 5");

    $rewards = [
        ['dimants' => 500],
        ['dimants' => 300],
        ['dimants' => 150],
        ['dimants' => 100],
        ['dimants' => 50]
    ];

    $position = 1;

    while ($row = mysqli_fetch_assoc($topPlayersQuery)) {
        if ($position <= count($rewards)) {
            $reward = $rewards[$position - 1];
            $dimants = $reward['dimants'];

            // Add rewards to the player
            $updateResult = mysqli_query($connect, "UPDATE players SET dimants = dimants + $dimants, reward_given = 1, points = 0 WHERE id = " . $row['id']);
            if (!$updateResult) {
                echo "Error updating player rewards: " . mysqli_error($connect);
                // Handle the error appropriately
            }

            // Insert player and reward into the tournament_rewards table
            $insertResult = mysqli_query($connect, "INSERT INTO tournament_rewards (player_id, username, dimants) VALUES (" . $row['id'] . ", '" . $row['username'] . "', $dimants)");
            if (!$insertResult) {
                echo "Error inserting tournament rewards: " . mysqli_error($connect);
                // Handle the error appropriately
            }

            $position++;
        }
    }
}




?>




<div class="col-xs-12 well">
    <center><h2><i class="fa fa-trophy"></i> <?php
echo lang_key("tournament");
?></h2></center><br />
</div>
   
   
	
	<div class="col-xs-12 well">
	    <h5 class="text-center"><?php echo lang_key("t-prize1");?><img src="images/resi/dimants.png" ></h5>
	    <h5 class="text-center"><?php echo lang_key("t-prize2");?><img src="images/resi/dimants.png" ></h5>
	    <h5 class="text-center"><?php echo lang_key("t-prize3");?><img src="images/resi/dimants.png" ></h5>
	    <h5 class="text-center"><?php echo lang_key("t-prize4");?><img src="images/resi/dimants.png" ></h5>
	    <h5 class="text-center"><?php echo lang_key("t-prize5");?><img src="images/resi/dimants.png" ></h5>
	    
	    <br>
        <h5 class="text-center"><?php echo lang_key("t-rule1");?></h5>
        <h5 class="text-center"><?php echo lang_key("t-rule2");?></h5>
        <h5 class="text-center"><?php echo lang_key("t-rule3");?></h5>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Player</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $querygp = mysqli_query($connect, "SELECT * FROM players ORDER BY points DESC");
                $i = 1;
                while ($rowgp = mysqli_fetch_assoc($querygp)) {
                    echo '<tr>';
                    echo '<td>' . $i++ . '</td>';
                    echo '<td><img src="' . $rowgp['avatar'] . '" width="15%" />&nbsp;' . $rowgp['username'] . '</td>';
                    echo '<td>' . $rowgp['points'] . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

	

    



<?php
footer();
?>
