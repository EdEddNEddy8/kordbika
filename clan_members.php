<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_GET['yes-id'])) {
    $yes_id = (int) $_GET['yes-id'];
    $querds = mysqli_query($connect, "SELECT * FROM `clansjoin` WHERE id = '$yes_id' LIMIT 1");
    $rowfh = mysqli_fetch_assoc($querds);
    $cid=$rowfh['clan_id'];
    $phid=$rowfh['player_id'];
    $yesclan = mysqli_query($connect, "UPDATE `players` SET clan_id='$cid', clanjoin=0 WHERE id='$phid'");
    $yesi = mysqli_query($connect, "DELETE FROM `clansjoin` WHERE id='$yes_id'");
}

if (isset($_GET['no-id'])) {
    $no_id = (int) $_GET['no-id'];
    $quers = mysqli_query($connect, "SELECT * FROM `clansjoin` WHERE id = '$no_id' LIMIT 1");
    $rowh = mysqli_fetch_assoc($quers);
    $pid=$rowh['player_id'];
    $noclan = mysqli_query($connect, "UPDATE `players` SET clan_id=0, clanjoin=0 WHERE id='$pid'");
    $noi = mysqli_query($connect, "DELETE FROM `clansjoin` WHERE id='$no_id'");
}

if (isset($_GET['kick-id']) && $rowu['clan_role'] == 'Leader') {
    $kick_id = (int) $_GET["kick-id"];
    if ($rowu['id'] !== $kick_id) {
        $leaveclan = mysqli_query($connect, "UPDATE `players` SET clan_id=0, clanjoin=0, clan_role='Members' WHERE id='$kick_id'");
        echo '<meta http-equiv="refresh" content="0; url=clan_members.php" />';
    }
}

if (isset($_GET['id'])) {
    $cid     = $_GET['id'];
    $queryp = mysqli_query($connect, "SELECT * FROM `clans` WHERE id='$cid'  LIMIT 1");
}

if (isset($_GET['change-role']) && $rowu['clan_role'] == 'Leader') {
    $change_role_id = (int) $_GET["change-role"];
    if ($rowu['id'] !== $change_role_id) {
        // Fetch the current role of the player
        $querkp = mysqli_query($connect, "SELECT * FROM players WHERE id='$change_role_id'");
        $rowgpl = mysqli_fetch_assoc($querkp);
        $current_role = $rowgpl['clan_role'];
        
        // Determine the new role based on the current role
        $new_role = ($current_role == 'Officer') ? 'Member' : 'Officer';

        // Update the player's role
        $update_role = mysqli_query($connect, "UPDATE `players` SET clan_role='$new_role' WHERE id='$change_role_id'");
        echo '<meta http-equiv="refresh" content="0; url=clan_members.php" />';
    }
}

if (isset($_GET['delete-clan']) && $rowu['clan_role'] == 'Leader') {
    $delete_clan_id = (int) $_GET["delete-clan"];
    
    // Set leader's role and clan_id to null
    $update_leader = mysqli_query($connect, "UPDATE `players` SET clan_id=0, clan_role='Member' WHERE id='$player_id'");
    
    // Fetch all members of the clan before deleting it
    $querygp = mysqli_query($connect, "SELECT * FROM players WHERE clan_id='$delete_clan_id'");
    while ($rowgp = mysqli_fetch_assoc($querygp)) {
        $member_id = $rowgp['id'];
        $member_role = $rowgp['clan_role'];
        
        // Reset roles and clan_id for all members
        $reset_member = mysqli_query($connect, "UPDATE `players` SET clan_id=0, clan_role='Member' WHERE id='$member_id'");
    }
    
    // Delete the clan and related records from your database
    // Make sure to handle this deletion process carefully and securely
    $delete_clan_query = mysqli_query($connect, "DELETE FROM `clans` WHERE id='$delete_clan_id'");
    // Optionally, delete related data from other tables if needed
    // ...
    
    echo '<meta http-equiv="refresh" content="0; url=clan.php" />';
}

if (isset($_GET['leave-clan']) && in_array($rowu['clan_role'], ['Officer', 'Member'])) {
    // Get the player's ID
    $player_id = $rowu['id'];
    
    // Update the player's clan_id and role
    $leave_clan_query = mysqli_query($connect, "UPDATE `players` SET clan_id=0, clan_role='Member' WHERE id='$player_id'");
    
    if ($leave_clan_query) {
        // Successful update, redirect back to the home page or wherever you want
        header("Location: home.php");
        exit(); // Make sure to exit after a redirect
    } 
} 

?>

<div class="container">
    <div class="row well">
        <center>
            <a class="btn btn-warning " href="clan_members.php" role="button"> <?php echo lang_key("clan-members");?> </a>
            <a class="btn btn-success " href="clan_bank.php" role="button">  <?php echo lang_key("clan-bank");?> </a>
            <a class="btn btn-danger " href="clan_stats.php" role="button">  <?php echo lang_key("clan-stats");?> </a>
            <a class="btn btn-info " href="clan_info.php" role="button">  <?php echo lang_key("clan-info");?> </a>
        </center>
        
<?php
if ($rowu['clan_role'] < 'Officer') {
?>
        <div class="container">
            <div class="col-md-12 card bg-dark card-body">
                <center><h4>Applications</h4></center><br />
                <table id="dt-basic" class="table table-hover " cellspacing="0" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th> Player</th>
                            <th> Level</th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
<?php
$clanidg=$rowu['clan_id'];
$queryp = mysqli_query($connect, "SELECT * FROM clansjoin WHERE clan_id='$clanidg'");
$i       = 1;
while ($rowgj = mysqli_fetch_assoc($queryp)) {
    $plid=$rowgj['player_id'];
    $querkp = mysqli_query($connect, "SELECT * FROM players WHERE id='$plid'");
    $rowgpl = mysqli_fetch_assoc($querkp);
?>
                        <tr>
                            <td>
                                <a href="player.php?id=<?php echo $rowgpl['id']; ?>#focus" style="text-decoration: ">
                                    <img src="<?php echo $rowgpl['big_image']; ?>" width="50" />&nbsp;
                                    <?php echo $rowgpl['username']; ?>
                                </a>
                            </td>
                            <td><?php echo $rowgpl['level']; ?></td>
                            <td>
                                <a href="?yes-id=<?php echo $rowgj['id']; ?>" class="btn btn-success">
                                    Accept
                                </a>
                                <a href="?no-id=<?php echo $rowgj['id']; ?>" class="btn btn-danger">
                                    Decline
                                </a>
                            </td>
                        </tr>
<?php
}
?>
                    </tbody>
                </table>
            </div>
        </div>
<?php
}
?>
        <!-- ... (previous code) ... -->

        <hr>
        <center><h4><i class="fa "></i> Clan Members</h4></center><br />
        <table id="dt-basic" class="table table-hover " cellspacing="0" width="100%">
            <thead class="thead-dark">
                <tr>
                    <th><i class="fa fa-user"></i> Player</th>
                    <th><i class="fa fa-user"></i> Level</th>
                    <th><i class="fa fa-user"></i> Power</th>
                    <th><i class="fa fa-user"></i> Role</th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody>
<?php
$clanid=$rowu['clan_id'];
$querygp = mysqli_query($connect, "SELECT * FROM players WHERE clan_id='$clanid'");
while ($rowgp = mysqli_fetch_assoc($querygp)) {
?>
                <tr>
                    <td>
                        <a href="player.php?id=<?php echo $rowgp['id']; ?>#focus" style="text-decoration: ">
                            <img src="<?php echo $rowgp['avatar']; ?>"  />&nbsp;
                            <?php echo $rowgp['username']; ?>
                        </a>
                    </td>
                    <td><?php echo $rowgp['level']; ?></td>
                    <td><?php echo $rowgp['power']; ?></td>
                    <td><?php echo $rowgp['clan_role']; ?></td>
                    <td>
                        <?php if ($rowu['clan_role'] == 'Leader' && $rowgp['clan_role'] !== 'Leader') { ?>
                        <a href="?kick-id=<?php echo $rowgp['id']; ?>" class="btn btn-danger">
                            Kick
                        </a>
                        <a href="?change-role=<?php echo $rowgp['id']; ?>" class="btn btn-primary">
                            Change Role
                        </a>
                        
                        <!-- Role maiņa -->
                        <?php } elseif ($rowu['clan_role'] == 'Leader' && $rowgp['clan_role'] == 'Leader') { ?>
                        <a href="?delete-clan=<?php echo $clanid; ?>" class="btn btn-danger">
                            Delete Clan
                        </a>
                        
                        <?php } elseif ($rowgp['id'] == $player_id) { ?>
                <a href="?leave-clan=<?php echo $rowgp['id']; ?>" class="btn btn-warning">
                    Leave Clan
                </a>
                <?php } elseif ($rowu['clan_role'] == 'Officer' && $rowgp['clan_role'] == 'Member') { ?>
                <a href="?kick-id=<?php echo $rowgp['id']; ?>" class="btn btn-danger">
                    Kick
                </a>
                 <?php } ?>
                    </td>
                </tr>
<?php
}
?>
</tbody>
</table>
 <center><h4>Total Player Power: <?php echo getTotalPlayerPower($connect, $clanid); ?></h4></center>
</div>
</div>




<?php
footer();
?>
<?php
// Function to calculate total player power in a clan
function getTotalPlayerPower($connection, $clanId) {
    $totalPower = 0;
    $query = mysqli_query($connection, "SELECT power FROM players WHERE clan_id='$clanId'");
    
    while ($row = mysqli_fetch_assoc($query)) {
        $totalPower += $row['power'];
    }
    
    return $totalPower;
}
?>
