<?php


namespace App\Services;


use App\Models\User;
use App\Utilities\PasswordUtility;
use Illuminate\Support\Facades\Auth;

class LoginSSOService
{

    private SSOService $ssoService;

    public function __construct(SSOService $ssoService)
    {
        $this->ssoService = $ssoService;
    }

    public function loginSSO(array $loginSSORequest): void
    {
        $authorizationCode = $loginSSORequest['code'];

        $accessToken = $this->ssoService->exchangeCodeToAccessToken($authorizationCode);

        $userFromSSO = $this->ssoService->getUser($accessToken);

        $user = (new User())->where('email', $userFromSSO['email'])->first();

        if(!$user) {
            $newUser = (new User())->create([
                'name' => $userFromSSO['name'],
                'email' => $userFromSSO['email'],
                'password' => PasswordUtility::generateRandomPassword(),
                'sso_uid' => $userFromSSO['sub'],
                'sso_access_token' => $accessToken
            ]);

            Auth::guard('web')->login($newUser);
//            $token = JWTAuth::fromUser($user);
//            $token = Token::createFromUserModel($user, $token);
        } else if ($user->sso_uid == null){
            $user->update([
                'sso_uid' => $userFromSSO['sub'],
                'sso_access_token' => $accessToken
            ]);

            Auth::guard('web')->login($user);
//            $token = JWTAuth::fromUser($newUser);
//            $token = Token::createFromUserModel($newUser, $token);
        } else {
            Auth::guard('web')->login($user);
        }

//        return $token;
    }

}
