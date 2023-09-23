<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];



if (isset($_POST['save'])) {
    $email    = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $emused = 'No';
    
    $susere  = mysqli_query($connect, "SELECT * FROM `players` WHERE email='$email' && id != $player_id LIMIT 1");
    $countue = mysqli_num_rows($susere);
    if ($countue > 0) {
        $emused = 'Yes';
    }
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        if ($password != null) {
            $password = hash('sha256', $_POST['password']);
            $querysd  = mysqli_query($connect, "UPDATE `players` SET email='$email', password='$password', username='$username' WHERE id='$player_id'");
            
            // Saglabā spēlētāja jauno username sesijas mainīgajā
            $_SESSION['username'] = $username;
        } else {
            $querysd = mysqli_query($connect, "UPDATE `players` SET email='$email', username='$username' WHERE id='$player_id'");
            
            // Saglabā spēlētāja jauno username sesijas mainīgajā
            $_SESSION['username'] = $username;
        }
        
    }
    
    echo '<meta http-equiv="refresh" content="0;url=settings.php">';
}
?>

<div class="container">
<div class="col-md-12 well">
<center>
        <a class="btn btn-danger " href="choice-avatar.php" role="button"><i class="fas fa-book-dead"></i> <?php echo lang_key("change-avatar");?> </a> 
        <a class="btn btn-danger " href="choose-character.php" role="button"><i class="fas fa-book-dead"></i> <?php echo lang_key("choose-character");?> </a> 
         <a class="btn btn-danger " href="avatar-frame.php" role="button"><i class="fas fa-book-dead"></i> <?php echo lang_key("choose-frame");?> </a> 
</center>
    
    <center><h2><i class="fa fa-cog"></i> <?php
echo lang_key("account-settings");
?></h2></center><br />

    <div class="row">

        <div class="col-md-1"></div>
		<div class="col-md-10">
		    
			<form action="" method="post">
			    <div class="form-group">
 			       <label for="email"><i class="fa fa-user"></i> <?php
echo lang_key("email-address");
?></label>
                   <input type="email" class="form-control" id="email" name="email" value="<?php
echo $rowu['email'];
?>">
 			    </div>
 			    
 			    
			    <div class="form-group">
 			       <label for="username"><i class="fa fa-user"></i> <?php
echo lang_key("username");
?></label>
                   <input type="username" class="form-control" id="username" name="username" value="<?php
echo $rowu['username'];
?>">
 			    </div>
				
                   
				<div class="form-group">
 			       <label for="password"><i class="fa fa-user"></i> <?php
echo lang_key("new-password");
?></label>
                   <input type="password" class="form-control" id="password" name="password" value="">
				   <i><?php
echo lang_key("password-message");
?></i><br /><br />
 			    </div>
 			    <button type="submit" name="save" class="btn btn-primary btn-block"><i class="far fa-floppy"></i>&nbsp; <?php
echo lang_key("save");
?></button>
			</form>
			
		</div>
		<div class="col-md-1"></div>







    </div>
    
</div>
<?php
footer();
?>