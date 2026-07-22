
<?php 
require 'includes/db.php';
require 'includes/settings.php';

include 'includes/header.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
$stmt = $conn->prepare("SELECT * FROM pages WHERE slug IN (?, ?, ?, ?, ?, ?)");

$home = "home";
$aside = "aside"; /**image*/
$features = "features"; /**latest insights*/
$services = "services"; /*featured services**/
$social = "social"; /**social media*/
$footer = "footer"; /*basic footer*/

$stmt->bind_param(
    "ssssss",
    $home,
    $aside,
    $features,
    $services,
    $social,
    $footer
);

$stmt->execute();

$result = $stmt->get_result();

$pages = [];

$tick = '✓ '; // tick

while ($row = $result->fetch_assoc()) {
    $pages[$row['slug']] = $row;
}
$page = $pages['home'];
$currentPage = $pages['home'];
?>
<div class="placeholder-container">

    <section class="placeholder-hero">
        <h1><?= htmlspecialchars($pages['home']['hero_title'] ?: 'Welcome to our website') ?></h1>
        <p><?= htmlspecialchars($pages['home']['hero_subtitle'] ?: 'Professional web development solutions.') ?></p>
        <button id="toggleBtn">Change Color</button>

    </section>

  
    <main id="placeholder-main">
          <figure>
        <!--Fetch dynamic image-->
                    <?php
            $image = !empty($pages['home']['hero_image'])
                ? htmlspecialchars($pages['home']['hero_image'])
                : "/images/tech.jpg";

            $alt = !empty($pages['home']['hero_image_alt'])
                ? htmlspecialchars($pages['home']['hero_image_alt'])
                : "Website image";
            ?>

            <picture>
                <source media="(min-width:800px)" srcset="<?= $image ?>">
                <source media="(min-width:400px)" srcset="<?= $image ?>">
                <img src="<?= $image ?>" alt="<?= $alt ?>">
            </picture>        


            <figcaption><?= htmlspecialchars($alt) ?></figcaption>        </figure>

        <section class="placeholder-content">
           <h2><?= htmlspecialchars($pages['home']['main_heading']  ?: 'Home') ?></h2>
            <p><?= nl2br(htmlspecialchars($pages['home']['main_content']  ?: 'Content coming soon.')) ?></p>
        </section>

        <aside id="placeholder-aside">
    <h3><?= htmlspecialchars($pages['aside']['main_heading'] ?? '') ?></h3>
    <ul class="placeholder-menu">
                <li><?= nl2br(htmlspecialchars($pages['aside']['main_content']  ?: 'Content coming soon.')) ?></li>
            </ul>
           
        </aside>

    </main>


<section class="placeholder-features">

    <article>
        <h3><?= htmlspecialchars($pages['features']['main_heading'] ?? 'Content coming soon.') ?></h3>
        <p><?= nl2br(htmlspecialchars($pages['features']['main_content'] ?? 'Content coming soon.')) ?></p>
    </article>

    <article>
        <h3><?= htmlspecialchars($pages['services']['main_heading'] ?? 'Content coming soon.') ?></h3>
        <p><?= nl2br(htmlspecialchars($pages['services']['main_content'] ?? 'Content coming soon.')) ?></p>
    </article>

    <article>
        <h3><?= htmlspecialchars($pages['social']['main_heading'] ?? 'Content coming soon.') ?></h3>
        <p><?= nl2br(htmlspecialchars($pages['social']['main_content'] ?? 'Content coming soon.')) ?></p>
    </article>

</section>

</div>

<?php include 'includes/footer.php'; ?>


