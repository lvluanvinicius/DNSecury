<?php

    namespace App\Controllers;

    //Recursos do miniframework
    use MF\Controller\Action;
    use MF\Model\Container;
    

    class IndexController extends Action {        

        public function index() 
        {
            $this->render('index', 'login');
        } 

        public function termos()
        {
            $this->render('termos', 'login');
        }

        
        
    }

?>