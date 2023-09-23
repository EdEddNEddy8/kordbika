<?php
require "clan.php";

$uname     = $_SESSION['username'];
$suser     = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu      = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];

					

if (isset($_GET['edit-id'])) {
    $id  = (int) $_GET["edit-id"];
    $sql = mysqli_query($connect, "SELECT * FROM `players` WHERE id = '$id'");
    $row = mysqli_fetch_assoc($sql);
    if (empty($id)) {
        echo '<meta http-equiv="refresh" content="0; url=clan_settings.php">';
    }
    if (mysqli_num_rows($sql) == 0) {
        echo '<meta http-equiv="refresh" content="0; url=clan_settings.php">';
}

if (isset($_GET['delete-id'])) {
    $delete_id = (int) $_GET['delete-id'];
    $quers = mysqli_query($connect, "SELECT * FROM `clans` WHERE id = '$delete_id' LIMIT 1");
    $rowh = mysqli_fetch_assoc($quers);
    $pid=$rowh['id'];
$noclan = mysqli_query($connect, "UPDATE `players` SET clan_id=0, clanjoin=0 WHERE id='$pid'");  
$deletei = mysqli_query($connect, "DELETE FROM `clans` WHERE id='$delete_id'");
}
?>



<form class="form-horizontal" action="" method="post">
                    <div class="box">
						<div class="box-header">
							<h3 class="box-title">Edit Clan Player</h3>
						</div>
				        <div class="box-body">
                               <div class="form-group">
											<label class="col-sm-2 control-label">Username: </label>
											<div class="col-sm-3">
												<input type="text" name="username" class="form-control" value="<?php
    echo $row['username'];
?>" disabled>

											</div>
										</div>
                                      
										
										<div class="form-group">
											<label class="col-sm-2 control-label">Clan Role: </label>
											<div class="col-sm-3">
												<select name="clan_role" class="form-control" required>
        <option value="Officer" <?php
    if ($row['clan_role'] == 'Officer') {
        echo 'selected';
    }
?>>Clan Officer</option>
        <option value="Admin" <?php
    if ($row['clan_role'] == 'Admin') {
        echo 'selected';
    }
?>>Clan Admin</option>
    </select>
    
  
							        <button class="btn btn-flat btn-success" name="edit" type="submit">Save</button>
							
				        
							
				        </div>
				     </div>
</form>
<?php
    if (isset($_POST['edit'])) {
        $clan_role    = $_POST['clan_role'];
        $query = mysqli_query($connect, "UPDATE `players` SET  clan_role='$clan_role' WHERE id='$id'");
        
        echo '<meta http-equiv="refresh" content="0;url=clan_settings.php">';
    }
}
?>

<?php
     if ($rowu['clan_role'] == 'Leader') {
    ?>
						
   
<a href="?delete-id=' . $row['cid'] . '" class="btn btn-flat btn-danger"><i class="fas fa-trash"></i> Delete</a>



				    <div class="box">
						<div class="box-header">
							<h3 class="box-title">Players</h3>
						</div>
						<div class="box-body">
						    
<table id="dt-basic" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											
											<th><i class="fas fa-user"></i> Username</th>
											<th><i class="fas fa-bookmark"></i> Clan Role</th>
											<th><i class="fas fa-server"></i> Level</th>
											<th><i class="fas fa-cogs"></i> Actions</th>
										</tr>
									</thead>
									<tbody>
<?php
$clanid=$rowu['clan_id'];
$querygp = mysqli_query($connect, "SELECT * FROM players WHERE clan_id='$clanid'");
$i       = 1;
while ($rowgp = mysqli_fetch_assoc($querygp)) {
    echo '
										<tr>
										    
                                            <td>' . $rowgp['username'] . '</td>
											<td>' . $rowgp['clan_role'] . '</td>
											<td>' . $rowgp['level'] . '</td>

                                            <td><a href="?edit-id=' . $rowgp['id'] . '" class="btn btn-flat btn-primary"><i class="fas fa-edit"></i> Edit </td>
                                           
                                            	
										</tr>
											
									
    ';
    }
    ?>
<?php               
    }
?>
 


								</tbody>
								</table>
                       
                    
                
                    
				
<script>
$(document).ready(function() {

	$('#dt-basic').dataTable( {
		"responsive": true,
		"language": {
			"paginate": {
			  "previous": '<i class="fas fa-angle-left"></i>',
			  "next": '<i class="fas fa-angle-right"></i>'
			}
		}
	} );
} );
  
</script>
<?php
footer();
?>