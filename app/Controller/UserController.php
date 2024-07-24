<?php 

namespace UmamZ\UkppLubangsa\Controller;

use UmamZ\UkppLubangsa\App\View;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Model\UserLoginRequest;
use UmamZ\UkppLubangsa\Model\UserRegisterRequest;
use UmamZ\UkppLubangsa\Repository\Impl\SessionRepositoryImpl;
use UmamZ\UkppLubangsa\Repository\Impl\UserRepositoryImpl;
use UmamZ\UkppLubangsa\Service\Impl\SessionServiceImpl;
use UmamZ\UkppLubangsa\Service\Impl\UserServiceImpl;
use UmamZ\UkppLubangsa\Service\SessionService;
use UmamZ\UkppLubangsa\Service\UserService;

class UserController 
{
    private UserService $userService;
    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $userRepository = new UserRepositoryImpl($connection);
        $sessionRepository = new SessionRepositoryImpl($connection);
        $this->userService = new UserServiceImpl($userRepository);
        $this->sessionService = new SessionServiceImpl($sessionRepository, $userRepository);
    }

    public function register() : void {
        View::render('/Home/register', [
            'title' =>  'Users | Register'
        ]);
    }

    public function postRegister() : void {
        $request = new UserRegisterRequest;
        $request->password = htmlspecialchars($_POST['password']);
        $request->username = htmlspecialchars($_POST['username']);
        try {
            $this->userService->register($request);
            View::redirect('/users/login');
        } catch (ValidationException $e) {
            View::render('/Home/register', [
                'title' =>  'Users | Register',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function login(): void {
        View::render('/Home/login', [
            'title' =>  'Users | Login'
        ]);
    }

    public function postLogin(): void {
        $request = new UserLoginRequest;
        $request->password = htmlspecialchars($_POST['password']);
        $request->username = htmlspecialchars($_POST['username']);
        
        try {
            $response = $this->userService->login($request);
            $this->sessionService->create($response->user->getId());
            View::redirect('/');
        } catch (ValidationException $e) {
            View::render('/Home/login', [
                'title' =>  'Users | Login',
                'error' => $e->getMessage()
            ]);
        }
    }
    
    public function logout(): void {
        $this->sessionService->destroy();
        View::redirect('/');
    }
}
