<?php

class AdvertManager
{
    public static function getAdvert($id)
    {
        $query = MyPDO::getInstance()->prepare('
                SELECT p.id, p.title, p.description, p.date, p.price, concat(u.login, ";", u.email) AS user, group_concat(i.id, "__", i.image SEPARATOR ";") as images
                FROM adverts p
                LEFT JOIN users u ON u.id = p.user
                LEFT JOIN images i ON i.advert_id = p.id
                WHERE p.id = :id
                GROUP BY p.id
                ');
        $query->execute(array(
            'id' => $id
        ));

        $result = $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Advert');

        if ($result[0] !== null) {
            return $result[0];
        }

        return null;
    }

    public static function getLastAdverts()
    {
        $query = MyPDO::getInstance()->prepare('
                SELECT p.id, p.title, p.price, group_concat(i.id, "__", i.image SEPARATOR ";") as images
                FROM adverts p
                LEFT JOIN images i ON i.advert_id = p.id
                GROUP BY p.id
                ORDER BY p.id DESC
                ');
        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Advert');
    }

    public static function getAdvertByUser()
    {
        $query = MyPDO::getInstance()->prepare('
                SELECT p.id, p.title, p.price, group_concat(i.id, "__", i.image SEPARATOR ";") as images
                FROM adverts p
                LEFT JOIN images i ON i.advert_id = p.id
                WHERE p.user = :id
                GROUP BY p.id
                ORDER BY p.id DESC
                ');
        $query->execute(['id' => $_SESSION['user']->getId()]);

        return $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Advert');
    }

    public static function create($args)
    {
        $title = $args['title'];
        $description = $args['description'];
        $price = $args['price'];
        $end_date = $args['end_date'];
        $images = [];

        $errors = self::checkData($title, $description, $price, $end_date);

        if ($errors !== null) {
            throw new Exception($errors);
        }

        foreach ($_FILES['advert_img']['error'] as $key => $error) {
            if ($error == UPLOAD_ERR_OK && empty($_FILES['advert_img']['name'][$key]) === false) {
                $fileExtensionsAllowed = ['jpeg', 'jpg', 'png'];

                $uploadDir = 'public/adverts/';
                $imageFileType = strtolower(pathinfo($_FILES['advert_img']['name'][$key], PATHINFO_EXTENSION));
                $uploadFile = $uploadDir . uniqid() . uniqid() . '.' . $imageFileType;

                if (!in_array($imageFileType, $fileExtensionsAllowed)) {
                    throw new Exception('This ' . $key . ' image is not allowed: please upload a JPEG or PNG file');
                }

                if (move_uploaded_file($_FILES['advert_img']['tmp_name'][$key], $uploadFile) === false) {
                    throw new Exception('Error while uploading an image');
                }

                $images[] = $uploadFile;
            }
        }

        $query = MyPDO::getInstance()->prepare('
                INSERT INTO adverts(title, description, date, end_date, price, user)
                VALUES (:title, :description, :date, :end_date, :price, :user)
                ');
        $query->execute([
            'title' => $title,
            'description' => $description,
            'date' => date('Y-m-d'),
            'end_date' => $end_date,
            'price' => $price,
            'user' => $_SESSION['user']->getId()
        ]);

        $advertId = MyPDO::getInstance()->lastInsertId();

        foreach ($images as $image) {
            $query = MyPDO::getInstance()->prepare('
                INSERT INTO images(advert_id, image)
                VALUES (:advert_id, :image)
                ');
            $query->execute([
                'advert_id' => $advertId,
                'image' => $image,
            ]);
        }

        return 'Advert successfully posted';
    }

    public static function update($args, $advert)
    {
        $title = $args['title'];
        $description = $args['description'];
        $price = $args['price'];
        $end_date = $args['end_date'];
        $images = [];

        $errors = self::checkData($title, $description, $price, $end_date);

        if ($errors !== null) {
            throw new Exception($errors);
        }

        $uploadDir = 'public/adverts/';
        $fileExtensionsAllowed = ['jpeg', 'jpg', 'png'];

        for ($i = 0; $i < 3; $i++) {
            if (empty($_FILES['advert_img']['name'][$i]) === false) {
                $imageFileType = strtolower(pathinfo($_FILES['advert_img']['name'][$i], PATHINFO_EXTENSION));
                $uploadFile = $uploadDir . uniqid() . uniqid() . '.' . $imageFileType;

                if (!in_array($imageFileType, $fileExtensionsAllowed)) {
                    throw new Exception('An image is not allowed: please upload a JPEG or PNG file');
                }

                if (move_uploaded_file($_FILES['advert_img']['tmp_name'][$i], $uploadFile) === false) {
                    throw new Exception('Error while uploading an image');
                }

                $images[$i] = $uploadFile;
            }
        }

        $query = MyPDO::getInstance()->prepare('
                UPDATE adverts
                SET title = :title, description = :description, end_date = :end_date, price = :price
                WHERE id = :id
                ');
        $query->execute([
            'title' => $title,
            'description' => $description,
            'end_date' => $end_date,
            'price' => $price,
            'id' => $advert->getId()
        ]);

        foreach ($images as $key => $value) {
            if (isset($advert->getImages()[$key])) {
                $query = MyPDO::getInstance()->prepare('
                UPDATE images
                SET image = :image
                WHERE id = :id
                ');
                $query->execute([
                    'image' => $value,
                    'id' => $advert->getImages()[$key][0],
                ]);
            } else {
                $query = MyPDO::getInstance()->prepare('
                INSERT INTO images(advert_id, image)
                VALUES (:advert_id, :image)
                ');
                $query->execute([
                    'advert_id' => $advert->getId(),
                    'image' => $value,
                ]);
            }
        }

        return 'Advert successfully updated';
    }

    public static function checkData($title, $description, $price, $end_date)
    {
        if (empty($title) || empty($description) || empty($price) || empty($end_date)) {
            return 'You must fill all the fields: images not required';
        }

        if (preg_match('#^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$#', $end_date) === 0) {
            return 'End date invalid';
        }

        if (preg_match('#^\d+(\.\d{2})?$#', $price) === 0) {
            return 'Price invalid';
        }

        return null;
    }

    public static function deleteImage($id)
    {
        $query = MyPDO::getInstance()->prepare('
                DELETE
                FROM images
                WHERE id = :id
                ');
        $query->execute(['id' => $id]);
    }

    public static function sendMessage($args, $advert)
    {
        $to = $args['email'];
        $message = $args['message'];

        if (empty($to) || empty($message)) {
            throw new Exception('You must fill all the fields to contact seller');
        }

        $subject = 'About your advert ' . $advert->getTitle();
        $message = wordwrap($message, 70, "\r\n");
        $headers = array(
            'From' => 'webmaster@advertshop.com',
            'Reply-To' => 'webmaster@advertshop.com',
            'X-Mailer' => 'PHP/' . phpversion()
        );

        $sending = mail($to, $subject, $message, $headers);

        if ($sending === false) {
            throw new Exception('The message was not sent due to an error');
        }

        return 'Your message has been sent successfully: the seller will contact you soon';
    }

    public static function sendArchive()
    {
        $images = $line = null;
        if (empty($_FILES['file']['name']) === false) {
            $fileType = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

            if ($fileType !== 'zip') {
                throw new Exception('This file is not allowed: please upload a ZIP');
            } else {
                $tmp_name = $_FILES['file']['tmp_name'];
                $zip = new ZipArchive;
                $res = $zip->open($tmp_name);

                if ($res === false) {
                    throw new Exception('Error while uploading file');
                } else {
                    $path = 'public/uploads/' . uniqid() . uniqid();
                    $zip->extractTo($path);
                    $zip->close();

                    if ($handle = opendir($path)) {
                        while (($file = readdir($handle)) !== false) {
                            if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'csv') {
                                $csvFile = file($path . '/' . $file);
                                $line = str_getcsv($csvFile[0]);

                                $errors = self::checkData($line[0], $line[1], $line[2], $line[3]);
                                if ($errors !== null) {
                                    throw new Exception($errors);
                                }
                                break;
                            }
                        }
                        closedir($handle);
                        $handle = opendir($path);

                        while (($file = readdir($handle)) !== false) {
                            $fileExtensionsAllowed = ['jpeg', 'jpg', 'png'];
                            $imageFileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            if (in_array($imageFileType, $fileExtensionsAllowed)) {
                                $uploadDir = 'public/adverts/';
                                $uploadFile = $uploadDir . uniqid() . uniqid() . '.' . $imageFileType;

                                if (copy($path . '/' . $file, $uploadFile) === false) {
                                    throw new Exception('Error while uploading an image');
                                }

                                $images[] = $uploadFile;
                            }
                        }

                        $query = MyPDO::getInstance()->prepare('
                                INSERT INTO adverts(title, description, date, end_date, price, user)
                                VALUES (:title, :description, :date, :end_date, :price, :user)
                                ');
                        $query->execute([
                            'title' => $line[0],
                            'description' => $line[1],
                            'date' => date('Y-m-d'),
                            'end_date' => $line[3],
                            'price' => $line[2],
                            'user' => $_SESSION['user']->getId()
                        ]);

                        $advertId = MyPDO::getInstance()->lastInsertId();

                        foreach ($images as $image) {
                            $query = MyPDO::getInstance()->prepare('
                                    INSERT INTO images(advert_id, image)
                                    VALUES (:advert_id, :image)
                                    ');
                            $query->execute([
                                'advert_id' => $advertId,
                                'image' => $image,
                            ]);
                        }

                        return 'Advert successfully posted';
                    }
                }
            }
        }

        throw new Exception('You must upload an archive in ZIP format');
    }
}
