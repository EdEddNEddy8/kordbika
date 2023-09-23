<?php
require "core.php";
head();

$player_id = $rowu['id'];

if (isset($_POST['sendm'])) {
    $toid    = $_POST['toid'];
    $fromid  = $player_id;
	$money   = $_POST['money'];
	$gold    = $_POST['gold'];
	
	if(($money > 0 && $money <= $rowu['money']) || ($gold > 0 && $gold <= $rowu['gold'])) {
		$content = 'You received a donation from ' . $rowu['username'] . ': ' . $money . ' Money, ' . $gold . ' Gold';
		$date    = date('d F Y');
		$time    = date('H:i');
    
		$donation     = mysqli_query($mysqli, "UPDATE `players` SET money = money + $money, gold = gold + $gold WHERE id = $toid");
		$minus        = mysqli_query($mysqli, "UPDATE `players` SET money = money - $money, gold = gold - $gold WHERE id = $player_id");
		$send_message = mysqli_query($mysqli, "INSERT INTO `messages` (toid, fromid, content, date, time) VALUES ('$toid', '$fromid', '$content', '$date', '$time')");
	
		echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#sent").modal(\'show\');
            });
        </script>

        <div id="sent" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-hand-holding-usd"></i> Donating player</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <center>
                            <h4><span class="badge bg-success">
								<i class="fas fa-hand-holding-usd"></i> Your donation is successful
							</span></h5><br />
                            <button type="button" class="btn btn-primary btn-md col-12" data-bs-dismiss="modal" aria-hidden="true"><i class="fab fa-get-pocket"></i> Okay</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>';
	}
}
?>
<div class="container-fluid">
	<div class="col-md-12 card bg-light card-body">

		<center><h4><i class="fas fa-donate"></i> Donate Money or Gold to other player</h4></center><br />

		<div class="row justify-content-center">
    
			<div class="col-md-12">
			
				<form action="" method="post">
					<div class="form-group">
						<label for="toid" style="width: 100%;">
							<i class="fa fa-user"></i> Recipient
						</label>
						<select class="form-control select2" name="toid" id="toid" required>
<?php
$queryap = mysqli_query($mysqli, "SELECT * FROM players WHERE id!='$player_id' ORDER BY username");
while ($rowap = mysqli_fetch_assoc($queryap)) {
?>
							<option value="<?php
    echo $rowap['id'];
?>"><?php
    echo $rowap['username'];
?></option>
<?php
}
?>
						</select>
					</div>
							
					<div class="form-group mt-3">
						<label for="money" style="width: 100%;">
							<i class="fas fa-money-bill-alt"></i> Money
						</label>
						<input type="number" class="form-control" id="money" name="money" min="1" max="<?php echo $rowu['money']; ?>" value="1" required>
					</div>
					
					<div class="form-group mt-3">
						<label for="gold" style="width: 100%;">
							<i class="fas fa-inbox"></i> Gold
						</label>
						<input type="number" class="form-control" id="gold" name="gold" min="1" max="<?php echo $rowu['gold']; ?>" value="1" required>
					</div><br />
					
					<button type="submit" name="sendm" class="btn btn-primary col-12"><i class="fas fa-hand-holding-usd"></i> Donate</button>
				</form>
	
			</div>

		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	
    $(".select2").select2({width: '100%', theme: 'bootstrap-5'});

} );
</script>   
<?php
footer();
?>