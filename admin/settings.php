<?php
require 'includes/auth.php';
require '../includes/db.php';/*connect to settings*/
$result = $conn->query("SELECT * FROM site_settings WHERE id = 1");
$settings = $result->fetch_assoc();
/*Check if button clicked in form*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $site_name = $_POST['site_name'];
    $admin_email = $_POST['admin_email'];
    $theme = $_POST['theme'];
    $maintenance = isset($_POST['maintenance']) ? 1 : 0;
    
  
    $stmt = $conn->prepare("
        UPDATE site_settings
        SET 
            site_name = ?,
            admin_email = ?,
            theme = ?,
            maintenance_mode = ?
        WHERE id = 1
    ");
   
    $stmt->bind_param(
        "sssi",
        $site_name,
        $contact_email,
        $theme,
        $maintenance
    );



    $stmt->execute();

      echo "Settings saved successfully.";

}

?>
<?php require 'includes/settings.php'; ?>
<!--Todo: needs extra features-->
<?php
$stmt = $conn->query("SELECT * FROM site_settings WHERE id = 1");
$settings = $stmt->fetch_assoc();
?>
<h2>Settings</h2>

<form method="post">

    <h3>General</h3>

    <label>Site Name</label><br>
    <input 
        type="text"
        name="site_name"
        value="<?= htmlspecialchars($settings['site_name']); ?>">

    <label>Site Description</label><br>
    <textarea name="site_description"> Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nihil asperiores necessitatibus sed illo ipsam nulla totam dolores laboriosam, optio expedita beatae omnis aut, eum, fuga corporis sint natus alias eius?</textarea><br><br>

    <label>Admin Email</label><br>
   <input 
        type="email"
        name="admin_email"
        value="<?= htmlspecialchars($settings['admin_email'] ?? ''); ?>">

    <h3>Appearance</h3>

    <label>Theme</label>
    <select name="theme">

    <option value="Light"
    <?= $settings['theme'] == "Light" ? "selected" : "" ?>>
    Light
    </option>

    <option value="Dark"
    <?= $settings['theme'] == "Dark" ? "selected" : "" ?>>
    Dark
    </option>

    </select>
    <label>
       <input 
        type="checkbox" 
        name="maintenance"
        <?= $settings['maintenance_mode'] ? "checked" : "" ?>>
        Maintenance Mode
    </label><br><br>

    <button class="button" type="submit">Save Settings</button>

</form>