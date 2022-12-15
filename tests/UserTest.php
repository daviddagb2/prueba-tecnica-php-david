<?php

use PHPUnit\Framework\TestCase;
use App\Entities\User;
use App\Repositories\UserRepository;
use App\Domain\CreateUserUseCase;
use App\Exceptions\UserDoesNotExistException;

class UserTest extends TestCase
{
    public $userRepository = null;
    
    public function setUp(): void
    {
        $this->userRepository = new UserRepository();
    }

    public function test_create_user()
    {
        $user = new User("John", "Cena", "Passwordd", 'johndoe@gmail.com', null);
        $response = $this->userRepository->create($user);
        $this->assertEquals(true, $response['result']);
    }

    public function test_get_user()
    {
        $userid = 1;
        $result = $this->userRepository->getUser($userid);
        $this->assertNotNull( 
            $result, 
            "user is null or not found"
        ); 
    }

    public function test_when_user_not_found_by_id()
    {
        $userid = 99999;
        $this->expectException(UserDoesNotExistException::class);
        $this->userRepository->getByIdOrFail($userid);
    }

    public function test_update_user()
    {   
        $userid = 1;
        $user = $this->userRepository->getUser($userid);
        $result = $this->userRepository->update($user);
        $this->assertEquals(true, $result);
    }

    public function test_get_all_users()
    {
        $result = $this->userRepository->getAllUsers();
        $this->assertNotNull( 
            $result, 
            "user is null or not found"
        ); 
    }

    public function test_delete_user()
    {   
        //Insert new user
        $user = new User("Robert", "Martinez", "Contrasenia", 'robertduran@hotmail.com', null);
        $response = $this->userRepository->create($user);

        //Get User
        $user = $this->userRepository->getUser($response['lastid']);

        //Delete User
        $result = $this->userRepository->delete($user);
        $this->assertEquals(true, $result);
    }

    public function test_create_user_use_case(){
        $usecase = new CreateUserUseCase();
        $result = $usecase->createUser("Jose", "Maderos", "newpassword", "josemaderos@gmail.com");
        $this->assertNotNull( 
            $result['user'], 
            "User was not created"
        );
    }

    public function test_delete_all_users()
    {   
        $result = $this->userRepository->deleteAllUsers();
        $this->assertEquals(true, $result);
    }

}