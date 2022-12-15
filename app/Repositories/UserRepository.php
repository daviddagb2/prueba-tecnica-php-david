<?php

namespace App\Repositories;
use App\Repositories\UserRepository;
use App\Repositories\Database;
use App\Entities\User;


class UserRepository
{
    private $db;
 
    public function __construct()
    {
        //Obtenemos la instancia de la BD
        $this->db = Database::getInstance();
    }

    public function getUser($userid){
        $user = null;
        $sql = 'SELECT * FROM users WHERE id = :userid';

        $statement = $pdo->prepare($sql);
        $statement->bindParam(':userid', $userid, PDO::PARAM_INT);

        $statement->execute();
        $publisher = $statement->fetch(PDO::FETCH_ASSOC);

        if ($publisher) {
            echo $publisher['publisher_id'] . '.' . $publisher['name'];
            $user = new User($publisher['firstname'], 
                            $publisher['lastname'], 
                            $publisher['password'], 
                            $publisher['email'], 
                            $publisher['id']);

        } 
        return $user;
    }

    public function getAllUsers(){
        $userslist = array();
        $sql = 'SELECT * FROM users';

        $statement = $pdo->query($sql);
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);

        // show the publishers
        if ($users) {
            foreach ($users as $usr) {
                $userq = new User($usr['firstname'], 
                $usr['lastname'], 
                $usr['password'], 
                $usr['email'], 
                $usr['id']);

                array_push($userslist, $userq);
            }
        }
        
        return $userslist;
    }


    public function create(User $user)
    {   
        $sql = 'INSERT INTO users(firstname, lastname, password, email) VALUES(:firstname, :lastname, :password, :email)';

        $statement = $this->db->getConnection()->prepare($sql);
        return $statement->execute([
            ':firstname' => $user->firstname, 
            ':lastname' => $user->lastname,
            ':password' => $user->password,
            ':email' => $user->email,
        ]);
    }

    public function update(User $user)
    {

        $sql = 'UPDATE publishers 
                SET firstname = :firstname, 
                    lastname = :lastname, 
                    password = :password, 
                    email = :email WHERE id = :id';

        // prepare statement
        $statement = $pdo->prepare($sql);

        // bind params
        $statement->bindParam(':publisher_id', $publisher['publisher_id'], PDO::PARAM_INT);
        $statement->bindParam(':name', $publisher['name']);

        // execute the UPDATE statment
        return $statement->execute();
    }

    
}