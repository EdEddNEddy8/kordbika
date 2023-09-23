<?php
require "core.php";
head();
$uname = $_SESSION['username'];
$suser = mysqli_query($connect, "SELECT * FROM `players` WHERE username='$uname' LIMIT 1");
$rowu = mysqli_fetch_assoc($suser);
$player_id = $rowu['id'];


?>


<div id="wraper">
    <div class="col-md-12 well">
    <center>
        <a class="btn btn-danger " href="upgrade_stats.php" role="button"><i class="fas fa-book-dead"></i> <?php echo lang_key("upgrade-stats");?> </a> 
        <a class="btn btn-danger " href="epuipments.php" role="button"><i class="fas fa-book-dead"></i> <?php echo lang_key("epuipments");?> </a> 
    </center>
    
    </div>
</div>   
    
    
    
     <div class="col-md-12 well">
<style>
  .player_character_section {
    display: flex;
    align-items: center;
}

.player_character {
    display: flex;
    align-items: center;
    margin-right: 20px;
}

.character_image img {
    width: 100px;
    height: 100px;
    border: 1px solid #ccc;
}

.character_info {
    margin-left: 10px;
}

.item_slots {
    display: flex;
}

.item_slot {
    margin-right: 10px;
}

.item_slot img {
    width: 50px;
    height: 50px;
    border: 1px solid #ccc;
}

.item_name {
    text-align: center;
}  
    
</style>
        
<div class="player_character_section">
    <div class="player_character">
        <div class="character_image">
            <img src="character_image.png" alt="Player Character Image">
        </div>
        <div class="character_info">
            <h3>Character Name</h3>
            <p>Level: 10</p>
            <p>Class: Warrior</p>
            <!-- Add more character info as needed -->
        </div>
    </div>

    <div class="item_slots">
        <div class="item_slot">
            <img src="item_slot_image.png" alt="Item Slot">
            <div class="item_name">Helmet</div>
        </div>

        <div class="item_slot">
            <img src="item_slot_image.png" alt="Item Slot">
            <div class="item_name">Armor</div>
        </div>

        <!-- Add more item slots as needed -->
    </div>
</div>

    </div>
<?php
footer();
?>