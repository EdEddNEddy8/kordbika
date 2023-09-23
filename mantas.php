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
                                <h4><?= $item['name'] ?></h4>
                            </li>
                        </ul>
                    </center>
                    <div class="row">
                        <div class="col-xs-7">
                            <center>
                                <div class="item-frame">
                                    <img src="<?= $item['image'] ?>" width="100">
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
    } elseif ($item['type'] == 7 ) {
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