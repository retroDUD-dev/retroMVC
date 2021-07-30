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
use app\models\UserProfile;
use app\models\UserSearch;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware([
            'userAccount',
            'upload',
            'characterSearch',
            'resetPassword',
            'logout',
            'ADMIN' => ['admin']
        ]));
    }

    public function register(Request $request, array $params = array()): string
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

    public function login(Request $request, array $params = array()): string
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

    public function userAccount(Request $request, array $params = array())
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
            } elseif (isset($action->edit)) {
                Application::$APP->response->redirect('/MyAccount/MyProfile');
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

    public function characterSearch(Request $request, array $params = array())
    {
        $character = new CharacterSearch();
        $by = array();
        if ($request->isPost()) {
            if ($request->checkValue('Download PDF')) {
                $charID = filter_var(substr($request->getValue('downloadPdf'), 11), FILTER_VALIDATE_INT);
                $character = $character->findOne(["id" => $charID]);
                Application::$APP->response->download(Application::$ROOT_DIR . '/runtime/' . substr($character->file, 0, -4) . ".pdf");
            } elseif ($request->checkValue('delete')) {
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

    public function upload(Request $request, array $params = array())
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

    public function resetPassword(Request $request, array $params = array())
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
                Application::$APP->response->redirect('/MyAccount/MyProfile');
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

    public function userProfile(Request $request, array $params = array())
    {
        $edit = new UserProfile();

        if (isset($params['disabled'])) {
            $disabled = $params['disabled'];
        } else {
            $disabled = 'disabled';
        }
        
            $userIdentifier = [Application::$APP->session->get('user')['primaryKey'] => Application::$APP->session->get('user')['primaryValue']];
        $user = $edit->findOne($userIdentifier);

        if ($request->isPost()) {
            $edit->loadData($request->getBody());
            if (isset($edit->resetPassword)) {
                    Application::$APP->response->redirect('/MyAccount/MyProfile/ResetPassword');
            }
            if (!isset($edit->edit)) {
                if ($edit->validate()) {
                    if (isset($edit->save)) {
                        $updated = false;
                        if (isset($edit->firstname)) {
                            $user->update(['firstname' => $edit->firstname], $userIdentifier);
                            $updated = true;
                        }
                        if (isset($edit->lastname)) {
                            $user->update(['lastname' => $edit->lastname], $userIdentifier);
                            $updated = true;
                        }
                        if (isset($edit->email)) {
                            $user->update(['email' => $edit->email], $userIdentifier);
                            $updated = true;
                        }
                        if ($updated) {
                            Application::$APP->login($user);
                            Application::$APP->session->setFlash('success', 'Profile updated');
                            Application::$APP->response->redirect('/MyAccount/MyProfile');
                        }
                        $disabled = 'disabled';
                    } elseif (isset($edit->deactivate)) {
                        $user->update(['status' => 2], $userIdentifier);
                        Application::$APP->logout();
                        Application::$APP->session->setFlash('success', 'Account has been deactivated. Contact me if you wish to restore it.');
                        Application::$APP->response->redirect('/');
                        exit;
                    } elseif (isset($edit->delete)) {
                        $user->delete(['id' => $userIdentifier]);
                        Application::$APP->logout();
                        Application::$APP->session->setFlash('success', 'Account has been deleted.');
                        Application::$APP->response->redirect('/');
                        exit;
                    }
                }
            } else {
                $disabled = '';
            }
        }
        return $this->render('userProfile', [
            'model' => $user,
            'disabled' => $disabled
        ]);
    }

    public function admin(Request $request, array $params = array())
    {
        $search = new UserSearch();
        $by = array();
        if ($request->isPost()) {
            if ($request->checkValue('EDIT')) {
                $userID = filter_var(substr($request->getValue('edit'), 4), FILTER_VALIDATE_INT);
                $user = new User();
                $user = $user->findOne(["id" => $userID]);
                Application::$APP->session->set('profileUser', $user);
                Application::$APP->response->redirect('Admin/UserProfile');
                exit;
            } elseif ($request->checkValue('DELETE')) {
                $userID = substr($request->getValue('delete'), 6);
                $search->delete(['id' => $userID]);
            }
            $search->loadData($request->getBody());
            if (isset($search->searchById) && $search->searchById) {
                $by['id'] = "$search->searchByName";
            }
            if (isset($search->searchByFirstname) && $search->searchByFirstname) {
                $by['firstname'] = "$search->searchByFirstname";
            }
            if (isset($search->searchByLastname) && $search->searchByLastname) {
                $by['lastname'] = "$search->searchByLastname";
            }
            if (isset($search->searchByEmail) && $search->searchByEmail) {
                $by['email'] = "$search->searchByEmail";
            }
            if (isset($search->searchByStatus) && $search->searchByStatus) {
                $by['status'] = "$search->searchByStatus";
            }
        }
        if ($search->search($by)) {
            Application::$APP->session->set('userSearch', $search);
            Application::$APP->session->set('searchResults', true);
        }

        return $this->render('userSearch', [
            'model' => $search
        ]);
    }

    public function adminUserProfile(Request $request, array $params = array())
    {
        $edit = new UserProfile();

        if (isset($params['disabled'])) {
            $disabled = $params['disabled'];
        } else {
            $disabled = 'disabled';
        }

        $userIdentifier = ['id' => Application::$APP->session->get('profileUser')->id];
        $user = $edit->findOne($userIdentifier);

        if ($request->isPost()) {
            $edit->loadData($request->getBody());
            if (isset($edit->resetPassword)) {
                //tod: set up password recovery
                Application::$APP->response->redirect('/Admin/UserProfile');
                exit;
            }
            if (!isset($edit->edit)) {
                if ($edit->validate()) {
                    if (isset($edit->save)) {
                        $updated = false;
                        if (isset($edit->firstname)) {
                            $user->update(['firstname' => $edit->firstname], $userIdentifier);
                            $updated = true;
                        }
                        if (isset($edit->lastname)) {
                            $user->update(['lastname' => $edit->lastname], $userIdentifier);
                            $updated = true;
                        }
                        if (isset($edit->email)) {
                            $user->update(['email' => $edit->email], $userIdentifier);
                            $updated = true;
                        }
                        if ($updated) {
                            $disabled = 'disabled';
                            Application::$APP->session->setFlash('success', 'Profile updated');
                            Application::$APP->response->redirect('/Admin');
                            exit;
                        }
                    } elseif (isset($edit->deactivate)) {
                        $user->update(['status' => 2], $userIdentifier);
                        Application::$APP->logout();
                        Application::$APP->session->setFlash('success', 'Account has been deactivated. Contact me if you wish to restore it.');
                        Application::$APP->response->redirect('/');
                        exit;
                    } elseif (isset($edit->delete)) {
                        $user->delete(['id' => $userIdentifier]);
                        Application::$APP->logout();
                        Application::$APP->session->setFlash('success', 'Account has been deleted.');
                        Application::$APP->response->redirect('/');
                        exit;
                    }
                }
            } else {
                $disabled = '';
            }
        }
        return $this->render('adminUserProfile', [
            'model' => $user,
            'disabled' => $disabled
        ]);
    }
}
