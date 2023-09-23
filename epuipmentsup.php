<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_GET['item_id'])) {
    $item_id = (int)$_GET['item_id'];

    // Iegūstiet esošo līmeni un resursu informāciju no tabulas player_inventory
    $query = mysqli_query($connect, "SELECT level, max_level, equipped, stars, nolietojums FROM `player_inventory` WHERE player_id='$player_id' AND id='$item_id'");
    $row = mysqli_fetch_assoc($query);
    $currentLevel = (int)$row['level'];
    $maxLevel = (int)$row['max_level']; // Iegūstiet maksimālo līmeni no datu bāzes
    $equipped = (int)$row['equipped']; // Iegūstiet informāciju, vai prece ir uzvilkta
    $itemStars = (int)$row['stars']; // Iegūstiet zvaigžņu skaitu
    $nolietojums = (float)$row['nolietojums']; // Iegūstiet esošo nolietojumu

    $queryItemPrice = mysqli_query($connect, "SELECT dimants, zelts, koks, dzlzs, āda, akmens FROM `items` WHERE id='$item_id'");
    $rowItemPrice = mysqli_fetch_assoc($queryItemPrice);

    // Noteikt, kādus resursus izmantot atkarībā no līmeņa
    $resourceType = ($currentLevel <= 100) ? 'resursi_zelts_koks_dzelzs_āda_akmens' : 'dimants';

    $itemPrice = (int)$rowItemPrice[$resourceType]; // Izvēlēties atbilstošo resursu cenu

    // Pārbaudiet, vai prece nav uzvilkta un vai ierīce nav jau sasniedzusi maksimālo līmeni
    if ($equipped == 0 && $currentLevel < $maxLevel) {
        if (isset($_GET['action']) && $_GET['action'] === 'upgrade_resources') {
            // Izmantot resursus uzlabošanai
            $upgradeCost = $itemPrice; // Cenu iegūst no datu bāzes
        } elseif (isset($_GET['action']) && $_GET['action'] === 'upgrade_dimants') {
            // Izmantot dimantus uzlabošanai
            $upgradeCost = 100; // Cenu jūs varat pielāgot, cik daudz dimantu maksā uzlabošana
        } else {
            echo '<div class="alert alert-danger">Nederīga darbība!</div>';
            exit;
        }

        // Pārbaudiet, vai spēlētājam ir pietiekami daudz resursu, ņemot tos no players tabulas
        $queryResources = mysqli_query($connect, "SELECT dimants, zelts, koks, dzelzs, āda, akmens FROM `players` WHERE id='$player_id'");
        $rowResources = mysqli_fetch_assoc($queryResources);
        $dimants = (int)$rowResources['dimants'];
        $zelts = (int)$rowResources['zelts'];
        $koks = (int)$rowResources['koks'];
        $dzelzs = (int)$rowResources['dzelzs'];
        $āda = (int)$rowResources['āda'];
        $akmens = (int)$rowResources['akmens'];

        // Pārbaudiet, vai spēlētājam ir pietiekami daudz resursu
        if (
            ($_GET['action'] === 'upgrade_resources' && $zelts >= 1 && $koks >= 1 && $dzelzs >= 1 && $āda >= 1 && $akmens >= 1) ||
            ($_GET['action'] === 'upgrade_dimants' && $dimants >= $upgradeCost)
        ) {
            // Definējiet iespējamību uzlabot atkarībā no zvaigžņu skaita
            $upgradeProbability = 0; // Sākotnēji nav iespējas uzlabot

            if ($itemStars == 0) {
                $upgradeProbability = 10; // 10% iespēja uzlabot, ja nav zvaigžņu
            } elseif ($itemStars == 1) {
                $upgradeProbability = 30; // 30% iespēja uzlabot, ja ir 1 zvaigzne
            } elseif ($itemStars == 2) {
                $upgradeProbability = 50; // 50% iespēja uzlabot, ja ir 2 zvaigznes
            } elseif ($itemStars >= 3) {
                $upgradeProbability = 70; // 70% iespēja uzlabot, ja ir 3 vai vairāk zvaigznes
            }

            // Ģenerējiet gadījuma skaitli no 1 līdz 100
            $randomNumber = rand(1, 100);

            if ($_GET['action'] === 'upgrade_resources') {
                // Izmantojot resursus uzlabošanai
                $upgradeProbability = 30; // Palielināt uzlabošanas iespēju, ja izmanto resursus
            } elseif ($_GET['action'] === 'upgrade_dimants') {
                // Izmantojot dimantus uzlabošanai
                $upgradeProbability = 60; // Samazināt uzlabošanas iespēju, ja izmanto dimantus
            }

            if ($randomNumber <= $upgradeProbability) {
                // Iegūstiet esošos mantas statistikas datus no datu bāzes
                $queryManta = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE player_id='$player_id' AND id='$item_id'");
                $rowManta = mysqli_fetch_assoc($queryManta);
                $attack = (int)$rowManta['attack'];
                $defense = (int)$rowManta['defense'];
                $power = (int)$rowManta['power'];
                $agility = (int)$rowManta['agility'];
                $endurance = (int)$rowManta['endurance'];
                $intelligence = (int)$rowManta['intelligence'];
                $max_hp = (int)$rowManta['max_hp'];
                $max_energy = (int)$rowManta['max_energy'];

                // Aprēķiniet, cik daudz katrs stats pieaug pēc uzlabošanas (10% no esošās vērtības)
                $statIncrease = 0.10; // 10% palielinājums
                
                if ($itemStars == 1) {
                    $statIncrease = 0.20; // Ja ir 1 zvaigzne, palieliniet par 20%
                } elseif ($itemStars == 2) {
                    $statIncrease = 0.40; // Ja ir 2 zvaigznes, palieliniet par 40%
                } elseif ($itemStars >= 3) {
                    $statIncrease = 0.60; // Ja ir 3 vai vairāk zvaigznes, palieliniet par 60%
                }
                
                $newAttack = $attack + ($attack * $statIncrease);
                $newDefense = $defense + ($defense * $statIncrease);
                $newPower = $power + ($power * $statIncrease);
                $newAgility = $agility + ($agility * $statIncrease);
                $newEndurance = $endurance + ($endurance * $statIncrease);
                $newIntelligence = $intelligence + ($intelligence * $statIncrease);
                $newMaxHp = $max_hp + ($max_hp * $statIncrease);
                $newMaxEnergy = $max_energy + ($max_energy * $statIncrease);
                

                // Aprēķiniet nolietojuma pieaugumu atkarībā no zvaigznēm
                if ($itemStars == 1) {
                    $nolietojums += 0.5; // Ja ir 1 zvaigzne, pievienojiet 0.5 nolietojumu (50%)
                } elseif ($itemStars == 2) {
                    $nolietojums += 1.0; // Ja ir 2 zvaigznes, pievienojiet 1.0 nolietojumu (100%)
                } elseif ($itemStars >= 3) {
                    $nolietojums += 1.5; // Ja ir 3 vai vairāk zvaigznes, pievienojiet 1.5 nolietojumu (150%)
                }

                // Atjauniniet datu bāzi ar jaunajām statu un nolietojuma vērtībām
                $updateManta = mysqli_query($connect, "UPDATE `player_inventory` SET attack='$newAttack', defense='$newDefense', power='$newPower', agility='$newAgility', endurance='$newEndurance', intelligence='$newIntelligence', max_hp='$newMaxHp', max_energy='$newMaxEnergy', nolietojums='$nolietojums' WHERE player_id='$player_id' AND id='$item_id'");

                // Palieliniet līmeni par +1 un atjauniniet datu bāzi player_inventory
                $newLevel = $currentLevel + 1;
                $updateInventory = mysqli_query($connect, "UPDATE `player_inventory` SET level='$newLevel' WHERE player_id='$player_id' AND id='$item_id'");

                // Samaziniet resursus atkarībā no izmantotās metodes (resursi vai dimanti)
                if ($_GET['action'] === 'upgrade_resources') {
                    $newZelts = $zelts - 10;
                    $newKoks = $koks - 10;
                    $newDzelzs = $dzelzs - 10;
                    $newĀda = $āda - 10;
                    $newAkmens = $akmens - 10;

                    // Atjauniniet resursus datu bāzē
                    $updateResources = mysqli_query($connect, "UPDATE `players` SET zelts='$newZelts', koks='$newKoks', dzelzs='$newDzelzs', āda='$newĀda', akmens='$newAkmens' WHERE id='$player_id'");
                } elseif ($_GET['action'] === 'upgrade_dimants') {
                    $newDimants = $dimants - $upgradeCost;

                    // Atjauniniet dimantu skaitu datu bāzē
                    $updateResources = mysqli_query($connect, "UPDATE `players` SET dimants='$newDimants' WHERE id='$player_id'");
                }

                echo '<meta http-equiv="refresh" content="0;url=epuipmentsup.php">';
                exit;
                echo '<div class="alert alert-success">Manta ir uzlabota veiksmīgi!</div>';
                    
                // Pēc tam pāradresējiet lietotāju uz lapu, kur varat parādīt jauno līmeni vai veikt citas darbības atkarībā no jūsu lietotāja saskarnes prasībām.
            } else {
                // Ja gadījuma skaitlis pārsniedz uzlabošanas iespēju, rādiet kļūdas ziņojumu.
                echo '<div class="alert alert-danger">Uzlabošana neizdevās!</div>';
            }
        } else {
            // Ja resursi vai dimanti nav pietiekami, rādiet kļūdas ziņojumu.
            echo '<div class="alert alert-warning">Nepietiek resursu!</div>';
        }
    } else {
        // Ja prece ir uzvilkta vai ierīce ir jau sasniedzusi maksimālo līmeni, varat rādīt atbilstošu ziņojumu vai veikt citus pasākumus.
        if ($equipped == 1) {
            echo '<div class="alert alert-warning">Prece ir uzvilkta, nevar uzlabot!</div>';
        } else {
            echo '<div class="alert alert-warning">Ierīce ir jau sasniedzusi maksimālo līmeni!</div>';
        }
    }
    
}

    


?>

<style>
    .stars {
    display: inline-block;
    color: red;
}

.stars img {
    width: 20px; /* Pielāgojiet izmēru pēc vēlēšanās */
    height: 20px; /* Pielāgojiet izmēru pēc vēlēšanās */
    margin: 0 2px; /* Neliels atstarpes starp attēliem */
    
}
.img[title] {
                                        border: 1px solid red; /* Pievienojiet šeit jebkādu citu stilu, ko vēlaties */
                                        padding: 5px; /* Piemērs: Padding ap title tekstu */
                                    }
</style>



<div class="col-md-12 well">
    <div class="row well">
        <center>
            <h2><i class="fa "></i> Iekrājumi</h2>
        </center><br />
        <center>
            <a class="btn btn-danger active" href="epuipments.php"><i class="fas fa-book-dead"></i> Ekips</a>
             <a class="btn btn-danger warning" href="starup.php"><i class="fas fa-book-dead"></i> zvaigznes</a>
        </center>
    </div>
</div>

<div class="container">
    <div class="col-md-12 well">
        <h2>Noliktava</h2>
        <div class="row">
            <?php
            // Iegūstiet visus nopirktos priekšmetus no datu bāzes un to kategoriju
            $queryItems = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE player_id='$player_id'");
            while ($item = mysqli_fetch_assoc($queryItems)) {
                $item_id = $item['id'];
                $level = $item['level']; // Iegūstiet priekšmeta līmeni no datu bāzes
                $category = $item['category']; // Iegūstiet priekšmeta kategoriju
            ?>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><?= $item['name'] ?></h4>
                        </div>
                        <div class="panel-body">
                            <center>
                                <img src="<?= $item['image'] ?>" width="100">
                                
                                
                                <div class="col-md-12">
                            <div class="stars">
                                <strong>Zvaigznes:</strong>
                                <?php
                                for ($i = 0; $i < $item['stars']; $i++) {
                                    echo ' &#9733;'; // Iekļaujiet Unicode zvaigznes simbolu šeit
                                }
                                ?>
                            </div>
                                </div>
                        
                            </center>
                        </div>

                        <div class="panel-footer">
                            
                             
                             
                            <!-- Modālais logs, kas atšķiras katram priekšmetam -->
                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal<?= $item_id ?>">Apksatīt mantu </button>
                            <div id="myModal<?= $item_id ?>" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content -->
                                    <div class="modal-content">
                                        <center>
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title"><?= $item['name'] ?></h4>
                                                <img src="<?= $item['image'] ?>" width="100">
                                                <div class="status-element">
                                                        <strong>Zvaigznes:</strong>
                                                        <?php
                                                        for ($i = 0; $i < $item['stars']; $i++) {
                                                            echo ' &#9733;'; // Iekļaujiet Unicode zvaigznes simbolu šeit
                                                        }
                                                        ?>
                                                </div>
                                            </div>

                                            <div class="modal-body">
                                                <p>
                                                    <strong><?php echo lang_key("level"); ?>:</strong> <?php echo $item['level']; ?>/<?php echo $item['max_level']; ?>
                                                    <div class="status-element">
                                                        <strong><?php echo lang_key("hp"); ?>:</strong> <?php echo $item['max_hp']; ?>
                                                    </div>
                                                    <div class="status-element">
                                                        <strong><?php echo lang_key("energy"); ?>:</strong> <?php echo $item['max_energy']; ?>
                                                    </div>
                                                    <div class="status-element">
                                                        <strong><?php echo lang_key("attack"); ?>:</strong> <?php echo $item['attack']; ?>
                                                    </div>

                                                    <div class="status-element">
                                                        <strong><?php echo lang_key("defense"); ?>:</strong> <?php echo $item['defense']; ?>
                                                    </div>

                                                    <div class="status-element">
                                                        <strong><?php echo lang_key("power"); ?>:</strong> <?php echo $item['power']; ?>
                                                    </div>

                                                    <div class="status-element">
                                                        <strong><?php echo lang_key("agility"); ?>:</strong> <?php echo $item['agility']; ?>
                                                    </div>

                                                    <div class="status-element">
                                                        <strong><?php echo lang_key("endurance"); ?>:</strong> <?php echo $item['endurance']; ?>
                                                    </div>

                                                    <div class="status-element">
                                                        <strong><?php echo lang_key("intelligence"); ?>:</strong> <?php echo $item['intelligence']; ?>
                                                    </div>

                                                    <div class="status-element">
                                                        <strong><?php echo lang_key("nolietojums"); ?>:</strong> <?php echo $item['nolietojums']; ?>
                                                    </div>
                                                    
                                                     
                                                </p>
                                            </div>
                                        </center>
                                        <div class="modal-footer">
                                            <a href="?item_id=<?= $item_id ?>&action=upgrade_resources" class="btn btn-sm btn-success"><i class="fa fa-arrow-up"></i> Uzlabot ar resursiem</a>
                                            <a href="?item_id=<?= $item_id ?>&action=upgrade_dimants" class="btn btn-sm btn-primary"><i class="fa fa-diamond"></i> Uzlabot ar dimantiem</a>
                                           

                                        </div>
                                    </div>
                                </div>
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