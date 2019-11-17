<?php

    namespace App\Controllers;

    //Recursos do miniframework
    use MF\Controller\Action;
    use MF\Model\Container;
    

    class SystemController extends Action 
    {
        # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
        public function validAutenticateLogin()
        {
            session_destroy();
            session_start();
            session_regenerate_id();
            
            if(!isset($_SESSION['id']) && $_SESSION['id'] == '' 
            || !isset($_SESSION['nome']) && $_SESSION['nome'] == '')
            {
                header('location: /?login=erro');
            }
        }


        public function notfy()
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();

            # Iniciando a getModel - chamando a classe System.
            $notfy = Container::getModel('System');

            # Recuperando os dados que será exibido nas notificações de e-mails.
            $tot = $notfy->totNotfy();
            print_r($tot[0]['tb_contacts']);
        }

        public function reqdata()
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();
            $contacts = Container::getModel('System');

            # Recuperando os dados que será exibido nas notificações de e-mails.
            $totContacts =  $contacts->dadosNotfy();
            echo json_encode($totContacts);

        }
        
        public function dashboard()
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();
            
            # Iniciando a getModel - chamando a classe System.
            $contacts = Container::getModel('System');
            
            $this->view->totContacts = $contacts->totalContatos(); # Total de contatos.s
                                            
            $this->render('dashboard');

        }

        public function contato()
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();
            
            # Verifica se o usuário logado é editor para ser bloqueado.
            if($_SESSION['id_type'] == '2')
            {
                header("location: /dashboard?access=no");
            }

            # Iniciando a getModel - chamando a classe System.
            $dado = Container::getModel('System');
            
            # Recuperando os dados enviados em texto puro pela camada model.
            $this->view->dados = $dado->getAll();

            $this->render('contato');

        }

        public function mensagem()
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();

            # Verifica se o usuário logado é editor para ser bloqueado.
            if($_SESSION['id_type'] == '2')
            {
                header("location: /dashboard?access=no");
            }

            # Iniciando a getModel - chamando a classe System.
            $dado = Container::getModel('System');
            
            # Recuperando os dados enviados pela camada model.
            $this->view->dados = $dado->getAll();

            # Renderizando a página usuários.
            $this->render('mensagem');
        }

        public function sendmail()
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();

            # Verifica se o usuário logado é editor para ser bloqueado.
            if($_SESSION['id_type'] == '2')
            {
                header("location: /dashboard?access=no");
            }

            # Iniciando a getModel - chamando a classe Sendmail.
            $sendmail = Container::getModel('Sendmail');

            $sendmail->__set('mail', $_POST['email']);
            $sendmail->__set('subject', $_POST['assunto']);
            $sendmail->__set('message', $_POST['mensagem']);

            $sendmail->sendmail();

            header('location: /mensagem?msg=success');
        }

        public function remover()
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();

            # Verifica se o usuário logado é administrador para ter acesso ao delete de usuarios.
            if($_SESSION['id_type'] != '1')
            {
                header("location: /dashboard?access=no");
            }

            $acao = isset($_GET['acao']) ? $_GET['acao'] : $acao; # Recuperando da super-global o valor de ação.
            $id = isset($_GET['id']) ? $_GET['id'] : $id; # recuperando da super-global o valor de id.

            if($acao == 'remover') 
            {    
                # Iniciando a getModel - chamando a classe System.
                $remover = Container::getModel('System');
                $remover->__set('id', $id);
                $remover->remover();
                header('location: /contato');

            } else if($acao == 'removerlogin')
            {
                $remover = Container::getModel('System');
                $remover->__set('id', $id);
                if($id == 1)
                {
                    header('location: /usuarios?rm=nao');
                } else
                {
                    $remover->removerLogin();
                    header('location: /usuarios');
                }
                
            } 
            
        }
        
        public function newuser()
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();

            # Verifica se o usuário logado é administrador para ter acesso ao registro de usuarios.
            if($_SESSION['id_type'] != '1')
            {
                header("location: /dashboard?access=no");
            }

            # Renderizando a página newuser.
            $this->render('newuser');
        }

        public function usuarios()
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();

            # Verifica se o usuário logado é administrador para ter acesso a lista de usuarios.
            if($_SESSION['id_type'] != '1')
            {
                header("location: /dashboard?access=no");
            }
            
            # Iniciando a getModel - chamando a classe System.
            $login = Container::getModel('System');
            utf8_encode($this->view->total_login = $login->getAllLogin());
            # Recuperando os dados que será exibido nas notificações de e-mails            
            $this->view->dadosNotfy = $login->dadosNotfy();

            # Renderizando a página usuários.
            $this->render('usuarios');
        }

        # Func responsável por enviar todos os dados de um novo registro para a camada model.
        public function registra()
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();

            # Verifica se o usuário logado é administrador para ter acesso ao registro de usuarios.
            if($_SESSION['id_type'] != '1')
            {
                header("location: /dashboard?access=no");
            }

            # Iniciando a getModel - chamando a classe Usuario e Sendmail.
            $user = Container::getModel('Usuario');
            $alert = Container::getModel('Sendmail');      

            # Validando os dados enviados pela super-global post.
            if($_POST['nome'] == '' || strlen($_POST['nome']) < 4 
            || $_POST['email'] == '' || strlen($_POST['email']) < 8
            || $_POST['username'] == '' || strlen($_POST['username']) <= 6 
            || $_POST['type'] == '')
            {
                # Retornando à página se as politicas de preenchimento não forem seguidas.
                header('location: /newuser?form=error');

            } else 
            {
                $logOff = $user->generator(); # Gerando uma nova senha.
                # Mandando os dados para os atributos da camada model.
                $alert->__set('mail', $_POST['email']);
                $alert->__set('name', $_POST['nome']);
                $alert->__set('logOff', $logOff);

                $alert->AlertLogoff(); # Enviando um alerta com as instruções de acesso ao novo usuário.

                # Preenchendo os atributos da camada model.
                $user->__set('nome', $_POST['nome']);
                $user->__set('email', $_POST['email']);
                $user->__set('username', $_POST['username']);
                $user->__set('senha', md5($logOff));
                $user->__set('type', $_POST['type']);
                $user->registra(); # Registrando o novo usuário no sistema.
                header('location: /newuser?form=success');
            }

        }
        
        public function testemesa() # Apenas para teste de novos códigos.
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();

            # Renderizando a página testemesa.
            $this->render('testemesa');
        }

        # Func que redireciona para a view o resultado do perfil de usuário retornado pela camada model.
        public function profile() 
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();
        
            # Iniciando a getModel - chamando a classe System.
            $login = Container::getModel('System');

            # Recuperando os dados enviados pela comada model.
            $this->view->total_login = $login->getAllLoginProfile();

            # Renderizando a página prifile.
            $this->render('profile');
        }

        # Func responsável por manipular a edição de perfil do usuário.
        public function profileEditaLogin()
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();

            # Iniciando a getModel - chamando a classe Usuario.
            $user = Container::getModel('Usuario');

            # Recuperando os valores da variável get.
            $acao = isset($_GET['alt']) ? $_GET['alt'] : $acao;
            $id = isset($_GET['id']) ? $_GET['id'] : $id;

            # Preenchendo os atributos da camada model.
            $user->__set('id', $id);
            $user->__set('nome', $_POST['nome']);
            $user->__set('email', $_POST['email']);
            $user->__set('username', $_POST['username']);
            $user->__set('type', $_POST['type']);

            # Validando se a ação de alteração está correta.
            if($acao == "alter") {                

                # Verificando se as politicas de preenchimento estão sendo seguidas.
                if($_POST['nome'] == '' || strlen($_POST['nome']) < 4 
                || $_POST['email'] == '' || strlen($_POST['email']) < 8
                || $_POST['username'] == '' || strlen($_POST['username']) <= 4 
                || $_POST['type'] == '')
                {
                    # Retorna à página se as politicas de preenchimento não forem seguidas.
                    header('location: /profile?form=error');
                } else
                {                   
                    # Executando a edição do login.
                    $user->profileEditaLogin();
                    # Retornando com sucesso.
                    header('location: /profile?form=success');

                }                

            }

        }

        # Função declarada para alterar o status do e-mail.
        public function alterStatus()
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();

            # Iniciando a getModel - chamando a classe System.
            $alter = Container::getModel('System');

            # Recuperando os valores da variável get.
            $id = isset($_GET['id']) ? $_GET['id'] : $id;
            $acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

            # Verificando se será possivel fazer a alteração de pendência.
            if($acao == 'alter')
            {
                $alter->__set('id', $id);
                $alter->alterNotfy();
                header("location: /mensagem?id=$id");
            }
        }

        public function newslider() 
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();

            # Verifica se o usuário logado é atendente para bloquear o acesso dele a outras areas admistrativas.
            if($_SESSION['id_type'] == '3')
            {
                header("location: /dashboard?access=no");
            }

            $this->render('newslider');
        }

        public function cadastrarslider()
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();

            # Verifica se o usuário logado é atendente para bloquear o acesso dele a outras areas admistrativas.
            if($_SESSION['id_type'] == '3')
            {
                header("location: /dashboard?access=no");
            }

            # Iniciando a getModel - chamando a classe Editor
            $alter = Container::getModel('Editor');

            if(isset($_FILES['imagem']))
            {
                # Iniciando a separação da extenção so arquivo.
                $filename = $_FILES['imagem']['name'];
                $filename = explode('.', $filename);
                $extensao = strtolower($filename[1]); // Recebendo a extenção do arquivo.
                
                $novo_nome = $_POST['new_name'].'.'.$extensao; // Recebendo o novo nome concatenado com a extensão.

                $sp = DIRECTORY_SEPARATOR;
                $diretorio = $sp.'home'.$sp.'loginroot'.$sp.'sitedns'.$sp.'DNSecury'.$sp.'public'.$sp.'imagens'.$sp.'slider'.$sp; // Diretório principal.             

                if(move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio.$novo_nome)) // move o arquivo para o diretorio principal.
                {       
                    
                    # Preenchendo os atributos da camada model.
                    $alter->__set("name_file", $novo_nome);
                    $alter->__set("name", strtoupper($_POST['nome']));
                    $alter->__set("url", $_POST['url']);
                    $alter->__set("description", $_POST['descricao']);

                    if($alter->insert_doc_slider())
                    {                        
                        header("location: /newslider?acao=success");
                    }
                    else 
                    {
                        header("location: /newslider?acao=error");
                    }
                }
                else
                {
                    header("location: /newslider?acao=error");
                }                                             
            }
        }

        public function sliderslist()
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();

            # Verifica se o usuário logado é atendente para bloquear o acesso dele a outras areas admistrativas.
            if($_SESSION['id_type'] == '3')
            {
                header("location: /dashboard?access=no");
            }

            # Iniciando a getModel - chamando a classe Editor
            $elements = Container::getModel("Editor");

            # Recuperando os dados enviado pela camada model atraves da função getAllelements().
            $this->view->elements = $elements->getAllelements();

            $this->render("sliderslist");
        }

        public function editaslider()
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();

            # Verifica se o usuário logado é atendente para bloquear o acesso dele a outras areas admistrativas.
            if($_SESSION['id_type'] == '3')
            {
                header("location: /dashboard?access=no");
            }

            # Iniciando a getModel - chamando a classe Editor
            $elements = Container::getModel("Editor");

            # Recuperando os dados enviado pela camada model atraves da função getAllelements().
            $this->view->elements = $elements->getAllelements();

            $this->render('editaslider');
        }

        public function updateslider()
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();

            # Verifica se o usuário logado é atendente para bloquear o acesso dele a outras areas admistrativas.
            if($_SESSION['id_type'] == '3')
            {
                header("location: /dashboard?access=no");
            }

            # Iniciando a getModel - chamando a classe Editor
            $alter = Container::getModel('Editor');

            if(isset($_FILES['imagem']))
            {
                $id = $_GET['id']; // Recebendo id
                # Iniciando a separação da extenção so arquivo.
                $filename = $_FILES['imagem']['name'];
                $filename = explode('.', $filename);
                $extensao = strtolower($filename[1]); // Recebendo a extenção do arquivo.
                
                $novo_nome = $_POST['new_name'].'.'.$extensao; // Recebendo o novo nome concatenado com a extensão.

                $sp = DIRECTORY_SEPARATOR;
                $diretorio = $sp.'home'.$sp.'loginroot'.$sp.'sitedns'.$sp.'DNSecury'.$sp.'public'.$sp.'imagens'.$sp.'slider'.$sp; // Diretório principal.               

                if(isset($_GET['acao']) && $_GET['acao'] == 'edit') // Executará somente se o valor de ação for edit.
                {
                    # Verifica se o arquivo já existe.
                    if(file_exists($diretorio.$novo_nome))
                    {
                        // Se existir, será excluido para receber um novo arquivo.
                        chown($diretorio.$novo_nome, 465);
                        unlink($diretorio.$novo_nome);
                    }

                    if(move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio.$novo_nome)) // move o arquivo para o diretorio principal.
                    {   
                        # Preenchendo os atributos da camada model.
                        $alter->__set("name", strtoupper($_POST['nome']));
                        $alter->__set("url", $_POST['url']);
                        $alter->__set("description", $_POST['descricao']);
                        $alter->__set("id", $id);

                        # Verifica se o updade foi executado com sucesso.
                        if($alter->update_doc_slider())
                        {                        
                            header("location: /editaslider?acao=open&id=$id&acaoedit=success");
                        }
                        else 
                        {
                            header("location: /editaslider?acao=open&id=$id&acaoedit=error");
                        }
                    }
                    else
                    {
                        header("location: /editaslider?acao=open&id=$id&acaoedit=error");
                    } 
                }
                else
                {
                    # Pelo contrário, se o valor de ação não for edit, retornará a página de login.
                    session_destroy();
                    header("location: /?login=errorlocal");
                }                                            
            }
            
        }

        public function removeslider()
        {
            # Verificando a existencia de uma autenticação e validando a continuidade no sistema ao usuário logado.
            $this->validAutenticateLogin();

            # Verifica se o usuário logado é atendente para bloquear o acesso dele a outras areas admistrativas.
            if($_SESSION['id_type'] == '3')
            {
                header("location: /dashboard?access=no");
            }

            # Iniciando a getModel - chamando a classe Editor
            $remove = Container::getModel('Editor');

            $acao = isset($_GET['acao']) ? $_GET['acao']:$acao; // Recebendo o valor de ação do get.
            $filename = isset($_GET['filename']) ? $_GET['filename']:$filename; // Recebendo o nome do arquivo de imagem do get.

            $sp = DIRECTORY_SEPARATOR;
            $diretorio = $sp.'home'.$sp.'loginroot'.$sp.'sitedns'.$sp.'DNSecury'.$sp.'public'.$sp.'imagens'.$sp.'slider'.$sp; // Diretório principal.

            if($acao === "remove")
            {
                if(file_exists($diretorio.$filename))
                {
                    chown($diretorio.$filename, 465);
                    unlink($diretorio.$filename);
                }

                # Enviando o id para a camada model, para remover o elemento desejado.
                $remove->__set('id', $_GET['id']);
                if($remove->removeslider())
                {
                    header("location: /sliderslist?acaorm=success");
                }
            }

        }       

    }