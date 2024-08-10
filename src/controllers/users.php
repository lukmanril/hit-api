<?php

class Users {

    public function __construct()
    {
        
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
                $this->create();
                break;
            case 'PUT':
                $this->update($id);
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
        http_response_code(201);
        echo json_encode(['message' => 'Create User']);
    }
    
    public function update($id) {
        if ($id) {
            http_response_code(200);
            echo json_encode(['message' => 'Update User', 'id' => $id]);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Bad Request', 'error' => 'ID is required for update']);
        }
    }
    
    public function delete($id) {
        if ($id) {
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