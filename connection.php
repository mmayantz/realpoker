<?php


class Connection
    {
        protected $db;
        public function Connection()
        {
        $conn = NULL;
            try{
                $conn = new PDO("mysql:host=127.0.0.1;dbname=realpoker;charset=utf8;collation=utf8_unicode_ci", "root", "");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo 'ERROR: ' . $e->getMessage();
            }   
            $this->db = $conn;
        }

        public function getConnection()
        {
            return $this->db;
        }
    }