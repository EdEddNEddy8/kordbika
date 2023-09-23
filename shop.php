
<?php
require "core.php";
head();

$uname = $_SESSION['username'];
$suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_GET['buy-id'])) {
    if ($rowu['role'] === 'Banned') {
        echo '<div class="alert alert-danger" role="alert">Jūs esat bloķēts un nevarat iegādāties mantas.</div>';
        exit();  // Exit the script if the user is banned
    }

    $item_id = $_GET['buy-id'];

    $item_query = mysqli_query($connect, "SELECT * FROM `items` WHERE id='$item_id'");
    $rowis = mysqli_fetch_assoc($item_query);

    if ($rowis) {
        $zelts = $rowis['zelts'];
        $koks = $rowis['koks'];
        $dzelzs = $rowis['dzelzs'];
        $ada = $rowis['āda'];
        $akmens = $rowis['akmens'];
        $dimants = $rowis['dimants'];
        $action_duration_hours = $rowis['action_duration_hours'];

        // Check if the item is active
        if ($rowis['active'] === 'Yes') {
            // Check if the player has enough resources to buy the item
            if (
                $rowu['zelts'] >= $zelts &&
                $rowu['koks'] >= $koks &&
                $rowu['dzelzs'] >= $dzelzs &&
                $rowu['āda'] >= $ada &&
                $rowu['akmens'] >= $akmens &&
                $rowu['dimants'] >= $dimants &&
                $rowu['level'] >= $rowis['min_level'] &&
                ($rowis['vip'] === 'No' || $rowu['role'] === 'VIP' || $rowu['role'] === 'Admin')
            ) {
                // Process the purchase and update player's resources
                $buy = mysqli_query($connect, "UPDATE `players` SET zelts=zelts-$zelts, koks=koks-$koks, dzelzs=dzelzs-$dzelzs, āda=āda-$ada, akmens=akmens-$akmens, dimants=dimants-$dimants WHERE id='$player_id'");

                // Add the item to the player's inventory
                $item_buy = mysqli_query($connect, "INSERT INTO `player_inventory` (player_id, item_id, name, image, level, type, power, agility, endurance, intelligence, attack, defense, nolietojums, max_nolietojums, max_level, max_hp, max_energy, bonus_xp, action_duration_hours)
                VALUES ('$player_id', '$item_id', '{$rowis['name']}', '{$rowis['image']}', '{$rowis['level']}', '{$rowis['type']}', '{$rowis['power']}', '{$rowis['agility']}', '{$rowis['endurance']}', '{$rowis['intelligence']}', '{$rowis['attack']}', '{$rowis['defense']}', '{$rowis['nolietojums']}' , '{$rowis['max_nolietojums']}' , '{$rowis['max_level']}', '{$rowis['max_hp']}', '{$rowis['max_energy']}', '{$rowis['bonus_xp']}', '$action_duration_hours')");
                
                // Notify the player that the item has been sent to their inventory
                echo '<div class="alert alert-success" role="alert">Jūsu manta tika nosūtīta uz inventāru.</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Jums nav pietiekami daudz resursu, nepieciešamais līmenis vai atbilstoša loma, lai iegādātos šo preci.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Šī prece nav pieejama.</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Prece ar norādīto ID nav atrasta.</div>';
    }
}









?>


    <div class="col-md-12 well">
    <center>
        <h2><i class="fa fa-shopping-cart"></i> <?php echo lang_key("shop"); ?></h2>
    </center><br />

    <ul class="nav nav-tabs nav-justified">
        <?php
        $first = true;
        $queryic = mysqli_query($connect, "SELECT * FROM `item_categories`");
        while ($rowic = mysqli_fetch_assoc($queryic)) {
            ?>
            <li <?php if ($first) { echo 'class="active"'; $first = false; } ?>>
                <a data-toggle="tab" href="#<?php echo $rowic['id']; ?>">
                    <i class="fa <?php echo $rowic['fa_icon']; ?>"></i> <?php echo $rowic['category']; ?>
                </a>
            </li>
            <?php
        }
        ?>
    </ul>

    <div class="tab-content">
        <?php
        $firsta = true;
        $queryicc = mysqli_query($connect, "SELECT * FROM `item_categories`");
        while ($rowicc = mysqli_fetch_assoc($queryicc)) {
            $category_id = $rowicc['id'];
            ?>
            <div id="<?php echo $category_id; ?>" class="tab-pane fade in <?php if ($firsta) { echo 'active'; $firsta = false; } ?>">
                <br />
                <div class="row">
                    <?php
                    $queryi = mysqli_query($connect, "SELECT * FROM `items` WHERE type = '$category_id'");
                    while ($rowi = mysqli_fetch_assoc($queryi)) {
                        // Pārbauda, vai prece ir aktīva vai ne
                    $is_active = ($rowi['active'] == 'Yes');

                    // Izvada preces tikai tad, ja tā ir aktīva
                    if ($is_active) {
                        ?>

                        <div class="col-md-4">
                            <center>
                                <ul class="breadcrumb">
                                    <li class="active">
                                        <h4><?php echo $rowi['item']; ?></h4>
                                    </li>
                                </ul>
                            </center>
                            <div class="row">
                                <div class="col-md-7">
                                    <center>
                                        <div class="item-image-frame">
                                            <h4 class="modal-title"><?= $rowi['name'] ?></h4>
                                            <img src="<?php echo $rowi['image']; ?>" width="100">
                                        </div>
                                    </center>
                                </div>
                                <div class="col-md-12">
                                <ul class="list-group">
                                    <li class="list-group-item active">
                                        <center><?php echo lang_key("item-details"); ?></center>
                                    </li>
                                    <?php if ($rowi['dimants'] > 0) { ?>
                                    <li class="list-group-item">
                                        <span class="badge badge-success"><?php echo $rowi['dimants']; ?></span>
                                        <i class="far fa-inbox"></i> <?php echo lang_key("dimants"); ?>
                                    </li>
                                    <?php } ?>
                                    <?php if ($rowi['zelts'] > 0) { ?>
                                    <li class="list-group-item">
                                        <span class="badge badge-success"><?php echo $rowi['zelts']; ?></span>
                                        <i class="far fa-inbox"></i> <?php echo lang_key("zelts"); ?>
                                    </li>
                                    <?php } ?>
                                    <?php if ($rowi['koks'] > 0) { ?>
                                    <li class="list-group-item">
                                        <span class="badge badge-success"><?php echo $rowi['koks']; ?></span>
                                        <i class="far fa-inbox"></i> <?php echo lang_key("koks"); ?>
                                    </li>
                                    <?php } ?>
                                    <?php if ($rowi['dzelzs'] > 0) { ?>
                                    <li class="list-group-item">
                                        <span class="badge badge-success"><?php echo $rowi['dzelzs']; ?></span>
                                        <i class="far fa-inbox"></i> <?php echo lang_key("dzelzs"); ?>
                                    </li>
                                    <?php } ?>
                                    <?php if ($rowi['āda'] > 0) { ?>
                                    <li class="list-group-item">
                                        <span class="badge badge-success"><?php echo $rowi['āda']; ?></span>
                                        <i class="far fa-inbox"></i> <?php echo lang_key("āda"); ?>
                                    </li>
                                    <?php } ?>
                                    
                                    <?php if ($rowi['akmens'] > 0) { ?>
                                    <li class="list-group-item">
                                        <span class="badge badge-success"><?php echo $rowi['akmens']; ?></span>
                                        <i class="far fa-inbox"></i> <?php echo lang_key("akmens"); ?>
                                    </li>
                                    <?php } ?>
                                    <?php if ($rowi['role'] > '') { ?>
                                    <li class="list-group-item">
                                        <span class="badge badge-success"><?php echo $rowi['role']; ?></span>
                                        <i class="far fa-inbox"></i> <?php echo lang_key("role"); ?>
                                    </li>
                                    <?php } ?>
                                    <li class="list-group-item">
                                        <span class="badge badge-info"><?php echo $rowi['min_level']; ?></span>
                                        <i class="fa fa-server"></i> <?php echo lang_key("required-level"); ?>
                                    </li>
                                    
                                    <!-- Poga, lai apskatītu mantu -->
                                    <li class="list-group-item">
                                        <button type="button" class="btn btn-info btn-md btn-block" data-toggle="modal" data-target="#myModal<?= $rowi['id'] ?>">Apskatīt mantu</button>
                                    </li>
                                </ul>
                                <!-- Modālais logs, lai apskatītu detaļas par mantu -->
                                <div id="myModal<?= $rowi['id'] ?>" class="modal fade" role="dialog">
                                    <!-- ... (pārējais koda fragments paliek nemainīgs) ... -->
                                </div>
                                <!-- Pārbaude, vai lietotājs var iegādāties šo mantu -->
                                <?php
                                $can_buy = true;
                            
                                if ($rowu['zelts'] < $rowi['zelts'] || $rowu['level'] < $rowi['min_level'] || ($rowi['vip'] == 'Yes' && $rowu['role'] != 'VIP')) {
                                    $can_buy = false;
                                }
                            
                                if ($can_buy) {
                                    echo '<a href="?buy-id=' . $rowi['id'] . '" class="btn btn-success btn-md btn-block"><i class="fa fa-cart-arrow-down"></i> ' . lang_key("buy") . '</a>';
                                } else {
                                    echo '<button class="btn btn-danger btn-md btn-block" disabled><em class="fa fa-fw fa-cart-arrow-down"></em>' . lang_key("no-") . '</button>';
                                }
                                ?>
                            </div>

                            </div>
                        </div>
                        <?php
                    }
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>



<?php
footer();
?>
