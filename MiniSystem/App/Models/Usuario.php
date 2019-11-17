<?php 

    namespace App\Models;

    use MF\Model\Model;

    class Usuario extends Model {

        private $id;
        private $id_type;
        private $nome;
        private $username;
        private $email;
        private $senha;
        private $type;


        # Função mágica get chamada para usuario.
        public function __get($attr)
        {
            return $this->$attr;
        }

        # Função mágica set chamada para usuario.
        public function __set($attr, $value)
        {
            $this->$attr = $value;
        }

        public function autenticar()
        {
            $query = "select lg.id, lg.nome, lg.email, lg.username, lg.senha, tp.id_type
                      from login as lg, type_user as tp 
                      where username = :username and senha = :senha and tp.id_type = lg.fk_id_type";

            // $query = "select id, nome, email, username, senha from login where username = :username and senha = :senha";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':username', $this->__get('username'));
            $stmt->bindValue(':senha', $this->__get('senha'));
            $stmt->execute();

            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($usuario['id'] != '' && $usuario['nome'] != '')
		{
			$this->__set('id', $usuario['id']);
			$this->__set('nome', $usuario['nome']);
			$this->__set('email', $usuario['email']);
			$this->__set('id_type', $usuario['id_type']);
		}

		return $this;
        }

        public function generator() 
        {
            $setAlpha = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@#$%&()_{}?";
            $word = array();
            $length = strlen($setAlpha);
            for ($p = 0; $p < 15; $p++)
            {
                $n = rand(0, $length);
                $word[] = $setAlpha[$n];
            }
            return implode($word);
        }

        public function registra() 
        {
            $query = "insert into login(nome, email, username, senha, fk_id_type)values(:nome, :email, :username, :senha, :fk_id_type)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':username', $this->__get('username'));
            $stmt->bindValue(':senha', $this->__get('senha'));
            $stmt->bindValue(':fk_id_type', $this->__get('type'));
            $stmt->execute();
        }

        public function profileEditaLogin()
        {
            $query = "update login set 
                        fk_id_type = :fk_id_type, nome = :nome, email = :email, username = :username
                    WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':fk_id_type', $this->__get('type'));
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':username', $this->__get('username'));
            $stmt->execute();

            return true;
            
        }

        public function logOff()
        {
            $query = "update login set senha = :senha where id = :id";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->bindValue(':senha', $this->__get('senha'));
            $stmt->execute();
            
            return true;
        }
    }

?>