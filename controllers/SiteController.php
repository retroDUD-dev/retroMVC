<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\core\Controller;
use app\core\middlewares\SiteMiddleware;
use app\models\Character;
use app\models\Email;
use app\models\Attack;
use app\models\Equipment;
use app\models\Feature;
use app\models\PDF;
use app\models\File;
use app\models\Dice;

class SiteController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new SiteMiddleware([
            'addAttack',
            'addEquipment',
            'addFeatures',
            'summary'
        ]));
    }

    public function home(Request $request): string
    {
        if (Application::isAdmin()) {
            Application::$APP->adminReset();
        }
        if ($request->isPost()) {
            //If needed
        }
        return $this->render('home');
    }

    public function about(Request $request): string
    {
        if (Application::isAdmin()) {
            Application::$APP->adminReset();
        }
        $model = new Email();
        if ($request->isPost()) {
            $model->loadData($request->getBody());

            if ($model->validate()) {
                $model->send();
                Application::$APP->session->setFlash('success', 'Email sent!');
                Application::$APP->response->redirect('/AboutMe');
                exit;
            }
        }
        return $this->render('about', ['model' => $model]);
    }

    public function createNewChar(Request $request): string
    {
        $model = new Character();
        if ($request->isPost()) {
            $model->loadData($request->getBody());
            if ($model->validate()) {
                Application::$APP->session->set('newCharacter', $model);
                Application::$APP->session->setFlash('success', $model->getName() . " created! Now add some actions!");
                Application::$APP->response->redirect('/CreateNewCharacter/AddAttacks');
                exit;
            }
        }
        return $this->render('createNewChar', ['model' => $model]);
    }

    public function addAttack(Request $request)
    {
        $model = new Attack();

        if ($request->isPost()) {
            $model->loadData($request->getBody());

            if ($model->validate() && !$model->addLast) {
                Application::$APP->session->get('newCharacter')->addAttack($model);
                Application::$APP->session->setFlash('success', "Action: " . $model->getAttackName() . " added! Add more actions!");
                Application::$APP->response->redirect('/CreateNewCharacter/AddAttacks');
                exit;
            } elseif (!$model->validate() && !$model->addLast) {
                Application::$APP->session->setFlash('success', "Can't have an attack without a name...");
            } elseif ($model->validate() && $model->addLast) {
                $model->addLast();
                Application::$APP->session->get('newCharacter')->addAttack($model);
                Application::$APP->session->setFlash('success', "Action: " . $model->getAttackName() . " added! Add some equipment!");
                Application::$APP->response->redirect('/CreateNewCharacter/AddEquipment');
                $this->render('addEquipment', ['model' => $model]);
                exit;
            } elseif (!$model->validate() && $model->addLast) {
                $model->addLast();
                Application::$APP->session->setFlash('success', "Add some equipment!");
                Application::$APP->response->redirect('/CreateNewCharacter/AddEquipment');
                $this->render('addEquipment', ['model' => $model]);
                exit;
            }
        }
        return $this->render('addAttack', ['model' => $model]);
    }
    public function addEquipment(Request $request)
    {
        $model = new Equipment();

        if ($request->isPost()) {
            $model->loadData($request->getBody());

            if ($model->validate() && !$model->addLast) {
                Application::$APP->session->get('newCharacter')->addToInventory($model);
                Application::$APP->session->setFlash('success', $model->getItemName() . "(" . $model->getQuantity() . ") added! Add more items!");
                Application::$APP->response->redirect('/CreateNewCharacter/AddEquipment');
                exit;
            } elseif (!$model->validate() && !$model->addLast) {
                Application::$APP->session->setFlash('success', "Can't have unnamed equipment...");
            } elseif ($model->validate() && $model->addLast) {
                $model->addLast();
                Application::$APP->session->get('newCharacter')->addToInventory($model);
                Application::$APP->session->setFlash('success', $model->getItemName() . "(" . $model->getQuantity() . ") added! Add some features!");
                Application::$APP->response->redirect('/CreateNewCharacter/AddFeatures');
                $this->render('addFeatures', ['model' => $model]);
                exit;
            } elseif (!$model->validate() && $model->addLast) {
                $model->addLast();
                Application::$APP->session->setFlash('success', "Add some features!");
                Application::$APP->response->redirect('/CreateNewCharacter/AddFeatures');
                $this->render('addFeatures', ['model' => $model]);
                exit;
            }
        }
        return $this->render('addEquipment', ['model' => $model]);
    }

    public function addFeatures(Request $request)
    {
        $model = new Feature();

        if ($request->isPost()) {
            $model->loadData($request->getBody());

            if ($model->validate() && !$model->addLast) {
                Application::$APP->session->get('newCharacter')->addFeature($model);
                Application::$APP->session->setFlash('success', "Feature: " . $model->getFeatureName() . " added! Add more features!");
                Application::$APP->response->redirect('/CreateNewCharacter/AddFeatures');
                exit;
            } elseif (!$model->validate() && !$model->addLast) {
                Application::$APP->session->setFlash('success', "Features need names too...");
            } elseif ($model->validate() && $model->addLast) {
                $model->addLast();
                Application::$APP->session->get('newCharacter')->addFeature($model);
                Application::$APP->session->setFlash('success', "Feature: " . $model->getFeatureName() . " added! Here is your character!");
                Application::$APP->response->redirect('/CreateNewCharacter/Summary');
                $this->render('summary', ['model' => $model]);
                exit;
            } elseif (!$model->validate() && $model->addLast) {
                $model->addLast();
                Application::$APP->session->setFlash('success', "Here is your character!");
                Application::$APP->response->redirect('/CreateNewCharacter/Summary');
                $this->render('summary', ['model' => $model]);
                exit;
            }
        }
        return $this->render('addFeatures', ['model' => $model]);
    }

    public function summary(Request $request)
    {
        $model = new File();
        if ($request->isPost()) {
            $model->loadData($request->getBody());

            if (isset($model->upload)) {
                Application::$APP->session->set('upload', ['waiting' => true, 'isPublic' => $model->isPublic()]);
                Application::$APP->response->redirect('/MyAccount');
                exit;
            } elseif (isset($model->saveFile)) {
                Application::$APP->response->download(Application::$ROOT_DIR . '/public_html/tmp/' . Application::$APP->session->get('newCharacter')->fileOutput('/public_html/tmp/'));
                Application::$APP->session->setFlash('success', "Character downloaded!");
            } elseif (isset($model->downloadPdf)) {
                Application::$APP->response->download(Application::$ROOT_DIR . "/public_html/tmp/" . substr(Application::$APP->session->get('newCharacter')->file, 0, -4) . ".pdf");
                Application::$APP->session->setFlash('success', "PDF downloaded!");
            }elseif (isset($model->newCharacter)) {
                Application::$APP->response->redirect('/CreateNewCharacter');
                exit;
            }
            $model->reset();
        }

        return $this->render('summary', ['model' => $model]);
    }
}
