<?php

namespace App\Repositories;
use App\Repositories\UserRepository;
use App\Repositories\Database;
use App\Entities\User;
use App\Exceptions\UserDoesNotExistException;
use PDO;

class UserRepository
{
    private $db;
 
    public function __construct()
    {
        //Obtenemos la instancia de la BD
        $this->db = Database::getInstance();
    }

    public function getByIdOrFail($userid){
        $user = null;
        $sql = 'SELECT * FROM users WHERE id = :userid';

        $statement = $this->db->getConnection()->prepare($sql);
        $statement->bindParam(':userid', $userid, PDO::PARAM_INT);
        $statement->execute();
        $getteduser = $statement->fetch(PDO::FETCH_ASSOC);

        if ($getteduser) {
            return new User($getteduser['firstname'], 
                            $getteduser['lastname'], 
                            $getteduser['password'], 
                            $getteduser['email'], 
                            $getteduser['id']);

        }else{
            throw new UserDoesNotExistException('No se encontró el usuario');
        }

    }

    public function getUser($userid){
        $user = null;
        $sql = 'SELECT * FROM users WHERE id = :userid';

        $statement = $this->db->getConnection()->prepare($sql);
        $statement->bindParam(':userid', $userid, PDO::PARAM_INT);

        $statement->execute();
        $getteduser = $statement->fetch(PDO::FETCH_ASSOC);

        if ($getteduser) {
            $user = new User($getteduser['firstname'], 
                            $getteduser['lastname'], 
                            $getteduser['password'], 
                            $getteduser['email'], 
                            $getteduser['id']);

        }
        return $user;
    }

    public function getAllUsers(){
        $userslist = array();
        $sql = 'SELECT * FROM users';

        $statement = $statement = $this->db->getConnection()->query($sql);
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
        $result = $statement->execute([
            ':firstname' => $user->firstname, 
            ':lastname' => $user->lastname,
            ':password' => $user->password,
            ':email' => $user->email,
        ]);

        $userid = $this->db->getConnection()->lastInsertId();

        $response = [
            'result' => $result,
            'lastid' =>  $userid
        ];
       
        return $response;
    }

    public function update(User $user)
    {

        $sql = 'UPDATE users 
                SET firstname = :firstname, 
                    lastname = :lastname, 
                    password = :password, 
                    email = :email WHERE id = :id';

        // prepare statement
        $statement = $this->db->getConnection()->prepare($sql);

        // bind params
        $statement->bindParam(':id', $user->id, PDO::PARAM_INT);
        $statement->bindParam(':firstname', $user->firstname);
        $statement->bindParam(':lastname', $user->lastname);
        $statement->bindParam(':password', $user->password);
        $statement->bindParam(':email', $user->email);

        // execute the UPDATE statment
        return $statement->execute();
    }

    public function delete(User $user)
    {
        $sql = 'DELETE FROM users WHERE id = :id';

        // prepare statement
        $statement = $this->db->getConnection()->prepare($sql);

        // bind params
        $statement->bindParam(':id', $user->id, PDO::PARAM_INT);

        // execute the UPDATE statment
        return $statement->execute();
    }

    public function deleteAllUsers()
    {
        $sql = 'TRUNCATE TABLE users';

        // prepare statement
        $statement = $this->db->getConnection()->prepare($sql);

        // execute the UPDATE statment
        return $statement->execute();
    }

    
}