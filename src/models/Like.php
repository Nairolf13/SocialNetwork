<?php

class Like extends LikeRepository
{
    private $id;
    private $project_id;
    private $user_id;

    public function __construct($project_id = null, $user_id = null, $id = null)
    {
        if (isset($id)) {
            $this->id = htmlspecialchars($id);
        }
        if (isset($project_id)) {
            $this->setProjectId($project_id);
        }
        if (isset($user_id)) {
            $this->setUserId($user_id);
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getProjectId()
    {
        return $this->project_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setProjectId($project_id)
    {
        $this->project_id = htmlspecialchars($project_id);
    }

    public function setUserId($user_id)
    {
        $this->user_id = htmlspecialchars($user_id);
    }
}
