<?php
require "core.php";
head();

$uname = $_SESSION['username'];
$suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu  = mysqli_fetch_assoc($suser);

if (isset($_GET['id'])) {
    $uid     = $_GET['id'];
    $querypl = mysqli_query($connect, "SELECT * FROM `players` WHERE id='$uid' LIMIT 1");
    @$countpl = mysqli_num_rows($querypl);
    if ($countpl == 0) {
        echo '<meta http-equiv="refresh" content="0; url=home.php" />';
        exit;
    }
    $rowpl = mysqli_fetch_assoc($querypl);
} else {
    echo '<meta http-equiv="refresh" content="0; url=home.php" />';
    exit;
}

if (isset($_POST['postcomment'])) {
    $comment   = $_POST['comment'];
    $player_id = $rowpl['id'];
    $author_id = $rowu['id'];
    $date      = date('d F Y');
    $time      = date('H:i');
    
    $querycpc = mysqli_query($connect, "SELECT * FROM `player_comments` WHERE author_id='$author_id' AND player_id='$player_id' AND comment='$comment' AND date='$date' LIMIT 1");
    $countcpc = mysqli_num_rows($querycpc);
    if ($countcpc == 0) {
        $post_comment = mysqli_query($connect, "INSERT INTO `player_comments` (player_id, author_id, comment, date, time) VALUES ('$player_id', '$author_id', '$comment', '$date', '$time')");
    }
}
?>
        <div class="col-md-12 well">
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bar-chart"></i> <?php
echo $rowpl['username'];
?><?php
echo lang_key("s-statistics");
?></h3>
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <img src="<?php
echo $rowpl['avatar'];
?>" width="100%" />
                                </div>
                                <div class="col-md-8">
                                    <h2><i class="fa fa-user"></i> <?php
echo $rowpl['username'];
?> <font size="4px">
<?php
if ($rowpl['role'] == "Admin") {
    echo '<span class="label label-danger"><i class="fa fa-bookmark"></i> ' . $rowpl['role'] . '</span> ';
}

if ($rowpl['role'] == "VIP") {
    echo '<span class="label label-warning"><i class="fa fa-star"></i> ' . $rowpl['role'] . '</span> ';
}

$timeonline = time() - 60;
if ($rowpl['timeonline'] > $timeonline) {
    echo '<span class="label label-success"><i class="fa fa-circle"></i> Online</span>';
}
?>
</font></h2>
                                    <hr />
                                    
                                    
<h5><strong><i class="fa fa-star"></i> <?php echo lang_key("last-online"); ?>: </strong>
<?php
$lastOnline = $rowpl['timeonline']; // Assuming $rowpl['timeonline'] is a timestamp
$currentTimestamp = time();
$timeDifference = $currentTimestamp - $lastOnline;

if ($timeDifference < 60) {
    echo '<span class="label label-success"><i class="fa fa-circle"></i> Online</span>';
} elseif ($timeDifference < 3600) {
    $minutesAgo = round($timeDifference / 60);
    echo '<span class="label label-primary">' . $minutesAgo . ' ' . lang_key("minutes-ago") . '</span>';
} elseif ($timeDifference < 86400) {
    $hoursAgo = round($timeDifference / 3600);
    echo '<span class="label label-primary">' . $hoursAgo . ' ' . lang_key("hours-ago") . '</span>';
} else {
    $lastOnlineFormatted = date("d F Y, H:i", $lastOnline); // Format the timestamp as you desire
    echo '<span class="label label-primary">' . $lastOnlineFormatted . '</span>';
}
?>
</h5>

                                </div>
                            </div>
                            <hr />

                            <b><i class="fa fa-star"></i> <?php
echo lang_key("level");
?>:</b> <?php
echo $rowpl['level'];
?>
<?php
$level   = $rowpl['level'];
$querycl = mysqli_query($connect, "SELECT min_respect FROM `levels` WHERE level='$level'");
$rowcl   = mysqli_fetch_assoc($querycl);
$querynl = mysqli_query($connect, "SELECT min_respect FROM `levels` WHERE level='$level'+1");
$rownl   = mysqli_fetch_assoc($querynl);

$levelpercent = (($rowpl['respect'] - $rowcl['min_respect']) / ($rownl['min_respect'] - $rowcl['min_respect'])) * 100;
?>
                            <div class="progress progress-striped active">
                                <div class="progress-bar progress-bar-primary" style="width: <?php
echo '' . round($levelpercent) . '';
?>%"></div>
                            </div>
                            <hr>
<?php
$querypfw = mysqli_query($connect, "SELECT * FROM `fights` WHERE winner_id='$uid'");
$countpfw = mysqli_num_rows($querypfw);
$querymfw = mysqli_query($connect, "SELECT * FROM `fight_history` WHERE player_id='$player_id'");
$countmfw = mysqli_num_rows($querypfw);
?>
                            <div class="row">
                                <div class="col-md-3"><b><i class="fa fa-bolt"></i> <?php
echo $countpfw;
?></b>
                                    <br/><small><?php
echo lang_key("fight-wins");
?></small>
                                </div>
                                
                              <div class="col-md-3"><b><i class="fa fa-bolt"></i> <?php
echo $countmfw;
?></b>
                                    <br/><small><?php
echo lang_key("monsters-wins");
?></small>
                                </div>  
                                
                                
                            </div>

                        </div>
                    </div>
                            <!--šeit var sākt jaunu sadadaļu--->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-wrench"></i> <?php
echo $rowpl['username'];
?>'s hz kas</h3>
                        </div>
                        <div class="panel-body">
                            <!--šeit var ielikt kautko  --->
                        </div>
                    </div>

                  
                    
                    
                </div>

                

                


<!-- Uzvilktās Mantas-->

<div class="col-md-8 ">
    <div class="panel panel-danger">
        <h2>Uzvilktās mantas</h2>
        
        <centre>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h3>Cepure</h3>
                <?php
                $queryi = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE player_id='$player_id' AND equipped=1 AND type='1'");
                while ($item = mysqli_fetch_assoc($queryi)) {
                    $item_id = $item['id'];
                ?>
                <div class="item">
                    <h4><?= $item['item'] ?></h4>
                   <div class="item-image-frame" onclick="removeCepure(<?= $item_id ?>)">
                    <img src="<?= $item['image'] ?>" width="100">
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            <div class="col-md-4"></div>
            <!-- Turpiniet ar citām kategorijām -->
        </div>
        </centre>
        
        <div class="row">
            <div class="col-md-4">
                <h3>Nūja</h3>
                <?php
                $queryi = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE player_id='$player_id' AND equipped=1 AND type='3'");
                while ($item = mysqli_fetch_assoc($queryi)) {
                    $item_id = $item['id'];
                ?>
                <div class="item">
                    <h4><?= $item['item'] ?></h4>
                    <div class="item-image-frame" onclick="removeNuja(<?= $item_id ?>)">
                    <img src="<?= $item['image'] ?>" width="100">
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            <div class="col-md-4">
                <h3>Apmetnis</h3>
                <?php
                $queryi = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE player_id='$player_id' AND equipped=1 AND type='2'");
                while ($item = mysqli_fetch_assoc($queryi)) {
                    $item_id = $item['id'];
                ?>
                <div class="item">
                    <h4><?= $item['item'] ?></h4>
                    <div class="item-image-frame" onclick="removeApmetnis(<?= $item_id ?>)">
                    <img src="<?= $item['image'] ?>" width="100">
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            <div class="col-md-4">
                <h3>Amulets</h3>
                <?php
                $queryi = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE player_id='$player_id' AND equipped=1 AND type='4'");
                while ($item = mysqli_fetch_assoc($queryi)) {
                    $item_id = $item['id'];
                ?>
                <div class="item">
                    <h4><?= $item['item'] ?></h4>
                    <div class="item-image-frame" onclick="removeAmulets(<?= $item_id ?>)">
                    <img src="<?= $item['image'] ?>" width="100">
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        
        
         <!-- Zābaki -->
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h3>Zābaki</h3>
                <?php
                $queryi = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE player_id='$player_id' AND equipped=1 AND type='5'");
                while ($item = mysqli_fetch_assoc($queryi)) {
                    $item_id = $item['id'];
                ?>
                <div class="item">
                    <h4><?= $item['item'] ?></h4>
                    <div class="item-image-frame" onclick="removeZabakus(<?= $item_id ?>)">
                    <img src="<?= $item['image'] ?>" width="100">
                    </div>
                    </center>
                   
                </div>
                <?php
                }
                ?>
            </div>
            
            <!-- Turpiniet ar citām kategorijām -->
        </div>
        
        
                    <h2>Visi uzvilktie gredzeni</h2>
                    <div class="row">
                <?php
                $queryi = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE player_id='$player_id' AND equipped=1 AND type='6'");
                while ($item = mysqli_fetch_assoc($queryi)) {
                    $item_id = $item['id'];
                ?>
                <div class="col-md-1">
                    <center>
                        <ul class="breadcrumb">
                            <li class="active">
                                <h4><?= $item['item'] ?></h4>
                            </li>
                        </ul>
                    </center>
                    <div class="row">
                        <div class="col-md-4">
                            <center>
                                <!-- Ievietojam bildi un pievienojam JavaScript funkciju -->
                                <div class="item-image-frame" onclick="removeGredzenus(<?= $item_id ?>)">
                                    <img src="<?= $item['image'] ?>" width="100">
                                </div>
                            </center>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>

    </div>
</div>
        </div>
        
    </div>
</div>
<?php
footer();
?>