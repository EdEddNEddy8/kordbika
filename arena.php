<?php
require "core.php";
head();
$uname = $_SESSION['username'];
$suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];



// Pārbauda, vai spēlētājam jau ir aktīva cīņa
$active_battle_query = mysqli_query($connect, "SELECT * FROM `arena_fights` WHERE player_id='$player_id' AND is_active='1'");
$hasActiveBattle = mysqli_num_rows($active_battle_query) > 0;



if (isset($_GET['fight-id'])) {
    if ($hasActiveBattle) {
    // Ja spēlētājam jau ir aktīva cīņa, izvadiet paziņojumu
    echo '<div class="alert alert-info" role="alert">';
    echo 'Jums jau ir aktīva cīņa! Nokārtojiet pašreizējo cīņu, pirms sākat jaunu.';
    echo '</div>';
} else {
        // Ja spēlētājam nav aktīvas cīņas

        // Iegūst spēlētāja HP un enerģiju no "players" tabulas
        $player_query = mysqli_query($connect, "SELECT hp, energy FROM `players` WHERE id='$player_id' LIMIT 1");
        $player_data = mysqli_fetch_assoc($player_query);

        if ($player_data) {
            $player_hp = $player_data['hp']; // Spēlētāja HP no players tabulas
            $player_energy = $player_data['energy']; // Spēlētāja enerģija no players tabulas

            $monster_id = $_GET['fight-id']; // Iegūst monstru ID no URL parametriem

            // Iegūst monstra HP no "monsters" tabulas
            $monster_query = mysqli_query($connect, "SELECT * FROM `monsters` WHERE id='$monster_id' LIMIT 1");
            $monster_data = mysqli_fetch_assoc($monster_query);

            if ($monster_data) {
                $monster_hp = $monster_data['hp']; // Monstra HP no monsters tabulas

                // Izveido SQL vaicājumu, lai ievietotu datus arena_fights tabulā
                $log_fight = mysqli_query($connect, "INSERT INTO `arena_fights` (player_id, player_hp, player_energy, monster_id, monster_hp, is_active)
                VALUES ('$player_id', '$player_hp', '$player_energy', '$monster_id', '$monster_hp', '1')");
                echo '<meta http-equiv="refresh" content="0;url=arena.php">';
                exit;
            } 
        } else {
            // Apstrādā gadījumu, ja spēlētāja dati netika atrasti
            echo '<div class="alert alert-danger" role="alert">Player data not found!!</div>';
        }

        if ($_SESSION['role'] == 'Admin') {
    // Atjauno spēlētāja maksimālo dzīvību un enerģijas vērtības uz maksimālajām vērtībām
    $update_max_values_query = mysqli_query($connect, "UPDATE `players` SET max_hp='jauna_max_hp_vērtība', max_energy='jauna_max_energy_vērtība' WHERE id='$player_id'");
        }

    }
}



if (isset($_POST['izdzest_cinu'])) {
                        // Izdzēš datus no `arena_fights` tabulas, kur is_active ir 1 un spēlētājs ir šis konkrētais spēlētājs
                        $delete_query = mysqli_query($connect, "DELETE FROM `arena_fights` WHERE player_id='$player_id' AND is_active='1'");
                        $delete_damage_query = mysqli_query($connect, "DELETE FROM `damage_history` WHERE player_id='$player_id' ");
                        echo '<meta http-equiv="refresh" content="0;url=arena.php">';
                        exit;
                        
}


if (isset($_POST['uguns']) || isset($_POST['zibens']) || isset($_POST['zemes'])) {
    // Fetch player attributes from the database
    $player_query = mysqli_query($connect, "SELECT * FROM `players` WHERE id='$player_id' LIMIT 1");
    $player_data = mysqli_fetch_assoc($player_query);
    




        if (isset($_POST['uguns'])) {
    $energy_cost = 15;
    // Adjust formula based on magic level
    $total_damage = ($player_data['attack'] + $player_data['defense'] + $player_data['power'] + $player_data['agility'] + $player_data['endurance'] + $player_data['intelligence']);
    // Adjust total_damage considering monster resistance
} elseif (isset($_POST['zibens'])) {
    $energy_cost = 10;
    // Adjust formula based on magic level
    $total_damage = ($player_data['attack'] + $player_data['defense'] + $player_data['power'] + $player_data['agility'] + $player_data['endurance'] + $player_data['intelligence']);
} elseif (isset($_POST['zemes'])) {
    $energy_cost = 3;
    // Adjust formula based on magic level
    $total_damage = ($player_data['attack'] + $player_data['defense'] + $player_data['power'] + $player_data['agility'] + $player_data['endurance'] + $player_data['intelligence']);
}


        
    // Update the monster's HP when the player attacks with the calculated total damage
    $player_damage = $total_damage;
    $update_query = mysqli_query($connect, "UPDATE `arena_fights` SET monster_hp=monster_hp-$total_damage WHERE player_id='$player_id' AND is_active='1'");

    // Deduct energy from the player
    $deduct_energy_query = mysqli_query($connect, "UPDATE `players` SET energy=energy-$energy_cost WHERE id='$player_id'");
    
    // Fetch the arena fight ID from the active battle data
    $active_battle_query = mysqli_query($connect, "SELECT * FROM `arena_fights` WHERE player_id='$player_id' AND is_active='1'");
    $active_battle_data = mysqli_fetch_assoc($active_battle_query);
    $arena_fights_id = $active_battle_data['id'];
    
    

        if (isset($_POST['uguns'])) {
        $damage_type = 'uguns';
        // citi koda bloki
         
    } elseif (isset($_POST['zibens'])) {
        $damage_type = 'zibens';
        // citi koda bloki
         
    } elseif (isset($_POST['zemes'])) {
        $damage_type = 'zemes';
        // citi koda bloki
         
    }

    // Add damage information to the database
   $insert_damage_query = mysqli_query($connect, "INSERT INTO `damage_history` (arena_fights_id, player_id, damage_info, damage_type) VALUES ('$arena_fights_id', '$player_id', '$total_damage', '$damage_type')");

    // Check if the monster's HP is now 0 or less
    $battle_query = mysqli_query($connect, "SELECT * FROM `arena_fights` WHERE player_id='$player_id' AND is_active='1' LIMIT 1");
    $battle_data = mysqli_fetch_assoc($battle_query);
    $monster_hp = $battle_data['monster_hp'];
    $monster_id = $battle_data['monster_id']; // Get the monster ID from the active battle data


    if ($monster_hp <= 0) {
        // Retrieve loot information based on the correct $monster_id
        $loot_query = mysqli_query($connect, "SELECT * FROM `monsters` WHERE id='$monster_id' LIMIT 1");
        $loot_data = mysqli_fetch_assoc($loot_query);
        $xp = $loot_data['xp'];
        $zeltsno = $loot_data['zelts_no'];
        $zeltslidz = $loot_data['zelts_lidz'];
        $koksno = $loot_data['koks_no'];
        $kokslidz = $loot_data['koks_lidz'];
        $dzelzsno = $loot_data['dzelzs_no'];
        $dzelzslidz = $loot_data['dzelzs_lidz'];
        $adano = $loot_data['ada_no'];
        $adalidz = $loot_data['ada_lidz'];
        $akmensno = $loot_data['akmens_no'];
        $akmenslidz = $loot_data['akmens_lidz'];
        
        
        
        $zelts = (rand($zeltsno, $zeltslidz));
        $koks = (rand($koksno, $kokslidz));
        $dzelzs = (rand($dzelzsno, $dzelzslidz));
        $ada = (rand($adano, $adalidz));
        $akmens = (rand($akmensno, $akmenslidz));
        
        
        
        $total_bonus_xp_percentage = 0; // Initialize total bonus XP percentage to 0
        // Fetch all bonus experience points from equipped potions for the player
        $potion_query = mysqli_query($connect, "SELECT bonus_xp FROM `player_inventory` WHERE  equipped='1' AND player_id='$player_id'");
        // Calculate total bonus XP as a percentage and display for debugging
        while ($potion_data = mysqli_fetch_assoc($potion_query)) {
            $bonus_xp = $potion_data['bonus_xp'] / 100;
            $total_bonus_xp_percentage += $bonus_xp;
            
        }
        // Calculate the total experience gained in the fight, including the bonus from the potion, equipment, and inventory
        $total_experience_gained = $xp + ($total_bonus_xp_percentage * $xp);
        // Update the player's statistics with the correct loot values
        $update_player_query = mysqli_query($connect, "UPDATE `players` SET zelts=zelts+$zelts,koks=koks+$koks, dzelzs=dzelzs+$dzelzs, āda=āda+$ada, akmens=akmens+$akmens, respect=respect+$total_experience_gained, points=points+ 10 WHERE id='$player_id'");
        $update_player_inven = mysqli_query($connect, "UPDATE `player_inventory` SET nolietojums=nolietojums-1  WHERE  equipped='1' AND player_id='$player_id'");
        // Display a message to the player about their victory and rewards
        // Iegūst loot ID
    
        $loot_id = $loot_data['loot'];

        if (!empty($loot_id)) {
            $loot_item_query = mysqli_query($connect, "SELECT * FROM items WHERE id='$loot_id' LIMIT 1");
            $loot_item_data = mysqli_fetch_assoc($loot_item_query);
        
            if ($loot_item_data) {
                // Iegūst loot datus
                $item_id = $loot_item_data['id'];
                $name = $loot_item_data['name'];
                $image = $loot_item_data['image'];
                $level = $loot_item_data['level'];
                $type = $loot_item_data['type'];
                $power = $loot_item_data['power'];
                $agility = $loot_item_data['agility'];
                $endurance = $loot_item_data['endurance'];
                $intelligence = $loot_item_data['intelligence'];
                $attack = $loot_item_data['attack'];
                $defense = $loot_item_data['defense'];
                $nolietojums = $loot_item_data['nolietojums'];
                $max_level = $loot_item_data['max_level'];
                $max_hp = $loot_item_data['max_hp'];
                $max_energy = $loot_item_data['max_energy'];
                $bonus_xp = $loot_item_data['bonus_xp'];
                $action_duration_hours = $loot_item_data['action_duration_hours'];
                $dropChancePercentage = $loot_data['monster_drop_chance'];

                // Generate a random number between 1 and 100
                $randomNumber = rand(1, 100);
               

                
                // Check if the random number falls within the drop chance range
                if ($randomNumber <= $dropChancePercentage) {
                
                $insert_loot_query = mysqli_query($connect, "INSERT INTO `player_inventory` (player_id, item_id, name, image, level, type, power, agility, endurance, intelligence, attack, defense, nolietojums, max_level, max_hp, max_energy, bonus_xp, action_duration_hours)
                                VALUES ('$player_id', '$item_id', '$name', '$image', '$level', '$type', '$power', '$agility', '$endurance', '$intelligence', '$attack', '$defense', '$nolietojums', '$max_level', '$max_hp', '$max_energy', '$bonus_xp', '$action_duration_hours')");
                }
        
                
        
            }
            
        }
        
        ?>
        
        <div class="modal fade" id="victoryModal" tabindex="-1" role="dialog" aria-labelledby="victoryModalLabel" aria-hidden="true">
            <link href="assets/css/arena.css" rel="stylesheet">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                  <img src="images/backgrounds/victory.png" alt="Victory Icon">
                <center><h1 class="modal-title" id="victoryModalLabel"><?php echo lang_key("victory"); ?></h1></center>
              </div>
                <div class="modal-body">
                    <!-- Your victory content -->
                    <strong><?php echo lang_key("reward"); ?>:</strong><br>
                
                    <div class="resource">
                        <img src="images/resi/xp.png" alt="Xp icon">
                        <span id="xp"><?php echo $total_experience_gained . ' ' . lang_key("respect") . ' (' . $xp . ' ' . lang_key("respect") . ' + ' . ($total_bonus_xp_percentage * 100) . '% ' . lang_key("equipment-bonus") . ')'; ?></span>
                    </div>
                
                    <div class="resource">
                        <img src="images/resi/zelts.png" alt="Zelts icon">
                        <strong><span id="zelts"><?php echo $zelts . ' ' . lang_key("zelts"); ?></span></strong>
                    </div>
                
                    <div class="resource">
                        <img src="images/resi/koks.png" alt="Koks icon">
                        <span id="koks"><?php echo $koks . ' ' . lang_key("koks"); ?></span>
                    </div>
                
                    <div class="resource">
                        <img src="images/resi/dzelzs.png" alt="Dzels icon">
                        <span id="dzelzs"><?php echo $dzelzs . ' ' . lang_key("dzelzs"); ?></span>
                    </div>
                
                    <div class="resource">
                        <img src="images/resi/ada.png" alt="Ada icon">
                        <span id="ada"><?php echo $ada . ' ' . lang_key("āda"); ?></span>
                    </div>
                
                    <div class="resource">
                        <img src="images/resi/akmens.png" alt="Akmens icon">
                        <span id="akmens"><?php echo $akmens . ' ' . lang_key("akmens"); ?></span>
                    </div>
                    
                    <?php
                    if ($insert_loot_query) {
                        echo '<div class="alert alert-success" role="alert">';
                        echo 'Loot pievienots tavam inventāram!<br>';
                        echo '<img src="' . $image . '" alt="' . $name . '"><br>';
                        echo 'Loot nosaukums: ' . $name;
                        echo '</div>';
                    } 
                    ?>
                </div>
                
              <div class="modal-footer">
                  
            
    
                <a href="arena.php" class="btn btn-primary"><?php echo lang_key("atpakal-uz-arenu"); ?></a>
              </div>
            </div>
          </div>
          
          
        </div>
        
       
        <?php      
      
      
     $current_date = date("Y-m-d H:i:s");
        $insert_history_query = mysqli_query($connect, "INSERT INTO `fight_history` (player_id, monster_id, victory_date) 
        VALUES ('$player_id', '$monster_id', '$current_date')");
        

    // Delete damage records associated with this battle
    $delete_damage_query = mysqli_query($connect, "DELETE FROM `damage_history` WHERE arena_fights_id='$arena_fights_id'");

    // End the battle by deleting the active battle entry
    $end_battle_query = mysqli_query($connect, "DELETE FROM `arena_fights` WHERE player_id='$player_id' AND is_active='1'");
    
    }   
    else {
        // Ja monstra HP nav 0, monsters uzbrūk spēlētājam
        $dmg = mysqli_query($connect, "SELECT * FROM `monsters` WHERE id='$monster_id' LIMIT 1");
        $dmg1 = mysqli_fetch_assoc($dmg);
        $dmgno = $dmg1['damage_no'];
        $dmglidz = $dmg1['damage_lidz'];
    
        $monster_attack = mt_rand($dmgno, $dmglidz); // Piemēram, monsters katru reizi atņem 5-15 HP
        $player_hp_after_monster_attack = $player_data['hp'] - $monster_attack;
    
        // Aizsargājamies no negatīva HP
        if ($player_hp_after_monster_attack < 0) {
            $player_hp_after_monster_attack = 0;
        }
    
        // Atjauno spēlētāja HP datubāzē
        $update_player_hp_query = mysqli_query($connect, "UPDATE `players` SET hp='$player_hp_after_monster_attack' WHERE id='$player_id'");
    
        // Saglabājam informāciju par uzbrukumu datu bāzē, iekļaujot arena_fights_id
        $insert_damage_query = mysqli_query($connect, "INSERT INTO `damage_history` (arena_fights_id, monster_attack) VALUES ('$arena_fights_id', '$monster_attack')");
    
        if ($insert_damage_query) {
            
    
            // Pēc cīņas izdzēšam ierakstus no cīņas vēstures
            $delete_fight_history_query = mysqli_query($connect, "DELETE FROM `fight_history` WHERE player_id='$player_id' AND monster_id='$monster_id'");
    
            
        } 
        
    
        
    }
    
    
    if ($player_data['hp'] <= 0) {
    // Player's HP is 0 or less, indicating the end of the game

    // Delete damage records associated with this battle
    $delete_damage_query = mysqli_query($connect, "DELETE FROM `damage_history` WHERE arena_fights_id='$arena_fights_id'");

    // End the battle by deleting the active battle entry
    $end_battle_query = mysqli_query($connect, "DELETE FROM `arena_fights` WHERE player_id='$player_id' AND is_active='1'");
    
   
    
    
    // Display an alert with the message "Jūs zaudējāt" and a button to return to arena.php
    echo '<div class="alert alert-danger">
            <strong><?php echo lang_key("defeat"); ?></strong>
            <center><a href="arena.php" class="btn btn-primary">Atpakaļ uz arenu</a></center>
          </div>';
    exit;
}
 
}




?>




                        
    
    
        
<?php
if ($hasActiveBattle) {
                // Iegūst aktīvās cīņas datus no arena_fights tabulas
                $battle_query = mysqli_query($connect, "SELECT * FROM `arena_fights` WHERE player_id='$player_id' AND is_active='1' LIMIT 1");
                $battle_data = mysqli_fetch_assoc($battle_query);

                if ($battle_data) {
                
                    // Izgūst spēlētāja un monstra karakteristikas ID no cīņas datiem
                    $player_id = $battle_data['player_id'];
                    
                    $monster_id = $battle_data['monster_id'];
                    $hp = $battle_data['hp'];
                    
                    // Izveido vaicājumus, lai iegūtu spēlētāja un monstra HP, enerģiju un karakteristikas
                    $player_query = mysqli_query($connect, "SELECT players.*, characters.image AS player_image FROM `players` 
                                                            LEFT JOIN characters ON players.character_id = characters.id 
                                                            WHERE players.id='$player_id'");
                    
                    $monster_query = mysqli_query($connect, "SELECT monsters.*, monsters_characters.image AS monster_image FROM `monsters` 
                                                              LEFT JOIN monsters_characters ON monsters.character_id = monsters_characters.id 
                                                              WHERE monsters.id='$monster_id'");
                    
                    // Izgūst spēlētāja un monstra datus no rezultātiem
                    $player_data = mysqli_fetch_assoc($player_query);
                    $php = $player_data['hp'];
                    $pmaxhp = $player_data['max_hp'];
                    $penergy = $player_data['energy'];
                    $pmaxenergy = $player_data['max_energy'];
                    $pusername = $player_data['username'];
                    $pavatar = $player_data['avatar'];
                    $player_character_image = $player_data['player_image'];
                    
                    $monster_data = mysqli_fetch_assoc($monster_query);
                    $mhp = $monster_data['hp'];
                    $monster_hp = $battle_data['monster_hp'];
                    $musername = $monster_data['username'];
                    $mavatar = $monster_data['avatar'];
                    $monster_character_image = $monster_data['monster_image'];

                                        

                    // Izveido cīņas lauku ar informāciju par spēlētāju un monstru
                    ?>
                    

                    <div class="col-xs-3">
                            <center>
                                <img src="<?php echo $player_character_image; ?>" width="150" style="border:8px solid #ccc; border-radius:15px;" />
                                <div class="panel panel-danger">
                                    <div class="panel-heading"><img src="<?php echo $pavatar; ?>" width="30" /></i> <?php echo $pusername; ?></div>
                                    <div class="panel-body">
                                        
                                    <div id="playerHP">
                                        <h5><i class="fa fa-heart"></i> <?php echo lang_key("hp"); ?></h5>
                                        <div class="progress progress-striped active">
                                            <div  class="progress-bar progress-bar-danger" style="width: <?php echo percent($php, $pmaxhp); ?>%;">
                                                <span><?php echo $php; ?> / <?php echo $pmaxhp; ?></span>
                                            </div>
                                        </div>
                                    </div>    
                                    <div id="playerEnergy">    
                                        <h5><i class="fa fa-heart"></i> <?php echo lang_key("energy"); ?></h5>
                                        <div class="progress progress-striped active">
                                            <div  class="progress-bar progress-bar-info" style="width: <?php echo percent($penergy, $pmaxenergy); ?>%;">
                                                <span><?php echo $penergy; ?> / <?php echo $pmaxenergy; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </center>
                            
                     <form method="POST" action="arena.php">
                            <input type="submit" class="btn btn-danger" value="Pamest cīņu" name="izdzest_cinu">
        </form>
                        </div>



              <div class="col-xs-6">
                  
    <div class="col-xs-6">
    <div class="well">
        <form method="POST" >
            <?php
            if ($rowu['energy'] < 15) {
                echo '<input type="submit" class="btn btn-warning" value="' . lang_key("uguns (-15 enerģija)") . '" name="uguns" disabled>';
            } else {
                echo '<input type="submit" class="btn btn-warning" value="' . lang_key("uguns -15 enerģija") . '" name="uguns">';
            }
            ?>
        </form>
        <form method="POST" >
            <?php
            if ($rowu['energy'] < 10) {
                echo '<input type="submit" class="btn btn-info" value="' . lang_key("zibens (-10 enerģija)") . '" name="zibens" disabled>';
            } else {
                echo '<input type="submit" class="btn btn-info" value="' . lang_key("zibens -10 enerģija") . '" name="zibens">';
            }
            ?>
        </form>
        <form method="POST" >
            <?php
            if ($rowu['energy'] < 3) {
                echo '<input type="submit" class="btn btn-success" value="' . lang_key("zemes (-3 enerģija)") . '" name="zemes" disabled>';
            } else {
                echo '<input type="submit" class="btn btn-success" value="' . lang_key("zemes -3 enerģija") . '" name="zemes">';
            }
            ?>
        </form>
    </div>
</div>


    <?php
// Iepriekšējais kods

if ($insert_damage_query) {
    echo "Monstrs uzbrūk tev!";
    echo "Tu zaudēji " . $monster_attack   ;

    // Pēc cīņas izdzēšam ierakstus no cīņas vēstures
    $delete_fight_history_query = mysqli_query($connect, "DELETE FROM `fight_history` WHERE player_id='$player_id' AND monster_id='$monster_id'");

    // Ievieto kodu šeit
    ?>
    <div class="col-xs-6">
        <div class="well">
            <div class="damage-history">
                
                <h3>Damage History</h3>
                <ul>
                    <?php
                    // Izgūstiet visus ierakstus no "damage history" datu bāzes, ierobežojot tos līdz 10
                    $damage_history_query = mysqli_query($connect, "SELECT * FROM `damage_history` WHERE player_id='$player_id' ORDER BY id DESC LIMIT 1");
                    
                    
                    // Pārbaudiet, vai ir ieraksti
                    if (mysqli_num_rows($damage_history_query) > 0) {
                        // Iegūstiet visus kaitējuma ierakstus
                        while ($damage_row = mysqli_fetch_assoc($damage_history_query)) {
                            $damage_info = $damage_row['damage_info'];
                            $damage_type = $damage_row['damage_type'];
                            $damage_class = '';
                            $damage_text = '';
                    
                            // Noteikt klasi atkarībā no ieraksta veida un tekstu
                            if ($damage_type == 'uguns') {
                                $damage_class = 'label-warning';
                                $damage_text = "Tu iesiti ar $damage_info uguni.";
                            } elseif ($damage_type == 'zibens') {
                                $damage_class = 'label-info';
                                $damage_text = "Tu iesiti ar $damage_info zibeni.";
                            } elseif ($damage_type == 'zemes') {
                                $damage_class = 'label-success';
                                $damage_text = "Tu iesiti ar $damage_info zemi.";
                            }
                    
                            ?>
                            <span class="label <?php echo $damage_class; ?>"><?php echo $damage_text; ?></span>
                            <?php
                        }
                    
                        // Izvadiet informāciju par monstru uzbrukumu spēkā
                        ?>
                        <br/>
                        <span class="label label-danger"><?php echo "Monstrs tevi uzbrūk ar " . $monster_attack . " spēku."; ?></span>
                        <?php
                    } else {
                        // Ja nav ierakstu, izvadiet paziņojumu, ka nav kaitējuma vēstures
                        ?>
                        <span>Nav ierakstu par kaitējumu no monstra.</span>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <?php
}
?>
    
             </div>









                        <div class="col-xs-3">
                            <center>
                                <img src="<?php echo $monster_character_image; ?>" width="150" style="border:8px solid #ccc; border-radius:15px;" />
                                <div class="panel panel-danger">
                                <div id="monsterHP">    
                                    <div class="panel-heading"><img src="<?php echo $mavatar; ?>" width="30" /></i> <?php echo $musername; ?></div>
                                    <div class="panel-body">
                                        <h5><i class="fa fa-heart"></i> <?php echo lang_key("hp"); ?></h5>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-danger" style="width: <?php echo percent($monster_hp,$mhp); ?>%;">
                                                <span><?php echo $monster_hp; ?>/<?php echo $mhp; ?> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                                </div>
                            </center>
                        </div>
                        
                        <?php
                        // Šeit jūs varat pievienot papildu informāciju par cīņu, piemēram, cīņas logiku un pogas
                        // ...
                            
                        echo '</div>'; // Beidz cīņas lauku
                    }
                } 
else {
                    ?>
                    <div class="col-xs-12 well">
                        
                            <?php
                            // Iegūstiet visus nopirktos priekšmetus no datu bāzes un to kategoriju
                            $queryMob = mysqli_query($connect, "SELECT * FROM `monsters` ");
                            while ($mob = mysqli_fetch_assoc($queryMob)) {
                                $mobId = $mob['id'];
                
                                // Pārbauda, vai šis mobs jau ir aktīvā cīņā
                                if ($hasActiveBattle) {
                                    continue; // Izmeklējiet nākamo mobu, ja jau ir aktīvā cīņā
                                }
                            ?>
                            <!-- Atrodas tikai tie mobi, ar kuriem nav aktīvu cīņu -->
                            <div class="col-xs-4">
                                <div class="row">
                                <div class="card bg-light card-body">
                                    <h4><center><img src="<?= $mob['avatar'] ?>" width="150" title="<?= $mob['username'] ?>"></center><center><?= $mob['username'] ?></center></h4>
                                    <center><?php echo lang_key("hp"); ?> <span class="badge badge-danger"><?= $mob['hp'] ?></span></h5></center>
                                    <center><?php echo lang_key("min_power"); ?> : <span class="badge badge-danger"><?= $mob['min_power'] ?></span> <?php echo lang_key("max_power"); ?> : <span class="badge badge-danger"><?= $mob['max_power'] ?></span></h5></center>
                                    <center><?php echo lang_key("attack_speed"); ?>: <span class="badge badge-warning"><?= $mob['attack_speed'] ?></span> Sek.</h5></center>
                            
                                    <!-- Add a tooltip for loot information -->
                                    <center>
                                        <?php echo lang_key("loot"); ?>: 
                                        <span class="badge badge-success" 
                                              title="<?= $mob['username'] ?>" 
                                              data-toggle="tooltip" 
                                              data-placement="top">
                                              <?= $mob['monster_drop_chance'] ?> %
                                        </span>
                                    </h5></center>
                            
                                    <?php
                                    if ($rowu['energy'] < 10 || $rowu['hp'] < 10) {
                                        echo '<button class="btn btn-danger btn-md btn-block" disabled title="' . lang_key("insufficient_hp_or_energy") . '"><em class="fa fa-fw fa-bolt"></em>' . lang_key("fight") . '</button>';
                                    } else {
                                        echo '<a href="?fight-id=' . $mob['id'] . '" class="btn btn-danger btn-md btn-block"><i class="fa fa-bolt"></i> ' . lang_key("fight") . '</a>';
                                    }
                                    ?>
                            
                                </div>
                            </div>
                
                
                            </div>
                            
                            <?php
                            }
                            ?>
                        
                    </div>
                <?php
                }
?>

   












    



<script>
  $(document).ready(function() {
    $('#victoryModal').modal('show');
  });


    // Initialize tooltips
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    
    
    
function countdownaction() {
   $("#action-modal").modal('show');

$(function(){
var timer = setInterval(function(){
$("#count_num").html(function(i,html){
   
if(parseInt(html)>0) {
   if(parseInt(html-1)==0) {
	  window.setTimeout(function () {
        window.location = "?opponent=<?php
echo $rowuo['id'];
?>";
      }, 700);
      return "Fight";
      clearTimeout(timer);
	  $("#action-modal").modal('hide');
   } else {
      return parseInt(html)-1;
   }
}
});

},1000);
});

}
</script>


<?php
footer();
?>