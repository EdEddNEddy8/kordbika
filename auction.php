<?php
require "core.php";
head();

$uname = $_SESSION['username'];
$suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if ($rowiz['termins'] == 0 && $rowiz['uzvaretajs_id'] == 0) {
    // Izsole ir beigusies un vēl nav noteikts uzvarētājs
    // Nosaka uzvarētāju, piemēram, pēdējo solītāju ar augstāko solījumu
    $queryLastBidder = mysqli_query($connect, "SELECT player_id FROM `solijumi` WHERE izsoles_id = '$izsole_id' ORDER BY solijums DESC LIMIT 1");
    $rowLastBidder = mysqli_fetch_assoc($queryLastBidder);

    if (!empty($rowLastBidder['player_id'])) {
        $uzvaretajs_id = $rowLastBidder['player_id'];
        
        // Atjauno izsoles ierakstu ar uzvarētāja ID
        $updateIzsole = mysqli_query($connect, "UPDATE `izsoles` SET uzvaretajs_id='$uzvaretajs_id', termins=0 WHERE id='$izsole_id'");
        
        // Iegūst preces informāciju
        $item = $rowiz['item'];
        
        // Pievieno mantu uzvarētāja inventāram
        $addItemQuery = mysqli_query($connect, "INSERT INTO `player_inventory` (player_id, item) VALUES ('$uzvaretajs_id', '$item')");
        
        if ($updateIzsole && $addItemQuery) {
            // Izsole noslēgta, un uzvarētājs ir saņēmis mantu
            echo "Izsole ir beigusies, un uzvarētājs ir saņēmis mantu!";
        } else {
            echo "Kļūda, neizdevās nosūtīt mantu uz uzvarētāju.";
        }
    } else {
        echo "Izsole ir beigusies, bet nav solījumu.";
    }
}

if (isset($_POST['solit'])) {
    $solijums = (int) $_POST['solijums'];
    $izsole_id = (int) $_POST['izsole_id'];

    // Pārbaudam, vai izsole beidzās
    $queryiz = mysqli_query($connect, "SELECT * FROM `izsoles` WHERE id = '$izsole_id' LIMIT 1");
    $rowiz = mysqli_fetch_assoc($queryiz);

    if ($rowiz['termins'] > 0) {
        // Veicam solījumu tikai, ja izsole nav beigusies
        // Pārbaudiet, vai spēlētājam ir pietiekami daudz resursu, lai veiktu solījumu
        if ($rowu[$rowiz['resurss']] >= $solijums) {
            // Ja solījums veikts veiksmīgi, atjaunojam izsoli un datu bāzi
            $new_daudzums = $rowiz['daudzums'] + $solijums;
            $update_izsole = mysqli_query($connect, "UPDATE `izsoles` SET daudzums='$new_daudzums' WHERE id='$izsole_id'");
            $rowu[$rowiz['resurss']] -= $solijums;
            $update_spelētājs = mysqli_query($connect, "UPDATE `players` SET {$rowiz['resurss']}={$rowu[$rowiz['resurss']]} WHERE id='$player_id'");
        }
    }
} elseif (isset($_POST['solit1000'])) {
    $solijums = 1000; // Šeit norādīsim, ka solījums ir 1000, ja tiek izvēlēta "Solīt +1000"
    $izsole_id = (int) $_POST['izsole_id'];

    // Pārbaudam, vai izsole beidzās
    $queryiz = mysqli_query($connect, "SELECT * FROM `izsoles` WHERE id = '$izsole_id' LIMIT 1");
    $rowiz = mysqli_fetch_assoc($queryiz);

    if ($rowiz['termins'] > 0) {
        // Veicam solījumu tikai, ja izsole nav beigusies
        // Pārbaudiet, vai spēlētājam ir pietiekami daudz resursu, lai veiktu solījumu
        if ($rowu[$rowiz['resurss']] >= $solijums) {
            // Ja solījums veikts veiksmīgi, atjaunojam izsoli un datu bāzi
            $new_daudzums = $rowiz['daudzums'] + $solijums;
            $update_izsole = mysqli_query($connect, "UPDATE `izsoles` SET daudzums='$new_daudzums' WHERE id='$izsole_id'");
            $rowu[$rowiz['resurss']] -= $solijums;
            $update_spelētājs = mysqli_query($connect, "UPDATE `players` SET {$rowiz['resurss']}={$rowu[$rowiz['resurss']]} WHERE id='$player_id'");
        }
    }
    
}
if (isset($_POST['solit100'])) {
    $solijums = 100; // Šeit norādīsim, ka solījums ir 1000, ja tiek izvēlēta "Solīt +1000"
    $izsole_id = (int) $_POST['izsole_id'];

    // Pārbaudam, vai izsole beidzās
    $queryiz = mysqli_query($connect, "SELECT * FROM `izsoles` WHERE id = '$izsole_id' LIMIT 1");
    $rowiz = mysqli_fetch_assoc($queryiz);

    if ($rowiz['termins'] > 0) {
        // Veicam solījumu tikai, ja izsole nav beigusies
        // Pārbaudiet, vai spēlētājam ir pietiekami daudz resursu, lai veiktu solījumu
        if ($rowu[$rowiz['resurss']] >= $solijums) {
            // Ja solījums veikts veiksmīgi, atjaunojam izsoli un datu bāzi
            $new_daudzums = $rowiz['daudzums'] + $solijums;
            $update_izsole = mysqli_query($connect, "UPDATE `izsoles` SET daudzums='$new_daudzums' WHERE id='$izsole_id'");
            $rowu[$rowiz['resurss']] -= $solijums;
            $update_spelētājs = mysqli_query($connect, "UPDATE `players` SET {$rowiz['resurss']}={$rowu[$rowiz['resurss']]} WHERE id='$player_id'");
        }
    }
}


?>









<!-- Game CSS -->
    <link href="assets/css/auction.css" rel="stylesheet">
    
<div id="wrapper">
    
    <div class="col-md-12 well">
        <center>
            <h2><i class="fa fa-shopping-cart"></i> <?php echo lang_key("izsole"); ?></h2>
        </center>
                    <div class="row">
                        <?php
                        $queryi = mysqli_query($connect, "SELECT izsoles.*, players.username AS solitajs_username, TIMESTAMPDIFF(SECOND, NOW(), izsoles.beigsies) AS term_diff FROM `izsoles` LEFT JOIN `players` ON izsoles.uzvaretajs_id = players.id WHERE item_id ");
                        $queryi = mysqli_query($connect, "SELECT izsoles.*, players.username AS solitajs_username FROM `izsoles` INNER JOIN `players` ON izsoles.player_id = players.id WHERE item_id ");
                        while ($rowi = mysqli_fetch_assoc($queryi)) {
                            ?>

                            <div class="col-md-4">
                                <center>
                                    <ul class="breadcrumb">
                                        <li class="active">
                                            <h4><?php echo $rowi['item']; ?></h4>
                                        </li>
                                    </ul>
                                </center>
                                <div class="row" >
                                    <div class="col-md-6">
                                    <div class="gold-item-frame">
                                        <center>
                                            <div class="item-image-frame">
                                                <img src="<?php echo $rowi['image']; ?>" width="100">
                                            </div>
                                        </center>
                                    </div>
                                    <ul class="list-group">
                                        <li class="list-group-item active">
                                            <center class="gold-item-details"><?php echo lang_key("item-details"); ?></center>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="badge badge-success"><?php echo $rowi['daudzums']; ?> <?php echo $rowi['resurss']; ?> </span>
                                            <i class="far fa-inbox"></i> <?php echo lang_key("izvēlēetais resurs"); ?>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="badge badge-info"><?php echo $rowi['solitajs_username']; ?></span>
                                            <i class="fa fa-server"></i> <?php echo lang_key("solītājs"); ?>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="badge badge-info"><?php echo $rowi['termins']; ?></span>
                                            <i class="fa fa-server"></i> <?php echo lang_key("beigsies"); ?>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="badge badge-info"><?php echo $rowi['term_diff']; ?> <?php echo lang_key("seconds-left"); ?></span>
                                            <i class="fa fa-server"></i> <?php echo lang_key("time-left"); ?>
                                        </li>
                                    </ul>
                                    <form method="post" action="auction.php">
                                            <input type="hidden" name="izsole_id" value="<?php echo $rowi['id']; ?>">
                                            <button type="submit" name="solit1000" class="red-button">Solīt +1000</button>
                                            <button type="submit" name="solit100" class="red-button">Solīt +100</button>
                                        </form>

                                        <a href="#" class="red-button" data-toggle="modal" data-target="#itemStatsModal">
                                            <i class="fas fa-info-circle"></i> <?php echo lang_key("view-item-stats"); ?>
                                        </a>
                                </div>
                                
                                </div>
                            </div>
                                        
                                        
                            <!-- Modal for Item Stats -->
<div class="modal fade" id="itemStatsModal" tabindex="-1" role="dialog" aria-labelledby="itemStatsModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="itemStatsModalLabel">
                    <?php echo $rowi['item']; ?> <?php echo lang_key("stats"); ?>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <center>
                    <div class="item-image-frame">
                        <img src="<?php echo $rowi['image']; ?>" width="50">
                    </div>
                </center>
                <p><strong><?php echo lang_key("power"); ?>:</strong> <?php echo $rowi['power']; ?></p>
                <p><strong><?php echo lang_key("agility"); ?>:</strong> <?php echo $rowi['agility']; ?></p>
                <p><strong><?php echo lang_key("endurance"); ?>:</strong> <?php echo $rowi['endurance']; ?></p>
                <p><strong><?php echo lang_key("intelligence"); ?>:</strong> <?php echo $rowi['intelligence']; ?></p>
            </div>
        </div>
    </div>
</div>


                            <?php
                        }
                        ?>
                    </div>
                </div>
          
        </div>


<?php
footer();
?>
