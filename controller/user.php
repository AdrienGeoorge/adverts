<?php
if (!empty($_GET['action'])) {
    if ($_GET['action'] === 'login') {
        if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
            UserManager::redirectToProfile();
        }

        if (isset($_POST['registerForm'])) {
            try {
                UserManager::register($_POST);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        } elseif (isset($_POST['loginForm'])) {
            try {
                UserManager::connect($_POST['email'], $_POST['password']);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        $returnedTemplate = 'user/login';
    } elseif ($_GET['action'] === 'logout') {
        UserManager::logout();
    } elseif ($_GET['action'] === 'profile') {
        if (isset($_SESSION['logged']) === false) {
            UserManager::redirectToLogin();
        }

        if (isset($_POST['sendArchive'])) {
            try {
                $success = AdvertManager::sendArchive();
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        $returnedTemplate = 'user/profile';
    } elseif ($_GET['action'] === 'update') {
        if (isset($_SESSION['logged']) === false) {
            UserManager::redirectToLogin();
        }

        if (isset($_POST['updateForm'])) {
            try {
                UserManager::update($_POST);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        $returnedTemplate = 'user/update';
    } elseif ($_GET['action'] === 'adverts') {
        if (isset($_SESSION['logged']) === false) {
            UserManager::redirectToLogin();
        }

        $adverts = AdvertManager::getAdvertByUser();

        $returnedTemplate = 'user/adverts';
    }
}
