<?php

namespace app\core;

use app\core\db\Database;

class Application
{
    public static string $ROOT_DIR;
    public static Application $APP;
    public static string $LAYOUT_MAIN = 'main';

    public ?string $userClass = null;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public ?Database $db = null;
    public ?Controller $controller = null;
    public ?UserModel $user = null;
    public ?Model $model = null;
    public View $view;

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$APP = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->session = new Session();
        $this->view = new View();

        $this->db = new Database($config['db']);
        $primaryValue = $this->session->get('user');

        if ($primaryValue) {
            $primaryKey = $this->{$this->userClass}?->primaryKey();
            $this->user = $this->{$this->userClass}?->findOne([$primaryKey => $primaryValue]);
        }
    }

    public static function isGuest(): bool
    {
        return !self::$APP->session->get('user');
    }

    public static function isAdmin(): bool
    {
        if (self::$APP->isGuest()) {
            return false;
        } elseif (self::$APP->session->get('user')['isAdmin']) {
            return true;
        }
        return false;
    }

    public function login(UserModel $user): void
    {
        $this->user = $user;
        $primaryKey = $this->user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', [
            'primaryKey' => $primaryKey,
            'primaryValue' => $primaryValue,
            'displayName' => $user->getDisplayName(),
            'email' => $user->email,
            'isAdmin' => $user->isAdmin()
        ]);
    }

    public function logout(): void
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }
}
