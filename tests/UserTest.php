<?php

use PHPUnit\Framework\TestCase;
use App\Entities\User;
use App\Repositories\UserRepository;

class UserTest extends TestCase
{
    public $userRepository = null;

    public function setUp(): void
    {
        $this->userRepository = new UserRepository();
    }

    public function test_create_user()
    {
        $user = new User("John", "Doe", "Passwordd", 'johndoe@gmail.com', null);
        $result = $this->userRepository->create($user);
        $this->assertEquals(true, $result);
    }

    public function test_update_user()
    {   
        $user = new User("John", "Doe", "Passwordd", 'johndoe@gmail.com', null);
        $result = $this->userRepository->create($user);
        $this->assertEquals(true, $result);
    }
  

}