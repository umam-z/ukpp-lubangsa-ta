<?php

namespace UmamZ\UkppLubangsa\Service;

use UmamZ\UkppLubangsa\Model\UserLoginRequest;
use UmamZ\UkppLubangsa\Model\UserLoginResponse;
use UmamZ\UkppLubangsa\Model\UserRegisterRequest;
use UmamZ\UkppLubangsa\Model\UserRegisterResponse;

interface UserService
{
    public function register(UserRegisterRequest $request): UserRegisterResponse;

    public function login(UserLoginRequest $request): UserLoginResponse;
}
