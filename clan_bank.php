<?php
require "core.php";
head();

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_POST['deposit-dimants'])) {
    $dimants = $_POST['dimants'];

    if (!ctype_digit($dimants)) {
        echo '<div class="alert alert-danger">' . lang_key("invalid-amount") . '</div>';
    } elseif ($dimants > $rowu['dimants']) {
        echo '<div class="alert alert-danger">' . lang_key("noenough-dimants") . '</div>';
    } elseif ($dimants < 100) {
        echo '<div class="alert alert-info">' . lang_key("minimum-amount") . ' 100 ' . lang_key("dimants") . '</div>';
    } else {
        // Atjaunojiet spēlētāja dimantus un klana dimantus_banka
        mysqli_query($connect, "UPDATE players SET dimants=dimants-$dimants WHERE id='" . $player_id . "'");
        mysqli_query($connect, "UPDATE clans SET dimants_banka=dimants_banka+$dimants WHERE id='" . $rowu['clan_id'] . "'");

        echo '<div class="alert alert-success">' . lang_key("success-deposit") . ' ' . $dimants . ' ' . lang_key("dimants") . '</div>';
    }
}

if (isset($_POST['deposit-zelts'])) {
    $zelts = $_POST['zelts'];

    if (!ctype_digit($zelts)) {
        echo '<div class="alert alert-danger">' . lang_key("invalid-amount") . '</div>';
    } elseif ($zelts > $rowu['zelts']) {
        echo '<div class="alert alert-danger">' . lang_key("noenough-zelts") . '</div>';
    } elseif ($zelts < 100) {
        echo '<div class="alert alert-info">' . lang_key("minimum-amount") . ' 100 ' . lang_key("zelts") . '</div>';
    } else {
        // Atjaunojiet spēlētāja zeltu un klana zelts_banka
        mysqli_query($connect, "UPDATE players SET zelts=zelts-$zelts WHERE id='" . $player_id . "'");
        mysqli_query($connect, "UPDATE clans SET zelts_banka=zelts_banka+$zelts WHERE id='" . $rowu['clan_id'] . "'");

        echo '<div class="alert alert-success">' . lang_key("success-deposit") . ' ' . $zelts . ' ' . lang_key("zelts") . '</div>';
    }
}

// Iegūst klana dimantu un zelta skaitu no datu bāzes
$clan_id = $rowu['clan_id'];
$result = mysqli_query($connect, "SELECT dimants_banka, zelts_banka FROM clans WHERE id='$clan_id'");
$clan_row = mysqli_fetch_assoc($result);
$clan_dimants = $clan_row['dimants_banka'];
$clan_zelts = $clan_row['zelts_banka'];
?>

<div class="container">
    <div class="row well">
        <center>
            <a class="btn btn-warning " href="clan_members.php" role="button"> <?php echo lang_key("clan-members");?> </a>
            <a class="btn btn-success " href="clan_bank.php" role="button">  <?php echo lang_key("clan-bank");?> </a>
            <a class="btn btn-danger " href="clan_stats.php" role="button">  <?php echo lang_key("clan-stats");?> </a>
            <a class="btn btn-info " href="clan_info.php" role="button">  <?php echo lang_key("clan-info");?> </a>
        </center>
            </div>
    <div class="col-md-12 well">
        <center><h2><i class="fa fa-university"></i> <?php echo lang_key("clan-bank"); ?></h2></center><br />

        <div class="row">
            <center>
                <div class="col-md-6 col-md-offset-3">
                    <div class="jumbotron">
                        <h3><i class="fa fa-upload"></i> <?php echo lang_key("deposit-dimants"); ?></h3>
                        <hr /><br />

                        <!-- Parāda klana dimantu skaitu -->
                        <p><?php echo lang_key("clan-dimants-amount") . ': ' . $clan_dimants . ' ' . lang_key("dimants"); ?></p>

                        <form method="post" action="">
                            <div class="form-group">
                                <label for="dimants"><?php echo lang_key("amount"); ?>:</label>
                                <input name="dimants" class="form-control" type="number" value="100" min="100" required>
                            </div>
                            <button value="<?php echo lang_key("deposit"); ?>" class="btn btn-primary btn-block" name="deposit-dimants" type="submit"><?php echo lang_key("deposit"); ?></button><br /><br />
                        </form>
                    </div>
                </div>
            </center>
        </div>
        
        <div class="row">
            <center>
                <div class="col-md-6 col-md-offset-3">
                    <div class="jumbotron">
                        <h3><i class="fa fa-upload"></i> <?php echo lang_key("deposit-zelts"); ?></h3>
                        <hr /><br />

                        <!-- Parāda klana zelta skaitu -->
                        <p><?php echo lang_key("clan-zelts-amount") . ': ' . $clan_zelts . ' ' . lang_key("zelts"); ?></p>

                        <form method="post" action="">
                            <div class="form-group">
                                <label for="zelts"><?php echo lang_key("amount"); ?>:</label>
                                <input name="zelts" class="form-control" type="number" value="100" min="100" required>
                            </div>
                            <button value="<?php echo lang_key("deposit"); ?>" class="btn btn-primary btn-block" name="deposit-zelts" type="submit"><?php echo lang_key("deposit"); ?></button><br /><br />
                        </form>
                    </div>
                </div>
            </center>
        </div>
    </div>
</div>

<?php footer(); ?>
