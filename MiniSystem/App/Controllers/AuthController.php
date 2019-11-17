<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action 
{
  
    public function autenticar() 
    {
        $usuario = Container::getModel('Usuario');
    
        $usuario->__set('username', $_POST['username']);
        $usuario->__set('senha', md5($_POST['password']));
        $usuario->autenticar();        

        if(isset($_POST['check']) && $_POST['check'] == 'concordar')
        {
            if($usuario->__get('id') != '' && $usuario->__get('nome') != '')
            {
                session_start();

                $_SESSION['id'] = $usuario->__get('id');
                $_SESSION['nome'] = $usuario->__get('nome');
                $_SESSION['user'] = $usuario->__get('username');
                $_SESSION['mail'] = $usuario->__get('email');
                $_SESSION['id_type'] = $usuario->__get('id_type');

                header('location: /dashboard');
            
            } else 
            {
                header('location: /?login=error');
            }
        } else
        {
            header('location: /?login=check');
        }        
    }

    public function sair() 
    {
        session_start();

        $user = Container::getModel('Usuario');
        $alert = Container::getModel('Sendmail');
           
        $logOff = $user->generator();

        $alert->__set('name', $_SESSION['nome']);
        $alert->__set('logOff', $logOff);
        $alert->__set('mail', $_SESSION['mail']);

        $alert->alertLogOff();
        
        $user->__set('id', $_SESSION['id']);
        $user->__set('senha', md5($logOff));

        $user->logOff();

        session_destroy();
        header('location: /');
    }
}