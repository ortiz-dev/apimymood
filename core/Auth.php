<?php
namespace Core;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth
{
    private $secret_key;
    private $algorithm;

    public function __construct()
    {
        require_once '../config/config.php';
        $this->secret_key = SECRET_KEY;
        $this->algorithm = ALGORITHM;
    }

    //generar token JWT
    public function generateToken($userData)
    {
        $issuedAt = time();
        $expiredTime = $issuedAt + 3600; //1 hora
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expiredTime,
            'data' => $userData
        ];

        return JWT::encode($payload, $this->secret_key, $this->algorithm);
    }

    //validar token y devolver datos del usuario
    public function validateToken($token)
    {
        try{
            $decoded = JWT::decode($token, new Key($this->secret_key, $this->algorithm));
            return $decoded->data; //datos del usuario
        }catch(\Exception $e){
            return false;
        }
    }

    //Obtener token desde cabecera
    public function getBearerToken()
    {
        $headers = getallheaders();
        if(isset($headers['Authorization'])){
            if(preg_match('/Bearer\s(\S+)/',$headers['Authorization'], $matches)){
                return $matches[1];
            }
        }
        return null;
    }

    //verifica si el usuario esta autenticado
    public function isAuthenticated()
    {
        $token = $this->getBearerToken();
        if(!$token){
            return false;
        }
        return $this->validateToken($token);
    }

    //hashear password
    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    //verificar password
    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}