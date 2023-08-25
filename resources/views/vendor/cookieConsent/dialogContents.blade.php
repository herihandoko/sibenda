@if (CookieSetting('cookie_status'))
    <div
        class="js-cookie-consent cookie-consent position-fixed bottom-0 bg-light bg-gradient">
        <div class="p-4 w-100 d-md-flex justify-content-between align-items-center">
            <span class="cookie-consent__message">
                {{CookieSetting('cookie_confirmation')}}
            </span>
            <button class="js-cookie-consent-agree cookie-consent__agree btn btn-light btn-xs border">
                {{CookieSetting('cookie_button')}}
            </button>
        </div>
    </div>
@endif
