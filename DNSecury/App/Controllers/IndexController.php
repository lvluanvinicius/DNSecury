<?php

    namespace App\Controllers;

    //Recursos do miniframework
    use MF\Controller\Action;
    use MF\Model\Container;



    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    

    class IndexController extends Action {        

        public function index() 
        {
            # Iniciando a model Manipulation.
            $elements_slider = Container::getModel("Manipulation");

            # Recebendo os dados recuperados pela camada Model Manipulation.
            $this->view->elements_slider = $elements_slider->all_area_slider();
            
            $this->render('index');
        }

        public function contato()
        {
            $this->render('contato');
        }

        public function registercontact()
        {    
            $results = @unserialize(file_get_contents("http://ip-api.com/php"));

            $data = date('d/m/Y H:i');           
            $send = Container::getModel('Contato');


            $send->__set('name', $_POST['name']);
            $send->__set('mail', $_POST['mail']);
            $send->__set('message', $_POST['message']);
            $send->__set('subject', $_POST['subject']);
            $send->__set('tel', $_POST['tel']);
            $send->__set('city', $_POST['city']);
            $send->__set('data_system', $data);
            $send->__set('estado', $results['regionName']);
            $send->__set('ip', $results['query']);
            $send->__set('zip', $results['zip']);
            $send->__set('country', $results['country']);
            $send->__set('provedor', $results['org']);
            $send->__set('resposta', "<div align='center'>
                                        <h3>DNSecury</h3>
                                        <p>
                                            Seu contato esta sendo analisado
                                            por um de nossos atendentes, em 
                                            ate 48 horas estaremos retornando.
                                        </p>
                                        <p>Horário do contato: $data</p>                         
                                      </div>");


            if (isset($_GET['form']) && $_GET['form'] == 'contato') 
            {                
                $send->confirmaEnvio();
                $send->registercontact();
                header('location: /contato?acao=success');
            } 
        }

        public function quemSomos()
        {
            $this->render('quemSomos');
        }

        public function servicos()
        {
            $this->render('servicos');
        }

    }

?>