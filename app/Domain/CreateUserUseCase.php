<?php

namespace App\Domain;

use App\Repositories\UserRepository;
use App\Entities\User;

/**
* @ORM\Entity
*/
class CreateUserUseCase
{
    public $userRepository = null;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    // Methods
    function createUser($firstname, $lastname, $password, $email) {
       $errors = array();
       $valid = true;
       $user = null;
       
        if(empty($firstname)){
            array_push($errors, "El nombre no puede quedar vacío");
        }

        if(strlen($firstname) < 3 || strlen($firstname) > 45 ){
            array_push($errors, "La longitud de caracteres del nombre es inválida");
        }

        if(empty($lastname)){
            array_push($errors, "El apellido no puede quedar vacío");
        }

        if(strlen($lastname) < 3 || strlen($lastname) > 45 ){
            array_push($errors, "La longitud de caracteres del apellido es inválida");
        }

        if(empty($password)){
            array_push($errors, "La contraseña no puede quedar vacía");
        }

        if(strlen($password) < 3 || strlen($password) > 200 ){
            array_push($errors, "La longitud de caracteres de la contraseña es inválida");
        }
        
        if(count($errors) > 0){
            $valid = false;
        }else{
            $user = new User($firstname, $lastname, $password, $email, null);
            $response = $this->userRepository->create($user);
            //Get User
            $user = $this->userRepository->getUser($response['lastid']);
        }

        return [
            'valid' => $valid,
            'errores' => $errors,
            'user' => $user
        ];

    }    

}