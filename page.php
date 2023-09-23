<?php
require "core.php";

$id = (int) $_GET['pageid'];
if (empty($id)) {
    echo '<meta http-equiv="refresh" content="0;url=home.php">';
}

$runcp = mysqli_query($mysqli, "SELECT * FROM `custom_pages` WHERE id='$id' LIMIT 1");
if (mysqli_num_rows($runcp) == 0) {
    echo '<meta http-equiv="refresh" content="0; url=home.php">';
}

$rowcp = mysqli_fetch_assoc($runcp);

if ($rowcp['logged'] == 'Yes') {
    if (isset($_SESSION['username'])) {
        $uname = $_SESSION['username'];
        $suser = mysqli_query($mysqli, "SELECT * FROM `players` WHERE username='$uname'");
        $rowu  = mysqli_fetch_assoc($suser);
        $count = mysqli_num_rows($suser);
        if ($count <= 0) {
            echo '<meta http-equiv="refresh" content="0; url=index.php" />';
            exit;
        }
		@include 'languages/' . $rowu['language'] . '.php';
    } else {
        echo '<meta http-equiv="refresh" content="0; url=index.php" />';
        exit;
    }
    
    head();
} else {
    if (isset($_SESSION['username'])) {
        $uname = $_SESSION['username'];
        $suser = mysqli_query($mysqli, "SELECT * FROM `players` WHERE username='$uname'");
        $rowu  = mysqli_fetch_assoc($suser);
        $count = mysqli_num_rows($suser);
        if ($count > 0) {
			@include 'languages/' . $rowu['language'] . '.php';
			head();
		} else {
			headind();
		}
	} else {
		headind();
	}
}
?>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-white bg-primary">
                <i class="fa <?php
echo $rowcp['fa_icon'];
?>"></i> <?php
echo $rowcp['title'];
?>
            </div>
            <div class="card-body">
<?php
echo html_entity_decode($rowcp['content']);
?>
            </div>
        </div>
	</div><br />
<?php
footer();
?>