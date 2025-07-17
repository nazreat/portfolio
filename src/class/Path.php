<?php
    //set path and store it into SERVER variable that can be accessd anywhere
    class Path {

        public $pageURL;

        public function __construct()
        {
            $pageURL = 'http';

            if (isset($_SERVER["HTTPS"])) 
            {
                if ($_SERVER["HTTPS"] == "on") 
                {
                    $pageURL .= "s";
                }
            }

            $pageURL .= "://";

            $pageURL .= $_SERVER["SERVER_NAME"];

            $this->pageURL = $pageURL;
        }

    }


?>