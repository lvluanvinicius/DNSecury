<?php

    namespace App;

    use MF\Init\Bootstrap;

    class Route extends Bootstrap {

        // ==========================================
        //Inicialização do array de rotas.
        protected function initRoutes() {

            //rota teste de mesa
            $routes['testemesa'] = array(
                'route' => '/testemesa',
                'controller' => 'SystemController',
                'action' => 'testemesa'
            );           
           
            // ================================ AuthController =================================
            $routes['autenticar'] = array(
                'route' => '/autenticar',
                'controller' => 'AuthController',
                'action' => 'autenticar'
            );

            $routes['sair'] = array(
                'route' => '/sair',
                'controller' => 'AuthController',
                'action' => 'sair'
            );

            // ================================ IndexController =================================

            $routes['home'] = array(
                'route' => '/',
                'controller' => 'indexController',
                'action' => 'index'
            );

            $routes['termos'] = array(
                'route' => '/termos',
                'controller' => 'IndexController',
                'action' => 'termos'
            );

            // ================================ SystemController =================================

            $routes['notfy'] = array(
                'route' => '/notfy',
                'controller' => 'SystemController',
                'action' => 'notfy'
            );

            $routes['reqdata'] = array(
                'route' => '/reqdata',
                'controller' => 'SystemController',
                'action' => 'reqdata'
            );

            $routes['dashboard'] = array(
                'route' => '/dashboard',
                'controller' => 'SystemController',
                'action' => 'dashboard'
            );

            $routes['contato'] = array(
                'route' => '/contato',
                'controller' => 'SystemController',
                'action' => 'contato'
            );

            $routes['sendmail'] = array(
                'route' => '/sendmail',
                'controller' => 'SystemController',
                'action' => 'sendmail'
            );

            $routes['mensagem'] = array(
                'route' => '/mensagem',
                'controller' => 'SystemController',
                'action' => 'mensagem'
            );

            $routes['remover'] = array(
                'route' => '/remover',
                'controller' => 'SystemController',
                'action' => 'remover'
            );            
            
            $routes['newuser'] = array(
                'route' => '/newuser',
                'controller' => 'SystemController',
                'action' => 'newuser'
            );

            $routes['usuarios'] = array(
                'route' => '/usuarios',
                'controller' => 'SystemController',
                'action' => 'usuarios'
            );

            $routes['registra'] = array(
                'route' => '/registra',
                'controller' => 'SystemController',
                'action' => 'registra'
            );

            $routes['profile'] = array(
                'route' => '/profile',
                'controller' => 'SystemController',
                'action' => 'profile'
            );

            $routes['profileEditaLogin'] = array(
                'route' => '/profileEditaLogin',
                'controller' => 'SystemController',
                'action' => 'profileEditaLogin'
            );
            
            $routes['alterStatus'] = array(
                'route' => '/alterStatus',
                'controller' => 'SystemController',
                'action' => 'alterStatus'
            );            

            $routes['newslider'] = array(
                'route' => '/newslider',
                'controller' => 'SystemController',
                'action' => 'newslider'
            );
            
            $routes['cadastrarslider'] = array(
                'route' => '/cadastrarslider',
                'controller' => 'SystemController',
                'action' => 'cadastrarslider'
            ); 
            
            $routes['sliderslist'] = array(
                'route' => '/sliderslist',
                'controller' => 'SystemController',
                'action' => 'sliderslist'
            );
            
            $routes['editaslider'] = array(
                'route' => '/editaslider',
                'controller' => 'SystemController',
                'action' => 'editaslider'
            );
            
            $routes['updateslider'] = array(
                'route' => '/updateslider',
                'controller' => 'SystemController',
                'action' => 'updateslider'
            );

            $routes['removeslider'] = array(
                'route' => '/removeslider',
                'controller' => 'SystemController',
                'action' => 'removeslider'
            );
            

            $this->setRoutes($routes);
        }

        // ==========================================
        
    }

?>