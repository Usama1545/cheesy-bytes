<?php if($cookieConsentConfig['enabled'] && !$alreadyConsentedWithCookies): ?>
    <?php echo $__env->make('cookie-consent::dialogContents', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        window.laravelCookieConsent = (function() {

            const COOKIE_VALUE = 1;
            const COOKIE_DOMAIN = '<?php echo e(config('session.domain') ?? request()->getHost()); ?>';

            function consentWithCookies() {
                setCookie('<?php echo e($cookieConsentConfig['cookie_name']); ?>', COOKIE_VALUE,
                    <?php echo e($cookieConsentConfig['cookie_lifetime']); ?>);
                hideCookieDialog();
            }

            function cookieExists(name) {
                return (document.cookie.split('; ').indexOf(name + '=' + COOKIE_VALUE) !== -1);
            }

            function hideCookieDialog() {
                const dialogs = document.getElementsByClassName('js-cookie-consent');

                for (let i = 0; i < dialogs.length; ++i) {
                    dialogs[i].classList.add('animate-outDownn'); // Add class to trigger animation
                    setTimeout(() => {
                        dialogs[i].style.display = 'none'; // Hide the dialog after animation completes
                    }, 500); // Adjust this timeout according to your animation duration
                }
            }

            function setCookie(name, value, expirationInDays) {
                const date = new Date();
                date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
                document.cookie = name + '=' + value +
                    ';expires=' + date.toUTCString() +
                    ';domain=' + COOKIE_DOMAIN +
                    ';path=/<?php echo e(config('session.secure') ? ';secure' : null); ?>' +
                    '<?php echo e(config('session.same_site') ? ';samesite=' . config('session.same_site') : null); ?>';
            }

            if (cookieExists('<?php echo e($cookieConsentConfig['cookie_name']); ?>')) {
                hideCookieDialog();
            }

            const buttons = document.getElementsByClassName('js-cookie-consent-agree');

            for (let i = 0; i < buttons.length; ++i) {
                buttons[i].addEventListener('click', consentWithCookies);
            }

            return {
                consentWithCookies: consentWithCookies,
                hideCookieDialog: hideCookieDialog
            };
        })();
    </script>
<?php endif; ?>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\vendor\spatie\laravel-cookie-consent\src\/../resources/views/index.blade.php ENDPATH**/ ?>