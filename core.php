<?php
require "config.php";

// Iegūst pašreizējo laiku
$current_time = time();


$_GET  = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if (isset($_SESSION['username'])) {
    $uname = $_SESSION['username'];
    $suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
    $rowu  = mysqli_fetch_assoc($suser);
    $count = mysqli_num_rows($suser);
    if ($count <= 0) {
        echo '<meta http-equiv="refresh" content="0; url=index.php" />';
        exit;
    }
} else {
    echo '<meta http-equiv="refresh" content="0; url=index.php" />';
    exit;
}

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




function percent($num_amount, $num_total)
{
    @$count1 = $num_amount / $num_total;
    $count2 = $count1 * 100;
    $count  = number_format($count2, 0);
    return $count;
}

function secondsToWords($seconds)
{
    $ret = "";
    
    //Days
    $mdays = intval(intval($seconds) / (3600 * 24));
    if ($mdays > 0) {
        $ret .= "$mdays days ";
    }
    
    //Hours
    $mhours = (intval($seconds) / 3600) % 24;
    if ($mhours > 0) {
        $ret .= "$mhours hours ";
    }
    
    //Minutes
    $mminutes = (intval($seconds) / 60) % 60;
    if ($mminutes > 0) {
        $ret .= "$mminutes minutes ";
    }
    
    /*
    //Seconds
    $seconds = intval($seconds) % 60;
    if ($seconds > 0) {
    $ret .= "$seconds seconds";
    }*/
    
    return $ret;
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






function head()
{
    require "config.php";
    
    $query = mysqli_query($connect, "SELECT * FROM `settings` WHERE id='1' LIMIT 1");
    $row   = mysqli_fetch_assoc($query);
    
    $uname     = $_SESSION['username'];
    $suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname'");
    $rowu      = mysqli_fetch_assoc($suser);
    $player_id = $rowu['id'];
    
    $querypc      = mysqli_query($connect, "SELECT character_id FROM `players` WHERE username='$uname' LIMIT 1");
    $rowpc        = mysqli_fetch_assoc($querypc);
    $character_id = $rowpc['character_id'];
    $queryc       = mysqli_query($connect, "SELECT * FROM `characters` WHERE id='$character_id' LIMIT 1");
    $countc       = mysqli_num_rows($queryc);
    $rowc         = mysqli_fetch_assoc($queryc);
    if ($countc == 0 && basename($_SERVER['SCRIPT_NAME']) != 'choose-character.php') {
        echo '<meta http-equiv="refresh" content="0; url=choose-character.php" />';
        exit;
    }
    
    
    @include 'languages/' . $rowu['language'] . '.php';
    
  







 
    
    
    
    
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
    <meta name="keywords" content="<?php
    echo $row['keywords'];
?>">
    <meta name="author" content="Antonov_WEB">
    <link rel="icon" href="assets/img/favicon.png">

    <title><?php
    echo $row['title'];
?></title>

    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">


    

    <!-- Game CSS -->
    <link href="assets/css/game.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">


    <!-- Right Sidebar - Chat -->
    <link href="assets/css/sidebar.css" rel="stylesheet">
	
<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'leaderboard.php' OR basename($_SERVER['SCRIPT_NAME']) == 'messages.php') {
        echo '
	<!-- DataTables -->
    <link href="assets/css/datatables.min.css" rel="stylesheet">';
    }
?>

<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'messages.php') {
        echo '
	<!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet">';
    }
?>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    
<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'casino.php') {
        echo '
	<!-- WinWheel -->
    <link href="assets/css/winwheel.css" rel="stylesheet">
	<script src="assets/js/winwheel.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js">';
    }
?>
	
<script>
setInterval(function () {
    $("#playerstats").load("ajax.php #stats");
    $("#playerstats2").load('ajax.php #stats2');
    $("#playerskills").load('ajax.php #skills');
    $("#globalchat").load('ajax.php #chat');
    $("#onlineplayers").load('ajax.php #online');
}, 1000);
</script>
    
</head>

<body>
<?php    
// Daily Bonus
date_default_timezone_set('Europe/Riga');
$current_date = date('d F Y');

if ($rowu['daily_bonus'] != $current_date) {
    $dimants_bonus = $row['dailybonus_dimants'];

    $claim_bonus = mysqli_query($connect, "UPDATE `players` SET dimants=dimants+'$dimants_bonus', daily_bonus='$current_date' WHERE id='$player_id'");
    
    echo '
    <script type="text/javascript">
        $(document).ready(function() {
            $("#daily-bonus").modal(\'show\');
        });
    </script>
    
    <div id="daily-bonus" class="modal fade">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Daily Bonus</h6> 
                    
                    
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <center>
                        <h5><span class="badge bg-info">You received a daily reward</span></h5>
                        <br /><br />
                        <div class="row">
                            <div class="col-md-6">
                                <img src="images/resi/dimants.png" width="25%"><br />
                                <h5>Money: <br /><hr /><span class="badge bg-secondary">+ ' . $dimants_bonus . '</span></h5>
                            </div>
                        </div>
                        <div class="modal-footer">
                                        
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                    </center>
                </div>
            </div>
        </div>
    </div>';
}
?>

<?php 
$current_time = date("Y-m-d H:i:s");

// Iegūst mikstūras, kuras ir beigušās
$get_expired_items_query = mysqli_query($connect, "SELECT id, power, agility, endurance, intelligence, attack, defense FROM `player_inventory` WHERE type='7' AND termiņa_beigas <= '$current_time' AND termiņa_beigas != '0000-00-00 00:00:00'");

if ($get_expired_items_query) {
    while ($item_data = mysqli_fetch_assoc($get_expired_items_query)) {
        $item_id = $item_data['id'];
        $power = $item_data['power'];
        $agility = $item_data['agility'];
        $endurance = $item_data['endurance'];
        $intelligence = $item_data['intelligence'];
        $attack = $item_data['attack'];
        $defense = $item_data['defense'];

        // Atjauno spēlētāja statistiku, atņemot mikstūras efektus
        $update_player_query = mysqli_query($connect, "UPDATE `players` SET 
            power = power - '$power',
            agility = agility - '$agility',
            endurance = endurance - '$endurance',
            intelligence = intelligence - '$intelligence',
            attack = attack - '$attack',
            defense = defense - '$defense'
            WHERE id = '$player_id'");

        if ($update_player_query) {
            // Dzēst beidzās mikstūru no inventāra
            $delete_expired_item_query = mysqli_query($connect, "DELETE FROM `player_inventory` WHERE id='$item_id'");

            if ($delete_expired_item_query) {
                // Mikstūra tika veiksmīgi noņemts no inventāra
                echo '<div class="alert alert-success">Mikstūra tika dzēsta no inventāra, un statistika atņemta no spēlētāja.</div>';
            } else {
                echo 'Kļūda, dzēšot beidzās mikstūru: ' . mysqli_error($connect);
            }
        } else {
            echo 'Kļūda, atjaunojot spēlētāja statistiku: ' . mysqli_error($connect);
        }
    }
} else {
    echo 'Kļūda, iegūstot beidzās mikstūras: ' . mysqli_error($connect);
}







$currentDatetime = date('Y-m-d H:i:s');

// Check if the tournament is active
$tournamentQuery = mysqli_query($connect, "SELECT id, end_datetime FROM tournaments WHERE is_active = 1");
$tournamentData = mysqli_fetch_assoc($tournamentQuery);

if ($tournamentData && $currentDatetime > $tournamentData['end_datetime']) {
    // Tournament has ended, update status
    mysqli_query($connect, "UPDATE tournaments SET is_active = 0 WHERE id = " . $tournamentData['id']);

    // Retrieve top players
    $topPlayersQuery = mysqli_query($connect, "SELECT id, username FROM players WHERE reward_given = 0 ORDER BY points DESC LIMIT 5");

    $rewards = [
        ['dimants' => 500],
        ['dimants' => 300],
        ['dimants' => 150],
        ['dimants' => 100],
        ['dimants' => 50]
    ];

    $position = 1;

    while ($row = mysqli_fetch_assoc($topPlayersQuery)) {
        if ($position <= count($rewards)) {
            $reward = $rewards[$position - 1];
            $dimants = $reward['dimants'];

            // Add rewards to the player and reset reward_given flag
            $updateResult = mysqli_query($connect, "UPDATE players SET dimants = dimants + $dimants, reward_given = 0, points = 0 WHERE id = " . $row['id']);
            if (!$updateResult) {
                echo "Error updating player rewards: " . mysqli_error($connect);
                // Handle the error appropriately
            }

            // Insert player and reward into the tournament_rewards table
            $insertResult = mysqli_query($connect, "INSERT INTO tournament_rewards (player_id, username, dimants) VALUES (" . $row['id'] . ", '" . $row['username'] . "', $dimants)");
            if (!$insertResult) {
                echo "Error inserting tournament rewards: " . mysqli_error($connect);
                // Handle the error appropriately
            }

            $position++;
        }
    }

    // Create a new tournament that lasts for one week
    $nextTournamentStart = date('Y-m-d H:i:s', strtotime($tournamentData['end_datetime'] ));
    $nextTournamentEnd = date('Y-m-d H:i:s', strtotime($nextTournamentStart . ' +1 week'));

    mysqli_query($connect, "INSERT INTO tournaments (start_datetime, end_datetime, is_active) VALUES ('$nextTournamentStart', '$nextTournamentEnd', 1)");

    // Delete the old tournament and related records
    mysqli_query($connect, "DELETE FROM tournaments WHERE id = " . $tournamentData['id']);
    mysqli_query($connect, "DELETE FROM tournament_rewards WHERE tournament_id = " . $tournamentData['id']);
}








  


?>



        
<!---navbars1(avatars)--->
<div class="navbar navbar-inverse">
    <div class="player-info-row">
        <div class="avatar">
            <img src="<?php echo $rowu['avatar']; ?>" alt="Spēlētāja avatars">
        </div>
        <div class="player-details">
            <div class="player-username-role">
                <!-- Username un Role pa kreisi -->
                <div>
                    <span class="player-username"><?php echo $rowu['username']; ?></span>
                    <?php
                    if ($rowu['role'] == "Admin") {
                        echo '<span class="label label-danger"><i class="fa fa-bookmark"></i> ' . $rowu['role'] . '</span> ';
                    } elseif ($rowu['role'] == "VIP") {
                        echo '<span class="label label-warning"><i class="fa fa-star"></i> ' . $rowu['role'] . '</span> ';
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- Atstarpes elements (tukšums) starp lietotāja lomu un aktīvajām mikstūrām -->
        &nbsp;
        <!-- Aktīvās mikstūras pa labi no lietotāja vārda un lomas, ja tādas eksistē -->
        <?php
        $current_time = date("Y-m-d H:i:s");
        $active_potion_query = mysqli_query($connect, "SELECT COUNT(*) AS active_potions FROM `player_inventory` WHERE player_id='$player_id' AND type='7' AND termiņa_beigas > '$current_time'");
        $active_potion_data = mysqli_fetch_assoc($active_potion_query);
        $active_potion_count = $active_potion_data['active_potions'];

        if ($active_potion_count > 0) {
            echo '<div class="active-potions-info">';
            echo '<span class="label label-info pull-right"><i class="fa fa-flask"></i> ' . lang_key("aktivie-mixi") . ' ' . $active_potion_count . '</span>';
            echo '</div>';
        }
        ?>
    </div>
    
    <!-- Pārējais jūsu navigācijas kods paliek nemainīgs -->
    <h5>
    <a href="settings.php" class="btn btn-primary pull-left"><i class="fa fa-user"></i> <span class="hidden-xs"><?php echo lang_key("my-account"); ?></span></a>
    <a href="messages.php" class="btn btn-success"><i class="fa fa-envelope"></i> <span class="hidden-xs"><?php echo lang_key("messages"); ?></span></a>
    <button class="btn btn-warning " data-toggle="collapse" data-target="#statisticsPanel"><i class="fa fa-chart-bar"></i> <span class="hidden-xs"><?php echo lang_key("statistics"); ?></span></button>
    <?php
    if ($rowu['role'] == 'Admin') {
        echo '<a href="admin" class="btn btn-info"><i class="fa fa-cogs"></i> <span class="hidden-xs">' . lang_key("admin-panel") . '</span></a>';
    }
    ?>
    
    <a href="logout.php" class="btn btn-danger pull-right"><i class="fa fa-sign-out-alt"></i> <span class="hidden-xs"><?php echo lang_key("logout"); ?></span></a>
    <div class="clearfix"></div>
    </h5>

<div id="statisticsPanel" class="collapse">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo lang_key("statistics"); ?></h3>
        </div>
        <div class="panel-body">
            <?php
$querypfw = mysqli_query($connect, "SELECT * FROM `fights` WHERE winner_id='$player_id'");
$countpfw = mysqli_num_rows($querypfw);
$querymfw = mysqli_query($connect, "SELECT * FROM `fight_history` WHERE player_id='$player_id'");
$countmfw = mysqli_num_rows($querypfw);
?>
            <div class="row">
                <div class="col-md-3">
                    <b><i class="fa fa-bolt"></i> <?php echo $countpfw; ?></b>
                    <br/>
                    <small><?php echo lang_key("fight-wins"); ?></small>
                </div>

                <div class="col-md-3">
                    <b><i class="fa fa-bolt"></i> <?php echo $countmfw; ?></b>
                    <br/>
                    <small><?php echo lang_key("monsters-wins"); ?></small>
                </div>

                <!-- Add more statistics here as needed -->
            </div>
        </div>
    </div>
</div>
</div>




<!---navbars2(resi)--->  
<nav class="navbar navbar-inverse navbar-grey">
    <div class="col-md-13" id="playerstats">
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
    </div>
</nav>

<!---navbars3(main)--->  
<nav class="navbar navbar-inverse">
                    <ul class="nav navbar-nav">
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'home.php') {
        echo 'class="active"';
    }
?>><a href="home.php"><i class="fa fa-home fa-2x"></i><br /> <?php
    echo lang_key("home");
?></a></li>
                        
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'properties.php') {
        echo 'class="active"';
    }
?>><a href="properties.php"><i class="fa fa-building fa-2x"></i><br /> <?php
    echo lang_key("properties");
?></a></li>
                        
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'shop.php') {
        echo 'class="active"';
    }
?>><a href="shop.php"><i class="fa fa-shopping-cart fa-2x"></i><br /> <?php
    echo lang_key("shop");
?></a></li>             
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'auction.php') {
        echo 'class="active"';
    }
?>><a href="auction.php"><i class="fa "></i><br /> <?php
    echo lang_key("auction");
?></a></li>

                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'bank.php') {
        echo 'class="active"';
    }
?>><a href="bank.php"><i class="fa fa-university fa-2x"></i><br /> <?php
    echo lang_key("bank");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'epuipments.php') {
        echo 'class="active"';
    }
?>><a href="epuipments.php"><i class="fa  fa-2x"></i><br /> <?php
    echo lang_key("ekips");
?></a></li>

                        <li <?php
        if (basename($_SERVER['SCRIPT_NAME']) == 'clan.php') {
            echo 'class="active"';
        }
    ?>><a href="clan.php"> <i class="fa fa-gem fa-2x"></i><br /><?php
        echo lang_key("clan"); ?></a> </li> 
                            
                            <li <?php
        if (basename($_SERVER['SCRIPT_NAME']) == 'tournament.php') {
            echo 'class="active"';
        }
    ?>><a href="tournament.php"> <i class="fa fa-gem fa-2x"></i><br /><?php
        echo lang_key("tournament"); ?></a> </li> 
        
        
                        <li <?php
        if (basename($_SERVER['SCRIPT_NAME']) == 'arena.php') {
            echo 'class="active"';
        }
    ?>><a href="arena.php"> <i class="fa "></i><br /><?php
        echo lang_key("arena"); ?></a> </li> 
        
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'fight-arena.php') {
        echo 'class="active"';
    }
?>><a href="fight-arena.php"><i class="fa fa-crosshairs fa-2x"></i><br /> <?php
    echo lang_key("fights");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'leaderboard.php') {
        echo 'class="active"';
    }
?>><a href="leaderboard.php"><i class="fa fa-trophy fa-2x"></i><br /> <?php
    echo lang_key("leaderboard");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'cas.php') {
        echo 'class="active"';
    }
?>><a href="cas.php"><i class="fa fa-gem fa-2x"></i><br /> <?php
    echo lang_key("casino");
?></a></li>
                        <li <?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'extras.php') {
        echo 'class="active"';
    }
?>><a href="extras.php"><i class="fa fa-dollar-sign fa-2x"></i><br /> <?php
    echo lang_key("SMS");
?></a></li>
                    </ul> 
</nav>                
<!---navbars4(hp/mana)---> 

<nav class="navbar navbar-inverse4">
    <div id="playerstats2">
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
    </div>
</nav>


<!---navbars5(stati)---> 
<nav class="navbar navbar-inverse">
    <div class="user-stats">
        <div id="playerskills">
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
        </div>
    </div>
</nav>


   


  




    <footer class="footer clearfix">
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

    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <!-- Right Sidebar - Chat -->
    <script src="assets/js/sidebar.js"></script>
    
    <!-- Game JS -->
    <script src="assets/js/game.js"></script>
	
<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'leaderboard.php' OR basename($_SERVER['SCRIPT_NAME']) == 'messages.php') {
        echo '
	<!-- DataTables -->
    <script src="assets/js/datatables.min.js"></script>';
    }
?>

<?php
    if (basename($_SERVER['SCRIPT_NAME']) == 'messages.php') {
        echo '
	<!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>';
    }
?>



</body>
</html>
<?php
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