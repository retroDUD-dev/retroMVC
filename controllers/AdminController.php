<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\core\Controller;
use app\core\Response;
use app\core\middlewares\AdminMiddleware;
use app\models\User;
use app\models\UserProfile;
use app\models\UserSearch;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AdminMiddleware([
            'admin',
            'userSearch',
            'userProfile'
        ]));
    }

    public function admin(Request $request)
    {
        $admin = new UserSearch();
        $params = array();
        if ($request->isPost()) {
            $admin->loadData($request->getBody());
            if ($admin->validate()) {
                if (isset($admin->userSearch)) {
                    Application::$APP->response->redirect('/Admin/UserSearch');
                    exit;
                }
            }
        }
        return $this->render('adminAccount', ['model' => $admin]);
    }

    public function userSearch(Request $request, array $params = array())
    {
        $search = new UserSearch();
        $by = array();
        if ($request->isPost()) {
            if ($request->checkValue('EDIT')) {
                $userID = filter_var(substr($request->getValue('edit'), 4), FILTER_VALIDATE_INT);
                $user = new User();
                $user = $user->findOne(["id" => $userID]);
                Application::$APP->session->set('user', $user);
                Application::$APP->response->redirect('MyAccount/MyProfile');
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

    public function userProfile(Request $request, array $params = array())
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
