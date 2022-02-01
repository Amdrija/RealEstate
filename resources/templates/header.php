<header>
    <!-- TODO: Make navbar sticky-->
    <div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; bottom: #transparent-sticky-navbar" class="uk-visible@m">
        <nav class="uk-navbar-container uk-background-primary" uk-navbar style="position: relative; z-index: 980;">
            <div class="uk-navbar-left">
                <a class="uk-navbar-item uk-logo uk-margin-top-small" href="/"><img src="/vectors/logo.svg" uk-svg class="logo"></a>
                <ul class="uk-navbar-nav">
                    <li><a href="/search">Search</a></li>
                    <li><a href="/estates/userList">Your estates</a></li>
                    <?php use Amdrija\RealEstate\Application\Services\LoginService;

                    if(LoginService::isAdminSession()): ?>
                        <li>
                            <a href="/admin/users">Admin controls</a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    <li><a href="/admin/users">Users</a></li>
                                    <li><a href="/admin/streets">Streets</a></li>
                                    <li><a href="/admin/microLocations">Micro locations</a></li>
                                    <li><a href="/admin/agencies">Agencies</a></li>
                                </ul>
                            </div>
                        </li>
                    <?php endif;?>
                </ul>

            </div>
            <div class="uk-navbar-right">
                <?php if(isset($_SESSION['userId'])):?>
                    <a href="/logout" class="uk-button uk-button-default uk-margin-right">Sign Out</a>
                    <a href="/user/edit" class="uk-button uk-button-secondary uk-margin-right">Edit Profile</a>
                <?php else:?>
                    <a href="/login" class="uk-button uk-button-default uk-margin-right">Sign In</a>
                    <a href="/register" class="uk-button uk-button-primary uk-margin-right">Register</a>
                <?php endif?>
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
