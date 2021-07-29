<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\core\Controller;
use app\core\Response;
use app\models\User;
use app\core\middlewares\AuthMiddleware;
use app\models\AccountActions;
use app\models\Character;
use app\models\LoginForm;
use app\models\ResetPasswordForm;
use app\models\CharacterSearch;
use app\models\CharacterUpload;
use app\models\PDF;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware([
            'userAccount',
            'upload',
            'characterSearch',
            'resetPassword',
            'logout'
        ]));
    }

    public function register(Request $request): string
    {
        $user = new User();
        if ($request->isPost()) {
            $user->loadData($request->getBody());
            if ($user->validate()) {
                $user->save();
                $user = $user->findOne(['email' => $user->email]);
                Application::$APP->login($user);
                Application::$APP->session->setFlash('success', 'Thanks for registering!');
                Application::$APP->response->redirect('/MyAccount');
                exit;
            }
        }
        return $this->render('register', [
            'model' => $user
        ]);
    }

    public function login(Request $request): string
    {
        $login = new LoginForm();
        $user = new User();
        if ($request->isPost()) {
            $login->loadData($request->getBody());
            if ($login->validate()) {
                $user = $user->findOne(['email' => $login->email]);
                if ($user && $user->verifyPasswords(['email' => $login->email], $login->password)) {
                    Application::$APP->login($user);
                    Application::$APP->response->redirect('/MyAccount');
                    exit;
                } else {
                    Application::$APP->session->setFlash('fail', 'Incorrect email or password (inclusive)');
                }
            }
        }
        return $this->render('login', [
            'model' => $login
        ]);
    }

    public function userAccount(Request $request)
    {
        $action = new AccountActions;
        if (Application::$APP->session->get('upload') && !Application::isGuest()) {
            $character = Application::$APP->session->get('newCharacter');
            $character->user = Application::$APP->session->get('user')['primaryValue'];
            if (Application::$APP->session->get('upload')['isPublic']) {
                $character->isPublic = 1;
            } else {
                $character->isPublic = 0;
            }
            Application::$APP->session->remove('upload');
            $characterUpload = $character->uploadPrepare();
            $characterUpload->save();
            if (!rename(Application::$ROOT_DIR . "//public_html/tmp" . Application::$APP->session->get('newCharacter')->file, Application::$ROOT_DIR . "/runtime/" . Application::$APP->session->get('newCharacter')->file)) {
                PDF::create(Application::$APP->session->get('newCharacter'), '/runtime/');
            }
            Application::$APP->session->setFlash('success', $character->name . ' uploaded!');
            Application::$APP->response->redirect('/MyAccount');
        }
        if ($request->isPost()) {
            $action->loadData($request->getBody());
            Application::$APP->session->set('action', $action);
            if (isset($action->createNew)) {
                Application::$APP->response->redirect('/CreateNewCharacter');
                exit;
            } elseif (isset($action->characterSearch)) {
                Application::$APP->response->redirect('/MyAccount/CharacterSearch');
                exit;
            } elseif (isset($action->upload)) {
                $this->upload($request);
            } elseif (isset($action->resetPassword)) {
                Application::$APP->response->redirect('/MyAccount/ResetPassword');
                exit;
            } elseif (isset($action->logout)) {
                Application::$APP->response->redirect('/MyAccount/Logout');
                exit;
            }
        }
        return $this->render('userAccount', [
            'model' => $action
        ]);
    }

    public function characterSearch(Request $request)
    {
        $character = new CharacterSearch();
        $by = array();
        if ($request->isPost()) {
            if ($request->checkValue('Download PDF')) {
                $charID = filter_var(substr($request->getValue('downloadPdf'), 11), FILTER_VALIDATE_INT);
                $character = $character->findOne(["id" => $charID]);
                Application::$APP->response->download(Application::$ROOT_DIR . '/runtime/' . substr($character->file, 0, -4) . ".pdf");
            }
            if ($request->checkValue('delete')) {
                $charID = substr($request->getValue('delete'), 6);
                $character->delete(['id' => $charID]);
            }
            $character->loadData($request->getBody());
            if (isset($character->searchByName) && $character->searchByName) {
                $by['name'] = "$character->searchByName";
            }
            if (isset($character->searchByClass) && $character->searchByClass) {
                $by['class'] = "$character->searchByClass";
            }
            if (isset($character->searchByLevel) && $character->searchByLevel) {
                $by['level'] = "$character->searchByLevel";
                if ($by['level'] < 1) {
                    unset($by['level']);
                }
            }
            if (isset($character->searchByUser) && $character->searchByUser) {
                $by['user'] = "$character->searchByUser";
            }
            if (isset($character->searchOnlyMine) && $character->searchOnlyMine) {
                $by['searchOnlyMine'] = $character->searchOnlyMine;
            }
        }
        if ($character->search($by)) {
            Application::$APP->session->set('characterSearch', $character);
            Application::$APP->session->set('searchResults', true);
        }
        return $this->render('characterSearch', [
            'model' => $character
        ]);
    }

    public function upload(Request $request)
    {
        $character = new Character();
        $action = Application::$APP->session->get('action');
        if ($request->isPost()) {
            $character->fileInput($request->readFile('characterUpload'));
            $character->user = Application::$APP->session->get('user')['primaryValue'] . "";
            $characterUpload = $character->uploadPrepare();
            $characterUpload->save();
            PDF::create(Application::$APP->session->get('newCharacter'), '/runtime/');
            Application::$APP->session->setFlash('success', $character->name . ' uploaded!');
            Application::$APP->response->redirect('/MyAccount');
        }
        return $this->render('userAccount', [
            'model' => $action,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $resetPassword = new ResetPasswordForm();
        $user = new User();
        $userIdentifier = [Application::$APP->session->get('user')['primaryKey'] => Application::$APP->session->get('user')['primaryValue']];
        $user = $user->findOne($userIdentifier);
        if ($request->isPost()) {
            $resetPassword->loadData($request->getBody());
            $isValid = $resetPassword->validate();
            if (!$user->verifyPasswords([Application::$APP->session->get('user')['primaryKey'] => Application::$APP->session->get('user')['primaryValue']], $resetPassword->oldPassword)) {
                Application::$APP->session->setFlash('fail', 'Incorrect password');
            } elseif ($isValid) {
                $resetPassword->update(['password' => password_hash($this->newPassword, PASSWORD_DEFAULT)], $userIdentifier);
                Application::$APP->session->setFlash('success', 'Password updated');
                Application::$APP->response->redirect('/MyAccount');
                exit;
            }
        }
        return $this->render('resetPassword', [
            'model' => $resetPassword
        ]);
    }

    public function logout()
    {
        Application::$APP->logout();
        Application::$APP->session->setFlash('success', 'You were successfully logged out');
        Application::$APP->response->redirect('/');
        exit;
    }
}
