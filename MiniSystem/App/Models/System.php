<?php 

    namespace App\Models;

    use MF\Model\Model;

    class System extends Model
    { 
        private $id;
        private $name;
        private $mail;
        private $tel;
        private $subject;
        private $message;
        private $city;
        private $data_system;
    

        # Função mágica get chamada para system
        public function __get($attr)
        {
            return $this->$attr;
        }

        # Função mágica set chamada para system
        public function __set($attr, $value)
        {
            $this->$attr = $value;
        }

        # Recuperando todos os dados em texto puro da tabela tb_contacts.
        public function getAll()
        {
            $query = "select * from tb_contacts order by data_system asc";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $dados = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $dados;
        }

        # Removendo contatos desejados.
        public function remover()
        {
            $query = "delete from tb_contacts where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return true;
        }

        # Selecionando e contando o total de contatos armazenados no banco de dados.
        public function totalContatos()
        {
            $query = "select count(*) as total_contact from tb_contacts";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);

        }

        # Recuperação dos dados do usuário.
        public function getAllLogin()
        {
            $query = "select 
                            lg.id, lg.nome, lg.email, lg.username, lg.fk_id_type, tu.type from login as lg, type_user as tu 
                      where 
                            lg.fk_id_type = tu.id_type";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $dados = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $dados;
        }

        # Recuperação dos dados do usuário.
        /* Pendente a remoção em futuras manutenções pois 
        a função getAllLogin já recupera todos os dados necessários 
        para a exibição na página Profile.
        */
        public function getAllLoginProfile()
        {
            $query = "select 
                            lg.id, lg.nome, lg.email, lg.username, lg.fk_id_type, tu.type from login as lg, type_user as tu 
                      where 
                            lg.fk_id_type = tu.id_type";

            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $dados = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $dados;
        }

        # Função de remoção de usuários.
        public function removerlogin()
        {
            $query = "delete from login where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return true;
        }

        # Recuperando o tootal de contatos com o status pendente.
        public function totNotfy()
        {
            $query = "select count(c.id) as tb_contacts from tb_contacts as c where c.id_status = 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            /* No banco de dados está configurado como pendente no numero 1
            e como concluido o numero 0 */
        }

        # Recuperando os dados para exibit nas notificações de e-mail.
        public function dadosNotfy()
        {
            $query = "select tb.id, tb.id_status, tb.name, tb.subject, tb.data_system from tb_contacts as tb where id_status = 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        # Alterando o status do contato.
        public function alterNotfy()
        {
            $query = "update tb_contacts set id_status = 0 where id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            return true;
        }

    }

?>