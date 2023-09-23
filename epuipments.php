<?php
require "core.php";
head();

$uname = $_SESSION['username'];
$suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];



if (isset($_GET['sell-id'])) {
    $itemfs_id = $_GET["sell-id"];
    
    mysqli_query($connect, "DELETE FROM `player_inventory` WHERE id='$itemfs_id' AND player_id='$player_id'");
}

// Pārbauda, vai mikstūras termiņš ir beigušies un dzēš tos
if ($item_buy) {
            $expired_items_query = mysqli_query($connect, "DELETE FROM `player_inventory` WHERE termiņa_beigas <= NOW()");
            if (!$expired_items_query) {
                // Kļūda, kas radusies, dzēšot mikstūras
                // Veiciet nepieciešamās darbības šeit, ja ir nepieciešams
            }
        }

if (isset($_GET['equip-id'])) {
    $item_id = $_GET["equip-id"];

    // Pārbauda, vai manta ir gredzens
    $item_equip = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE id='$item_id' LIMIT 1");
    $itemeq = mysqli_fetch_assoc($item_equip);
    $itemType = $itemeq['type'];

    if ($itemType == '6') {
        
        // Pārbauda, cik daudz gredžu jau ir uzvilkts
        $checkEquippedQuery = mysqli_query($connect, "SELECT id FROM `player_inventory` WHERE type='6' AND equipped=1 AND player_id='$player_id'");
        $equippedCount = mysqli_num_rows($checkEquippedQuery);
        
        
        if ($equippedCount < 10) {
            // Ja spēlētājs vēl var uzvilkt gredzeni, turpiniet ar uzvilšanas darbību
            $powe = $itemeq['power'];
            $agil = $itemeq['agility'];
            $endu = $itemeq['endurance'];
            $intel = $itemeq['intelligence'];
            $attack = $itemeq['attack'];
            $defense = $itemeq['defense'];
            $max_hp = $itemeq['max_hp'];
            $max_energy = $itemeq['max_energy'];

            // Calculate total power
            $total_power = $powe + $agil + $endu + $intel + $attack + $defense;

            
            // Update player statistics and total power
            mysqli_query($connect, "UPDATE `players` SET power=power+'$powe', agility=agility+'$agil', endurance=endurance+'$endu', intelligence=intelligence+'$intel', attack=attack+'$attack', defense=defense+'$defense', max_hp=max_hp+'$max_hp', max_energy=max_energy+'$max_energy', total_power='$total_power' WHERE id='$player_id'");
        
            // Atzīmē mantu kā uzvilkto
            mysqli_query($connect, "UPDATE `player_inventory` SET equipped=1 WHERE id='$item_id' AND player_id='$player_id'");
            echo '<meta http-equiv="refresh" content="0;url=epuipments.php">';
            exit;
        } else {
            // Spēlētājs jau ir uzvilkis maksimālo skaitu gredžu, rādiet kļūdas ziņojumu vai veiciet citus pasākumus
            echo '<div class="alert alert-warning">Jūs nevarat uzvilkt vairāk par 10 gredzeniem!</div>';
        }
    }
    else {
        // Ja manta nav gredzens, pārbaudiet, vai to vēl nav uzvilcis no šīs kategorijas
        $category_id = $itemeq['type'];

        $checkEquippedQuery = mysqli_query($connect, "SELECT id FROM `player_inventory` WHERE type='$category_id' AND equipped=1 AND player_id='$player_id'");
        $equippedCount = mysqli_num_rows($checkEquippedQuery);

        if ($equippedCount < 1) {
            // Mantu var uzvilkt tikai vienu reizi no šīs kategorijas
            $powe = $itemeq['power'];
            $agil = $itemeq['agility'];
            $endu = $itemeq['endurance'];
            $intel = $itemeq['intelligence'];
            $attack = $itemeq['attack'];
            $defense = $itemeq['defense'];
            $max_hp = $itemeq['max_hp'];
            $max_energy = $itemeq['max_energy'];
        
            // Calculate total power for the item, including max_hp and max_energy
            $total_power = $powe + $agil + $endu + $intel + $attack + $defense + $max_hp + $max_energy;
        
            // Update player statistics and total power
            mysqli_query($connect, "UPDATE `players` SET power=power+'$powe', agility=agility+'$agil', endurance=endurance+'$endu', intelligence=intelligence+'$intel', attack=attack+'$attack', defense=defense+'$defense', max_hp=max_hp+'$max_hp', max_energy=max_energy+'$max_energy', total_power='$total_power' WHERE id='$player_id'");
        

            // Atzīmē mantu kā uzvilkto
            mysqli_query($connect, "UPDATE `player_inventory` SET equipped=1 WHERE id='$item_id' AND player_id='$player_id'");
            echo '<meta http-equiv="refresh" content="0;url=epuipments.php">';
            exit;
        } else {
            // Spēlētājs jau ir uzvilkis mantu no šīs kategorijas, rādiet kļūdas ziņojumu vai veiciet citus pasākumus
            echo '<div class="alert alert-warning">No katras katrgorijas var uzvilkt tik 1 mantu!</div>';
        }
    }
}




if (isset($_GET['unequip-id'])) {
    $item_id = $_GET["unequip-id"];

    $item_equip = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE id='$item_id' LIMIT 1");
    $itemeq = mysqli_fetch_assoc($item_equip);
    $powe = $itemeq['power'];
    $agil = $itemeq['agility'];
    $endu = $itemeq['endurance'];
    $intel = $itemeq['intelligence'];
    $attack = $itemeq['attack'];
    $defense = $itemeq['defense'];
    $max_hp = $itemeq['max_hp'];
    $max_energy = $itemeq['max_energy'];

    // Retrieve the current total_power
    $player_query = mysqli_query($connect, "SELECT total_power FROM `players` WHERE id='$player_id'");
    $player_data = mysqli_fetch_assoc($player_query);
    $current_total_power = $player_data['total_power'];

    // Calculate the new total_power after unequipping the item
    $new_total_power = $current_total_power - $powe - $agil - $endu - $intel - $attack - $defense - $max_hp - $max_energy;

    // Update the player's total_power and subtract the item's statistics
    mysqli_query($connect, "UPDATE `players` SET total_power='$new_total_power', power=power-'$powe', agility=agility-'$agil', endurance=endurance-'$endu', intelligence=intelligence-'$intel', attack=attack-'$attack', defense=defense-'$defense', max_hp=max_hp-'$max_hp', max_energy=max_energy-'$max_energy' WHERE id='$player_id'");

    mysqli_query($connect, "UPDATE `player_inventory` SET equipped=0 WHERE id='$item_id' AND player_id='$player_id'");
    echo '<meta http-equiv="refresh" content="0;url=epuipments.php">';
    exit;
}


if (isset($_GET['activate-id'])) {
    $item_id = $_GET["activate-id"];
    
    // Pārbauda, vai priekšmets ir jau aprīkots
    $check_equipped_query = mysqli_query($connect, "SELECT equipped, type, power, agility, endurance, intelligence, attack, defense, action_duration_hours FROM `player_inventory` WHERE id='$item_id' AND player_id='$player_id'");
    $item_data = mysqli_fetch_assoc($check_equipped_query);

    if ($item_data['equipped'] == 1) {
        echo '<div class="alert alert-warning">Šis priekšmets jau ir aprīkots un to nevar izmantot vēlreiz.</div>';
    } else {
        // Pārbauda, vai priekšmets ir mikstūra
        if ($item_data['type'] == 7) {
            // Pārbauda, vai spēlētājs nav sasniedzis maksimālo aktivizēto mikstūru skaitu (10)
            $activatedMiksturasQuery = mysqli_query($connect, "SELECT id FROM `player_inventory` WHERE type='7' AND equipped=1 AND player_id='$player_id'");
            $activatedMiksturasCount = mysqli_num_rows($activatedMiksturasQuery);

            // Maksimālais atļautais skaits aktivizēto mikstūru
            $maxAllowedMiksturas = 10;

            if ($activatedMiksturasCount < $maxAllowedMiksturas) {
                // Iegūst mikstūras darbības laika ilgumu no mikstūras ieraksta
                $action_duration_hours = $item_data['action_duration_hours'];

                // Iegūst pašreizējo laiku
                $current_time = time();
        
                // Pievieno darbības laika ilgumu pašreizējam laikam
                $expiration_time = date("Y-m-d H:i:s", strtotime("+{$action_duration_hours} hours"));

                // Atjauno mikstūras darbības laiku datubāzē
                $update_query = mysqli_query($connect, "UPDATE `player_inventory` SET termiņa_beigas='$expiration_time', equipped=1 WHERE id='$item_id' AND player_id='$player_id'");
                    
                if ($update_query) {
                    // Piešķir statusus no `player_inventory` ieraksta
                    $power = $item_data['power'];
                    $agility = $item_data['agility'];
                    $endurance = $item_data['endurance'];
                    $intelligence = $item_data['intelligence'];
                    $attack = $item_data['attack'];
                    $defense = $item_data['defense'];
                    $max_hp = $item_data['max_hp'];
                    $max_energy = $item_data['max_energy'];
                
                    // Atjauno spēlētāja statusus, pievienojot mikstūras efektus un max_hp, max_energy
                    $update_player_query = mysqli_query($connect, "UPDATE `players` SET power=power+'$power', agility=agility+'$agility', endurance=endurance+'$endurance', intelligence=intelligence+'$intelligence', attack=attack+'$attack', defense=defense+'$defense', max_hp=max_hp+'$max_hp', max_energy=max_energy+'$max_energy' WHERE id='$player_id'");

                        
                    if ($update_player_query) {
                        echo '<div class="alert alert-success">Mikstūras efekts ir aktivizēts uz ' . $action_duration_hours . ' stundām un piešķirti visi statusi!</div>';
                    } else {
                        echo '<div class="alert alert-danger">Neizdevās atjaunot spēlētāja statusus.</div>';
                    }
                    
                    echo '<meta http-equiv="refresh" content="0;url=epuipments.php">';
                    exit;
                } else {
                    echo '<div class="alert alert-danger">Neizdevās atjaunot mikstūras darbības laiku.</div>';
                }
            } else {
                echo '<div class="alert alert-warning">Jūs nevarat aktivizēt vairāk par ' . $maxAllowedMiksturas . ' mikstūrām.</div>';
            }
        } else {
            echo '<div class="alert alert-warning">Izvēlētais priekšmets nav mikstūra.</div>';
        }
    }
}


if (isset($_GET['fix-id'])) {
    $item_id = $_GET['fix-id'];


$zeltst=20;

   if($rowu['zelts']>=$zeltst){
      $update = mysqli_query($connect, "UPDATE `players` SET zelts=zelts-'$zeltst' WHERE id='$player_id'");
    // Update nolietojums to max_nolietojums
    $rep_item = mysqli_query($connect, "UPDATE `player_inventory` SET nolietojums=max_nolietojums WHERE player_id='$player_id' AND id='$item_id'");
    echo '<div class="alert alert-success" role="alert">Manta ir salabota</div>';
   }
   
}















?>
<!-- Game CSS -->
    <link href="assets/css/ekipejums.css" rel="stylesheet">


<div class="container">

<div class="row well">
    <center>
        <h2><i class="fa "></i> <?php echo lang_key("ekips");?></h2>
    </center><br />
    <center>
        <a class="btn btn-danger" href="starup.php"><i class="fas fa-book-dead"></i> zvaigznes</a>
        <a class="btn btn-warning active" href="epuipmentsup.php" ><i class="fas fa-book-dead"></i> <?php echo lang_key("uzlabot");?> </a> 
        
    </center>  
</div>
</div>





<!-- Uzvilktās Mantas-->

 
<div class="col-xs-12 well">
     
        

        <!-- Cepure Slot -->
        <div class="col-xs-2">
            <h3>Cepure Slot</h3>
            
            <div class="item-slot-1">
                <?php
                // Modify the SQL query to fetch the item for slot type 1
                $queryi = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE player_id='$player_id' AND type='1' LIMIT 1");
                if ($item = mysqli_fetch_assoc($queryi)) {
                    $item_id = $item['id'];
                    $equipped = $item['equipped'];
                ?>
                
                    <div class="item-slot">
                        <div class="custom-image-frame">
                            <?php if ($equipped) { ?>
                                <img src="<?= $item['image']; ?>" alt="Item Image" width="100" class="remove-item" onclick="removeItem(<?= $item_id ?>)">
                                
                                <span class="tooltip">
                                    <div class="tooltip-content">
                                        <div class="tooltip-image">
                                            <img src="<?= $item['image']; ?>" width="100"><br><br>
                                            <strong>Name:</strong> <?= $item['name']; ?><br><br>
                                        </div>
                                        
                                        <div class="stats" >
                                            <strong><img src="images/stats/hp.png"> <?php echo lang_key("hp"); ?>:</strong> <?= $item['max_hp']; ?><br><br>
                                            <strong><img src="images/stats/mana.png"><?php echo lang_key("energy"); ?>:</strong> <?= $item['max_energy']; ?><br><br>
                                            <strong><img src="images/stats/speks.png"><?php echo lang_key("attacks"); ?>:</strong> <?= $item['attack']; ?><br><br>
                                            <strong><?php echo lang_key("defense"); ?>:</strong> <?= $item['defense']; ?><br><br>
                                            <strong><?php echo lang_key("power"); ?>:</strong> <?= $item['power']; ?><br><br>
                                            <strong><img src="images/stats/atrums.png"><?php echo lang_key("agility"); ?>:</strong> <?= $item['agility']; ?><br><br>
                                            <strong><img src="images/stats/gars.png"><?php echo lang_key("endurance"); ?>:</strong> <?= $item['endurance']; ?><br><br>
                                            <strong><img src="images/stats/gudriba.png"><?php echo lang_key("intelligence"); ?>:</strong> <?= $item['intelligence']; ?><br><br>
                                        </div>
                                        
                                        <div class="additional-info">
                                            <strong><?php echo lang_key("level"); ?>:</strong> <?php echo $item['level']; ?>/<?php echo $item['max_level']; ?><br><br>
                                            <strong><?php echo lang_key("star"); ?>:</strong> <?php echo $item['stars']; ?><br><br>
                                            <strong><img src="images/stats/noliet.png" ><?php echo lang_key("nolietojums"); ?>:</strong> <?= $item['nolietojums']; ?>/<?= $item['max_nolietojums']; ?><br><br>
                                        </div>
                                        
                                    </div>
                                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal<?= $item_id ?>">Apskatīt mantu</button>
                                </span>
                                
                            <?php } else { ?>
                                <i class="fa-solid fa-hat-wizard fa-6x" aria-hidden="true"></i>
                                <span class="tooltip">Default Item<br><br><i class="fa-solid fa-hat-wizard fa-6x" aria-hidden="true"></i></span>
                            <?php } ?>
                        </div>
                    </div>
                <?php
                } else {
                    // Display default icon if no hat item is found
                    ?>
                    <div class="item-slot">
                        <div class="custom-image-frame">
                              <i class="fa-solid fa-hat-wizard fa-6x" aria-hidden="true"></i>
                                <span class="tooltip">Default Item<br><br><i class="fa-solid fa-hat-wizard fa-6x" aria-hidden="true"></i></span>
                        </div>
                    </div>
                <?php } ?>
                        </div>

        
        <!-- Nūja and Amulets -->
        
            <h3>Apmetnis Slot</h3>
            <div class="item-slot-2">
                <?php
                // Modify the SQL query to fetch the item for slot type 2
                $queryi = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE player_id='$player_id' AND type='2' LIMIT 1");
                if ($item = mysqli_fetch_assoc($queryi)) {
                    $item_id = $item['id'];
                    $equipped = $item['equipped'];
                ?>
                    <div class="item-slot">
                        <div class="custom-image-frame">
                            <?php if ($equipped) { ?>
                                <img src="<?= $item['image']; ?>" alt="Item Image" width="100" class="remove-item" onclick="removeItem(<?= $item_id ?>)">
                                <span class="tooltip">
                                    <div class="tooltip-content">
                                        <div class="tooltip-image">
                                            <img src="<?= $item['image']; ?>" width="100"><br><br>
                                            <strong>Name:</strong> <?= $item['name']; ?><br><br>
                                        </div>
                                        
                                        <div class="stats">
                                            <strong><img src="images/stats/hp.png"> <?php echo lang_key("hp"); ?>:</strong> <?= $item['max_hp']; ?><br><br>
                                            <strong><img src="images/stats/mana.png"><?php echo lang_key("energy"); ?>:</strong> <?= $item['max_energy']; ?><br><br>
                                            <strong><img src="images/stats/speks.png"><?php echo lang_key("attacks"); ?>:</strong> <?= $item['attack']; ?><br><br>
                                            <strong><?php echo lang_key("defense"); ?>:</strong> <?= $item['defense']; ?><br><br>
                                            <strong><?php echo lang_key("power"); ?>:</strong> <?= $item['power']; ?><br><br>
                                            <strong><img src="images/stats/atrums.png"><?php echo lang_key("agility"); ?>:</strong> <?= $item['agility']; ?><br><br>
                                            <strong><img src="images/stats/gars.png"><?php echo lang_key("endurance"); ?>:</strong> <?= $item['endurance']; ?><br><br>
                                            <strong><img src="images/stats/gudriba.png"><?php echo lang_key("intelligence"); ?>:</strong> <?= $item['intelligence']; ?><br><br>
                                        </div>
                                        
                                        <div class="additional-info">
                                            <strong><img src="images/stats/noliet.png" ><?php echo lang_key("nolietojums"); ?>:</strong> <?= $item['nolietojums']; ?>/<?= $item['max_nolietojums']; ?><br><br>
                                        </div>
                                    </div>
                                </span>
                            <?php } else { ?>
                                <i class="fa-solid fa-vest fa-6x" aria-hidden="true"></i>
                                <span class="tooltip">Default Item<br><br><i class="fa-solid fa-vest fa-6x" aria-hidden="true"></i></span>
                            <?php } ?>
                        </div>
                    </div>
                <?php
                } else {
                    // Display default icon if no hat item is found
                    ?>
                    <div class="item-slot">
                        <div class="custom-image-frame">
                             <i class="fa-solid fa-vest fa-6x" aria-hidden="true"></i>
                                <span class="tooltip">Default Item<br><br><i class="fa-solid fa-vest fa-6x" aria-hidden="true"></i></span>
                        </div>
                    </div>
                <?php } ?>
                        </div>

            
            
            <h3>Nūja Slot</h3>
            <div class="item-slot-3">
                <?php
                // Modify the SQL query to fetch the item for slot type 3
                $queryi = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE player_id='$player_id' AND type='3' LIMIT 1");
                if ($item = mysqli_fetch_assoc($queryi)) {
                    $item_id = $item['id'];
                    $equipped = $item['equipped'];
                ?>
                    <div class="item-slot">
                        <div class="custom-image-frame">
                            <?php if ($equipped) { ?>
                                <img src="<?= $item['image']; ?>" alt="Item Image" width="100" class="remove-item" onclick="removeItem(<?= $item_id ?>)">
                                <span class="tooltip">
                                    <div class="tooltip-content">
                                        <div class="tooltip-image">
                                            <img src="<?= $item['image']; ?>" width="100"><br><br>
                                            <strong>Name:</strong> <?= $item['name']; ?><br><br>
                                        </div>
                                        
                                        <div class="stats">
                                            <strong><img src="images/stats/hp.png"> <?php echo lang_key("hp"); ?>:</strong> <?= $item['max_hp']; ?><br><br>
                                            <strong><img src="images/stats/mana.png"><?php echo lang_key("energy"); ?>:</strong> <?= $item['max_energy']; ?><br><br>
                                            <strong><img src="images/stats/speks.png"><?php echo lang_key("attacks"); ?>:</strong> <?= $item['attack']; ?><br><br>
                                            <strong><?php echo lang_key("defense"); ?>:</strong> <?= $item['defense']; ?><br><br>
                                            <strong><?php echo lang_key("power"); ?>:</strong> <?= $item['power']; ?><br><br>
                                            <strong><img src="images/stats/atrums.png"><?php echo lang_key("agility"); ?>:</strong> <?= $item['agility']; ?><br><br>
                                            <strong><img src="images/stats/gars.png"><?php echo lang_key("endurance"); ?>:</strong> <?= $item['endurance']; ?><br><br>
                                            <strong><img src="images/stats/gudriba.png"><?php echo lang_key("intelligence"); ?>:</strong> <?= $item['intelligence']; ?><br><br>
                                        </div>
                                        
                                        <div class="additional-info">
                                            <strong><img src="images/stats/noliet.png" ><?php echo lang_key("nolietojums"); ?>:</strong> <?= $item['nolietojums']; ?>/<?= $item['max_nolietojums']; ?><br><br>
                                        </div>
                                    </div>
                                </span>
                            <?php } else { ?>
                                <i class="fa-solid fa-wand-sparkles fa-6x" aria-hidden="true"></i>
                                <span class="tooltip">Default Item<br><br><i class="fa-solid fa-wand-sparkles fa-6x" aria-hidden="true"></i></span>
                            <?php } ?>
                        </div>
                    </div>
                <?php
                } else {
                    // Display default icon if no hat item is found
                    ?>
                    <div class="item-slot">
                        <div class="custom-image-frame">
                            <i class="fa-solid fa-wand-sparkles fa-6x" aria-hidden="true"></i>
                                <span class="tooltip">Default Item<br><br><i class="fa-solid fa-wand-sparkles fa-6x" aria-hidden="true"></i></span>
                        </div>
                    </div>
                <?php } ?>
                        </div>

        </div>





        <!-- Player Mikstūras -->
           <div class="col-xs-8">
    <h3>Mikstūras Slot</h3>
   <div class="item-slot-4">
        <?php
        // Modify the SQL query to fetch the item for slot type 3
        $queryi = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE player_id='$player_id' AND type='7' LIMIT 10");

        // Initialize a counter for the items in a row
        $itemCount = 0;

        while ($item = mysqli_fetch_assoc($queryi)) {
            $item_id = $item['id'];
            $equipped = $item['equipped'];

            if ($itemCount % 5 == 0) {
                // Start a new row for every 5 items
                echo '<div class="item-row">';
            }
        ?>
            <div class="item-slot">
                        <div class="custom-image-frame">
                            <?php if ($equipped) { ?>
                                <img src="<?= $item['image']; ?>" alt="Item Image" width="100" class="remove-item" onclick="removeItem(<?= $item_id ?>)">
                                <span class="tooltip">
                                    <div class="tooltip-content">
                                        <div class="tooltip-image">
                                            <img src="<?= $item['image']; ?>" width="100"><br><br>
                                            <strong>Name:</strong> <?= $item['name']; ?><br><br>
                                        </div>
                                        
                                        <div class="stats">
                                            <strong><img src="images/stats/hp.png"> <?php echo lang_key("hp"); ?>:</strong> <?= $item['max_hp']; ?><br><br>
                                            <strong><img src="images/stats/mana.png"><?php echo lang_key("energy"); ?>:</strong> <?= $item['max_energy']; ?><br><br>
                                            <strong><img src="images/stats/speks.png"><?php echo lang_key("attacks"); ?>:</strong> <?= $item['attack']; ?><br><br>
                                            <strong><?php echo lang_key("defense"); ?>:</strong> <?= $item['defense']; ?><br><br>
                                            <strong><?php echo lang_key("power"); ?>:</strong> <?= $item['power']; ?><br><br>
                                            <strong><img src="images/stats/atrums.png"><?php echo lang_key("agility"); ?>:</strong> <?= $item['agility']; ?><br><br>
                                            <strong><img src="images/stats/gars.png"><?php echo lang_key("endurance"); ?>:</strong> <?= $item['endurance']; ?><br><br>
                                            <strong><img src="images/stats/gudriba.png"><?php echo lang_key("intelligence"); ?>:</strong> <?= $item['intelligence']; ?><br><br>
                                        </div>
                                        
                                        <div class="additional-info">
                                            <strong><img src="images/stats/noliet.png" ><?php echo lang_key("nolietojums"); ?>:</strong> <?= $item['nolietojums']; ?>/<?= $item['max_nolietojums']; ?><br><br>
                                        </div>
                                    </div>
                                </span>
                            <?php }  ?>
                        </div>
                    </div>
        <?php
            $itemCount++;

            if ($itemCount % 5 == 0) {
                // Close the row after 5 items
                echo '</div>';
            }
        }

        // Close the row if there are less than 5 items in the last row
        if ($itemCount % 5 != 0) {
            echo '</div>';
        }
        ?>
    </div>
</div>









        <!-- Armor and Boots -->
        <div class="col-xs-1">
            <h3>Amulets Slot</h3>
            
            <div class="item-slot-5">
                <?php
                // Modify the SQL query to fetch the hat item
                $queryi = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE player_id='$player_id' AND type='4' LIMIT 1");
                $item = mysqli_fetch_assoc($queryi);
            
                if ($item) {
                    $item_id = $item['id'];
                    $equipped = $item['equipped'];
                ?>
                    <div class="item-slot">
                        <div class="custom-image-frame">
                            <?php if ($equipped) { ?>
                                <img src="<?= $item['image']; ?>" alt="Hat Image" width="100" class="remove-item" onclick="removeItem(<?= $item_id ?>)">
                                <span class="tooltip">
                                    <div class="tooltip-content">
                                        <div class="tooltip-image">
                                            <img src="<?= $item['image']; ?>" width="100"><br><br>
                                            <strong>Name:</strong> <?= $item['name']; ?><br><br>
                                        </div>
                                        
                                        <div class="stats">
                                            <strong><img src="images/stats/hp.png"> <?php echo lang_key("hp"); ?>:</strong> <?= $item['max_hp']; ?><br><br>
                                            <strong><img src="images/stats/mana.png"><?php echo lang_key("energy"); ?>:</strong> <?= $item['max_energy']; ?><br><br>
                                            <strong><img src="images/stats/speks.png"><?php echo lang_key("attacks"); ?>:</strong> <?= $item['attack']; ?><br><br>
                                            <strong><?php echo lang_key("defense"); ?>:</strong> <?= $item['defense']; ?><br><br>
                                            <strong><?php echo lang_key("power"); ?>:</strong> <?= $item['power']; ?><br><br>
                                            <strong><img src="images/stats/atrums.png"><?php echo lang_key("agility"); ?>:</strong> <?= $item['agility']; ?><br><br>
                                            <strong><img src="images/stats/gars.png"><?php echo lang_key("endurance"); ?>:</strong> <?= $item['endurance']; ?><br><br>
                                            <strong><img src="images/stats/gudriba.png"><?php echo lang_key("intelligence"); ?>:</strong> <?= $item['intelligence']; ?><br><br>
                                        </div>
                                        
                                        <div class="additional-info">
                                            <strong><img src="images/stats/noliet.png" ><?php echo lang_key("nolietojums"); ?>:</strong> <?= $item['nolietojums']; ?>/<?= $item['max_nolietojums']; ?><br><br>
                                        </div>
                                    </div>
                                </span>
                            <?php } else { ?>
                                <i class="fa-solid fa-ankh fa-6x" aria-hidden="true"></i>
                                <span class="tooltip">Default Item<br><br><i class="fa-solid fa-ankh fa-6x" aria-hidden="true"></i></span>
                            <?php } ?>
                        </div>
                    </div>
                <?php
                } else {
                    // Display default icon if no hat item is found
                    ?>
                    <div class="item-slot">
                        <div class="custom-image-frame">
                            <i class="fa-solid fa-ankh fa-6x" aria-hidden="true"></i>
                                <span class="tooltip">Default Item<br><br><i class="fa-solid fa-ankh fa-6x" aria-hidden="true"></i></span>
                        </div>
                    </div>
                <?php } ?>
                        </div>

            
            <h3>Zābaki Slot</h3>
            <div class="item-slot-5">
                <?php
                // Modify the SQL query to fetch the hat item
                $queryi = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE player_id='$player_id' AND type='5' LIMIT 1");
                $item = mysqli_fetch_assoc($queryi);
            
                if ($item) {
                    $item_id = $item['id'];
                    $equipped = $item['equipped'];
                ?>
                    <div class="item-slot">
                        <div class="custom-image-frame">
                            <?php if ($equipped) { ?>
                                <img src="<?= $item['image']; ?>" alt="Hat Image" width="100" class="remove-item" onclick="removeItem(<?= $item_id ?>)">
                                <span class="tooltip">
                                    <div class="tooltip-content">
                                        <div class="tooltip-image">
                                            <img src="<?= $item['image']; ?>" width="100"><br><br>
                                            <strong>Name:</strong> <?= $item['name']; ?><br><br>
                                        </div>
                                        
                                        <div class="stats">
                                            <strong><img src="images/stats/hp.png"> <?php echo lang_key("hp"); ?>:</strong> <?= $item['max_hp']; ?><br><br>
                                            <strong><img src="images/stats/mana.png"><?php echo lang_key("energy"); ?>:</strong> <?= $item['max_energy']; ?><br><br>
                                            <strong><img src="images/stats/speks.png"><?php echo lang_key("attacks"); ?>:</strong> <?= $item['attack']; ?><br><br>
                                            <strong><?php echo lang_key("defense"); ?>:</strong> <?= $item['defense']; ?><br><br>
                                            <strong><?php echo lang_key("power"); ?>:</strong> <?= $item['power']; ?><br><br>
                                            <strong><img src="images/stats/atrums.png"><?php echo lang_key("agility"); ?>:</strong> <?= $item['agility']; ?><br><br>
                                            <strong><img src="images/stats/gars.png"><?php echo lang_key("endurance"); ?>:</strong> <?= $item['endurance']; ?><br><br>
                                            <strong><img src="images/stats/gudriba.png"><?php echo lang_key("intelligence"); ?>:</strong> <?= $item['intelligence']; ?><br><br>
                                        </div>
                                        
                                        <div class="additional-info">
                                            <strong><img src="images/stats/noliet.png" ><?php echo lang_key("nolietojums"); ?>:</strong> <?= $item['nolietojums']; ?>/<?= $item['max_nolietojums']; ?><br><br>
                                        </div>
                                    </div>
                                </span>
                            <?php } else { ?>
                                <i class="fa-solid fa-shoe-prints fa-6x" aria-hidden="true"></i>
                                <span class="tooltip">Default Zābaki<br><br><i class="fa-solid fa-shoe-prints fa-6x" aria-hidden="true"></i></span>
                            <?php } ?>
                        </div>
                    </div>
                <?php
                } else {
                    // Display default icon if no hat item is found
                    ?>
                    <div class="item-slot">
                        <div class="custom-image-frame">
                            <i class="fa-solid fa-shoe-prints fa-6x" aria-hidden="true"></i>
                            <span class="tooltip">Default Zābaki<br><br><i class="fa-solid fa-shoe-prints fa-6x" aria-hidden="true"></i></span>
                        </div>
                    </div>
                <?php } ?>
                        </div>
            </div>

        
        
        
        <!-- Gredzeni -->
        <div class="col-xs-12">
     <h3 class="text-center">Gredzeni Slot</h3>
    <div class="item-slot-6 d-flex justify-content-center">
        <?php
        // Modify the SQL query to fetch all equipped ring items
        $queryi = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE player_id='$player_id' AND type='6' AND equipped='1'");
        
        // Get the count of equipped rings
        $equipped_ring_count = mysqli_num_rows($queryi);
        $remaining_slots = 10 - $equipped_ring_count;
        
        // Display the equipped ring(s) with custom image frame and item name
        while ($item = mysqli_fetch_assoc($queryi)) {
            $item_id = $item['id'];
        ?>
            <div class="item-slot">
                <div class="custom-image-frame">
                    <img src="<?= $item['image']; ?>" alt="<?= $item['item']; ?>" width="80" class="remove-item" onclick="removeItem(<?= $item_id ?>)">
                    
                    <span class="tooltip">
                    <div class="custom-image-frame">
                        <div class="tooltip-content">
                            <div class="tooltip-image">
                                <img src="<?= $item['image']; ?>" width="100"><br><br>
                                <strong>Name:</strong> <?= $item['name']; ?><br><br>
                            </div>
                            
                            <div class="stats">
                                <strong><img src="images/stats/hp.png" > <?php echo lang_key("hp"); ?>:</strong> <?= $item['max_hp']; ?><br><br>
                                <strong><img src="images/stats/mana.png" ><?php echo lang_key("energy"); ?>:</strong> <?= $item['max_energy']; ?><br><br>
                                <strong><img src="images/stats/speks.png" ><?php echo lang_key("attacks"); ?>:</strong> <?= $item['attack']; ?><br><br>
                                <strong><?php echo lang_key("defense"); ?>:</strong> <?= $item['defense']; ?><br><br>
                                <strong><?php echo lang_key("power"); ?>:</strong> <?= $item['power']; ?><br><br>
                                <strong><img src="images/stats/atrums.png" ><?php echo lang_key("agility"); ?>:</strong> <?= $item['agility']; ?><br><br>
                                <strong><img src="images/stats/gars.png" ><?php echo lang_key("endurance"); ?>:</strong> <?= $item['endurance']; ?><br><br>
                                <strong><img src="images/stats/gudriba.png" ><?php echo lang_key("intelligence"); ?>:</strong> <?= $item['intelligence']; ?><br><br>
                            </div>
                            
                            <div class="additional-info">
                                <strong><img src="images/stats/noliet.png" ><?php echo lang_key("nolietojums"); ?>:</strong> <?= $item['nolietojums']; ?>/<?= $item['max_nolietojums']; ?><br><br>
                                
                            </div>
                            
                        </div>
                    </div>
                    </span>
                    
                </div>
            </div>
        <?php
        }
        
        // Display default icons for remaining slots with custom image frame and item name
        for ($i = 1; $i <= $remaining_slots; $i++) {
        ?>
            <div class="item-slot ">
                <div class="custom-image-frame">
                    <i class="fa-solid fa-ring fa-5x" aria-hidden="true"></i>
                    <span class="tooltip">Default Ring</span>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>








       




    
</div>






<div class="col-xs-12 well" >
   
    <ul class="nav nav-tabs nav-justified">
        <?php
        $first = true;
        $queryic = mysqli_query($connect, "SELECT * FROM `item_categories`");
        while ($rowic = mysqli_fetch_assoc($queryic)) {
            $category_id = $rowic['id'];
        ?>
        <li <?php if ($first) { echo 'class="active"'; $first = false; } ?>>
            <a data-toggle="tab" href="#<?= $category_id ?>">
                <i class="fa <?= $rowic['fa_icon'] ?>"></i> <?= $rowic['category'] ?>
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
            $class = $firsta ? 'active' : '';
        ?>
        <div id="<?= $category_id ?>" class="tab-pane fade in <?= $class ?>">
            <br />
            <div class="row">
                <?php
                $queryi = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE type = '$category_id' AND player_id='$player_id' ");
                while ($item = mysqli_fetch_assoc($queryi)) {
                    $item_id = $item['id'];
                    $equipped = $item['equipped'];
                ?>
                <div class="col-xs-4">
                    <center>
                        <ul class="breadcrumb">
                            <li class="active">
                                <h4><?= $item['name'] ?>(<?php echo lang_key("level"); ?>: <?= $item['level'] ?>)</h4>
                            </li>
                        </ul>
                    </center>
                    <div class="row">
                        <div class="col-xs-7">
                            <center>
                                <div class="custom-image-frame">
                    <img src="<?= $item['image']; ?>" alt="<?= $item['item']; ?>" width="80" class="equip-item" onclick="equipItem(<?= $item_id ?>)">
                    
                    <span class="tooltip">
                        <div class="tooltip-content">
                            <div class="tooltip-image">
                                <img src="<?= $item['image']; ?>" width="100"><br><br>
                                <strong>Name:</strong> <?= $item['name']; ?><br><br>
                            </div>
                            
                            <div class="stats">
                                <strong><img src="images/stats/hp.png" > <?php echo lang_key("hp"); ?>:</strong> <?= $item['max_hp']; ?><br><br>
                                <strong><img src="images/stats/mana.png" ><?php echo lang_key("energy"); ?>:</strong> <?= $item['max_energy']; ?><br><br>
                                <strong><img src="images/stats/speks.png" ><?php echo lang_key("attacks"); ?>:</strong> <?= $item['attack']; ?><br><br>
                                <strong><?php echo lang_key("defense"); ?>:</strong> <?= $item['defense']; ?><br><br>
                                <strong><?php echo lang_key("power"); ?>:</strong> <?= $item['power']; ?><br><br>
                                <strong><img src="images/stats/atrums.png" ><?php echo lang_key("agility"); ?>:</strong> <?= $item['agility']; ?><br><br>
                                <strong><img src="images/stats/gars.png" ><?php echo lang_key("endurance"); ?>:</strong> <?= $item['endurance']; ?><br><br>
                                <strong><img src="images/stats/gudriba.png" ><?php echo lang_key("intelligence"); ?>:</strong> <?= $item['intelligence']; ?><br><br>
                            </div>
                            
                            <div class="additional-info">
                                <strong><img src="images/stats/noliet.png" ><?php echo lang_key("nolietojums"); ?>:</strong> <?= $item['nolietojums']; ?>/<?= $item['max_nolietojums']; ?><br><br>
                                
                            </div>
                            
                        </div>
                    </span>
                    
                </div>
                            </center>
                        </div>
                        
                        <div class="col-xs-12">
    
                                            <?php
                                            if ($item['type'] >= 1 && $item['type'] <= 6) {
                                                if ($item['equipped'] == '0') {
                                                    echo '<a href="?equip-id=' . $item['id'] . '" class="btn btn-success btn-md btn-block"><i class="fa fa-cart-arrow-down"></i>Uzvilkt</a>';
                                                } elseif ($item['equipped'] == '1') {
                                                    echo '<p>Manta ir uzvilkta</p>';
                                                    echo '<a href="?unequip-id=' . $item['id'] . '" class="btn btn-warning btn-md btn-block"><i class="fa fa-cart-arrow-down"></i>Noņemt</a>';
                                                }
                                                echo '<a href="?sell-id=' . $item['id'] . '" class="btn btn-danger btn-md btn-block"><i class="fa fa-fw fa-dollar-sign"></i>Pārdot</a>';
                                            
                                                // Add the 'fix-id' button
                                                echo '<a href="?fix-id=' . $item['id'] . '" class="btn btn-info btn-md btn-block"><i class="fa fa-wrench"></i>Salabot</a>';
                                            
                                            } elseif ($item['type'] == 7) {
                                                // Display the expiration time for potions (type 7)
                                                echo '<p>Beigu termiņš: ' . $item['termiņa_beigas'] . '</p>';
                                            
                                                // Pārbauda, vai ir iestatīts equipped uz 1
                                                if ($item['equipped'] != 1) {
                                                    echo '<a href="?activate-id=' . $item['id'] . '" class="btn btn-success btn-md btn-block"><i class="fa fa-play"></i>Aktivizēt</a>';
                                                }
                                            }
                                            ?>
                                            
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal<?= $item_id ?>">Apskatīt mantu</button>

    <div id="myModal<?= $item_id ?>" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content -->
                                <div class="modal-content">
                                    <center>
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"><?= $item['name'] ?></h4>
                                        <img src="<?= $item['image'] ?>" width="100" >
                                        <div class="stars">
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
                                        <?php
                                            if ($item['type'] >= 1 && $item['type'] <= 6) {
                                                if ($item['equipped'] == '0') {
                                                    echo '<a href="?equip-id=' . $item['id'] . '" class="btn btn-success btn-md btn-block"><i class="fa fa-cart-arrow-down"></i>Uzvilkt</a>';
                                                } elseif ($item['equipped'] == '1') {
                                                    echo '<p>Manta ir uzvilkta</p>';
                                                    echo '<a href="?unequip-id=' . $item['id'] . '" class="btn btn-warning btn-md btn-block"><i class="fa fa-cart-arrow-down"></i>Noņemt</a>';
                                                }
                                                echo '<a href="?sell-id=' . $item['id'] . '" class="btn btn-danger btn-md btn-block"><i class="fa fa-fw fa-dollar-sign"></i>Pārdot</a>';
                                            } elseif ($item['type'] == 7 ) {
                                            // Display the expiration time for potions (type 7)
                                            echo '<p>Beigu termiņš: ' . $item['termiņa_beigas'] . '</p>';
                                            
                                            // Pārbauda, vai ir iestatīts equipped uz 1
                                            if ($item['equipped'] != 1) {
                                                echo '<a href="?activate-id=' . $item['id'] . '" class="btn btn-success btn-md btn-block"><i class="fa fa-play"></i>Aktivizēt</a>';
                                            }
                                        }
                                            ?>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
        <?php
        $firsta = false;
        }
        ?>
       
                                
    </div>
</div>

<script>
    function removeItem(itemId) {
        // Assuming you have a PHP script to handle the removal (e.g., remove_item.php)
        window.location.href = `epuipments.php?unequip-id=${itemId}`;
    }
    function equipItem(itemId) {
        // Assuming you have a PHP script to handle the removal (e.g., remove_item.php)
        window.location.href = `epuipments.php?equip-id=${itemId}`;
    }
    
    



</script>






<?php
footer();
?>
