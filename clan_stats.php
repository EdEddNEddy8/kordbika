<?php
require "core.php";
head();

$clanid = $rowu['clan_id'];
$querygp = mysqli_query($connect, "SELECT * FROM players WHERE clan_id='$clanid'");
$membersStats = array(); // To store individual member stats

?>

<div class="container">
     <div class="row well">
        <center>
            <a class="btn btn-warning " href="clan_members.php" role="button"> <?php echo lang_key("clan-members");?> </a>
            <a class="btn btn-success " href="clan_bank.php" role="button">  <?php echo lang_key("clan-bank");?> </a>
            <a class="btn btn-danger " href="clan_stats.php" role="button">  <?php echo lang_key("clan-stats");?> </a>
            <a class="btn btn-info " href="clan_info.php" role="button">  <?php echo lang_key("clan-info");?> </a>
        </center>

        <hr>
        <center><h4><i class="fa fa-user"></i> Clan Member Stats</h4></center><br />
        <table id="dt-basic" class="table table-hover " cellspacing="0" width="100%">
            <thead class="thead-dark">
                <tr>
                    <th><i class="fa fa-user"></i> Player</th>
                    <th><i class="fa fa-trophy"></i> Power</th>
                    <th><i class="fa fa-running"></i> Agility</th>
                    <th><i class="fa fa-heart"></i> Endurance</th>
                    <!-- Add more columns for other stats -->
                </tr>
            </thead>
            <tbody>
                <?php
                while ($rowgp = mysqli_fetch_assoc($querygp)) {
                    // Store individual member stats
                    $membersStats[] = array(
                        'power' => $rowgp['power'],
                        'agility' => $rowgp['agility'],
                        'endurance' => $rowgp['endurance'],
                        // Add more stats here
                    );
                ?>
                    <tr>
                        <td>
                            <a href="player.php?id=<?php echo $rowgp['id']; ?>#focus" style="text-decoration: ">
                                <img src="<?php echo $rowgp['avatar']; ?>" width="50" />&nbsp;
                                <?php echo $rowgp['username']; ?>
                            </a>
                        </td>
                        <td><?php echo $rowgp['power']; ?></td>
                        <td><?php echo $rowgp['agility']; ?></td>
                        <td><?php echo $rowgp['endurance']; ?></td>
                        <!-- Add more columns for other stats -->
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <!-- Display Total Clan Stats -->
        <div class="row">
            <div class="col-md-12">
                <h4>Total Clan Stats:</h4>
                <?php
                $totalPower = $totalAgility = $totalEndurance = 0;

                foreach ($membersStats as $memberStats) {
                    $totalPower += $memberStats['power'];
                    $totalAgility += $memberStats['agility'];
                    $totalEndurance += $memberStats['endurance'];
                    // Calculate other stats here
                }

                echo "Total Power: " . $totalPower . "<br>";
                echo "Total Agility: " . $totalAgility . "<br>";
                echo "Total Endurance: " . $totalEndurance . "<br>";
                // Update Total Clan Stats in Database
$updateQuery = "UPDATE clans SET total_power = $totalPower, total_agility = $totalAgility, total_endurance = $totalEndurance WHERE id = $clanid";
mysqli_query($connect, $updateQuery);

                ?>
            </div>
        </div>
    </div>
</div>

<?php
footer();
?>
