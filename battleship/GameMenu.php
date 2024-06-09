<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Menu</title>
    <link rel="stylesheet" href="css/home-styles.css">
    <script type="text/javascript" src="Game.js"></script>
    <script type="text/javascript" src="Player.js"></script>
    <script type="text/javascript" src="PlayerHuman.js"></script>
    <script type="text/javascript" src="PlayerComp.js"></script>
    <script type="text/javascript" src="CookieIO.js"></script>
</head>
<body>
    <h1>Game Menu</h1>
    <div class="form-container">
        <form action="GameMenuHandler.php" method="post">
            <button type="submit" name="action" value="new_campaign">New Campaign</button>
            <button id="load-campaign" type="submit" name="action" value="load_campaign">Load Campaign</button>
        </form>
        <span id="error"><?php echo isset($_SESSION['game_error']) ? $_SESSION['game_error'] : "";?></span>
    </div>
    
    <script>
        const load_campaign_button = document.getElementById("load-campaign");
        async function main() {
            load_campaign_button.addEventListener("click", async () => {
                alert("Loading Game!");
//                
                const data = await loadGameFromDB();
                const p1 = data[0]["P1"];
//                console.log(p1);  //DEBUG
//                console.log(typeof(p1));  //DEBUG
                const p2 = data[0]["P2"];
//                console.log(p2);  //DEBUG
//                console.log(typeof(p2));  //DEBUG
                saveGameToCookie(p1, p2);
//                console.log(p1);

//                alert("DONE WITH LOADING");  //DEBUG
            });
        }
        main();
    
    </script>
</body>
</html>