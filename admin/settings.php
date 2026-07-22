<?php
require 'includes/auth.php';
require '../includes/db.php';

/* Save settings */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $site_name       = trim($_POST['site_name']);
    $admin_email     = trim($_POST['admin_email']);
    $contact_email   = trim($_POST['contact_email']);
    $contact_phone   = trim($_POST['contact_phone']);
    $copyright_text  = trim($_POST['copyright_text']);
    $theme           = $_POST['theme'];
    $maintenance     = isset($_POST['maintenance']) ? 1 : 0;
    $seo_title       = trim($_POST['seo_title']);
    $seo_description = trim($_POST['seo_description']);

    $stmt = $conn->prepare("
        UPDATE site_settings
        SET
            site_name = ?,
            admin_email = ?,
            contact_email = ?,
            contact_phone = ?,
            copyright_text = ?,
            theme = ?,
            maintenance_mode = ?,
            seo_title = ?,
            seo_description = ?
        WHERE id = 1
    ");

    $stmt->bind_param(
        "ssssssiss",
        $site_name,
        $admin_email,
        $contact_email,
        $contact_phone,
        $copyright_text,
        $theme,
        $maintenance,
        $seo_title,
        $seo_description
    );

    $stmt->execute();

    header("Location: index.php?page=settings&success=updated");
    exit;
}

/* Load settings */
$result = $conn->query("SELECT * FROM site_settings WHERE id = 1");
$settings = $result->fetch_assoc();
?>

<h1>Website Settings</h1>

<?php if (isset($_GET['success']) && $_GET['success'] === 'updated'): ?>
    <div class="success-message">
        ✅ Settings saved successfully.
    </div>
<?php endif; ?>

<form method="post">

    <h3>General</h3>

    <label>Site Name</label>
    <input
        type="text"
        name="site_name"
        value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>">

    <label>Admin Email</label>
    <input
        type="email"
        name="admin_email"
        value="<?= htmlspecialchars($settings['admin_email'] ?? '') ?>">

    <hr>

    <h3>Contact Information</h3>

    <label>Contact Email</label>
    <input
        type="email"
        name="contact_email"
        value="<?= htmlspecialchars($settings['contact_email'] ?? '') ?>">

    <label>Contact Phone</label>
    <input
        type="text"
        name="contact_phone"
        value="<?= htmlspecialchars($settings['contact_phone'] ?? '') ?>">

    <label>Copyright Text</label>
    <input
        type="text"
        name="copyright_text"
        value="<?= htmlspecialchars($settings['copyright_text'] ?? '') ?>">

    <hr>

    <h3>Appearance</h3>

    <label>Theme</label>

    <select name="theme">

        <option value="Light"
            <?= ($settings['theme'] ?? '') === 'Light' ? 'selected' : '' ?>>
            Light
        </option>

        <option value="Dark"
            <?= ($settings['theme'] ?? '') === 'Dark' ? 'selected' : '' ?>>
            Dark
        </option>

    </select>

    <label>
        <input
            type="checkbox"
            name="maintenance"
            <?= !empty($settings['maintenance_mode']) ? 'checked' : '' ?>>
        Maintenance Mode
    </label>

    <hr>

    <h3>SEO</h3>

    <label>Default SEO Title</label>
    <input
        type="text"
        name="seo_title"
        value="<?= htmlspecialchars($settings['seo_title'] ?? '') ?>">

    <label>Default SEO Description</label>
    <textarea
        name="seo_description"
        rows="5"><?= htmlspecialchars($settings['seo_description'] ?? '') ?></textarea>

    <br><br>

    <button class="button" type="submit">
        Save Settings
    </button>

</form>