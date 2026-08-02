<article>

    <h3>
        <?= htmlspecialchars($title ?? '') ?>
    </h3>

    <p>
        <?= nl2br(htmlspecialchars($content ?? '')) ?>
    </p>

</article>