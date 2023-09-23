<?php
require "core.php";
head();

$uname = $_SESSION['username'];
$suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

// Creating a Clan
if (isset($_POST['create'])) {
    $clanname = $_POST['clan_name'];
    $avatarPath = 'images/clan_avatar/clan_house_default.jpg'; // Initialize the avatar path
    $player_username = $rowu['username'];

    // Update player's clan information
    $clan = mysqli_query($connect, "UPDATE `players` SET clanjoin=0, clan_role='Leader' WHERE id='$player_id'");

    // Handle the uploaded avatar
    if (isset($_FILES['clan_avatar']) && $_FILES['clan_avatar']['error'] === UPLOAD_ERR_OK) {
        $avatarName = $_FILES['clan_avatar']['name'];
        $avatarTmpPath = $_FILES['clan_avatar']['tmp_name'];
        $avatarPath = 'images/clan_avatar/' . $avatarName; // Set the actual path where the image will be stored
        move_uploaded_file($avatarTmpPath, $avatarPath);
    }

    // Rest of your code for inserting the clan into the database
    // ... (connect to database, prepare SQL query, etc.)

    // Add the avatar path to your insert query
    $insert = mysqli_query($connect, "INSERT INTO `clans` (`name`, `avatar`, `leader_id`, `leader_username`) VALUES ('$clanname', '$avatarPath', '$player_id', '$player_username')");

    if ($rowu['dimants'] >= 250) {
        $create_clan = mysqli_query($connect, "UPDATE `players` SET dimants = dimants - '250' WHERE id = '$player_id'");
        echo '<meta http-equiv="refresh" content="0;url=clan_members.php">';
    }
}

// Joining a Clan
if (isset($_GET['join-id'])) {
    if ($rowu['clanjoin'] > 0) {
        // Redirect if already applied
        echo '<meta http-equiv="refresh" content="0; url=clan_members.php" />';
        exit;
    } else {
        $joinid = (int) $_GET["join-id"];

        // Update player's clan join status
        $joinclan = mysqli_query($connect, "UPDATE `players` SET clanjoin='$joinid' WHERE id='$player_id'");

        // Insert join request
        $insert = mysqli_query($connect, "INSERT INTO `clansjoin` (`clan_id`, `player_id`, `accept`) VALUES ('$joinid', '$player_id', 0)");

        echo '<meta http-equiv="refresh" content="0; url=clan.php" />';
        exit;
    }
}

// Cancel Clan Join
if (isset($_POST['cancel'])) {
    $cancclan = mysqli_query($connect, "UPDATE `players` SET clan_id=0, clanjoin=0, clan_role='Officer' WHERE id='$player_id'");
    $cancelc = mysqli_query($connect, "DELETE FROM `clansjoin` WHERE player_id='$player_id'");
    echo '<meta http-equiv="refresh" content="0; url=clan.php" />';
    exit;
}

?>


    <div class="row well">
        <?php
        // Display the "Clan Members" and "Clan Bank" buttons only if player is in a clan
        if ($rowu['clan_id'] > 0) {
            echo '
            <div class="row well">
                <center>
                    <a class="btn btn-warning" href="clan_members.php" role="button">' . lang_key("clan-members") . '</a>
                    <a class="btn btn-success" href="clan_bank.php" role="button">' . lang_key("clan-bank") . '</a>
                    <a class="btn btn-danger" href="clan_stats.php" role="button">' . lang_key("clan-stats") . '</a>
                    <a class="btn btn-info" href="clan_info.php" role="button">' . lang_key("clan-info") . '</a>
                    <a class="w3-button w3-hover-red" href="clan_upg.php" role="button">' . lang_key("clan-upg") . '</a>
                </center>
            </div>';
            
            // Display the clan avatar and name in the center
            $clanInfo = mysqli_query($connect, "SELECT * FROM `clans` WHERE id='" . $rowu['clan_id'] . "' LIMIT 1");
            $clanRow = mysqli_fetch_assoc($clanInfo);
            
            echo '
            <div class="col-md-12 well text-center">
                <img src="' . $clanRow['avatar'] . '" width="20%" />
                <h2>' . $clanRow['name'] . '</h2>
            </div>';
        }
        ?>
        
        
        
    <div class="row well">       
           <?php
if ($rowu['clan_id'] == 0) {
    echo '
    <div class="row ">
        <div class="col-md-12 card bg-light card-body">
            <center><h2><i class="fa fa-gem"></i>' . lang_key("clan") . '</h2></center><br />
            <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#clan">
                <i class="fa fa-plus-square"></i>' . lang_key("create_clan") . '</button>
            </h2></center><hr /><br />
            <div id="clan" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" style="width: 100%;" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="clan_name" style="width: 100%;">' . lang_key("clan_name") . '</label>
                                    <input type="text" class="form-control" id="clan_name" name="clan_name" value="" required>
                                </div>
                                <div class="form-group">
                                    <label for="clan_avatar">' . lang_key("clan_avatar") . '</label>
                                    <input type="file" class="form-control-file" id="clan_avatar" name="clan_avatar">
                                </div>';
    
    if ($rowu['dimants'] > 250) {
        echo '<button type="submit" name="create" class="btn btn-warning btn-block">
            <i class="far fa-floppy"></i>&nbsp;' . lang_key("create_clan") . ' -250 <img src="images/resi/dimants.png" width="25%">
        </button>';
    } else {
        echo '<button class="btn btn-success btn-md col-12" disabled>' . lang_key("create_clan") . '</button>';
    }
    
    echo '
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';
        // ... Rest of the code ...
            
            if ($rowu['clanjoin'] > 0) {
    $clid = $rowu['clanjoin'];
    $querl = mysqli_query($connect, "SELECT * FROM clans WHERE id='$clid' LIMIT 1");
    $rowp = mysqli_fetch_assoc($querl);
    
    echo '<div class="col-md-12 well text-center">';
    echo '<img src="' . $rowp['avatar'] . '" width="75" />';
    echo '<h3><strong>You applied for clan: ' . $rowp['name'] . '</strong></h3>';
    echo '<form action="" method="post" style="width: 80%;" enctype="multipart/form-data">';
    echo '<button type="submit" name="cancel" class="btn btn-danger col-4"> Cancel it</button>';
    echo '</form>';
    echo '</div>';
}

            
            echo '
            <div id="all_clans" class="tab ';
            
            if ($tabonline == 'No') {
                echo 'show active';
            }
            
            echo '">
                <table id="dt-basic" class="table table-hover table-bordered" cellspacing="0" width="100%">
                    <thead class="thead-dark">
                        <th><i class="fa fa-user"></i> Clan Name</th>
                        <th><i class="fa fa-user"></i> Clan Region</th>
                        <th><i class="fa fa-user"></i> Clan Members</th>
                        <th><i class="fa fa-user"></i> Leader</th>
                        <th><i class="fa fa-user"></i> Action</th>
                    </thead>
                    <tbody>';
                    
            $querc = mysqli_query($connect, "SELECT * FROM clans ORDER BY id DESC");
            
            while ($rowgpco = mysqli_fetch_assoc($querc)) {
                $cid = $rowgpco['id'];
                $querygp = mysqli_query($connect, "SELECT * FROM `players` WHERE clan_id='$cid'");
                $countbiedri = mysqli_num_rows($querygp);
                
                echo '<tr>';
                echo '<td><a href="clan_info.php?id=' . $rowgpco['id'] . '"><img src="' . $rowgpco['avatar'] . '" width="5%" />&nbsp;' . $rowgpco['name'] . '</a></td>';
                echo '<td>&nbsp;' . $rowgpco['region'] . '</td>';
                echo '<td><i class="fa fa-users"></i> Members <span class="badge bg-info">' . $countbiedri . '</span> / 
                    <span class="badge bg-danger">' . $rowgpco['max_members'] . '</span></td>';
                echo '<td>&nbsp;' . $rowgpco['leader_username'] . '</td>';
                
                echo '<td>';
                
                if ($rowu['clanjoin'] > 0) {
                    echo '<button class="btn btn-danger btn-md col-12" disabled>' . lang_key("applied_for_clan") . '</button>';
                } elseif ($countbiedri >= $rowgpco['max_members']) {
                    echo '<button class="btn btn-danger btn-md col-12" disabled>' . lang_key("clan_full") . '</button>';
                } else {
                    echo '<a href="?join-id=' . $rowgpco['id'] . '" class="btn btn-danger btn-block">' . lang_key("join") . '</a>';
                }
                
                echo '</td>';
                echo '</tr>';
            }
            
            echo '</tbody></table></div>';
        }
        ?>
    </div>
    
    

    
    </div>


</div>
 



              

<?php
footer();
?>