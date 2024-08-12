<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class LoginController {

    // Constructor
    public function __construct()
    {
        // Intentionally left blank
    }

    // Main method to handle different HTTP methods
    public function index($id = '') {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $this->login();
                break;
            default:
                http_response_code(405);
                echo json_encode(['message' => 'Method Not Allowed']);
                exit;
        }
    }
    
    /**
     * Create a new user.
     */
    public function login() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $db = new Database;
        $db->query('SELECT * FROM users WHERE username=:username');
        $db->bind('username', $username);
        $row=$db->single();
        if(!$row){
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            exit;
        }

        if(!password_verify($password, $row['password'])){
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            exit;
        }
        
        $payload = [
            "username" => $row['username'],
        ];
        try {
            $token = JWT::encode($payload, SECRETKEY, 'HS256');
            http_response_code(200);
            echo json_encode(['message' => 'Login User', 'token' => $token]);
            /*
                echo json_encode(['message' => 'Login User', 'token' => $token]);
                $token ditaruh di token.text aplikasi mobile
                agar token bisa dipakai berulang ulang saat hit API
            */
        }catch (Exception $exception){
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            exit;
        }
    }
}