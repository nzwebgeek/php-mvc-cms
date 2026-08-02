<div class="placeholder-container">


<?php

$hero_title = $pages['home']['hero_title'] ?? 'Welcome to our website';

$hero_subtitle = $pages['home']['hero_subtitle'] ?? '';

require __DIR__ . '/partials/hero.php';

?>


<main id="placeholder-main">


<figure>

<?php

$image = !empty($pages['home']['hero_image'])
    ? $pages['home']['hero_image']
    : '/assets/images/tech.jpg';


$alt = !empty($pages['home']['hero_image_alt'])
    ? $pages['home']['hero_image_alt']
    : 'Website image';

?>


<picture>
 <source media="(min-width:800px)" srcset="<?= $image ?>">
 <source media="(min-width:400px)" srcset="<?= $image ?>">
 <img src="<?= htmlspecialchars($image) ?>"
     alt="<?= htmlspecialchars($alt) ?>">
</picture>


<figcaption>
<?= htmlspecialchars($alt) ?>
</figcaption>


</figure>



<section class="placeholder-content">


<h2>
<?= htmlspecialchars(
    $pages['home']['main_heading'] ?? 'Home'
) ?>
</h2>


<p>
<?= nl2br(
    htmlspecialchars(
        $pages['home']['main_content'] ?? 'Content coming soon.'
    )
) ?>
</p>


</section>



<aside id="placeholder-aside">


<h3>
<?= htmlspecialchars(
    $pages['aside']['main_heading'] ?? ''
) ?>
</h3>


<ul class="placeholder-menu">

<li>
<?= nl2br(
    htmlspecialchars(
        $pages['aside']['main_content'] ?? ''
    )
) ?>
</li>

</ul>


</aside>


</main>



<section class="placeholder-features">


<article>

<h3>
<?= htmlspecialchars(
    $pages['features']['main_heading'] ?? ''
) ?>
</h3>


<p>
<?= nl2br(
    htmlspecialchars(
        $pages['features']['main_content'] ?? ''
    )
) ?>
</p>

</article>



<article>

<h3>
<?= htmlspecialchars(
    $pages['services']['main_heading'] ?? ''
) ?>
</h3>


<p>
<?= nl2br(
    htmlspecialchars(
        $pages['services']['main_content'] ?? ''
    )
) ?>
</p>

</article>



<article>

<h3>
<?= htmlspecialchars(
    $pages['social']['main_heading'] ?? ''
) ?>
</h3>


<p>
<?= nl2br(
    htmlspecialchars(
        $pages['social']['main_content'] ?? ''
    )
) ?>
</p>

</article>


</section>


</div>


