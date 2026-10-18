<?php
defined('ABSPATH') || exit;

/**
 * Cookie banner + script injection.
 *
 * Скрипты «всегда» — выводятся на каждой странице.
 * Скрипты «после согласия» — только если пользователь нажал «Принять»
 * (наличие куки custom_cookie_consent === 'accepted').
 *
 * Поля редактируются в «Настройки сайта → Cookie / Скрипты».
 */

const custom_COOKIE_NAME = 'custom_cookie_consent';

function custom_cookie_is_accepted(): bool {
    return isset($_COOKIE[custom_COOKIE_NAME])
        && $_COOKIE[custom_COOKIE_NAME] === 'accepted';
}

function custom_cookie_is_decided(): bool {
    return isset($_COOKIE[custom_COOKIE_NAME])
        && in_array($_COOKIE[custom_COOKIE_NAME], ['accepted', 'declined'], true);
}

/**
 * Always-on scripts — выводятся в <head>.
 * После-accept скрипты — выводятся в <head> только при наличии согласия.
 */
add_action('wp_head', 'custom_render_head_scripts', 5);
function custom_render_head_scripts() {
    $always = trim((string) get_field('cookie_scripts_always', 'option'));
    if ($always !== '') {
        echo "\n<!-- always-on scripts -->\n" . $always . "\n";
    }

    if (custom_cookie_is_accepted()) {
        $after = trim((string) get_field('cookie_scripts_after_accept', 'option'));
        if ($after !== '') {
            echo "\n<!-- post-consent scripts -->\n" . $after . "\n";
        }
    }
}

/**
 * Баннер. Выводится только если согласие ещё не получено.
 * После accept-а ставится cookie на 365 дней и страница перезагружается,
 * чтобы post-consent скрипты подключились серверно.
 */
add_action('wp_footer', 'custom_render_cookie_banner', 100);
function custom_render_cookie_banner() {
    if (custom_cookie_is_decided()) return;

    $text       = get_field('cookie_banner_text', 'option');
    $btn        = get_field('cookie_banner_button', 'option');
    $policy_url = get_field('cookie_policy_url', 'option');
    ?>
    <div class="cookie-banner" id="cookie-banner" role="dialog" aria-live="polite" aria-label="Cookie">
      <div class="cookie-banner__inner">
        <div class="cookie-banner__content">
          <?php if ($text) : ?>
            <p class="cookie-banner__text text">
              <?php echo nl2br(esc_html($text)); ?>
              <?php if ($policy_url) : ?> <a href="<?php echo esc_url($policy_url); ?>">Политикой обработки файлов cookie</a><?php endif; ?>
            </p>
          <?php endif; ?>
        </div>
        <div class="cookie-banner__actions">
          <?php if ($btn) : ?>
          <button type="button" class="btn cookie-banner__btn" id="cookie-accept-btn">
            <?php echo esc_html($btn); ?>
          </button>
          <?php endif; ?>
          <button type="button" class="btn btn--outline cookie-banner__btn" id="cookie-decline-btn">
            Отклонить
          </button>
        </div>
      </div>
    </div>
    <script>
    (function () {
      var name    = '<?php echo esc_js(custom_COOKIE_NAME); ?>';
      var banner  = document.getElementById('cookie-banner');
      var btnOk   = document.getElementById('cookie-accept-btn');
      var btnNo   = document.getElementById('cookie-decline-btn');
      if (!banner) return;

      function setCookie(value, days) {
        var d = new Date();
        d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + d.toUTCString() + '; path=/; SameSite=Lax';
      }

      function hide() { banner.classList.add('cookie-banner--hidden'); }

      if (btnOk) btnOk.addEventListener('click', function () {
        setCookie('accepted', 365);
        hide();
        setTimeout(function () { window.location.reload(); }, 150);
      });

      if (btnNo) btnNo.addEventListener('click', function () {
        setCookie('declined', 30);
        hide();
      });
    })();
    </script>
    <?php
}
