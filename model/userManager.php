<?php

class UserManager
{
    public static function connect($email, $password = null, $updated = false)
    {
        $query = MyPDO::getInstance()->prepare('
                SELECT *
                FROM users
                WHERE email = :email
                ');
        $query->execute(['email' => $email]);
        $result = $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');

        if ($result[0] !== null) {
            if (password_verify($password, $result[0]->getPassword()) || $updated === true) {
                $_SESSION['logged'] = true;
                $_SESSION['user'] = $result[0];
            } else {
                throw new Exception('Password invalid');
            }
        } else {
            throw new Exception('No user with this login');
        }

        self::redirectToProfile();
    }

    public static function register($args)
    {
        $login = $args['login'];
        $email = $args['email'];
        $phone = $args['phone'];
        $password = $args['password'];
        $repeat = $args['password_repeat'];

        if (empty($login) || empty($email) || empty($phone) || empty($password) || empty($repeat)) {
            throw new Exception('You must fill all the fields');
        }

        $errors = self::checkUserInfos($login, $email, $phone);

        if ($errors !== null) {
            throw new Exception($errors);
        }

        if (preg_match('#^\S*(?=\S{8,})(?=\S*[\d])(?=.*[a-z])(?=.*\W)\S*$#', $password) === 0) {
            throw new Exception('Password invalid: 8 characters minimum and should include at least one letter, one number, and one special character');
        }

        if ($password !== $repeat) {
            throw new Exception('Passwords do not match');
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $query = MyPDO::getInstance()->prepare('
                INSERT INTO users(login, email, password, phone, register_date)
                VALUES (:login, :email, :password, :phone, :register_date)
                ');
        $query->execute([
            'login' => $login,
            'email' => $email,
            'password' => $hashed,
            'phone' => $phone,
            'register_date' => date('Y-m-d')
        ]);

        self::connect($email, $password);
    }

    public static function update($args)
    {
        $login = $args['login'];
        $email = $args['email'];
        $phone = $args['phone'];
        $currentPassword = $args['current_password'];
        $newPassword = $args['new_password'];
        $repeat = $args['password_repeat'];
        $uploadFile = $_SESSION['user']->getImage();

        if (empty($login) || empty($email) || empty($phone)) {
            throw new Exception('You must fill login, email and phone fields');
        }

        $errors = self::checkUserInfos($login, $email, $phone);

        if ($errors !== null) {
            throw new Exception($errors);
        }

        if (empty($newPassword) === false) {
            if (empty($currentPassword) || empty($repeat)) {
                throw new Exception('You must fill current password and repeat the new');
            }

            if (preg_match('#^\S*(?=\S{8,})(?=\S*[\d])(?=.*[a-z])(?=.*\W)\S*$#', $newPassword) === 0) {
                throw new Exception('Password invalid: 8 characters minimum and should include at least one letter, one number, and one special character');
            }

            if (password_verify($currentPassword, $_SESSION['user']->getPassword()) === false) {
                throw new Exception('Current password invalid');
            }

            if ($newPassword !== $repeat) {
                throw new Exception('New passwords do not match');
            }

            $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        } else {
            $hashed = $_SESSION['user']->getPassword();
        }

        if (empty($_FILES['user_img']['name']) === false) {
            $fileExtensionsAllowed = ['jpeg', 'jpg', 'png'];

            $uploadDir = 'public/users/';
            $imageFileType = strtolower(pathinfo($_FILES['user_img']['name'], PATHINFO_EXTENSION));
            $uploadFile = $uploadDir . uniqid() . uniqid() . '.' . $imageFileType;

            if (!in_array($imageFileType, $fileExtensionsAllowed)) {
                throw new Exception('This profile picture is not allowed: please upload a JPEG or PNG file');
            }

            if (move_uploaded_file($_FILES['user_img']['tmp_name'], $uploadFile) === false) {
                throw new Exception('Error while uploading profile picture');
            }
        }

        $query = MyPDO::getInstance()->prepare('
                UPDATE users
                SET login = :login, email = :email, password = :password, phone = :phone, image = :image
                WHERE id = :id
                ');
        $query->execute([
            'login' => $login,
            'email' => $email,
            'password' => $hashed,
            'phone' => $phone,
            'image' => $uploadFile,
            'id' => $_SESSION['user']->getId()
        ]);

        self::connect($email, null, true);
    }

    public static function checkUserInfos($login, $email, $phone)
    {
        if (self::checkCredentials($login, $email) === false) {
            return 'Login or email already used';
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return 'Email invalid';
        }

        if (preg_match('#^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$#', $phone) === 0) {
            return 'Phone number invalid';
        }

        return null;
    }

    public static function checkCredentials($login, $email)
    {
        $query = MyPDO::getInstance()->prepare('
                SELECT *
                FROM users
                WHERE (login = :login
                OR email = :email)
                AND login != :loginSession
                ');

        $loginSession = isset($_SESSION['user']) ? $_SESSION['user']->getLogin() : null;

        $query->execute([
            'login' => $login,
            'email' => $email,
            'loginSession' => $loginSession
        ]);

        return empty($query->fetchAll());
    }

    public static function logout()
    {
        session_unset();
        session_destroy();
        header('Location: ' . ROOT);
    }

    public static function checkLogged()
    {
        return isset($_SESSION['logged']) && $_SESSION['logged'] === true;
    }

    public static function redirectToProfile()
    {
        header('Location: ' . ROOT . '/user/profile');
    }

    public static function redirectToLogin()
    {
        header('Location: ' . ROOT . '/user/login');
    }

    public static function redirectToHome()
    {
        header('Location: ' . ROOT);
    }
}
