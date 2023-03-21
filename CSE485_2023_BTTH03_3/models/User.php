<?php
class Member
{

    // Thuộc tính

    private $id;
    private $name;
    private $email;
    private $user;
    private $pass;

    private $is_admin;


    public function __construct($id, $name, $email, $user, $pass, $is_admin)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->user = $user;
        $this->pass = $pass;
        $this->is_admin = $is_admin;
    }

    // Setter và Getter
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getUser()
    {
        return $this->user;
    }
    public function getPass()
    {
        return $this->pass;
    }
    public function getIs_admin()
    {
        return $this->is_admin;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setUser($user)
    {
        $this->user = $user;
    }
    public function setPass($pass)
    {
        $this->pass = $pass;
    }
    public function setIs_admin($is_admin)
    {
        $this->is_admin = $is_admin;
    }
}
