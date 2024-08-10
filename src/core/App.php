<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class App
{
    protected $controller = '';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        header("Content-Type: application/json");

        $url = $this->parseURL();

        // Handle missing URL segment
        if (!isset($url[0])) {
            http_response_code(500);
            echo json_encode(["message" => "Internal Server Error"]);
            exit;
        }

        // authorization
        if ($url[0] != 'login') {
            $token = isset($_GET['token']) ? $_GET['token'] : '';
            try {
                $decoded = JWT::decode($token, new Key(SECRETKEY, 'HS256'));
            }catch (Exception $exception){
                http_response_code(401);
                echo json_encode(['message' => 'Unauthorized']);
                exit;
            }
        }

        // Check if the controller file exists
        if (file_exists('../src/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        } else {
            http_response_code(405);
            echo json_encode(["message" => "Controller Not Allowed"]);
            exit;
        }

        require_once '../src/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Set parameters
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        // Check if the method exists in the controller
        if (method_exists($this->controller, $this->method)) {
            call_user_func_array([$this->controller, $this->method], $this->params);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Not Found"]);
            exit;
        }
    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}