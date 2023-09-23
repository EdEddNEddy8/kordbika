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




$_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

function percent($num_amount, $num_total)
{
    @$count1 = $num_amount / $num_total;
    $count2 = $count1 * 100;
    $count  = number_format($count2, 0);
    return $count;
}

function emoticons($text)
{
    $icons = array(
        ':)' => '🙂',
        ':-)' => '🙂',
        ':}' => '🙂',
        ':D' => '😀',
        ':d' => '😁',
        ':-D ' => '😂',
        ';D' => '😂',
        ';d' => '😂',
        ';)' => '😉',
        ';-)' => '😉',
        ':P' => '😛',
        ':-P' => '😛',
        ':-p' => '😛',
        ':p' => '😛',
        ':-b' => '😛',
        ':-Þ' => '😛',
        ':(' => '🙁',
        ';(' => '😓',
        ':\'(' => '😓',
        ':o' => '😮',
        ':O' => '😮',
        ':0' => '😮',
        ':-O' => '😮',
        ':|' => '😐',
        ':-|' => '😐',
        ' :/' => ' 😕',
        ':-/' => '😕',
        ':X' => '😷',
        ':x' => '😷',
        ':-X' => '😷',
        ':-x' => '😷',
        '8)' => '😎',
        '8-)' => '😎',
        'B-)' => '😎',
        ':3' => '😊',
        '^^' => '😊',
        '^_^' => '😊',
        '<3' => '😍',
        ':*' => '😘',
        'O:)' => '😇',
        '3:)' => '😈',
        'o.O' => '😵',
        'O_o' => '😵',
        'O_O' => '😵',
        'o_o' => '😵',
        '0_o' => '😵',
        'T_T' => '😵',
        '-_-' => '😑',
        '>:O' => '😆',
        '><' => '😆',
        '>:(' => '😣',
        ':v' => '🙃',
        '(y)' => '👍',
        ':poop:' => '💩',
        ':|]' => '🤖'
    );
    return strtr($text, $icons);
}

if (isset($_SESSION['username'])) {
    $uname = $_SESSION['username'];
    $suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
    $rowu  = mysqli_fetch_assoc($suser);
    $count = mysqli_num_rows($suser);
    if ($count <= 0) {
        exit;
    }
    
    include 'languages/' . $rowu['language'] . '.php';
    
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
function formatNumber($number) {
    if ($number >= 1000000000) {
        return round($number / 1000000000, 1) . 'B';
    } elseif ($number >= 1000000) {
        return round($number / 1000000, 1) . 'M';
    } elseif ($number >= 1000) {
        return round($number / 1000, 1) . 'K';
    } else {
        return $number;
    }
}
?>

<div id="stats">
            <div class="row">
                <div class="col-md-8">
                    <h8><strong><i class="far fa-gem" style="color: white;"></i> <?php echo lang_key("dimants"); ?>: </strong><span class="label label-info" style="color: white;"><?php echo formatNumber($rowu['dimants']); ?></span></h8>
                    <h8><strong><i class="far fa-gem" style="color: white;"></i> <?php echo lang_key("zelts"); ?>: </strong><span class="label label-warning" style="color: white;"><?php echo formatNumber($rowu['zelts']); ?></span></h8>
                    <h8><strong><i class="far fa-gem" style="color: white;"></i> <?php echo lang_key("koks"); ?>: </strong><span class="label label-success" style="color: white;"><?php echo formatNumber($rowu['koks']); ?></span></h8>
                    <h8><strong><i class="far fa-gem" style="color: white;"></i> <?php echo lang_key("dzelzis"); ?>: </strong><span class="label label-success" style="color: white;"><?php echo formatNumber($rowu['dzelzs']); ?></span></h8>
                    <h8>
                        <span class="label label-success" style="color: white;">
                            <i class="fas fa-gem"></i> <?php echo formatNumber($rowu['āda']); ?>
                        </span>
                    </h8>
                    <h8>
                        <span class="label label-success" style="color: white;">
                            <i class="fa-solid fa-fingerprint"></i> <?php echo formatNumber($rowu['akmens']); ?>
                        </span>
                    </h8>
                </div>
            </div>
        </div>

<div id="stats2">
    
            <div class="stat-item">
    <b><i class="fa fa-star"></i> <?php echo lang_key("level"); ?>:</b> <?php echo $rowu['level']; ?>

    <?php
    $level = $rowu['level'];

    // Fetch the minimum respect for the current level
    $querycl = mysqli_query($connect, "SELECT min_respect FROM `levels` WHERE level = $level");
    $rowcl = mysqli_fetch_assoc($querycl);
    $minRespectCurrentLevel = $rowcl['min_respect'];

    // Fetch the minimum respect for the next level
    $nextLevel = $level + 1;
    $querynl = mysqli_query($connect, "SELECT min_respect FROM `levels` WHERE level = $nextLevel");
    $rownl = mysqli_fetch_assoc($querynl);
    $minRespectNextLevel = $rownl['min_respect'];

    ?>
    <div class="progress progress-striped active">
    <div class="progress-bar progress-bar-warning" style="width: <?php echo percent($rowu['respect'], $minRespectNextLevel); ?>%;">
        <span><h5><i class="fa fa-star"></i><?php echo lang_key("respect"); ?> <?php echo $rowu['respect']; ?> / <?php echo $minRespectNextLevel; ?></h5></span>
    </div>
</div>
   
</div>

            <div class="stat-item">
                <div class="progress progress-striped active">
                    <div class="progress-bar progress-bar-danger" style="width: <?php echo percent( $rowu['hp'], $rowu['max_hp']); ?>%;">
                        <span><h5><i class="fa-regular fa-heart fa-beat"></i><?php echo lang_key("hp"); ?> <?php echo $rowu['hp']; ?> / <?php echo $rowu['max_hp']; ?></h5></span>
                    </div>
                </div>
            </div>
            
            <div class="stat-item">
                <div class="progress progress-striped active">
                    <div class="progress-bar progress-bar-info" style="width: <?php echo percent( $rowu['energy'], $rowu['max_energy']); ?>%;">
                         <span><h5><i class="fa-solid fa-bolt fa-beat"></i> <?php echo lang_key("energy"); ?> <?php echo $rowu['energy']; ?> / <?php echo $rowu['max_energy']; ?></h5></span>
                    </div>
                </div>
            </div>
          
</div>

<div id="skills">
                <div class="stats-left">
                    <h5 style="color: #FF5C4B;"><strong><i class="fa-solid fa-khanda fa-beat"></i> <?php echo lang_key("attack"); ?>: </strong><span style="color: white;" ><?php echo formatNumber($rowu['attack']); ?></span></h5>
                    <br/>
                    <h5 style="color: #FF5C4B;"><strong><i class="fa-solid fa-shield-halved fa-beat"></i></i> <?php echo lang_key("defense"); ?>: </strong><span style="color: white;" ><?php echo formatNumber($rowu['defense']); ?></span></h5>
                </div>
                
                <div class="stats-center">
                    <h5 style="color: #FF5C4B;"><strong><i class="fa-solid fa-gun fa-fade"></i> <?php echo lang_key("power"); ?>: </strong><span style="color: white; "><?php echo formatNumber($rowu['power']); ?></span></h5>
                    <br/>
                    <h5 style="color: #FF5C4B;"><strong><i class="fa-solid fa-person-running fa-bounce"></i> <?php echo lang_key("agility"); ?>: </strong><span style="color: white;" ><?php echo formatNumber($rowu['agility']); ?></span></h5>
                </div>
                
                <div class="stats-right">
                    
                     <h5 style="color: #FF5C4B;"><strong><i class="fa-solid fa-hand-holding-heart fa-fade"></i></i> <?php echo lang_key("endurance"); ?>: </strong><span style="color: white;"><?php echo formatNumber($rowu['endurance']); ?></span></h5>
                     <br/>
                     <h5 style="color: #FF5C4B;"><strong><i class="fa-solid fa-brain fa-fade"></i> <?php echo lang_key("intelligence"); ?>: </strong><span style="color: white;" ><?php echo formatNumber($rowu['intelligence']); ?></span></h5>
                </div>
                
            </div>

<div id="chat">
<?php
    $gtday   = date("d");
    $gtmonth = date("n");
    $gtyear  = date("Y");
    
    $gthour   = date("H");
    $gtminute = date("i");
    
    $querygc = mysqli_query($connect, "SELECT * FROM `global_chat` ORDER BY id DESC LIMIT 15");
    while ($rowgc = mysqli_fetch_assoc($querygc)) {
        $author_id = $rowgc['player_id'];
        $querygcp  = mysqli_query($connect, "SELECT * FROM `players` WHERE id='$author_id' LIMIT 1");
        $rowgcp    = mysqli_fetch_assoc($querygcp);
?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <img src="<?php
        echo $rowgcp['avatar'];
?>" width="8%">&nbsp;&nbsp;<strong><a href="player?id=<?php
        echo $author_id;
?>"><?php
        echo $rowgcp['username'];
?></a></strong>
            </div>
            <div class="panel-body"><?php
        echo emoticons($rowgc['message']);
?></div>
            <div class="panel-footer">
                <i class="fas fa-clock"></i> 
<?php
        $mgetdate = date_parse_from_format("d F Y", $rowgc['date']);
        $mgettime = date_parse_from_format("H:i", $rowgc['time']);
        $mday     = $mgetdate["day"];
        $mmonth   = $mgetdate["month"];
        $myear    = $mgetdate["year"];
        $mhour    = $mgettime["hour"];
        $mminute  = $mgettime["minute"];
        
        if ($myear != $gtyear) {
            $d_year = $gtyear - $myear;
            if ($d_year == 1) {
                $gsymbol = '';
            } else {
                $gsymbol = 's';
            }
            echo '' . $d_year . ' year' . $gsymbol . ' ago';
        } else {
            if ($mmonth != $gtmonth) {
                $d_month = $gtmonth - $mmonth;
                if ($d_month == 1) {
                    $gsymbol = '';
                } else {
                    $gsymbol = 's';
                }
                echo '' . $d_month . ' month' . $gsymbol . ' ago';
            } else {
                if ($mday != $gtday) {
                    $d_day = $gtday - $mday;
                    if ($d_day == 1) {
                        $gsymbol = '';
                    } else {
                        $gsymbol = 's';
                    }
                    echo '' . $d_day . ' day' . $gsymbol . ' ago';
                } else {
                    if ($mhour != $gthour) {
                        $d_hour = $gthour - $mhour;
                        if ($d_hour == 1) {
                            $gsymbol = '';
                        } else {
                            $gsymbol = 's';
                        }
                        echo '' . $d_hour . ' hour' . $gsymbol . ' ago';
                    } else {
                        if ($mminute != $gtminute) {
                            $d_minute = $gtminute - $mminute;
                            if ($d_minute == 1) {
                                $gsymbol = '';
                            } else {
                                $gsymbol = 's';
                            }
                            echo '' . $d_minute . ' minute' . $gsymbol . ' ago';
                        } else {
                            echo 'Just Now';
                        }
                    }
                }
            }
        }
        
?>
            </div>
        </div>
<?php
    }
?> 
</div>

<?php
    $timeon  = time() - 60;
    $queryop = mysqli_query($connect, "SELECT * FROM `players` WHERE timeonline>$timeon");
    $countop = mysqli_num_rows($queryop);
?>

                <div id="online">
                    <a href="leaderboard.php?tab=onlineplayers" class="btn btn-success btn-block pull-right"><i class="fa fa-users"></i> <?php
    echo lang_key("online-players");
?> &nbsp;&nbsp;<span class="badge badge-primary"><?php
    echo $countop;
?></span></a>
                </div>

<?php
    
    //Global Chat - Message Insert
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $chat_message = $_POST['chatmessage'];
        $player_id    = $rowu['id'];
        $date         = date('d F Y');
        $time         = date('H:i');
        
        $querygcm = mysqli_query($connect, "SELECT * FROM `global_chat` WHERE player_id='$player_id' AND message='$chat_message' AND date='$date' LIMIT 1");
        $countgcm = mysqli_num_rows($querygcm);
        if ($countgcm == 0 && $chat_message != "") {
            $post_gcmessage = mysqli_query($connect, "INSERT INTO `global_chat` (player_id, message, date, time) VALUES ('$player_id', '$chat_message', '$date', '$time')");
        }
    }
    
    //Get Prize
    if (isset($_POST['prize'])) {
        
        $player_id = $rowu['id'];
        $fullprize = $_POST['prize'];
        $sprize    = explode(" ", $fullprize);
        $prize     = $sprize[1];
        $value     = $sprize[0];
        
        $querycpc = mysqli_query($connect, "SELECT * FROM `casino_prizes` WHERE prizetype='$prize' AND value='$value' LIMIT 1");
        $countcpc = mysqli_num_rows($querycpc);
        
        if ($countcpc > 0) {
            $rowcpc = mysqli_fetch_assoc($querycpc);
            
            if ($prize == "Money") {
                $player_update = mysqli_query($connect, "UPDATE `players` SET money=money+'$value', spins=spins-1 WHERE id='$player_id'");
            }
            if ($prize == "Gold") {
                $player_update = mysqli_query($connect, "UPDATE `players` SET gold=gold+'$value', spins=spins-1 WHERE id='$player_id'");
            }
            if ($prize == "Respect") {
                $player_update = mysqli_query($connect, "UPDATE `players` SET respect=respect+'$value', spins=spins-1 WHERE id='$player_id'");
            }
            if ($prize == "Energy") {
                $player_update = mysqli_query($connect, "UPDATE `players` SET energy=energy+'$value', spins=spins-1 WHERE id='$player_id'");
            }
            if ($prize == "Health") {
                $player_update = mysqli_query($connect, "UPDATE `players` SET health=health+'$value', spins=spins-1 WHERE id='$player_id'");
            }
        }
        
    }
    
}


$current_time = date("Y-m-d H:i:s");

// Atjauno spēlētāja statistiku un dzēš mantas
$update_player_query = mysqli_query($connect, "UPDATE `players` AS p
    INNER JOIN `player_inventory` AS pi ON p.id = pi.player_id
    SET 
    p.power = p.power - pi.power,
    p.agility = p.agility - pi.agility,
    p.endurance = p.endurance - pi.endurance,
    p.intelligence = p.intelligence - pi.intelligence,
    p.attack = p.attack - pi.attack,
    p.defense = p.defense - pi.defense
    WHERE pi.type = '7' AND pi.termiņa_beigas <= '$current_time' AND pi.termiņa_beigas != '0000-00-00 00:00:00'");

if ($update_player_query) {
    // Dzēst beidzās mikstūras no inventāra
    $delete_expired_items_query = mysqli_query($connect, "DELETE FROM `player_inventory` WHERE type='7' AND termiņa_beigas <= '$current_time' AND termiņa_beigas != '0000-00-00 00:00:00'");

    if ($delete_expired_items_query) {
        // Iegūst dzēsto ierakstu skaitu
        $deleted_items_count = mysqli_affected_rows($connect);

        if ($deleted_items_count > 0) {
            // Beidzās mikstūras tika veiksmīgi noņemtas no inventāra
            echo '<div class="alert alert-success">Beidzās mikstūras tika dzēstas no inventāra, un statistika atņemta no spēlētāja.</div>';
        }
    } else {
        echo 'Kļūda, dzēšot beidzās mikstūras: ' . mysqli_error($connect);
    }
} else {
    echo 'Kļūda, atjaunojot spēlētāja statistiku: ' . mysqli_error($connect);
}
?>