
<?php
require "core.php";
head();

$uname = $_SESSION['username'];
$suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
$rowu  = mysqli_fetch_assoc($suser);

if (isset($_POST['upghp'])) {
    if ($rowu['atr_point'] >= $sum) {
        $upghp = mysqli_query($connect, "UPDATE `players` SET max_hp=max_hp+'1',atr_point=atr_point-'1' WHERE id='$player_id'");
        echo '<meta http-equiv="refresh" content="0;url=upgrade_stats.php">';
        exit;
    }
}

if (isset($_POST['upgenergy'])) {
    if ($rowu['atr_point'] >= $sum) {
        $upghp = mysqli_query($connect, "UPDATE `players` SET max_energy=max_energy+'1',atr_point=atr_point-'1' WHERE id='$player_id'");
        echo '<meta http-equiv="refresh" content="0;url=upgrade_stats.php">';
        exit;
    }
}



if (isset($_POST['magic_level'])) {
    if ($rowu['atr_point'] >= $sum) {
        $upgmagic_level = mysqli_query($connect, "UPDATE `players` SET magic_level=magic_level+'1', atr_point=atr_point-'1000' WHERE id='$player_id'");
        echo '<meta http-equiv="refresh" content="0;url=upgrade_stats.php">';
        exit;
    }
}

?>

<div class="container mt-5">
        <!-- Game CSS -->
    
    <div class="row well">
        <center><h2><i class="fa "></i> <?php echo lang_key("stati");?></h2></center>
        <center>
            <a class="btn btn-danger active" href="upgrade_stats.php" >
                <i class="fas fa-book-dead"></i> <?php echo lang_key("upagrade-stats");?> 
            </a>
        </center>
    </div>

    <div class="well p-4">
        <center>
            <?php echo lang_key("you have atribut points:");?> <?php echo $rowu['atr_point'];?>
        </center>
        <hr>

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
                    <th><strong><?php echo $rowu['max_hp'];?></strong></th>
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
                    <th><strong><?php echo $rowu['max_energy'];?></strong></th>
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
                
              
                
                <tr>
                    <th></th>
                    <th><h5 title="<?php echo lang_key("total-magic-level");?>">
                        <font color="purple"><i class="fas fa-radiation"></i> <?php echo lang_key("magic-level");?></font>
                    </h5></th>
                    <th><strong><?php echo $rowu['magic_level'];?></strong></th>
                    <th>
                        <?php 
                        if ($rowu['magic_level'] < 5 & $rowu['atr_point'] >= 1000) {
                            echo '<form action="" method="post" style="width: 80%;" enctype="multipart/form-data">
                                    <button type="submit" name="magic_level" class="btn btn-success col-4"> Buy</button>
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



<?php
footer();
?>


