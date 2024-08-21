<?php

class mUser
{
    private $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function all()
    {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }

    public function find()
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE username=:username');
        $this->db->bind('username', $_POST['username']);
        return $this->db->single();
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table . " (username, password) VALUES (:username, :password)";
        $this->db->query($query);
        $this->db->bind('username', $_POST['username']);
        $this->db->bind('password', password_hash($_POST['password'], PASSWORD_DEFAULT));
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function update()
    {
        $query = "UPDATE " . $this->table . " SET password=:password WHERE username=:username";
        $this->db->query($query);
        $this->db->bind('username', $_POST['username']);
        $this->db->bind('password', password_hash($_POST['password'], PASSWORD_DEFAULT));
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function destroy($username)
    {
        $query = "DELETE FROM " . $this->table . " WHERE username=:username";
        $this->db->query($query);
        $this->db->bind('username', $username);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function saveSessions($username, $token) {
        $query = "INSERT INTO sessions (username, token, tanggal) VALUES (:username, :token, :tanggal)";
        $this->db->query($query);
        $this->db->bind('tanggal', date('Y-m-d'));
        $this->db->bind('username', $username);
        $this->db->bind('token', $token);
        return $this->db->single();
    }

    public function getSessions($token)
    {
        $this->db->query('SELECT * FROM sessions WHERE token=:token');
        $this->db->bind('token', $token);
        return $this->db->single();
    }
}