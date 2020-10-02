<?php if (isset($error)): ?>
    <div class="alert alert__error">
        <?= $error ?>
    </div>
<?php endif; ?>

<div class="text-center">
    <h2>Update my information</h2>
    <div class="box w-60 m-auto mt-1">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="user_img">Profile picture</label>
                <input class="form-field" type="file" id="user_img" name="user_img">
            </div>

            <div class="form-group">
                <label for="login">Login</label>
                <input class="form-field" type="text" id="login" name="login"
                       value="<?= $_SESSION['user']->getLogin() ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input class="form-field" type="text" id="email" name="email"
                       value="<?= $_SESSION['user']->getEmail() ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="phone">Phone number</label>
                <input class="form-field" type="tel" id="phone" name="phone"
                       value="<?= $_SESSION['user']->getPhone() ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="current_password">Current password</label>
                <input class="form-field" type="password" id="current_password" name="current_password"
                       placeholder="Enter your current password">
            </div>

            <div class="form-group">
                <label for="new_password">New password</label>
                <input class="form-field" type="password" id="new_password" name="new_password"
                       placeholder="Enter a new password">
            </div>

            <div class="form-group">
                <label for="password_repeat">Repeat password</label>
                <input class="form-field" type="password" id="password_repeat" name="password_repeat"
                       placeholder="Repeat the password">
            </div>

            <button class="button button--green" type="submit" name="updateForm">Update</button>
            <a href="<?= ROOT . '/user/profile' ?>" class="button button--red">Cancel and return to my profile</a>
        </form>
    </div>
</div>
