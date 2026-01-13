<?php
class Administrator extends User
{
    public function __construct(
        $user_id = null,
        $userName = null,
        $userEmail = null,
        $userRole = 'admin',
        $userStatus = null,
        $passwordHash = null,
        $userCreateDate = null
    ) {
        parent::__construct(
            $user_id,
            $userName,
            $userEmail,
            $userRole,
            $userStatus,
            $passwordHash,
            $userCreateDate
        );
    }

    

    public function __toString()
    {
        return "Administrator (ID: {$this->user_id}, Name: {$this->userName})";
    }
}