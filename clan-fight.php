<?php
require "core.php";
head();

$uname = $_SESSION['username'];
$clan_id = $_SESSION['clan_id']; // Assuming you store clan ID in the session

// Retrieve clan information
$clan_query = mysqli_query($connect, "SELECT * FROM `clans` WHERE id='$clan_id' LIMIT 1");
$clan_row = mysqli_fetch_assoc($clan_query);

// Retrieve clan members for the logged-in user's clan
$clan_members_query = mysqli_query($connect, "SELECT * FROM `players` WHERE clan_id='$clan_id'");
$clan_members = array();

while ($member_row = mysqli_fetch_assoc($clan_members_query)) {
    $clan_members[] = $member_row;
}

// Clan vs. Clan Battle Logic
if (isset($_GET['opponent_clan'])) {
    $opponent_clan_id = (int) $_GET['opponent_clan'];

    // Retrieve opponent clan information
    $opponent_clan_query = mysqli_query($connect, "SELECT * FROM `clans` WHERE id='$opponent_clan_id' LIMIT 1");
    $opponent_clan_row = mysqli_fetch_assoc($opponent_clan_query);

    // Retrieve opponent clan members
    $opponent_members_query = mysqli_query($connect, "SELECT * FROM `players` WHERE clan_id='$opponent_clan_id'");
    $opponent_members = array();

    while ($opponent_member_row = mysqli_fetch_assoc($opponent_members_query)) {
        $opponent_members[] = $opponent_member_row;
    }

    // Functions for calculating strength and determining battle result
function calculateClanStrength($members) {
    $totalAttack = 0;
    $totalDefense = 0;
    
    foreach ($members as $member) {
        // Assuming each player has attributes like 'attack', 'defense', 'agility', etc.
        $totalAttack += $member['attack'];
        $totalDefense += $member['defense'];
        // Add similar calculations for other attributes if needed
    }
    
    // Calculate total strength based on attack and defense or other attributes
    $totalStrength = $totalAttack + $totalDefense;

    return $totalStrength;
}

function determineBattleResult($clanStrength, $opponentStrength) {
    // Compare clan strengths and determine battle result
    if ($clanStrength > $opponentStrength) {
        return "win";
    } elseif ($clanStrength < $opponentStrength) {
        return "lose";
    } else {
        return "draw";
    }
}

// Perform battle calculations and determine the winner
$clan_attack = calculateClanAttack($clan_members);
$clan_defense = calculateClanDefense($clan_members);

$opponent_attack = calculateClanAttack($opponent_members);
$opponent_defense = calculateClanDefense($opponent_members);

$battle_result = determineBattleResult($clan_attack + $clan_defense, $opponent_attack + $opponent_defense);

if ($battle_result === "win") {
    echo '<p>Your clan emerged victorious against ' . $opponentData['name'] . '! You\'ve earned valuable rewards and reputation.</p>';
} elseif ($battle_result === "lose") {
    echo '<p>Your clan faced defeat against ' . $opponentData['name'] . '. Reevaluate your strategy and prepare for the next battle.</p>';
} else {
    echo '<p>The battle between your clan and ' . $opponentData['name'] . ' ended in a draw. Both clans remain equal in strength.</p>';
}

// Functions for calculating clan attack and defense
function calculateClanAttack($members) {
    $totalAttack = 0;
    
    foreach ($members as $member) {
        $totalAttack += $member['attack'];
    }
    
    return $totalAttack;
}

function calculateClanDefense($members) {
    $totalDefense = 0;
    
    foreach ($members as $member) {
        $totalDefense += $member['defense'];
    }
    
    return $totalDefense;
}
}

// Functions for calculating strength and determining battle result
function calculateClanStrength($members) {
    // Implement your logic to calculate clan strength based on members' attributes
    // Return the total strength
}

function determineBattleResult($clanStrength, $opponentStrength) {
    // Implement your logic to determine the battle result ("win," "lose," or "draw")
    // Return the result
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Clan Battle</title>
    <!-- Include your CSS and other header elements here -->
</head>
<body>
    <header>
        <!-- Include your navigation or header elements here -->
    </header>
    
    <main>
        
            <?php
            // Include your database connection
            $connect = mysqli_connect("localhost", "u642167750_kb", "Dreimani8!", "u642167750_kb");

            // Check connection
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                exit();
            }

            // Fetch your clan's information (assuming you have a $clan_id variable)
            $clan_id = 190; // Replace with your actual clan ID
            $clanQuery = mysqli_query($connect, "SELECT * FROM `clans` WHERE id='$clan_id' LIMIT 1");
            $clanData = mysqli_fetch_assoc($clanQuery);

            // Fetch the list of opponents
            $opponentsQuery = mysqli_query($connect, "SELECT * FROM `clans` WHERE id != '$clan_id'");
            ?>

            <div class="clan-info">
                <h2>Your Clan</h2>
                <p>Clan Name: <?php echo $clanData['name']; ?></p>
                <p>Members: <?php echo $clanData['members_count']; ?></p>
                <!-- Display other clan information as needed -->
            </div>
            
            <div class="opponents-list">
                <h2>Opponents</h2>
                <ul>
                    <?php
                    while ($opponentData = mysqli_fetch_assoc($opponentsQuery)) {
                        echo '<li><a href="?opponent_id=' . $opponentData['id'] . '">' . $opponentData['name'] . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
            
            <div class="battle-results">
             <h2>Battle Results</h2>
            <?php
            if (isset($_GET['opponent_id'])) {
                // Fetch opponent clan information
                $opponentID = (int) $_GET['opponent_id'];
                $opponentQuery = mysqli_query($connect, "SELECT * FROM `clans` WHERE id='$opponentID' LIMIT 1");
                $opponentData = mysqli_fetch_assoc($opponentQuery);
            
                // Simplified example: Calculate total attack and defense points for both clans
                $clan_total_attack = calculateTotalAttack($clanData); // You need to define this function
                $clan_total_defense = calculateTotalDefense($clanData); // You need to define this function
            
                $opponent_total_attack = calculateTotalAttack($opponentData); // You need to define this function
                $opponent_total_defense = calculateTotalDefense($opponentData); // You need to define this function
            
                // Perform battle calculations and determine the winner based on attack and defense
                $battle_result = determineBattleResult($clan_total_attack, $clan_total_defense, $opponent_total_attack, $opponent_total_defense);
            
                // Display battle results based on battle outcome
                if ($battle_result === "win") {
    echo '<p>Your clan emerged victorious against ' . $opponentData['name'] . '! You\'ve earned valuable rewards and reputation.</p>';
} elseif ($battle_result === "lose") {
    echo '<p>Your clan faced defeat against ' . $opponentData['name'] . '. Reevaluate your strategy and prepare for the next battle.</p>';
} else {
    echo '<p>The battle between your clan and ' . $opponentData['name'] . ' ended in a draw. Both clans remain equal in strength.</p>';
}
            } else {
                echo '<p>Select an opponent clan to initiate the battle.</p>';
            }
                ?>
            </div>
        
    </main>
    
    <footer>
        <!-- Include your footer elements here -->
    </footer>
</body>
</html>







<?php
footer();
?>