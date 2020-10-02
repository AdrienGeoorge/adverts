<?php

class Advert
{
    private $id;
    private $title;
    private $picture;
    private $description;
    private $price;
    private $date;
    private $user;
    private $images;
    private $imagesId;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getUser()
    {
        return explode(';', $this->user);
    }

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function getImages()
    {
        $array = [];
        if (empty($this->images) === false) {
            $tmp = explode(';', $this->images);
            foreach ($tmp as $item) {
                $array[] = explode('__', $item);
            }
            return $array;
        } else {
            return null;
        }
    }

    public function setImages($images)
    {
        $this->$images = $images;

        return $this;
    }
}
