<header>
    <div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; bottom: #transparent-sticky-navbar" class="uk-visible@m">
        <nav class="uk-navbar-container uk-background-primary" uk-navbar style="position: relative; z-index: 980;">
            <div class="uk-navbar-left">
                <a class="uk-navbar-item uk-logo uk-margin-top-small" href="#"><img src="/vectors/logo.svg" uk-svg class="logo"></a>
                <ul class="uk-navbar-nav">
                    <li class="uk-active"><a href="#">Active</a></li>
                    <li>
                        <a href="#">Parent</a>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li class="uk-active"><a href="#">Active</a></li>
                                <li><a href="#">Item</a></li>
                                <li><a href="#">Item</a></li>
                            </ul>
                        </div>
                    </li>
                    <li><a href="#">Item</a></li>
                </ul>

            </div>
            <div class="uk-navbar-right">
                <a href="/admin/login" class="uk-button uk-button-default uk-margin-right">Sign In</a>
                <a href="/register" class="uk-button uk-button-primary uk-margin-right">Register</a>
            </div>
        </nav>
    </div>

    <nav class="uk-navbar uk-navbar-container uk-hidden@m">
        <div class="uk-navbar-left">
            <a class="uk-navbar-toggle" href="#">
                <span uk-navbar-toggle-icon uk-toggle="target: #offcanvas-usage"></span>
                <a class="uk-navbar-item uk-logo" href="#">Logo</a>
            </a>
        </div>
    </nav>

    <div id="offcanvas-usage" uk-offcanvas>
        <div class="uk-offcanvas-bar">

            <button class="uk-offcanvas-close" type="button" uk-close></button>

            <h3>Title</h3>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

        </div>
    </div>
</header>
