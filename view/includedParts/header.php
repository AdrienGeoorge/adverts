<header>
    <div class="header-limiter">
        <h1><a href="#">Advert<span>Shop</span></a></h1>
        <nav>
            <a href="<?= ROOT ?>">Adverts</a>
            <a href="<?= ROOT . '/advert/create' ?>">Post an advert</a>
            <a href="<?= ROOT . '/user/adverts' ?>">My adverts</a>
        </nav>

        <div class="header-right">
            <?php if (UserManager::checkLogged()): ?>
                <div class="header-user__menu">
                    <?= $_SESSION['user']->getLogin() ?>
                    <ul>
                        <li><a href="<?= ROOT . '/user/profile' ?>">My profile</a></li>
                        <li><a href="<?= ROOT . '/user/logout' ?>" class="highlight">Logout</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <div class="header-user__button">
                    <a href="<?= ROOT . '/user/login' ?>">Log in or register</a>
                </div>
            <?php endif; ?>
        </div>

    </div>

</header>
