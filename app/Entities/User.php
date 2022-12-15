<?php

namespace App\Entities;
use App\Repositories\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
*/
class User
{
    public $id;
    public $firstname;
    public $lastname;
    public $password;
    public $email;

    public function __construct($firstname, $lastname, $password, $email, $id = null)
    {
        $this->id  = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password =  password_hash($password, PASSWORD_BCRYPT);
        $this->email = $email;
    }

    // Methods
    function set_id($id) {
        $this->id = $id;
    }

    function get_id() {
        return $this->id;
    }
    
    function set_firstname($firstname) {
        $this->firstname = $firstname;
    }

    function get_firstname() {
        return $this->firstname;
    }
    
    function set_lastname($lastname) {
        $this->lastname = $lastname;
    }

    function get_lastname() {
        return $this->lastname;
    }
    
    function set_password($password) {
        $this->password = $password;
    }

    function get_password() {
        return $this->password;
    }
    
    function set_email($email) {
        $this->email = $email;
    }

    function get_email() {
        return $this->email;
    }

}