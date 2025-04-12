<?php

namespace App\Services;
use Illuminate\Support\Str;


class PasswordService extends Service
{
    public function generateTemporaryPassword()
    {
        return Str::password(
            length: 10,
            symbols: false,
            numbers: true
        );
    }

}
