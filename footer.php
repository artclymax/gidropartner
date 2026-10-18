
<?php
$logo               = function_exists('get_field') ? get_field('site_logo', 'option') : null;
$logo_text          = function_exists('get_field') ? get_field('site_logo_text', 'option') : null;
$logo_text_alt      = trim(preg_replace('/\r\n|\r|\n/', ' ', (string) $logo_text));
$phone               = function_exists('get_field') ? get_field('contact_phone', 'option') : null;
$hours               = function_exists('get_field') ? get_field('contact_hours', 'option') : null;
$phone_href          = $phone ? 'tel:' . preg_replace('/[^\d+]/', '', $phone) : '';
$callback_btn_text   = function_exists('get_field') ? get_field('callback_modal_btn_text', 'option') : null;
$callback_btn_text   = $callback_btn_text ?: 'Заказать звонок';
$footer_description  = function_exists('get_field') ? get_field('footer_description', 'option') : null;
$footer_copyright    = function_exists('get_field') ? get_field('footer_copyright_name', 'option') : null;
$footer_copyright    = $footer_copyright ?: 'ООО «М350»';
$cookie_policy_url   = function_exists('get_field') ? get_field('cookie_policy_url', 'option') : null;
$privacy_policy_url  = function_exists('get_privacy_policy_url') ? get_privacy_policy_url() : '';
?>

<footer class="footer">
    <div class="container">
        <div class="footer__columns">

            <div class="footer__col footer__col--about">
                <a href="<?= esc_url(home_url('/')) ?>" class="footer__logo">
                    <?php if (!empty($logo['url'])) : ?>
                        <img src="<?= esc_url($logo['url']) ?>" alt="<?= esc_attr($logo_text_alt) ?>" class="footer__logo-icon" width="<?= (int) $logo['width'] ?>" height="<?= (int) $logo['height'] ?>">
                    <?php endif; ?>
                    <?php if ($logo_text) : ?><span class="footer__logo-text title-4"><?= nl2br(esc_html($logo_text)) ?></span><?php endif; ?>
                </a>
                <div class="footer__divider"></div>
                <?php if ($footer_description) : ?><p class="footer__description text-s"><?= esc_html($footer_description) ?></p><?php endif; ?>
            </div>

            <div class="footer__col footer__col--nav">
                <p class="footer__title text-badge">Навигация</p>
                <?php if (has_nav_menu('footer')) : ?>
                    <?php wp_nav_menu([
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'footer__menu',
                        'depth'          => 1,
                    ]); ?>
                <?php endif; ?>
            </div>

            <div class="footer__col footer__col--services">
                <p class="footer__title text-badge">Услуги</p>
                <?php
                $footer_services = get_posts(array(
                    'post_type'      => 'service',
                    'posts_per_page' => -1,
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC',
                    'no_found_rows'  => true,
                ));
                ?>
                <?php if ($footer_services) : ?>
                    <ul class="footer__services-list">
                        <?php foreach ($footer_services as $service_post) :
                            $service_link = function_exists('get_field') ? get_field('service_link', $service_post->ID) : null;
                            $service_link = $service_link ?: get_permalink($service_post->ID);
                        ?>
                            <li>
                                <a href="<?= esc_url($service_link) ?>"><?= esc_html($service_post->post_title) ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="footer__col footer__col--contacts">
                <p class="footer__title text-badge">Контакты</p>
                <div class="footer__contacts">
                    <?php if ($phone) : ?>
                        <a href="<?= esc_url($phone_href) ?>" class="footer__phone">
                            <?= custom_icon_phone() ?>
                            <span><?= esc_html($phone) ?></span>
                        </a>
                    <?php endif; ?>
                    <?php if ($hours) : ?>
                        <span class="footer__hours">
                            <?= custom_icon_clock() ?>
                            <span><?= esc_html($hours) ?></span>
                        </span>
                    <?php endif; ?>
                </div>
                <button type="button" class="btn footer__cta" data-open="callback-modal"><?= esc_html($callback_btn_text) ?></button>
            </div>

        </div>

        <div class="footer__bottom">
            <p class="footer__copyright text-s"><?= esc_html($footer_copyright) ?> © <?= esc_html(date('Y')) ?>. Все права защищены.</p>
            <div class="footer__legal">
                <?php if ($cookie_policy_url) : ?><a href="<?= esc_url($cookie_policy_url) ?>" class="text-s">Политика обработки файлов cookie</a><?php endif; ?>
                <?php if ($privacy_policy_url) : ?><a href="<?= esc_url($privacy_policy_url) ?>" class="text-s">Политика обработки персональных данных</a><?php endif; ?>
            </div>
        </div>
    </div>
</footer>

<a href="#top" class="scroll-top" aria-label="Наверх"><?= custom_icon_arrow_up() ?></a>

<?php get_template_part('template-parts/modals'); ?>

<?php wp_footer(); ?>
</body>
</html>
