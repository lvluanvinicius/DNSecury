<?php

    namespace App\Models;

    use MF\Model\Model;

    class Manipulation extends Model {

        public function all_area_slider() {
            
            $query = "select * from tb_area_slider";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    
    }

?>