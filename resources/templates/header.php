<header>
    <!-- TODO: Make navbar sticky-->
    <div uk-sticky="sel-target: #navbar; cls-active: uk-navbar-sticky;" class="uk-visible@m">
        <nav class="uk-navbar-container" id="navbar" uk-navbar style="z-index: 980;">
            <div class="uk-navbar-left">
                <a class="uk-navbar-item uk-logo uk-margin-top-small" href="/"><img src="/vectors/logo.svg" uk-svg class="logo"></a>
                <ul class="uk-navbar-nav">
                    <li><a href="/search">Search</a></li>
                    <?php if(isset($_SESSION['userId'])): ?>
                        <li>
                            <a href="/estates/userList">Your estates</a>
                            <div class="uk-navbar-dropdown" uk-dropdown="offset: 0">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    <li><a href="/estates/add">Add estate</a></li>
                                    <li><a href="/favourites">Favourites</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="/stats">Stats</a></li>
                    <?php endif;?>

                    <?php use Amdrija\RealEstate\Application\Services\LoginService;

                    if(LoginService::isAdminSession()): ?>
                        <li>
                            <a href="/admin/users">Admin controls</a>
                            <div class="uk-navbar-dropdown"  uk-dropdown="offset: 0">
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

    <div uk-sticky="sel-target: #mobile-navbar; cls-active: uk-navbar-sticky;" class="uk-hidden@m" >
        <nav class="uk-navbar uk-navbar-container uk-background-muted" id="mobile-navbar">
            <div class="uk-navbar-left">
                <a class="uk-navbar-toggle" href="#">
                    <span uk-navbar-toggle-icon uk-toggle="target: #offcanvas-usage"></span>
                </a>
                <a class="uk-navbar-item uk-logo uk-margin-top-small uk-background-muted" href="/"><img src="/vectors/logo.svg" class="logo" style="margin-left: -20px;"></a>
            </div>
        </nav>
    </div>

    <div id="offcanvas-usage" uk-offcanvas>
        <div class="uk-offcanvas-bar uk-flex uk-flex-column">

            <button class="uk-offcanvas-close" type="button" uk-close></button>

            <ul class="uk-nav uk-nav-primary uk-nav-center uk-margin-auto-vertical">
                <li><a href="/search">Search</a></li>
                <?php if(isset($_SESSION['userId'])): ?>
                    <li class="uk-parent">
                        <a href="/estates/userList">Your estates</a>
                        <ul class="uk-nav-sub">
                            <li><a href="/estates/add">Add estate</a></li>
                            <li><a href="/favourites">Favourites</a></li>
                        </ul>
                    </li>
                    <li><a href="/stats">Stats</a></li>
                <?php endif;?>

                <?php if(LoginService::isAdminSession()): ?>
                    <li class="uk-parent">
                        <a href="/admin/users">Admin controls</a>
                        <ul class="uk-nav-sub">
                            <li><a href="/admin/users">Users</a></li>
                            <li><a href="/admin/streets">Streets</a></li>
                            <li><a href="/admin/microLocations">Micro locations</a></li>
                            <li><a href="/admin/agencies">Agencies</a></li>
                        </ul>
                    </li>
                <?php endif;?>

                <?php if(isset($_SESSION['userId'])):?>
                    <li><a href="/logout">Sign Out</a></li>
                    <li><a href="/user/edit">Edit Profile</a></li>
                <?php else:?>
                    <li><a href="/login">Sign In</a></li>
                    <li><a href="/register">Register</a></li>
                <?php endif?>
            </ul>
        </div>
    </div>
</header>
