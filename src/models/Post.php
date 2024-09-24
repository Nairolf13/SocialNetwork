<?php
class Post extends PostRepository
{
    private $id;
    private $title;
    private $description;
    private $image;
    private $userId; 

    public function __construct($title, $description, $image, $id = null, $userid = null)
    {
            if (isset($id)|| ($id !== null)) {
                $this->id = htmlspecialchars($id);
            }
            if (isset($userid)) {
                $this->setUserId($userid); 
            }
            $this->setTitle($title);
            $this->setDescription($description);
            $this->setImage($image);
        
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setTitle($title)
    {
        $this->title = htmlspecialchars($title);
    }

    public function setDescription($description)
    {
        $this->description = htmlspecialchars($description);
    }

    public function setImage($image)
    {
        $this->image = htmlspecialchars($image);
    }

    public function setUserId($userId)
    {
        $this->userId = htmlspecialchars($userId);
    }
}
