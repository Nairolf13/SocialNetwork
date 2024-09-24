<?php
class Comment extends CommentRepository
{
    private $id;
    private $project_id;
    private $user_id;
    private $content;
    

    public function __construct($project_id = null, $user_id = null, $content = null, $id = null)
    {
        if (isset($id)) {
            $this->id = htmlspecialchars($id);
        }
        if (isset($project_id)) {
            $this->setProject_id($project_id);
        }
        if (isset($user_id)) {
            $this->setUserId($user_id);
        }
        if (isset($content)) {
            $this->setContent($content);
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getProject_id()
    {
        return $this->project_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setProject_id($project_id)
    {
        $this->project_id = htmlspecialchars($project_id);
    }

    public function setUserId($user_id)
    {
        $this->user_id = htmlspecialchars($user_id);
    }

    public function setContent($content)
    {
        $this->content = htmlspecialchars($content);
    }

   
}
