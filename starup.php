<?php
require "core.php";
head();

$uname = $_SESSION['username'];
$suser = mysqli_query($connect, "SELECT id FROM `players` WHERE username='$uname' LIMIT 1");
$rowu = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_GET['upgrade-id'])) {
    $item_id = (int)$_GET["upgrade-id"];

    // Pārbauda, vai manta ir gredzens
    $item_equip = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE id='$item_id' LIMIT 1");
    $itemeq = mysqli_fetch_assoc($item_equip);
    $stars = $itemeq['stars'];
    
    if ($stars < 5) {
        // Ja manta zvaigznes līmenis ir mazāks par 5, turpiniet ar uzlabošanas darbību
        $upgradeStones = $itemeq['upgrade_stones'];

        if ($upgradeStones >= 10) {
            // Veiciet mantas uzlabošanu
            $newStars = $stars + 1;

            mysqli_query($connect, "UPDATE `player_inventory` SET stars='$newStars' WHERE id='$item_id'");

            // Samaziniet uzlabošanas akmeņu skaitu par 10
            mysqli_query($connect, "UPDATE `players` SET upgrade_stones=upgrade_stones-10 WHERE id='$player_id'");

            echo '<div class="alert alert-success">Mantas ir uzlabotas veiksmīgi!</div>';
        } else {
            // Nav pietiekami daudz uzlabošanas akmeņu
            echo '<div class="alert alert-warning">Nav pietiekami daudz uzlabošanas akmeņu!</div>';
        }
    } else {
        // Manta zvaigznes līmenis jau ir maksimāls, rādiet kļūdas ziņojumu vai veiciet citus pasākumus
        echo '<div class="alert alert-warning">Mantas zvaigznes līmenis jau ir maksimāls!</div>';
    }
}







?>




<div class="col-md-12 well">
    <div class="row well">
        <center>
            <h2><i class="fa "></i> Iekrājumi</h2>
        </center><br />
        <center>
            <a class="btn btn-danger active" href="epuipments.php"><i class="fas fa-book-dead"></i> Ekips</a>
             <a class="btn btn-danger warning" href="epuipmentsup.php"><i class="fas fa-book-dead"></i> uzlabot</a>
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
                                            
                                           
                                            <a href="?upgrade-id=<?= $item_id ?>">Uzlabot šo mantu</a>


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