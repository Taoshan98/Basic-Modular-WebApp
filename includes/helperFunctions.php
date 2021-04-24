<?php

/**
 * Password Hash.
 * @param $password
 * @return string
 */
function hashPassword($password): string
{
    $salt = "$2a$13$0JA545O7Xc0W1dHvNErPpE";
    return crypt($password, $salt);
}
