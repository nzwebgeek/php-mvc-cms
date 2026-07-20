
<?php include 'includes/header.php'; 


require 'db.php';

$stmt = $conn->prepare("SELECT * FROM pages WHERE slug IN (?, ?, ?, ?, ?, ?)");

$home = "home";
$aside = "aside"; /**image*/
$features = "features";
$services = "services";
$social = "social";
$footer = "footer";

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

while ($row = $result->fetch_assoc()) {
    $pages[$row['slug']] = $row;
}
?>
<div class="placeholder-container">

    <section class="placeholder-hero">
        <h1><?= htmlspecialchars($pages['home']['hero_title']) ?></h1>
        <p><?= htmlspecialchars($pages['home']['hero_subtitle']) ?></p>
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
           <h2><?= htmlspecialchars($pages['home']['main_heading']) ?></h2>
            <p><?= nl2br(htmlspecialchars($pages['home']['main_content'])) ?></p>
        </section>

        <aside id="placeholder-aside">
<h3><?= htmlspecialchars($pages['aside']['main_heading'] ?? '') ?></h3>            <ul class="placeholder-menu">
                <li>✓ Experienced Development Team</li>
                <li>✓ Modern Technology Stack</li>
                <li>✓ Secure & Scalable Solutions</li>
                <li>✓ Agile Project Delivery</li>
                <li>✓ Dedicated Support</li>
            </ul>
           
        </aside>

    </main>

    <section class="placeholder-features">
        <article><h3><?= htmlspecialchars($pages['features']['main_heading']) ?></h3>
        <ul class="placeholder-menu">
            <p><?= nl2br(htmlspecialchars($pages['features']['main_content'])) ?></p>
        </ul>
    

     
       
       </article>
        <article><h3><?= htmlspecialchars($pages['services']['main_heading']) ?></h3>
        <ul class="placeholder-menu">
           <p><?= nl2br(htmlspecialchars($pages['services']['main_content'])) ?></p>
        </ul>
        </article>
        <article><h3><?= htmlspecialchars($pages['social']['main_heading']) ?></h3>
        <ul class="placeholder-menu">
            <p><?= nl2br(htmlspecialchars($pages['social']['main_content'])) ?></p>
        </ul>
    
    
    
        </article>
    </section>
</div>

<?php include 'includes/footer.php'; ?>


