<?php
require "core.php";
head();

$uname = $_SESSION['username'];
$suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
$rowu  = mysqli_fetch_assoc($suser);

if (isset($_POST['choice-avatar'])) {
    $avatar1 = $_POST['character'];
    
    $querycs = mysqli_query($connect, "SELECT * FROM `avatar` WHERE id = '$avatar1' LIMIT 1");
    $rowa  = mysqli_fetch_assoc($querycs);
    $countcs = mysqli_num_rows($querycs);
    $awa=$rowa['image'];
        
        $character_set = mysqli_query($connect, "UPDATE `players` SET avatar='$awa',dimants=dimants-'25'  WHERE username='$uname'");
       echo '<meta http-equiv="refresh" content="0; url=choice-avatar.php">';
        exit;
    
}
?>
                   
                  
 <div class="container">
<center>  <div class="well"><i class="fa fa-cog"></i> <?php
echo lang_key("choice-avatar");
?><br><?php
echo lang_key("select-pic");
?></div>
</center>


              
  
  <div class="well"><center><img src="<?php echo $rowu['avatar'];?>" width="10%" /><?php echo lang_key("current-avatar");?></center> 


   
       	<form action="" method="post">                     
                    
<?php
    $queryc = mysqli_query($connect, "SELECT * FROM `avatar` WHERE id ");
    while ($rowc = mysqli_fetch_assoc($queryc)) {
?>                              
                                    
                                <div class="col-md-2">
                                
                                    <label class="btn btn-default">
                                        <input type="radio" name="character" value="<?php
        echo $rowc['id'];
?>" required />
                                        <img src="<?php
        echo $rowc['image'];
?>" width="100%" />
                                    </label>
                                  
                                </div>
<?php
    }
?>
                            
                            
                      
                    <?if ($rowu['dimants'] > '25') {
        echo '<button  type="submit" name="choice-avatar" class="btn btn-warning  btn-block"></i> <?php echo lang_key("choice-avatar");?> -25 <img src="images/resi/dimants.png" width="25"></button>';
    } else {
        
        echo '<button  type="submit" name="choice-avatar" class="btn btn-warning  btn-block disabled"></i> <?php echo lang_key("choice-avatar");?> -25 <img src="images/resi/dimants.png" width="25"></button>';
    }?>
                </form>

            </div>
       
        
        
</div>
<?php
footer();
?>