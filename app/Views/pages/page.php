

<div class="post-page">

    <article class="post-card">

        <h1 class="post-title">

            <?= htmlspecialchars(
                $page['title'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            ); ?>

        </h1>


        <div class="post-content">

            <?= nl2br(
                htmlspecialchars(
                    $page['main_content'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                )
            ); ?>

        </div>


        <br>


        <a href="/">
            Back home
        </a>


    </article>

</div>


