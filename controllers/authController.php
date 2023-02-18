<?php
require_once('config/jwt.php');
require_once('classes/user.php');

class authController {
    private $db;
    private $jwt;

    function __construct($db) {
        $this->db = $db;
        $this->jwt = new Jwt();
    }

    function login($username, $password) {
        $user = new User($this->db);
        $user->username = $username;
        $user->password = $password;

        if ($user->login()) {
            $token = $this->jwt->generateToken($user->id, $user->username);
            return array('token' => $token);
        } else {
            return array('error' => 'Usuário ou senha inválidos');
        }
    }

    function verifyToken($token) {
        return $this->jwt->verifyToken($token);
    }
}