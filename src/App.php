<?php
//require_once './Controller/UserController.php';
//require_once './Controller/ProductController.php';
//require_once './Controller/CartController.php';
//require_once './Controller/FavoriteController.php';
class App
{
    private array $routes = [
        '/login' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getLogin'],
            'POST' => [
                'class' => 'UserController',
                'method' => 'login']
        ],
        '/registration' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getRegistrate'
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'registrate']
        ],
        '/main' => [
            'GET' => [
                'class' => 'ProductController',
                'method' => 'getAll'
            ]
        ],
        '/logout' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'logout'
            ]
        ],
        '/add-product' => [
            'GET' => [
                'class' => 'CartController',
                'method' => 'getaddProduct'
            ],
            'POST' => [
                'class' => 'CartController',
                'method' => 'addProduct'
            ]
        ],
        '/cart' => [
            'GET' => [
                'class' => 'CartController',
                'method' => 'getUserCart'
            ]
        ],
        '/add-favorite' => [
            'GET' => [
                'class' => 'FavoriteController',
                'method' => 'getAddFavorite'
            ],
            'POST' => [
                'class' => 'FavoriteController',
                'method' => 'addFavorite'
            ]
        ],
        '/favorite' =>[
            'GET' => [
                'class' => 'FavoriteController',
                'method' => 'getUserFavorite'
                ]
        ]
    ];

    public function run()
    {

        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        $route = $this->routes[$requestUri][$requestMethod];
        $class = $route['class'];
        $method = $route['method'];
        $controller = new $class();
        $controller->$method();


    }
}

//switch ($requestUri)
//{
//    case '/login':
//        if ($requestMethod === 'GET') {
//            $userController = new UserController();
//            $userController->getLogin();
//        }
//        elseif ($requestMethod === 'POST') {
//            $user = new UserController();
//            $user->login();
//        } else {"Для адреса $requestUri метод $requestMethod не поддерживается" ;}
//        break;
//    case '/registration':
//        if ($requestMethod === 'GET') {
//            $userController = new UserController();
//            $userController->getRegistrate();
////             require_once './get_registration.php';
//        }
//        elseif ($requestMethod === 'POST') {
//            $userController = new UserController();
//            $userController->registrate();
////             require_once './post_registration.php';
//        } else {"Для адреса $requestUri метод $requestMethod не поддерживается" ;}
//        break;
//    case '/main': if ($requestMethod === 'GET') {
//        $product = new ProductController();
//        $product->getAll();
//    }
//    else {"Для адреса $requestUri метод $requestMethod не поддерживается" ;}
//        break;
//    case '/logout':
//        require_once './../View/logout.php';
//        break;
//    case '/add-product':
//        if ($requestMethod === 'GET') {
//            $product = new CartController();
//            $product->getAddProduct();
//        } elseif ($requestMethod === 'POST') {
//            $product = new CartController();
//            $product->addProduct();
//        }
//        else {"Для адреса $requestUri метод $requestMethod не поддерживается" ;}
//        break;
//
//    case '/cart':
//        if ($requestMethod === 'GET') {
//            $cartController = new CartController();
//
//            $cartController->getUserCart();
//        }break;
//
//    case '/add-favorite':
//        if ($requestMethod === 'GET') {
//            $product = new FavoriteController();
//            $product->getAddFavorite();
//        } elseif ($requestMethod === 'POST') {
//            $product = new FavoriteController();
//            $product->addFavorite();
//        }
//        else {"Для адреса $requestUri метод $requestMethod не поддерживается" ;}
//        break;
//
//    case '/favorite':
//        if ($requestMethod === 'GET') {
//            $favoriteController = new FavoriteController();
//
//            $favoriteController->getUserFavorite();
//        }
//        break;
//
//
//    default: require_once './../View/404.php'; break;
//
//
