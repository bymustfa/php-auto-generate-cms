<?php

namespace Core;

use Buki\Router\Router;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Pagination\Paginator;

//use Valitron\Validator;
use Arrilot\DotEnv\DotEnv;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;
use Core\Mail;
use Core\Token;


class Bootstrap
{

    public $router;
    public $validator;
    public $mailler;
    public $token;

    public function __construct()
    {
        DotEnv::load(dirname(__DIR__) . '/ENV/.env.php');
        $whoops = new Run();
        $whoops->pushHandler(new PrettyPageHandler());
//        if (config('DEVELOPMENT')) {
//            $whoops->register();
//        }


        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => config('DB_HOST', 'localhost'),
            'database' => config('DB_NAME'),
            'username' => config('DB_USER'),
            'password' => config('DB_PASSWORD'),
            'charset' => config('DB_CHARSET', 'utf8mb4'),
            'collation' => config('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'options' => [
                \PDO::ATTR_EMULATE_PREPARES => true
            ]
        ]);
        Paginator::useBootstrap();
        $capsule->setAsGlobal();
        $capsule->bootEloquent();


        $this->router = new Router([
            'paths' => [
                'controllers' => 'App/Controllers',
                'middlewares' => 'App/Middlewares'
            ],
            'namespaces' => [
                'controllers' => 'App\Controllers',
                'middlewares' => 'App\Middlewares'
            ]
        ]);


        $this->mailler = new Mail();
        $this->token = new Token();


    }


    public function run()
    {
        $this->router->run();
    }

}


?>
