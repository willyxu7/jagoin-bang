<?php


namespace App\Services;


use App\Dto\SSOFormRegisUserDto;
use Illuminate\Support\Facades\Http;

class SSOService
{

    public function getClientCredentialToken(): string
    {
        $response = Http::withoutVerifying()->asForm()->post(config('sso.domain_sso') .
            'auth/realms/' . config('sso.realms_name') . '/protocol/openid-connect/token',
            [
                'grant_type' => 'client_credentials',
                'client_id' => config('sso.client_id'),
                'client_secret' => config('sso.client_secret'),
            ]);

        $responseBody = json_decode((string)$response->getBody(), true);

        return $responseBody['access_token'];
    }

    public function exchangeCodeToAccessToken(string $authorizationCode): string
    {
        $response = Http::withoutVerifying()->asForm()->post(config('sso.domain_sso') .
            'auth/realms/' . config('sso.realms_name') . '/protocol/openid-connect/token',
            [
                'grant_type' => 'authorization_code',
                'code' => $authorizationCode,
                'client_id' => config('sso.client_id'),
                'client_secret' => config('sso.client_secret'),
                'redirect_uri' => config('sso.redirect_uri')
            ]);

        $responseBody = json_decode((string)$response->getBody(), true);

        return $responseBody['access_token'];
    }

    public function getUser(string $accessToken): array
    {
        $user = Http::withoutVerifying()->accept('application/json')
            ->withToken($accessToken)
            ->get(config('sso.domain_sso') .
                'auth/realms/' . config('sso.realms_name') . '/protocol/openid-connect/userinfo'
            );

        return json_decode((string)$user->getBody(), true);
    }

    public function findUserByEmail(string $email): object|bool
    {
        $response = Http::withoutVerifying()->accept('application/json')
            ->withToken($this->getClientCredentialToken())
            ->get(config('sso.domain_sso') .
                'auth/admin/realms/' . config('sso.realms_name') . '/users?email=' . $email);

        if ($this->checkIfResponseContainUser($response))
            return json_decode($response->getBody())[0];

        return false;
    }

    private function checkIfResponseContainUser($response): bool
    {
        return count($response->object()) > 0;
    }

    public function createUser(array $user)
    {
        Http::withoutVerifying()->accept('application/json')
            ->withToken($this->getClientCredentialToken())
            ->post(config('sso.domain_sso') . 'auth/admin/realms/' .
                config('sso.realms_name') . '/users', $user);
    }

    public function updateUser(string $uidSSO, array $user): void
    {
        Http::withoutVerifying()->accept('application/json')
            ->withToken($this->getClientCredentialToken())
            ->put(config('sso.domain_sso') . 'auth/admin/realms/' .
                config('sso.realms_name') . '/users/' . $uidSSO, $user);
    }

    public function login(string $username, string $password): string
    {
        $response = Http::withoutVerifying()->asForm()->post(config('sso.domain_sso') .
            'auth/realms/' . config('sso.realms_name') . '/protocol/openid-connect/token',
            [
                'grant_type' => 'password',
                'client_id' => config('sso.client_id'),
                'client_secret' => config('sso.client_secret'),
                'username' => $username,
                'password' => $password
            ]
        );

        $responseBody = json_decode((string)$response->getBody(), true);

        return $responseBody['access_token'];
    }

    public function logout(string $uidSSO): void
    {
        Http::withoutVerifying()->accept('application/json')
            ->withToken($this->getClientCredentialToken())
            ->post(config('sso.domain_sso') . 'auth/admin/realms/' .
                config('sso.realms_name') . '/users/' . $uidSSO . '/logout');
    }

    public function mapToFormRegisUser(SSOFormRegisUserDto $dto): array
    {
        return [
            'username' => $dto->getUsername(),
            'enabled' => $dto->isEnabled(),
            'email' => $dto->getEmail(),
            'attributes' => [
                'place_of_birth' => $dto->getPlaceOfBirth(),
                'date_of_birth' => $dto->getDateOfBirth(),
                'gender' => $dto->getGender(),
                'address' => $dto->getAddress(),
                'province' => $dto->getProvince(),
                'city' => $dto->getCity(),
                'district' => $dto->getDistrict(),
                'zip_code' => $dto->getZipCode(),
                'phone_number' => $dto->getPhoneNumber(),
                'fax_number' => $dto->getFaxNumber(),
            ],
            'credentials' => [
                [
                    'type' => 'password',
                    'value' => $dto->getRandomPassword(),
                    'temporary' => $dto->isTemporary()
                ]
            ]
        ];
    }

    public function mapToFormRegisUserDto(array $user, string $randomPassword): SSOFormRegisUserDto
    {
        return (new SSOFormRegisUserDto())
            ->setUsername($user['username'])
            ->setEmail($user['email'])
            ->setPlaceOfBirth($user['place_of_birth'])
            ->setDateOfBirth($user['date_of_birth'])
            ->setGender($user['gender'])
            ->setAddress($user['address'])
            ->setProvince($user['province'])
            ->setCity($user['city'])
            ->setDistrict($user['district'])
            ->setZipCode($user['zip_code'])
            ->setPhoneNumber($user['phone_number'])
            ->setFaxNumber($user['fax_number'])
            ->setRandomPassword($randomPassword);
    }
}
