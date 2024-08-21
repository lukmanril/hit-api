<?php

class UsersController extends Controller {

    public function __construct()
    {
        if(!$this->model('mUser')->getSessions($_GET['token'])){
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            exit;
        }
    }

    public function index($id = '') {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if ($id != '') {
                    $this->detail($id);
                } else {
                    $this->show();
                }
                break;
            case 'POST':
                if ($id != '') {
                    $this->update();
                } else {
                    $this->create();
                }
                break;
            case 'DELETE':
                $this->delete($id);
                break;
            default:
                http_response_code(405);
                echo json_encode(['message' => 'Method Not Allowed']);
                exit;
        }
    }
    
    public function create() {
        if($this->model('mUser')->find()){
            http_response_code(400);
            echo json_encode(['message' => 'duplicate username', 'error' => 'error']);
        }else{
            if($this->model('mUser')->create()){
                http_response_code(201);
                echo json_encode(['message' => 'Create User']);
            }else{
                http_response_code(400);
                echo json_encode(['message' => 'Bad Request', 'error' => 'error']);
            }
        }
    }
    
    public function update() {
        if($this->model('mUser')->find()){
            if($this->model('mUser')->update()){
                http_response_code(201);
                echo json_encode(['message' => 'Update User']);
            }else{
                http_response_code(400);
                echo json_encode(['message' => 'Bad Request', 'error' => 'error']);
            }
        }else{
            http_response_code(400);
            echo json_encode(['message' => 'not found username', 'error' => 'error']);
        }
    }
    
    public function delete($id) {
        if($this->model('mUser')->destroy($id)){
            http_response_code(200);
            echo json_encode(['message' => 'Delete User', 'id' => $id]);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Bad Request', 'error' => 'ID is required for deletion']);
        }
    }
    
    public function show() {
        http_response_code(200);
        echo json_encode(['message' => 'Show User']);
    }
    
    public function detail($id) {
        if ($id) {
            http_response_code(200);
            echo json_encode(['message' => 'Show User Detail', 'id' => $id]);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Bad Request', 'error' => 'ID is required for detail']);
        }
    }
}