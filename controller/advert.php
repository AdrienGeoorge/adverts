<?php
if (!empty($_GET['action'])) {
    if ($_GET['action'] === 'show') {
        $advert = AdvertManager::getAdvert($_GET['id']);

        if (empty($advert)) {
            UserManager::redirectToHome();
        }

        if (isset($_POST['sendMessage'])) {
            try {
                $success = AdvertManager::sendMessage($_POST, $advert);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        $returnedTemplate = 'advert/showOneAdvert';
    } elseif ($_GET['action'] === 'create') {
        if (isset($_SESSION['logged']) === false) {
            UserManager::redirectToLogin();
        }

        if (isset($_POST['createForm'])) {
            try {
                $success = AdvertManager::create($_POST);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        $returnedTemplate = 'advert/create';
    } elseif ($_GET['action'] === 'update') {
        if (isset($_SESSION['logged']) === false) {
            UserManager::redirectToLogin();
        }

        $advert = AdvertManager::getAdvert($_GET['id']);

        if (isset($_POST['updateForm'])) {
            try {
                $success = AdvertManager::update($_POST, $advert);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        $advert = AdvertManager::getAdvert($_GET['id']);
        $returnedTemplate = 'advert/update';
    } elseif ($_GET['action'] === 'deleteImage') {
        AdvertManager::deleteImage($_GET['id']);
        return true;
    }
}
