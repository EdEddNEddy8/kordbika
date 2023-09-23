<?php
require "core.php";
head();


$uname = $_SESSION['username'];
$suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];


if (isset($_POST['buy-status'])) {
    $selected_status = $_POST['status'];
    $status_price = getStatusPrice($selected_status, $connect); // Iegūst cenu no datubāzes

    // Pārbauda, vai spēlētājam ir pietiekami daudz valūtas, lai veiktu pirkumu
    if ($rowu['currency'] >= $status_price) {
        // Veic pirkumu, atjaunojot statusu un valūtas summu
        $new_currency = $rowu['currency'] - $status_price;
        $update_player = mysqli_query($connect, "UPDATE `players` SET currency='$new_currency', status='$selected_status' WHERE id='$player_id'");
        if ($update_player) {
            echo "Jūs esat iegādājies statusu: $selected_status!";
        } else {
            echo "Kļūda, neizdevās veikt pirkumu.";
        }
    } else {
        echo "Jums nav pietiekami daudz valūtas, lai iegādātos šo statusu.";
    }
}

function getStatusPrice($status, $connection) {
    $status = mysqli_real_escape_string($connection, $status);
    $query = mysqli_query($connection, "SELECT price FROM status WHERE name='$status'");
    $row = mysqli_fetch_assoc($query);
    return $row['price'];
}

?>



<?php
// Iegūst visus statusus no datubāzes
$queryStatuses = mysqli_query($connect, "SELECT name, image, duration_days, price FROM status");

?>
<div id="wrapper">
    <div class="col-md-12 well">
        <center>
            <h2>Nopirkt statusus</h2>
        </center>
        <div class="row">
            <?php
            // Parāda visus statusus
            while ($rowStatus = mysqli_fetch_assoc($queryStatuses)) {
                $statusName = $rowStatus['name'];
                $statusImage = $rowStatus['image'];
                $statusDuration = $rowStatus['duration_days'];
                $statusPrice = $rowStatus['price'];
                ?>
                <div class="col-md-4">
                    <center>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <h4><img src="<?php echo $statusImage; ?>" alt="" width="150" height="150"></h4>
                            </li>
                            <li class="list-group-item">
                                <h2><?php echo $statusName; ?> (<?php echo $statusDuration; ?> dienas)</h2>
                            </li>
                            <li class="list-group-item">
                                <h3>Cena: <?php echo $statusPrice; ?> valūta</h3>
                            </li>
                            <li class="list-group-item">
                                <form method="post" action="status.php">
                                    <input type="hidden" name="status" value="<?php echo $statusName; ?>">
                                    <button type="submit" name="buy-status" class="btn btn-success">Nopirkt</button>
                                </form>
                            </li>
                        </ul>
                    </center>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php
footer();
?>
