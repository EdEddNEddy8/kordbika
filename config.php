<?php
//Fill this information
$host     = "localhost"; // Database Host
$user     = "u642167750_kb"; // Database Username
$password = "Dreimani8!"; // Database's user Password
$database = "u642167750_kb"; // Database Name

//------------------------------------------------------------

$connect = mysqli_connect($host, $user, $password, $database);

// Checking Connection
if (mysqli_connect_errno()) {
    echo "Failed to connect with MySQL: " . mysqli_connect_error();
}

    
    
mysqli_set_charset($connect, "utf8");

@session_start();




if (isset($_SESSION['username'])) {
    $uname = $_SESSION['username'];
    $suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
    $count = mysqli_num_rows($suser);
    if ($count > 0) {
        //Set Online
        $prow    = mysqli_fetch_assoc($suser);
        $timenow = time();
        $update  = mysqli_query($connect, "UPDATE `players` SET timeonline='$timenow' WHERE username='$uname'");
        
        //Level Up
        $playerrespect = $prow['respect'];
        $playerlevel   = $prow['level'];
        $player_id=$prow['id'];
        $querylv       = mysqli_query($connect, "SELECT * FROM `levels` WHERE level='$playerlevel'");
        $lvrow         = mysqli_fetch_assoc($querylv);
        $minrespect    = $lvrow['min_respect'];
        $queryblv      = mysqli_query($connect, "SELECT * FROM levels WHERE level='$playerlevel'+1");
        $rowblv        = mysqli_fetch_assoc($queryblv);
        $blevel        = $rowblv['level'];
        $bminrespect   = $rowblv['min_respect'];
        
        if ($playerrespect > $bminrespect OR $playerrespect == $bminrespect) {
            $update = mysqli_query($connect, "UPDATE `players` SET level='$blevel', dimants=dimants+'100', atr_point=atr_point+'3' WHERE username='$uname'");
        }
        if ($playerrespect < $minrespect) {
            $update = mysqli_query($connect, "UPDATE `players` SET level=level-1 WHERE username='$uname'");
        }
        
        if ($prow['dimants'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET dimants=0 WHERE username='$uname'");
        }
        
        if ($prow['zelts'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET zelts=0 WHERE username='$uname'");
        }
        
        if ($prow['koks'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET koks=0 WHERE username='$uname'");
        }
        
        if ($prow['dzelzs'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET dzelzs=0 WHERE username='$uname'");
        }
        
        if ($prow['āda'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET āda=0 WHERE username='$uname'");
        }
        
        if ($prow['akmens'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET akmens=0 WHERE username='$uname'");
        }
        
        
        if ($prow['energy'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET energy=0 WHERE username='$uname'");
        }
        
        if ($prow['energy'] > $prow['max_energy']) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET energy=max_energy WHERE username='$uname'");
        }
        
        if ($prow['hp'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET hp=0 WHERE username='$uname'");
        }
        
        if ($prow['hp'] > $prow['max_hp']) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET hp=max_hp WHERE username='$uname'");
        }
        
        if ($prow['respect'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET respect=0 WHERE username='$uname'");
        }
        
        if ($prow['bank'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET bank=0 WHERE username='$uname'");
        }
        
        if ($prow['power'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET power=0 WHERE username='$uname'");
        }
        
    
        
        if ($prow['agility'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET agility=0 WHERE username='$uname'");
        }
        
        
        
        if ($prow['endurance'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET endurance=0 WHERE username='$uname'");
        }
        
        
        
        if ($prow['intelligence'] < 0) {
            $player_update = mysqli_query($connect, "UPDATE `players` SET intelligence=0 WHERE username='$uname'");
        }
        
        
        
        $querc = mysqli_query($connect, "SELECT * FROM `clans` WHERE leader_id= '$player_id'");

    $rowc = mysqli_fetch_assoc($querc);

    $clid=$rowc['id'];
    $lid=$rowc['leader_id'];
    $cln = mysqli_query($connect, "UPDATE `players` SET clan_id='$clid'  WHERE id='$lid'");
    }
    

    
}
?>