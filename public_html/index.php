<?php

use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;
use app\controllers\AdminController;

require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
  'userClass' => \app\models\User::class,
  'db' => [
    'dsn' => $_ENV['DB_DSN'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD']
  ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/AboutMe', [SiteController::class, 'about']);
$app->router->post('/AboutMe', [SiteController::class, 'about']);
$app->router->get('/CreateNewCharacter', [SiteController::class, 'createNewChar']);
$app->router->post('/CreateNewCharacter', [SiteController::class, 'createNewChar']);
$app->router->get('/CreateNewCharacter/AddAttacks', [SiteController::class, 'addAttack']);
$app->router->post('/CreateNewCharacter/AddAttacks', [SiteController::class, 'addAttack']);
$app->router->get('/CreateNewCharacter/AddEquipment', [SiteController::class, 'addEquipment']);
$app->router->post('/CreateNewCharacter/AddEquipment', [SiteController::class, 'addEquipment']);
$app->router->get('/CreateNewCharacter/AddFeatures', [SiteController::class, 'addFeatures']);
$app->router->post('/CreateNewCharacter/AddFeatures', [SiteController::class, 'addFeatures']);
$app->router->get('/CreateNewCharacter/Summary', [SiteController::class, 'summary']);
$app->router->post('/CreateNewCharacter/Summary', [SiteController::class, 'summary']);

$app->router->get('/Register', [AuthController::class, 'register']);
$app->router->post('/Register', [AuthController::class, 'register']);
$app->router->get('/Login', [AuthController::class, 'login']);
$app->router->post('/Login', [AuthController::class, 'login']);
$app->router->get('/MyAccount', [AuthController::class, 'userAccount']);
$app->router->post('/MyAccount', [AuthController::class, 'userAccount']);
$app->router->get('/MyAccount/Upload', [AuthController::class, 'upload']);
$app->router->post('/MyAccount/Upload', [AuthController::class, 'upload']);
$app->router->get('/MyAccount/CharacterSearch', [AuthController::class, 'characterSearch']);
$app->router->post('/MyAccount/CharacterSearch', [AuthController::class, 'characterSearch']);
$app->router->get('/MyAccount/MyProfile', [AuthController::class, 'userProfile']);
$app->router->post('/MyAccount/MyProfile', [AuthController::class, 'userProfile']);
$app->router->get('/MyAccount/Logout', [AuthController::class, 'logout']);
$app->router->post('/MyAccount/Logout', [AuthController::class, 'logout']);
$app->router->get('/MyAccount/MyProfile/ResetPassword', [AuthController::class, 'resetPassword']);
$app->router->post('/MyAccount/MyProfile/ResetPassword', [AuthController::class, 'resetPassword']);

$app->router->get('/Admin', [AdminController::class, 'admin']);
$app->router->post('/Admin', [AdminController::class, 'admin']);
$app->router->get('/Admin/UserSearch', [AdminController::class, 'userSearch']);
$app->router->post('/Admin/UserSearch', [AdminController::class, 'userSearch']);
$app->router->get('/Admin/UserProfile', [AdminController::class, 'userProfile']);
$app->router->post('/Admin/UserProfile', [AdminController::class, 'userProfile']);

$app->run();