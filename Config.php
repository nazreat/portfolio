<?php
    class Config {

        public $server_name;

        public $port;

        public $username;
        
        public $password;

        public $db_name;

        public function __construct()
        {
            $this->server_name = 'localhost';
            $this->port = 3306;
            $this->username = 'root';
            $this->password = '';
            $this->db_name = 'session_library';
        }

    }
?>