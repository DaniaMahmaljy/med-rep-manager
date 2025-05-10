<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RepresentativeLoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {

    }


    public function login(RepresentativeLoginRequest $request)
    {
        $data = $request->validated();
        $response = $this->authService->representativeLogin($data);
        if (!$response['success']) {
            return $this->answer(message: $response['message'], code: $response['code']);
        }
        return $this->answer(UserResource::make($response['user']));
    }

    public function logout(Request $request)
    {
        $response = $this->authService->RepresentativeLogout($request);

        return $this->answer($response);
    }
}
