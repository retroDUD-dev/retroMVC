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
        $params = array();
        if ($request->isPost()) {
            //If needed
        }
        return $this->render('home', $params);
    }

    public function about(Request $request): string
    {
        $params = array();
        Application::$APP->model = new Email();
        if ($request->isPost()) {
            Application::$APP->model->loadData($request->getBody());

            if (Application::$APP->model->validate()) {
                Application::$APP->model->send();
                Application::$APP->session->setFlash('success', 'Email sent!');
                Application::$APP->response->redirect('/AboutMe');
                exit;
            }
        }
        return $this->render('about', $params);
    }

    public function createNewChar(Request $request): string
    {
        $params = array();
        Application::$APP->model = new Character();
        if ($request->isPost()) {
            Application::$APP->model->loadData($request->getBody());
            Application::$APP->model->setHitDice(new Dice(Application::$APP->model->numberOfDice, Application::$APP->model->sidesOfDice));
            if (Application::$APP->model->validate()) {
                Application::$APP->session->set('newCharacter', Application::$APP->model);
                Application::$APP->session->setFlash('success', Application::$APP->model->getName() . " created! Now add some actions!");
                Application::$APP->response->redirect('/CreateNewCharacter/AddAttacks');
                exit;
            }
        }
        return $this->render('createNewChar', $params);
    }

    public function addAttack(Request $request)
    {
        $params = array();
        Application::$APP->model = new Attack();

        if ($request->isPost()) {
            Application::$APP->model->loadData($request->getBody());

            if (Application::$APP->model->validate() && !Application::$APP->model->addLast) {
                Application::$APP->session->get('newCharacter')->addAttack(Application::$APP->model);
                Application::$APP->session->setFlash('success', "Action: " . Application::$APP->model->getAttackName() . " added! Add more actions!");
                Application::$APP->response->redirect('/CreateNewCharacter/AddAttacks');
                exit;
            } elseif (!Application::$APP->model->validate() && !Application::$APP->model->addLast) {
                Application::$APP->session->setFlash('success', "Can't have an attack without a name...");
            } elseif (Application::$APP->model->validate() && Application::$APP->model->addLast) {
                Application::$APP->model->addLast();
                Application::$APP->session->get('newCharacter')->addAttack(Application::$APP->model);
                Application::$APP->session->setFlash('success', "Action: " . Application::$APP->model->getAttackName() . " added! Add some equipment!");
                Application::$APP->response->redirect('/CreateNewCharacter/AddEquipment');
                $this->render('addEquipment', $params);
                exit;
            } elseif (!Application::$APP->model->validate() && Application::$APP->model->addLast) {
                Application::$APP->model->addLast();
                Application::$APP->session->setFlash('success', "Add some equipment!");
                Application::$APP->response->redirect('/CreateNewCharacter/AddEquipment');
                $this->render('addEquipment', $params);
                exit;
            }
        }
        return $this->render('addAttack', $params);
    }
    public function addEquipment(Request $request)
    {
        $params = array();
        Application::$APP->model = new Equipment();

        if ($request->isPost()) {
            Application::$APP->model->loadData($request->getBody());

            if (Application::$APP->model->validate() && !Application::$APP->model->addLast) {
                Application::$APP->session->get('newCharacter')->addToInventory(Application::$APP->model);
                Application::$APP->session->setFlash('success', Application::$APP->model->getItemName() . "(" . Application::$APP->model->getQuantity() . ") added! Add more items!");
                Application::$APP->response->redirect('/CreateNewCharacter/AddEquipment');
                exit;
            } elseif (!Application::$APP->model->validate() && !Application::$APP->model->addLast) {
                Application::$APP->session->setFlash('success', "Can't have unnamed equipment...");
            } elseif (Application::$APP->model->validate() && Application::$APP->model->addLast) {
                Application::$APP->model->addLast();
                Application::$APP->session->get('newCharacter')->addToInventory(Application::$APP->model);
                Application::$APP->session->setFlash('success', Application::$APP->model->getItemName() . "(" . Application::$APP->model->getQuantity() . ") added! Add some features!");
                Application::$APP->response->redirect('/CreateNewCharacter/AddFeatures');
                $this->render('addFeatures', $params);
                exit;
            } elseif (!Application::$APP->model->validate() && Application::$APP->model->addLast) {
                Application::$APP->model->addLast();
                Application::$APP->session->setFlash('success', "Add some features!");
                Application::$APP->response->redirect('/CreateNewCharacter/AddFeatures');
                $this->render('addFeatures', $params);
                exit;
            }
        }
        return $this->render('addEquipment', $params);
    }

    public function addFeatures(Request $request)
    {
        $params = array();
        Application::$APP->model = new Feature();

        if ($request->isPost()) {
            Application::$APP->model->loadData($request->getBody());

            if (Application::$APP->model->validate() && !Application::$APP->model->addLast) {
                Application::$APP->session->get('newCharacter')->addFeature(Application::$APP->model);
                Application::$APP->session->setFlash('success', "Feature: " . Application::$APP->model->getFeatureName() . " added! Add more features!");
                Application::$APP->response->redirect('/CreateNewCharacter/AddFeatures');
                exit;
            } elseif (!Application::$APP->model->validate() && !Application::$APP->model->addLast) {
                Application::$APP->session->setFlash('success', "Features need names too...");
            } elseif (Application::$APP->model->validate() && Application::$APP->model->addLast) {
                Application::$APP->model->addLast();
                Application::$APP->session->get('newCharacter')->addFeature(Application::$APP->model);
                Application::$APP->session->setFlash('success', "Feature: " . Application::$APP->model->getFeatureName() . " added! Here is your character!");
                Application::$APP->response->redirect('/CreateNewCharacter/Summary');
                $this->render('summary', $params);
                exit;
            } elseif (!Application::$APP->model->validate() && Application::$APP->model->addLast) {
                Application::$APP->model->addLast();
                Application::$APP->session->setFlash('success', "Here is your character!");
                Application::$APP->response->redirect('/CreateNewCharacter/Summary');
                $this->render('summary', $params);
                exit;
            }
        }
        return $this->render('addFeatures', $params);
    }

    public function summary(Request $request)
    {
        $params = array();
        Application::$APP->model = new File();
        if ($request->isPost()) {
            Application::$APP->model->loadData($request->getBody());

            if (Application::$APP->model->type() === 'upload') {
                Application::$APP->session->set('upload', ['waiting' => true, 'isPublic' => Application::$APP->model->isPublic()]);
                Application::$APP->response->redirect('/MyAccount');
            } elseif (Application::$APP->model->type() === 'saveFile') {
                Application::$APP->response->download(Application::$ROOT_DIR . '/public_html/tmp/' . Application::$APP->session->get('newCharacter')->fileOutput('/public_html/tmp/'));
                Application::$APP->model->reset();
                Application::$APP->session->setFlash('success', "Character downloaded!");
            } elseif (Application::$APP->model->type() === 'downloadPdf') {
                Application::$APP->response->download(Application::$ROOT_DIR . "/public_html/tmp/" . substr(Application::$APP->session->get('newCharacter')->file, 0, -4) . ".pdf");
                Application::$APP->model->reset();
                Application::$APP->session->setFlash('success', "PDF downloaded!");
            }
            Application::$APP->model->reset();
        }

        return $this->render('summary', $params);
    }
}
