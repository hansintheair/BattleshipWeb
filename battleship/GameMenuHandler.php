<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check which button was clicked
    if (isset($_POST["action"])) {
        $action = $_POST["action"];

        switch ($action) {
            case "new_campaign":
                header("Location: NewGame.php");
                exit();
                break;
            case "load_campaign":
                // Example: header("Location: LoadCampaign.php");
                break;
            case "delete_campaign":
                // Example: header("Location: DeleteCampaign.php");
                break;
            default:
                // Redirect to an error page or the same page
                // Example: header("Location: ErrorPage.php");
                break;
        }
    }
}
?>
