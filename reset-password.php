<?php
require "config.php";

if (isset($_SESSION['username'])) {
    $uname = $_SESSION['username'];
    $suser = mysqli_query($mysqli, "SELECT * FROM `players` WHERE username='$uname'");
    $count = mysqli_num_rows($suser);
    if ($count > 0) {
        echo '<meta http-equiv="refresh" content="0; url=home.php" />';
        exit;
    }
}

$_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

$dirname   = $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
$vcity_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$dirname";

$query = mysqli_query($mysqli, "SELECT * FROM `settings` LIMIT 1");
$row   = mysqli_fetch_assoc($query);

if (isset($_GET["key"])) {
    $key     = $_GET["key"];
    $curDate = date("Y-m-d H:i:s");
    $query   = mysqli_query($mysqli, "SELECT * FROM `password_reset` WHERE `resetkey`='" . $key . "' LIMIT 1");
    $rowrr   = mysqli_num_rows($query);
    if ($rowrr <= 0) {
        echo '<meta http-equiv="refresh" content="0;url=' . $vcity_url . '" />';
        exit;
    } else {
        $rowrr   = mysqli_fetch_assoc($query);
        $email   = $rowrr['email'];
        $expDate = $rowrr['expiry_date'];
        if ($expDate < $curDate) {
            echo '<meta http-equiv="refresh" content="0;url=' . $vcity_url . '" />';
            exit;
        }
    }
} else {
    echo '<meta http-equiv="refresh" content="0;url=' . $vcity_url . '" />';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="<?php
echo $row['description'];
?>">
    <meta name="author" content="Antonov_WEB">
    <link rel="icon" href="assets/img/favicon.png">

    <title><?php
echo $row['title'];
?></title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	
    <!-- Game CSS -->
    <link href="assets/css/game.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.0/css/all.css">

    <style type="text/css">
    .indbgr {
  background: url(assets/img/city2.jpg) no-repeat center center fixed;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
  </style>
</head>

<body>

    <center>
        <nav class="navbar navbar-dark bg-dark navbar-expand-md">
            <a class="navbar-brand" href="#"><i class="fa fa-building"></i> <i class="fa fa-car"></i> <i class="fa fa-users"></i> <?php
echo $row['title'];
?></a>
                    <button type="button" class="navbar-toggler collapsed" data-bs-toggle="collapse"
                data-bs-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Navigation</span>
&#x2630;</button>
                    <a class="navbar-brand d-block d-sm-none" href="index.php"><?php
echo $row['title'];
?></a>
                <div id="navbar" class="navbar-collapse collapse justify-content-md-center">
                    <ul class="nav navbar-nav">
                        <li class="active nav-item"><a href="#home" class="nav-link"><i class="fa fa-home fa-2x"></i><br /> Home</a></li>
                        <li><a href="index.php#about" class="nav-link"><i class="fa fa-info-circle fa-2x"></i><br /> About The Game</a></li>
                        <li><a href="index.php#screenshots" class="nav-link"><i class="fa fa-images fa-2x"></i><br /> Screenshots</a></li>
                        <li><a href="index.php#gamelogin" class="nav-link"><i class="fa fa-sign-in-alt fa-2x"></i><br /> Sign In</a></li>
                    </ul>
			   </div>
        </nav>
    </center>

    <div class="container-fluid">

        <div class="jumbotron indbgr">
            <div class="row">
                <div class="col-md-7" style="color: black; text-shadow: 1px 1px #ffffff;">
                    <h2><i class="fa fa-building"></i> <i class="fa fa-car"></i> <i class="fa fa-users"></i> <?php
echo $row['title'];
?></h2>
                    <h5><?php
echo $row['description'];
?></h5>
                </div>
                <div class="col-lg-5 col-12" id="gamelogin">
                    <div class="card bg-light card-body mb-3">
                <?php
$error = "No";

if (isset($_POST['newpass'])) {
    $password = hash('sha256', $_POST['password']);
    $check    = mysqli_query($mysqli, "SELECT username, email FROM `players` WHERE `email`='$email'");
    if (mysqli_num_rows($check) <= 0) {
        $error = "Yes";
    } else {
        $querysd = mysqli_query($mysqli, "UPDATE `players` SET password='$password' WHERE `email`='$email'");
        $queryrd = mysqli_query($mysqli, "DELETE FROM `password_reset` WHERE email='$email'");
        
        $rowpusn              = mysqli_fetch_assoc($check);
        $pusname              = $rowpusn['username'];
        $_SESSION['username'] = $pusname;
        echo '<meta http-equiv="refresh" content="0;url=home.php">';
    }
}
?>
                <form action="reset-password.php?key=<?php
echo $key;
?>" method="post">
					<center>
                                <h5><i class="fa fa-key"></i> Reset Password</h5>
                                <hr />
                            </center>
                    <div class="form-group">
                        <label style="width:100%;">New Password</span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><em class="fa fa-fw fa-key"></em></div>
          </div>
                            <input name="password" type="password" placeholder="Password" class="form-control" <?php
if ($error == "Yes") {
    echo 'autofocus';
}
?> required>
                        </div><br />
						<div class="btn-toolbar">
                                <button type="submit" name="newpass" class="btn btn-info btn-md col-12"><i class="fa fa-floppy"></i> Save</button>
                            </div>
                            </form>
                    </div>
						  </div>
						</div>
                    </div>
            </div>
        </div>

    </div>
    <!-- /container -->

    <footer class="footer">
        <div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
            <div class="float-end">&copy; <?php
echo date("Y");
?> <?php
echo $row['title'];
?></div>

			</div>
		</div>
        </div>
    </footer>

</body>
</html>