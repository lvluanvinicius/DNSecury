<?php 

    namespace App\Models;

    use MF\Model\Model;

    class Editor extends Model
    {
        private $id;
        private $name_file;
        private $name;
        private $url;
        private $description;
        

        # Função mágica get chamada para Editor
        public function __get($attr)
        {
            return $this->$attr;
        }
        # Função mágica set chamada para Editor
        public function __set($attr, $value)
        {
            $this->$attr = $value;
        }

        # Iniciando a inserção dos valores na tabela tb_area_slider.
        public function insert_doc_slider()
        {
            $query = "insert into tb_area_slider(
                title_element, name_file, desc_element, link_element
                ) values (
                    :title_element, :name_file, :desc_element, :link_element
                )";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':title_element', $this->__get("name"));
            $stmt->bindValue(':name_file', $this->__get("name_file"));            
            $stmt->bindValue(':desc_element', $this->__get("description"));
            $stmt->bindValue(':link_element', $this->__get("url"));
            $stmt->execute();
            
            return $this;
        }

        # Selecionando todos os elementos da tabela tb_area_slider.
        public function getAllelements()
        {
            $query = "select * from tb_area_slider";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        # Iniciando o update dos valores na tabela tb_area_slider.
        public function update_doc_slider()
        {
            $query = "
                update tb_area_slider set 
                    title_element = :title_element, link_element = :link_element, desc_element = :desc_element
                where id = :id
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':title_element', $this->__get('name'));
            $stmt->bindValue(':link_element', $this->__get('url'));
            $stmt->bindValue(':desc_element', $this->__get('description'));
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            
            return $this;
        }

        public function removeslider()
        {
            $query = "delete from tb_area_slider where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            return $this;
        }
    }