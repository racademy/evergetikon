<?php
$address = get_field('map_address');
?>

<?php if ($address): ?>
    <div class="google-map">
        <iframe class="google-map__iframe" width="100%" height="900" style="border:0;" loading="lazy" allowfullscreen
            referrerpolicy="no-referrer-when-downgrade"
            src="https://www.google.com/maps?q=<?= urlencode($address); ?>&output=embed">
        </iframe>
    </div>
<?php endif; ?>