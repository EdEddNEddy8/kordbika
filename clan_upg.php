
<?php
require "core.php";
head();

$uname = $_SESSION['username'];
$suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
$rowu  = mysqli_fetch_assoc($suser);

// Pārbauda, vai spēlētājs ir klanā
if ($rowu['clan_id'] > 0) {
    // Spēlētājs ir klanā
    $clan_id = $rowu['clan_id'];

    // Pārbauda, vai spēlētājam jau ir piešķirti bonusi
    if ($rowu['clan_bonus_applied'] == 0) {
        // Spēlētājam vēl nav piešķirti bonusi

        // Atrodiet bonus_max_hp un bonus_max_energy vērtības no klana datiem
        $clan_query = mysqli_query($connect, "SELECT bonus_max_hp, bonus_max_energy FROM clans WHERE id='$clan_id'");
        $clan_data = mysqli_fetch_assoc($clan_query);

        if ($clan_data) {
            $bonus_max_hp = $clan_data['bonus_max_hp'];
            $bonus_max_energy = $clan_data['bonus_max_energy'];

            // Atjauno spēlētāja maksimālo HP un enerģiju, pievienojot bonusus
            mysqli_query($connect, "UPDATE players SET max_hp=max_hp+'$bonus_max_hp', max_energy=max_energy+'$bonus_max_energy' WHERE id='" . $rowu['id'] . "'");

            // Atzīmē, ka spēlētājam ir piešķirti bonusi
            mysqli_query($connect, "UPDATE players SET clan_bonus_applied=1 WHERE id='" . $rowu['id'] . "'");
        }
    }
}


?>

<div class="container mt-5">
        <!-- Game CSS -->
    <link href="assets/css/custom-style.css" rel="stylesheet">
    <div class="row well">
        <center><h2><i class="fa "></i> <?php echo lang_key("stati");?></h2></center>
        <center>
            <a class="btn btn-danger active" href="clan.php" >
                <i class="fas fa-book-dead"></i> <?php echo lang_key("clan");?> 
            </a>
        </center>
    </div>

    <div class="well p-4">
        <?php
       $clan_id = $rowu['clan_id'];
$result = mysqli_query($connect, "SELECT * FROM clans WHERE id='$clan_id'");
$clan_row = mysqli_fetch_assoc($result);
$hp = $clan_row['bonus_max_hp'];
$energy = $clan_row['bonus_max_energy'];
?>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th><?php echo lang_key("upgrade what?");?></th>
                    <th><?php echo lang_key("how much?");?></th>
                    <th><?php echo lang_key("upgrade?");?></th>
                </tr>
            </thead>
             <tbody>
                

                <tr>
                    
                    <th></th>
                    <th><h5 title="<?php echo lang_key("max hp upgrade");?>">
                        <font color="red"><i class="fas fa-radiation"></i> <?php echo lang_key("max hp upgrade");?></font>
                    </h5></th>
                    <th><strong><?php echo $clan_row['bonus_max_hp'];?></strong></th>
                    <th>
                        <?php 
                        if ($rowu['atr_point'] > 0) {
                            echo '<form action="" method="post" style="width: 80%;" enctype="multipart/form-data">
                                    <button type="submit" name="upghp" class="btn btn-success col-4"> Buy</button>
                                </form>';
                        } else {
                            echo '<button class="btn btn-danger btn-md col-12" disabled> Buy </button>';
                        }
                        ?>
                    </th>
                </tr>   

                <tr>
                    <th></th>
                    <th><h5 title="<?php echo lang_key("max energy upgrade");?>">
                        <font color="blue"><i class="fas fa-radiation"></i> <?php echo lang_key("max energy upgrade");?></font>
                    </h5></th>
                    <th><strong><?php echo $clan_row['bonus_max_energy'];?></strong></th>
                    <th>
                        <?php 
                        if ($rowu['atr_point'] > 0) {
                            echo '<form action="" method="post" style="width: 80%;" enctype="multipart/form-data">
                                    <button type="submit" name="upgenergy" class="btn btn-success col-4"> Buy</button>
                                </form>';
                        } else {
                            echo '<button class="btn btn-danger btn-md col-12" disabled> Buy </button>';
                        }
                        ?>
                    </th>
                </tr>   
                
                
                
                
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

<script>
function updatePlayerDatabase() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "clan_upg.php", true); // Aizvietojiet "update_player.php" ar sava servera skriptu nosaukumu, kas atjauno datubāzi
    xhr.send();
}

setInterval(updatePlayerDatabase, 1000); // Atjauno datubāzi ik pēc 1 sekundes (1000 milisekundes)
</script>

<?php
footer();
?>


