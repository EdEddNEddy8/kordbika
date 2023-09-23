<?php
require "core.php";
head();

$uname = $_SESSION['username'];
$suser = mysqli_query($connect, "SELECT id FROM `players` WHERE username='$uname' LIMIT 1");
$rowu = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

if (isset($_POST['item_id']) && isset($_POST['gem_id'])) {
    $item_id = (int)$_POST['item_id'];
    $gem_id = (int)$_POST['gem_id'];

    // Pārbauda, vai šis priekšmets pieder šim spēlētājam
    $item_query = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE id='$item_id' AND player_id='$player_id' LIMIT 1");

    if (mysqli_num_rows($item_query) > 0) {
        // Pārbauda, vai šis gem pieder šim spēlētājam
        $gem_query = mysqli_query($connect, "SELECT * FROM `gems` WHERE id='$gem_id' AND player_id='$player_id' LIMIT 1");

        if (mysqli_num_rows($gem_query) > 0) {
            // Pārbauda, cik gemu jau ir ievietoti šajā priekšmetā
            $slot_count_query = mysqli_query($connect, "SELECT COUNT(*) AS count FROM `item_gem_slots` WHERE item_id='$item_id'");
            $slot_count = mysqli_fetch_assoc($slot_count_query)['count'];

            if ($slot_count < 3) { // Var ievietot maksimāli 3 gemus
                // Ievieto gemu priekšmetā, pievienojot jaunu ierakstu item_gem_slots tabulā
                mysqli_query($connect, "INSERT INTO `item_gem_slots` (item_id, gem_id) VALUES ('$item_id', '$gem_id')");

                // Atjauno gemu informāciju (piemēram, iestatot statusu "ievietots")
                mysqli_query($connect, "UPDATE `gems` SET status='ievietots' WHERE id='$gem_id'");

                echo '<div class="alert alert-success">Gems ir ievietots priekšmetā!</div>';
            } else {
                echo '<div class="alert alert-warning">Šajā priekšmetā jau ir ievietoti maksimāli 3 gemi!</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Šis gem nepieder jums!</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Šis priekšmets nepieder jums!</div>';
    }
}
?>

<!-- HTML forma, lai spēlētājs varētu atlasīt priekšmetu un gemu -->
<form method="post" action="gem_insert.php">
    <label for="item_id">Atlasiet priekšmetu:</label>
    <select name="item_id" id="item_id">
        <?php
        $item_query = mysqli_query($connect, "SELECT * FROM `player_inventory` WHERE player_id='$player_id'");
        while ($item = mysqli_fetch_assoc($item_query)) {
            echo '<option value="' . $item['id'] . '">' . $item['name'] . '</option>';
        }
        ?>
    </select>
    <br>

    <label for="gem_id">Atlasiet gemu:</label>
    <select name="gem_id" id="gem_id">
        <?php
        $gem_query = mysqli_query($connect, "SELECT * FROM `gems` WHERE player_id='$player_id' AND status='neievietots'");
        while ($gem = mysqli_fetch_assoc($gem_query)) {
            echo '<option value="' . $gem['id'] . '">' . $gem['name'] . '</option>';
        }
        ?>
    </select>
    <br>

    <input type="submit" value="Ievietot gemu priekšmetā">
</form>