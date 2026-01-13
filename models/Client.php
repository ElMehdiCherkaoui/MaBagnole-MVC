<?php


class Client extends User
{
    public function __construct(
        $user_id = null,
        $userName = null,
        $userEmail = null,
        $userRole = 'client',
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
        return "Client (ID: {$this->user_id}, Name: {$this->userName}, Email: {$this->userEmail})";
    }
}