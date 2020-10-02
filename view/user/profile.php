<?php if (isset($error)): ?>
    <div class="alert alert__error">
        <?= $error ?>
    </div>
<?php elseif (isset($success)): ?>
    <div class="alert alert__success">
        <?= $success ?>
    </div>
<?php endif; ?>

<div class="grid__2">
    <div>
        <h2>Account information</h2>
        <div class="box">
            <?php if (empty($_SESSION['user']->getImage()) === false): ?>
                <div class="text-center profile--image"
                     style="background-image: url(<?= ROOT . '/' . $_SESSION['user']->getImage() ?>)"></div>
            <?php endif; ?>

            <div class="form-group">
                <label for="login">Login</label>
                <input class="form-field" type="text" id="login" name="login"
                       value="<?= $_SESSION['user']->getLogin() ?>"
                       disabled>
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input class="form-field" type="text" id="email" name="email"
                       value="<?= $_SESSION['user']->getEmail() ?>"
                       disabled>
            </div>

            <div class="form-group">
                <label for="phone">Phone number</label>
                <input class="form-field" type="tel" id="phone" name="phone"
                       value="<?= $_SESSION['user']->getPhone() ?>"
                       disabled>
            </div>

            <div class="form-group">
                <label for="register_date">Register date</label>
                <input class="form-field" type="date" id="register_date" name="register_date"
                       value="<?= $_SESSION['user']->getRegisterDate() ?>"
                       disabled>
            </div>

            <a href="<?= ROOT . '/user/update' ?>" class="button button--green">Update my information</a>
        </div>
    </div>
    <div>
        <h2>Actions</h2>
        <div class="box">
            <a href="<?= ROOT . '/advert/create' ?>" class="button button--blue">Create a new advert</a>
            <div id="button--archive" class="button button--blue">Create a new advert (upload a zip)</div>
            <form action="" method="post" class="form__sendArchive d-none" enctype="multipart/form-data">
                <div class="form-group m-0">
                    <label for="file">File</label>
                    <input class="form-field" type="file" id="file" name="file" required>
                </div>
                <button class="button button--green m-0 mt-1" type="submit" name="sendArchive">Post</button>
            </form>
            <a href="<?= ROOT . '/user/adverts' ?>" class="button button--blue">See all my adverts</a>
        </div>
    </div>
</div>
<script>
    document.getElementById('button--archive').addEventListener('click', () => {
        document.querySelector('.form__sendArchive').classList.remove('d-none');
    });
</script>
