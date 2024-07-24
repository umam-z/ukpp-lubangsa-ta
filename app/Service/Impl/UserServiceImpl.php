<?php

namespace UmamZ\UkppLubangsa\Service\Impl;

use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Domain\User;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Helper\ValidationUtil;
use UmamZ\UkppLubangsa\Model\UserLoginRequest;
use UmamZ\UkppLubangsa\Model\UserLoginResponse;
use UmamZ\UkppLubangsa\Model\UserRegisterRequest;
use UmamZ\UkppLubangsa\Model\UserRegisterResponse;
use UmamZ\UkppLubangsa\Repository\UserRepository;
use UmamZ\UkppLubangsa\Service\UserService;

class UserServiceImpl implements UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRegisterRequest $request): UserRegisterResponse
    {
        ValidationUtil::validate($request);

        try {
            Database::beginTransaction();
            $user = $this->userRepository->findByUsername($request->username);
            if ($user != null) {
                throw new ValidationException("Username already exists");
            }

            $user = new User(
                mt_rand(),
                $request->username,
                password_hash($request->password, PASSWORD_BCRYPT)
            );

            $this->userRepository->save($user);

            $response = new UserRegisterResponse();
            $response->user = $user;

            Database::commitTransaction();
            return $response;
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    public function login(UserLoginRequest $request): UserLoginResponse
    {
        ValidationUtil::validate($request);

        $user = $this->userRepository->findByUsername($request->username);
        if ($user == null) {
            throw new ValidationException("Username or password is wrong");
        }

        if (password_verify($request->password, $user->getPassword())) {
            $response = new UserLoginResponse();
            $response->user = $user;
            return $response;
        } else {
            throw new ValidationException("Username or password is wrong");
        }
    }

    // public function updateProfile(UserProfileUpdateRequest $request): UserProfileUpdateResponse
    // {
    //     $this->validateUserProfileUpdateRequest($request);

    //     try {
    //         Database::beginTransaction();

    //         $user = $this->userRepository->findById($request->id);
    //         if ($user == null) {
    //             throw new ValidationException("User is not found");
    //         }

    //         $user->name = $request->name;
    //         $this->userRepository->update($user);

    //         Database::commitTransaction();

    //         $response = new UserProfileUpdateResponse();
    //         $response->user = $user;
    //         return $response;
    //     } catch (\Exception $exception) {
    //         Database::rollbackTransaction();
    //         throw $exception;
    //     }
    // }

    // private function validateUserProfileUpdateRequest(UserProfileUpdateRequest $request)
    // {
    //     if ($request->id == null || $request->name == null ||
    //         trim($request->id) == "" || trim($request->name) == "") {
    //         throw new ValidationException("Id, Name can not blank");
    //     }
    // }

    // public function updatePassword(UserPasswordUpdateRequest $request): UserPasswordUpdateResponse
    // {
    //     $this->validateUserPasswordUpdateRequest($request);

    //     try {
    //         Database::beginTransaction();

    //         $user = $this->userRepository->findById($request->id);
    //         if ($user == null) {
    //             throw new ValidationException("User is not found");
    //         }

    //         if (!password_verify($request->oldPassword, $user->password)) {
    //             throw new ValidationException("Old password is wrong");
    //         }

    //         $user->password = password_hash($request->newPassword, PASSWORD_BCRYPT);
    //         $this->userRepository->update($user);

    //         Database::commitTransaction();

    //         $response = new UserPasswordUpdateResponse();
    //         $response->user = $user;
    //         return $response;
    //     } catch (\Exception $exception) {
    //         Database::rollbackTransaction();
    //         throw $exception;
    //     }
    // }

    // private function validateUserPasswordUpdateRequest(UserPasswordUpdateRequest $request)
    // {
    //     if ($request->id == null || $request->oldPassword == null || $request->newPassword == null ||
    //         trim($request->id) == "" || trim($request->oldPassword) == "" || trim($request->newPassword) == "") {
    //         throw new ValidationException("Id, Old Password, New Password can not blank");
    //     }
    // }
}
