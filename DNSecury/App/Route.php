<?php

    namespace App;

    use MF\Init\Bootstrap;

    class Route extends Bootstrap {

        // ==========================================
        //Inicialização do array de rotas.
        protected function initRoutes() {

            $routes['home'] = array(
                'route' => '/',
                'controller' => 'indexController',
                'action' => 'index'
            );

            $routes['contato'] = array(
                'route' => '/contato',
                'controller' => 'indexController',
                'action' => 'contato'
            );

            $routes['registercontact'] = array(
                'route' => '/registercontact',
                'controller' => 'indexController',
                'action' => 'registercontact'
            );

            $routes['quemSomos'] = array(
                'route' => '/quemSomos',
                'controller' => 'indexController',
                'action' => 'quemSomos'
            );

            $routes['servicos'] = array(
                'route' => '/servicos',
                'controller' => 'IndexController',
                'action' => 'servicos'
            );



            $this->setRoutes($routes);
        }

        // ==========================================
        
    }

?>