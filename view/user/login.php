<?php if (isset($error)): ?>
    <div class="alert alert__error">
        <?= $error ?>
    </div>
<?php endif; ?>

<div class="grid__2">
    <div>
        <h2>Log in</h2>
        <div class="box">
            <form action="" method="post">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input class="form-field" type="text" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-field" type="password" id="password" name="password"
                           placeholder="Enter your password" required>
                </div>

                <div class="text-center">
                    <button class="button button--green" type="submit" name="loginForm">Connect</button>
                </div>
            </form>
        </div>
    </div>
    <div>
        <h2>Register</h2>
        <div class="box">
            <form action="" method="post">
                <div class="form-group">
                    <label for="login">Login</label>
                    <input class="form-field" type="text" id="login" name="login" placeholder="Enter a login" required>
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input class="form-field" type="text" id="email" name="email" placeholder="Enter an email" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone number</label>
                    <input class="form-field" type="tel" id="phone" name="phone" placeholder="Enter a phone number"
                           required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-field" type="password" id="password" name="password"
                           placeholder="Enter a password" required>
                </div>

                <div class="form-group">
                    <label for="password_repeat">Repeat password</label>
                    <input class="form-field" type="password" id="password_repeat" name="password_repeat"
                           placeholder="Repeat the password" required>
                </div>

                <div class="text-center">
                    <button class="button button--green" type="submit" name="registerForm">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>
