<?php if (isset($error)): ?>
    <div class="alert alert__error">
        <?= $error ?>
    </div>
<?php elseif (isset($success)): ?>
    <div class="alert alert__success">
        <?= $success ?>
    </div>
<?php endif; ?>

<div class="advert__container">
    <div class="advert__background"
         style="background-image: url('<?= empty($advert->getImages()) ? ROOT . '/assets/images/no_images.png' : ROOT . '/' . $advert->getImages()[0][1] ?>');">
        <div class="advert__background__title">
            <div class="advert__background__title--relative">
                <div class="advert__background__title--absolute">
                    <div class="advert__background__title--name"><?= $advert->getTitle() ?></div>
                    <div class="advert__background__title--infos">Published on
                        <b><?= strftime("%A %d %B %Y", strtotime($advert->getDate())) ?></b> by
                        <b><?= $advert->getUser()[0] ?></b>
                    </div>
                </div>
            </div>
            <div class="advert__background__title--relative">
                <div class="advert__background__title--absolute text-center">
                    <div class="advert__background__title--price"><?= $advert->getPrice() ?> $</div>
                    <div id="button--contact" class="button button--blue">
                        Contact seller
                    </div>
                    <div id="expand">
                        <div class="expand__header">
                            <div class="expand__header--email">
                                Write your message
                            </div>
                            <div class="expand__header--x">
                                <div class="expand__header--close">
                                    <div class="expand__header--x-line1"></div>
                                    <div class="expand__header--x-line2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="expand__content">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input class="form-field" type="email" id="email" name="email"
                                           placeholder="Enter your email" required>
                                </div>

                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea class="form-field" id="message" name="message"
                                              placeholder="Enter your message" rows="3" required></textarea>
                                </div>
                                <button class="button button--green" type="submit" name="sendMessage">Send message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="advert__content">
        <?= htmlspecialchars_decode($advert->getDescription()) ?>
        <h2 class="mt-1">Gallery pictures</h2>
        <?php if (empty($advert->getImages())): ?>
            <h3>There are no pictures</h3>
        <?php else: ?>
            <div class="advert__content__pictures">
                <?php foreach ($advert->getImages() as $image): ?>
                    <img src="<?= ROOT . '/' . $image[1] ?>" alt="">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<script>
    document.getElementById('button--contact').addEventListener('click', () => {
        document.getElementById('expand').style.opacity = 1;
    });

    document.querySelector('.expand__header--close').addEventListener('click', () => {
        document.getElementById('expand').style.opacity = 0;
    });
</script>
