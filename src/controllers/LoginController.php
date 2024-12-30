<?php

namespace App\controllers;

use App\models\LoginModel;
use App\models\UsresModel;

class LoginController extends Controller
{

    /**
     * cette fonction nous permet de connecter un avec son code de connection
     *
     * @return void
     */
    public function confirm()
    {
        $login = new LoginModel();
        if ($this->request->isPost()) {

            // on hydrate l'utilisateur
            $login->loadData($this->request->getBody());

            if ($login->isValid()) {
                $body = $this->request->getBody();
                //on stock le temps actuel
                $time = time();

                // on récupère l'utlistaeur selon son email
                $userArray = $login->findOneByEmail($body['email']);

                // on recupère l'utilisateur avec son code 
                $verify = $login->findOneByCode($body['email']);

                // on verife si l'utlisateur existe
                if (!$userArray) {
                    $login->adError('email', "l'adress email et / ou le mot de passe est incorrect");
                    $this->response->redirect('login/confirm');
                    exit;
                }
                //si l'utlisateur existe  on l'hydrate
                $user1 = $login->hydrate($userArray);

                //on vérifie si le mot de passe est correct 
                // si c'est correct on redirige vers contact
                if (password_verify($body['password'], $user1->getPassword())) {

                    if ($verify->time > $time) {
                        if ($verify->code == $body['number']) {

                            // Si le code est bon je met a jour l'utlisateur au niveau de email_verify
                            $login->requete('UPDATE users SET email_verify = ? WHERE email = ' . $body['email'], [$verify->email]);

                            //on ouvre la session 
                            $login->setSession();

                            // on redirige l'utilisateur
                            $this->response->redirect('contact/contact');
                            exit;
                        } else {
                            $login->adError('number', 'wrong code');
                            $this->response->redirect('login/confirm');
                            exit;
                        }
                    } else {
                        $login->adError('number', 'time expired');
                        $this->response->redirect('login/confirm');
                        exit;
                    }
                } else {
                    $login->adError('password', "l'adress email et / ou le mot de passe est incorrect");
                    $this->response->redirect('login/confirm');
                    return false;
                    exit;
                }
            }
        }
        $this->renderView("login/confirm", [
            'model' => $login
        ]);
    }

    /**
     * login function
     *
     * @return void
     */
    public function login()
    {
        $login = new LoginModel();

        if ($this->request->isPost()) {

            // on hydrate l'utilisateur
            $login->loadData($this->request->getBody());

            if ($login->isValid()) {
                $body = $this->request->getBody();

                // on récupère l'utlistaeur selon son email
                $userArray = $login->findOneByEmail($body['email']);


                // on verife si l'utlisateur existe
                if (!$userArray) {
                    $login->adError('email', "l'adress email et / ou le mot de passe est incorrect");
                    $this->response->redirect('login/login');
                    exit;
                }

                //si l'utlisateur existe  on l'hydrate
                $user1 = $login->hydrate($userArray);

                //on vérifie si le mot de passe est correct 
                // si c'est correct on redirige vers contact
                if (password_verify($body['password'], $user1->getPassword())) {

                    //on ouvre la session 
                    $login->setSession();

                    // on redirige l'utilisateur
                    $this->response->redirect('contact/contact');
                    exit;
                } else {
                    $login->adError('password', "l'adress email et / ou le mot de passe est incorrect");
                    $this->response->redirect('login/login');
                    return false;
                    exit;
                }
            }
        }
        $this->renderView("login/login", [
            'model' => $login
        ]);
    }

    /**
     * cette fonction nous permet de reenvoyer un le code de vérification
     *
     * @return void
     */
    public function code()
    {
        $user = new UsresModel();
        $mail = new MailController();

        if ($this->request->isPost()) {
            $user->loadData($this->request->getBody());

            if ($user->isValid()) {
                $verify = [];
                $body = $this->request->getBody();

                //on creer le code qu'on envoie a l'utilisateur
                $verify['code'] = rand(10000, 99999);

                //le temps d'expiration est 2 min
                $verify['time'] = (time() + (60 * 60));

                $verify['email'] = $body['email'];

                // on envoie le code verification a notre utlisateur
                $mail->mail(
                    $verify['email'],
                    "Demandes d'inscription",
                    "votre code confirmation est " . $verify['code'],
                    'Ce code expire dans 5 minutes'
                );
                // maintenant on insert la verification 
                $user->creat_verify($verify);

                //on hash le mot de passe de l'utlisateur
                $body['password'] = password_hash($body['password'], PASSWORD_BCRYPT);
                $user->create($body);
                $this->response->redirect('login/confirm');
            }
        }
    }

    /**
     * function to logout user
     *
     * @return void
     */
    public function logout()
    {
        unset($_SESSION['user']);
        header('Location:' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
