<?php

/**
 * @OA\Schema(
 *     description="Some simple request createa as example",
 *     type="object",
 *     title="Example storring request",
 * )
 */
class Login
{
    /**
     * @OA\Property(
     *     title="Email",
     *     description="Some email field",
     *     format="email",
     *     example="viktar202@ya.ru"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *     title="Password",
     *     description="Some password",
     *     format="string",
     *     example="password"
     * )
     *
     * @var int
     */
    public $password;
}
