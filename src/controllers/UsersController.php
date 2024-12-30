<?php

namespace App\controllers;

defined("ROOTPATH") or exit("access Denied");

use App\models\UsresModel;

class UsersController extends Controller
{

    /**
     * cette fonction nous permet de creer un utilisateurs
     *
     * @return void
     */
    public function register()
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
        $this->renderView("register/register", [
            'model' => $user
        ]);
    }
}
