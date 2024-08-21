<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class LoginController extends Controller {

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
            "datetime" => date('Y-m-d H:i:s'),
        ];
        try {
            $token = JWT::encode($payload, SECRETKEY, 'HS256');

            //menyimpan token ke dalam database
            $this->model('mUser')->saveSessions($row['username'], $token);

            http_response_code(200);
            echo json_encode(['message' => 'Login User ' . date('Y-m-d H:i:s') . ' - ' . date('d-m-Y H:i:s', (time() + 3600 * 24)), 'token' => $token]);
        }catch (Exception $exception){
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            exit;
        }
    }
}