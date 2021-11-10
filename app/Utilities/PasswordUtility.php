<?php


namespace App\Utilities;


class PasswordUtility
{

    public static function generateRandomPassword(): string
    {
        $str = rand();
        return bcrypt($str);
    }

}
