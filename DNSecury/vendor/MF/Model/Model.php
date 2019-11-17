<?php 

    namespace MF\Model;

    abstract class Model {

        protected $DB;

        public function __construct(\PDO $db)
        {
            $this->db = $db;
        }
    }

?>