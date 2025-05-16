<?php
$signature_description = get_field('signature_description');
$signature_img = get_field('signature_history');


if (have_rows('our_history')): ?>
    <section class="timeline-section">
        <div class="container">
            <div class="timeline-line"></div>

            <?php $i = 0; ?>
            <?php while (have_rows('our_history')):
                the_row();
                $side = get_sub_field('layout_side') ?: 'left';
                $semi_title = get_sub_field('semi_title');
                $title = get_sub_field('title');
                $description = get_sub_field('description');
                $link = get_sub_field('link');
                $image = get_sub_field('image');
                ?>
                <div class="timeline-block <?= $side ?>" data-index="<?= $i ?>">
                    <div class="timeline-content">
                        <div class="timeline-text">
                            <?php if ($semi_title): ?><span class="caption_l"><?= esc_html($semi_title) ?></span><?php endif; ?>
                            <?php if ($title): ?>
                                <h2 class="h2_alternative"><?= esc_html($title) ?></h2><?php endif; ?>
                            <?php if ($description): ?>
                                <div class="subtitle_s_light"><?= wp_kses_post($description) ?></div><?php endif; ?>
                            <?php if ($link): ?>
                                <div class="theme-buttons">
                                    <a href="<?= esc_url($link['url']) ?>" class="theme-buttons__neutral">
                                        <?= esc_html($link['title']) ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if ($image): ?>
                            <div class="timeline-image">
                                <img src="<?= esc_url($image) ?>" alt="<?= esc_attr($title) ?>">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php $i++; ?>
            <?php endwhile; ?>
        </div>
    </section>
<?php endif; ?>

<section class="signature-about">
    <div class="container">
        <div class="signature-about__holder">
            <h2 class="h2_alternative">
                <?= esc_html($signature_description); ?>
            </h2>

            <?php if ($signature_img): ?>
                <img src="<?= esc_url($signature_img) ?>" alt="Signature">
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
$section_title = get_field('our_promise_title', 'options');
$our_promises = get_field('our_promises_rep', 'options');

if ($section_title || $our_promises): ?>
    <section class="our-promises">
        <div class="container">
            <?php if ($section_title): ?>
                <h2><?= esc_html($section_title); ?></h2>
            <?php endif; ?>

            <?php if ($our_promises && is_array($our_promises)): ?>
                <div class="our-promises__list">
                    <?php foreach ($our_promises as $promise):
                        $title = $promise['title'] ?? '';
                        $description = $promise['description'] ?? '';
                        $link = $promise['link'] ?? null;
                        ?>
                        <div class="our-promises__list--item">
                            <?php if ($title): ?>
                                <span class="title"><?= esc_html($title); ?></span>
                            <?php endif; ?>

                            <?php if ($description): ?>
                                <p class="body_one_light"><?= esc_html($description); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($link['url'])): ?>
                                <div class="theme-buttons">
                                    <a class="theme-buttons__neutral" href="<?= esc_url($link['url']); ?>"
                                        target="<?= esc_attr($link['target'] ?? '_self'); ?>">
                                        <?= esc_html($link['title']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const timelineBlocks = document.querySelectorAll(".timeline-block");
        const timelineLine = document.querySelector(".timeline-line");

        const dotsContainer = document.createElement("div");
        dotsContainer.classList.add("timeline-dots-overlay");
        timelineLine.appendChild(dotsContainer);

        const dotSpacing = 485;
        const totalDots = Math.ceil(document.body.scrollHeight / dotSpacing);

        for (let i = 0; i <= totalDots; i++) {
            const dot = document.createElement("div");
            dot.classList.add("timeline-dot");
            dot.style.top = `${i * dotSpacing}px`;
            dotsContainer.appendChild(dot);
        }

        window.addEventListener("scroll", function () {
            const scrollTop = window.scrollY || document.documentElement.scrollTop;
            const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrollPercent = (scrollTop / docHeight) * 150;

            timelineLine.style.height = scrollPercent + "%";

            timelineBlocks.forEach(function (block) {
                const blockTop = block.offsetTop;
                const blockBottom = blockTop + block.offsetHeight;

                if (scrollTop + window.innerHeight >= blockTop && scrollTop <= blockBottom) {
                    block.classList.add("active");
                } else {
                    block.classList.remove("active");
                }
            });

            const currentLineHeight = timelineLine.offsetHeight;
            const dots = dotsContainer.querySelectorAll(".timeline-dot");
            dots.forEach(dot => {
                const dotTop = parseInt(dot.style.top);
                dot.style.display = (dotTop <= currentLineHeight) ? "block" : "none";
            });
        });
    });
</script>