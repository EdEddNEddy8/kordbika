<?php
require "core.php";
head();

$uname = $_SESSION['username'];
$suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
$rowu  = mysqli_fetch_assoc($suser);

if (isset($_POST['start'])) {
    $character_id = $_POST['character'];
    
    $querycs = mysqli_query($connect, "SELECT * FROM `characters` WHERE id = '$character_id' LIMIT 1");
    $countcs = mysqli_num_rows($querycs);
    
        
        $character_set = mysqli_query($connect, "UPDATE `players` SET character_id='$character_id'  WHERE username='$uname'");
        echo '<meta http-equiv="refresh" content="0;url=home.php">';
        exit;
    
}
?>
        
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-male"></i> <?php
echo lang_key("choose-your-character");
?></h3>
            </div>
            <div class="panel-body">
                <center><h2><i class="far fa-hand-pointer"></i> <?php
echo lang_key("choose-your-character");
?></h2></center><br />

        
           
                <ul class="nav nav-tabs nav-justified">
<?php
$first   = true;
$querycc = mysqli_query($connect, "SELECT * FROM `character_categories`");
while ($rowcc = mysqli_fetch_assoc($querycc)) {
?>
                    <li <?php
    if ($first) {
        echo 'class="active"';
        $first = false;
    }
?></l><a data-toggle="tab" href="#<?php
    echo $rowcc['id'];
?>"><i class="fa <?php
    echo $rowcc['fa_icon'];
?>"></i> <?php
    echo $rowcc['category'];
?></a></li>
<?php
}
?>
                </ul>

                <form role="form" action="" method="post">
                    <input type="submit" name="start" value="<?php
echo lang_key("start-the-game");
?>" class="btn btn-success btn-md btn-block">
                    <div class="tab-content">
<?php
$firsta   = true;
$queryccs = mysqli_query($connect, "SELECT * FROM `character_categories`");
while ($rowccs = mysqli_fetch_assoc($queryccs)) {
    $category_id = $rowccs['id'];
?>
                        <div id="<?php
    echo $category_id;
?>" class="tab-pane fade in <?php
    if ($firsta) {
        echo 'active';
        $firsta = false;
    }
?>">
                            <div class="row">
<?php
    $queryc = mysqli_query($connect, "SELECT * FROM `characters` WHERE category_id = '$category_id'");
    while ($rowc = mysqli_fetch_assoc($queryc)) {
?>
                                <div class="col-md-3">
                                    <center>
                                        <h2><br /><span class="label label-default"><?php
        echo $rowc['name'];
?></span></h2>
                                    </center><br />
                                    <label class="btn btn-default">
                                        <input type="radio" name="character" value="<?php
        echo $rowc['id'];
?>" required />
                                        <img src="<?php
        echo $rowc['image'];
?>" width="100%" />
                                    </label>
                                    <hr />
                                </div>
<?php
    }
?>
                            </div>
                            
                        </div>
<?php
}
?>
                    </div>

                    <br />
                    <input type="submit" name="start" value="<?php
echo lang_key("start-the-game");
?>" class="btn btn-success btn-md btn-block">
                </form>

            </div>
        </div>
<?php
footer();
?>