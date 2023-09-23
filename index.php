<?php
require "config.php";

$lang = isset($_GET['lang']) ? $_GET['lang'] : "";

if (!empty($lang)) {
    $curr_lang = $_SESSION['curr_lang'] = $lang;
} else if (isset($_SESSION['curr_lang'])) {
    $curr_lang = $_SESSION['curr_lang'];
} else {
    $curr_lang = "en";
}

if (file_exists("languages/" . $curr_lang . ".php")) {
    include "languages/" . $curr_lang . ".php";
} else {
    include "languages/en.php";
}

if (isset($_GET['lang'])) {
    $langcode = $_GET["lang"];
    $queryls  = mysqli_query($connect, "SELECT * FROM `languages` WHERE langcode='$langcode'");
    $rowls    = mysqli_fetch_assoc($queryls);
    $countls  = mysqli_num_rows($queryls);
    if ($countls > 0) {
        $querytu = mysqli_query($connect, "UPDATE `players` SET language='$langcode' WHERE username='$uname'");
        echo '<meta http-equiv="refresh" content="0; url=home.php" />';
    }
}

// Returns language key
function lang_key($key)
{
    global $arrLang;
    $output = "";
    
    if (isset($arrLang[$key])) {
        $output = $arrLang[$key];
    } else {
        $output = str_replace("_", " ", $key);
    }
    return $output;
}

if (isset($_SESSION['username'])) {
    $uname = $_SESSION['username'];
    $suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
    
    $count = mysqli_num_rows($suser);
    if ($count > 0) {
        echo '<meta http-equiv="refresh" content="0; url=home.php" />';
        exit;
    }
}
//ielogoties//
if (isset($_POST['signin'])) {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = hash('sha256', $_POST['password']);
    $check    = mysqli_query($connect, "SELECT username, password FROM `players` WHERE `username`='$username' AND password='$password'");
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['username'] = $username;
        echo '<meta http-equiv="refresh" content="0;url=home.php">';
    } else {
        echo '
		<div class="alert alert-danger">
              <i class="fa fa-exclamation-circle"></i> The entered <strong>Username</strong> or <strong>Password</strong> is incorrect.
        </div>';
        $error = "Yes";
    }
}
//Aizmirsu paroli //
if (isset($_POST['forgpass'])) {
    $emailf = filter_var($_POST['emailf'], FILTER_SANITIZE_EMAIL);
    $check  = mysqli_query($connect, "SELECT email FROM `players` WHERE `email`='$emailf'");
    if (mysqli_num_rows($check) <= 0) {
        $error = "Yes";
    } else {
        $expFormat = mktime(date("H"), date("i"), date("s"), date("m"), date("d") + 1, date("Y"));
        $expDate   = date("Y-m-d H:i:s", $expFormat);
        $key = md5(2418 * 2);
        $key .= md5($emailf);
        $addKey = substr(md5(uniqid(rand(), 1)), 3, 10);
        $key    = $key . $addKey;
        mysqli_query($connect, "INSERT INTO `password_reset` (`email`, `resetkey`, `expiry_date`)
VALUES ('" . $emailf . "', '" . $key . "', '" . $expDate . "');");
        
        $subject = '' . $row['title'] . ' - Reset Password';
        $message = '
                                    <center>
                					<a href="' . $vcity_url . '" title="Visit ' . $row['title'] . '" target="_blank">
                					<h1>' . $row['title'] . ' - Reset Password</h1>
                					</a><br />

                					<h2>Please click on the following link to reset your password: </h2>
		<p><a href="' . $vcity_url . '/reset-password.php?key=' . $key . '">' . $vcity_url . '/reset-password.php?key=' . $key . '</a></p>
                					</center>
                				    ';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'To: ' . $emailf . ' <' . $emailf . '>' . "\r\n";
        $headers .= 'From: vcity@mail.com <vcity@mail.com>' . "\r\n";
        @mail($emailf, $subject, $message, $headers);
        
        echo '<div class="alert alert-primary">
                <i class="fa fa-envelope"></i> An email with instructions has been sent
              </div>';
    }
}
//reģistrēties//
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = hash('sha256', $_POST['password']);
    $email    = $_POST['email'];
    
    // Pārbauda, vai lietotājvārds satur tikai burtus un ciparus
    if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
        echo '<br /><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' . lang_key("invalid_username") . '</div>';
    } else {
        // Pārbauda, vai lietotājvārds jau eksistē
        $check_username_query = mysqli_query($connect, "SELECT username FROM `players` WHERE username='$username'");
        if (mysqli_num_rows($check_username_query) > 0) {
            echo '<br /><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' . lang_key("username_taken") . '</div>';
        } else {
            // Pārbauda, vai e-pasta adrese jau eksistē
            $check_email_query = mysqli_query($connect, "SELECT email FROM `players` WHERE email='$email'");
            if (mysqli_num_rows($check_email_query) > 0) {
                echo '<br /><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>  ' . lang_key("email_taken") . '</div>';
            } else {
                // Ja neviens lietotājs ar šādu lietotājvārdu vai e-pasta adresi nav atrasts, veic reģistrāciju
                $dimants    = $row['startdimants'];
                $zelts     = $row['startzelts'];
                $themeid  = $rowtd['id'];
                $langcode = $rowld['langcode'];
                
                $insert = mysqli_query($connect, "INSERT INTO `players` (username, password, email, dimants, zelts) VALUES ('$username', '$password', '$email', '$dimants', '$zelts')");
                
                $subject = 'Welcome at ' . $row['title'] . '';
                $message = '
                        <center>
                        <a href="' . $vcity_url . '" title="Visit ' . $row['title'] . '" target="_blank">
                        <h1>' . $row['title'] . '</h1>
                        </a><br />
                        
                        <h2>You have successfully registered at ' . $row['title'] . '</h2><br /><br />
                        
                        <b>Registration details:</b><br />
                        Username: ' . $username . '<b></b><br />
                        E-Mail Addess: ' . $email . '<b></b><br />
                        </center>
                        ';
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $headers .= 'To: ' . $email . ' <' . $email . '>' . "\r\n";
                $headers .= 'From: vcity@mail.com <vcity@mail.com>' . "\r\n";
                @mail($to, $subject, $message, $headers);
                
                $_SESSION['username'] = $username;
                echo '<meta http-equiv="refresh" content="0;url=home.php">';
            }
        }
    }
}


// Choose username modal
if ($chusername_modal == "Yes") {
    echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#choose-username").modal(\'show\');
            });
        </script>

        <div id="choose-username" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Choose username</h5>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label style="width:100%;">Username</span>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><em class="fa fa-fw fa-user"></em></div>
									</div>
                                    <input name="cusername" type="text" placeholder="Username" class="form-control"
';
    if ($errorcu == "Yes") {
        echo 'autofocus';
    }
    echo ' required>
                                </div>
                            </div>
                            <div class="btn-toolbar">
                                <button type="submit" name="choose_username" class="btn btn-info btn-md btn-block"><i class="fa fa-sign-in-alt"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
}

$_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

$dirname   = $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
$vcity_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$dirname";

$query = mysqli_query($connect, "SELECT * FROM `settings` LIMIT 1");
$row   = mysqli_fetch_assoc($query);

$timeon  = time() - 60;
$queryop = mysqli_query($connect, "SELECT * FROM `players` WHERE timeonline>$timeon");
$countop = mysqli_num_rows($queryop);

$querytp = mysqli_query($connect, "SELECT * FROM `players`");
$counttp = mysqli_num_rows($querytp);

$querybp = mysqli_query($connect, "SELECT * FROM `players` ORDER BY power DESC LIMIT 1 ");
$countbp = mysqli_num_rows($querybp);
if ($countbp > 0) {
    $rowbp       = mysqli_fetch_assoc($querybp);
    $best_player = $rowbp['username'];
} else {
    $best_player = "-";
}

$querynp = mysqli_query($connect, "SELECT * FROM `players` ORDER BY id DESC LIMIT 1");
$countnp = mysqli_num_rows($querynp);
if ($countnp > 0) {
    $rownp         = mysqli_fetch_assoc($querynp);
    $newest_player = $rownp['username'];
} else {
    $newest_player = "-";
}






if (isset($_POST['signin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Pārbauda lietotājvārdu un paroli
    // ...
    
    if ($valid_login) {
        // Ja lietotājs ir veiksmīgi pieslēdzies, izveido sīkdatnes
        setcookie('username', $username, time() + (86400 * 30), "/");
        setcookie('password', $password, time() + (86400 * 30), "/");

        // Pāradresē uz citu lapu
        header('Location: home.php');
        exit;
    } 
}

if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    // Ja ir saglabātas sīkdatnes, automātiski aizpilda formu
    $saved_username = $_COOKIE['username'];
    $saved_password = $_COOKIE['password'];
}



?>
<?php

$queryld = mysqli_query($connect, "SELECT * FROM `languages` WHERE default_language='Yes'");
$rowld   = mysqli_fetch_assoc($queryld);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content= "width=device-width, initial-scale=1.0"> 
   
    <meta name="description" content="<?php
echo $row['description'];
?>">
    <meta name="keywords" content="<?php
echo $row['keywords'];
?>">
    <meta name="author" content="Antonov_WEB">
    <link rel="icon" href="assets/img/50X50.jpg">

    <title><?php
echo $row['title'];
?></title>

    
    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    


    
    
    
    
    <!-- Game CSS -->
    <link href="assets/css/game.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
</head>

<body id="wrap">
<!-- Login CSS -->
    
 <div class="login-wrap">
	<div class="login-html">
		<input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab"><?php echo lang_key("signin");?></label>
		<input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab"><?php echo lang_key("register");?></label>
		
		<div class="login-form">
			<div class="sign-in-htm">
                <form action="" method="post">
                    <div class="form-group">
                        <label><?php echo lang_key("username"); ?></label>
                        <div class="group">
                            <input name="username" type="text" class="input" value="<?php echo isset($saved_username) ? $saved_username : ''; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?php echo lang_key("password"); ?></label>
                        <div class="group">
                            <input name="password" type="password" class="input" value="<?php echo isset($saved_password) ? $saved_password : ''; ?>" required>
                        </div>
                    </div>
                    <div class="group">
                        <input type="submit" name="signin" class="button" value="<?php echo lang_key("signin"); ?>">
                    </div>
                </form>
            </div>
		        
            <div class="sign-up-htm">
			<form action="" method="post">   
				<div class="form-group">
                    <label><?php echo lang_key("username");?></label>
                     <div class="group">
                    <input name="username" type="text" class="input"  pattern=".{5,}" required title="5 characters minimum" <?php if ($error == "Yes") { echo 'autofocus';}?> required>
                </div>
                </div>
				<div class="form-group">
                    <label><?php echo lang_key("password");?></label>
                     <div class="group">
                    <input name="password" type="text" class="input" data-type="password" pattern=".{5,}" required title="5 characters minimum" <?php if ($error == "Yes") { echo 'autofocus';}?> required>
                </div>
                </div>
				
				<div class="form-group">
                    <label><?php echo lang_key("email");?></label>
                    <div class="group">
                    <input name="email" type="text" class="input"  <?php if ($error == "Yes") { echo 'autofocus';}?> required>
                </div>
                </div>
				<div class="group">
                    <input type="submit" name="register" class="button" value="<?php echo lang_key("register");?>">
                    </form>
				</div>
				
			</div>

        </div>


                <div class="card bg-light card-body mb-3">
						  
<h6><i class="fas fa-check-circle"></i> Online Players: <span class="badge badge-success"><?php
echo $countop;
?></span></h6>
                    <h6><i class="fa fa-users"></i> Total Players: <span class="badge badge-primary"><?php
echo $counttp;
?></span></h6>
                    <h6><i class="fa fa-trophy"></i> Best Player: <span class="badge badge-danger"><?php
echo $best_player;
?></span></h6>
                    <h6><i class="fa fa-user-plus"></i> Newest Player: <span class="badge badge-warning"><?php
echo $newest_player;
?></span></h6>

                </div>
                
           
           
	</div>
	
</div>   
    
    
    

						  
						  
<div class="tab-pane fade <?php
echo $show3 . ' ' . $active3;
?>" id="forgotpass" role="tabpanel" aria-labelledby="forgotpass-tab">
<?php


?>
                <form action="" method="post">
                    <div class="form-group">
                        <span style="width:100%;">E-Mail Address</span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><em class="fa fa-fw fa-envelope"></em></div>
          </div>
                            <input name="emailf" type="text" placeholder="E-Mail Address" class="form-control" <?php
if ($error == "Yes") {
    echo 'autofocus';
}
?> required>
                        </div><br />
						<div class="btn-toolbar">
                                <button type="submit" name="forgpass" class="btn btn-info btn-md btn-block"><i class="fa fa-sign-in-alt"></i> Reset Password</button>
                            </div>
                            </form>
                    </div>
						  </div>
</div>




                

      
        

    
    <!-- /container -->

       <footer class="footer">
        <div class="container-fluid">
		<div class="row">
            <div class="col-md-6">
		
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?php
echo lang_key("languages");
?> <span class="caret caret-up"></span></button>
                <ul class="dropdown-menu drop-up" role="menu">
                    <li><a href="?lang=<?php
echo $rowld['langcode'];
?>"><?php
echo $rowld['language'];
?> [<?php
echo lang_key("default");
?>]</a></li>
                    <li class="divider"></li>
<?php
$queryl = mysqli_query($connect, "SELECT * FROM `languages`");
while ($rowl = mysqli_fetch_assoc($queryl)) {
?>
                    <li><a href="?lang=<?php
    echo $rowl['langcode'];
?>"><?php
    echo $rowl['language'];
?></a></li>
<?php
}
?>
                </ul>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?php
echo lang_key("themes");
?> <span class="caret caret-up"></span></button>
                <ul class="dropdown-menu drop-up" role="menu">
                    <li><a href="?theme=<?php
echo $rowtd['id'];
?>"><?php
echo $rowtd['name'];
?> [<?php
echo lang_key("default");
?>]</a></li>
                    <li class="divider"></li>
<?php
$queryt = mysqli_query($connect, "SELECT * FROM `themes`");
while ($rowt = mysqli_fetch_assoc($queryt)) {
?>
                    <li><a href="?theme=<?php
    echo $rowt['id'];
?>"><?php
    echo $rowt['name'];
?></a></li>
<?php
}
?>
                </ul>
            </div>
			
			</div>
			<div class="col-md-6">
			
            <div class="pull-right">&copy; <?php
echo date("Y");
?> <?php
echo $row['title'];
?></div>
            <a href="#" class="go-top"><i class="fa fa-arrow-up"></i></a>
			
			</div>
		</div>
        </div>
    </footer>

    <!-- JavaScript Libraries
    ================================================== -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Game JS -->
    <script src="assets/js/game.js"></script>

    <script type="text/javascript">
$(document).ready(function () {
    //Disable cut copy paste
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
    //Disable mouse right click
    $("body").on("contextmenu",function(e){
        return false;
    });
});


</script>
<!-- Game CSS -->

</body>
</html>