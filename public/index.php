<?php
/**
 * Point d'entrée principal de l'application
 * Router pour diriger les requêtes vers les contrôleurs appropriés
 */

// Démarrer la session
session_start();

// Charger la configuration
require_once __DIR__ . '/../config/config.php';

// Charger les modèles
require_once MODELS_PATH . '/Database.php';
require_once MODELS_PATH . '/User.php';
require_once MODELS_PATH . '/Book.php';
require_once MODELS_PATH . '/Loan.php';
require_once MODELS_PATH . '/Category.php';

// Charger les contrôleurs
require_once CONTROLLERS_PATH . '/HomeController.php';
require_once CONTROLLERS_PATH . '/BookController.php';
require_once CONTROLLERS_PATH . '/LoanController.php';
require_once CONTROLLERS_PATH . '/AuthController.php';

// Récupérer la page demandée
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Routeur simple
try {
    switch ($page) {
        case 'home':
            $controller = new HomeController();
            $controller->index();
            break;
            
        case 'books':
            $controller = new BookController();
            if ($action === 'search') {
                $controller->search();
            } elseif ($action === 'create') {
                $controller->create();
            } elseif ($action === 'store') {
                $controller->store();
            } else {
                $controller->index();
            }
            break;
            
        case 'book':
            $controller = new BookController();
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            $controller->show($id);
            break;
            
        case 'loans':
            $controller = new LoanController();
            $controller->index();
            break;
            
        case 'loan':
            $controller = new LoanController();
            if ($action === 'create') {
                $bookId = isset($_GET['book_id']) ? (int)$_GET['book_id'] : 0;
                $controller->create($bookId);
            } elseif ($action === 'return') {
                $loanId = isset($_GET['loan_id']) ? (int)$_GET['loan_id'] : 0;
                $controller->return($loanId);
            }
            break;
            
        case 'login':
            $controller = new AuthController();
            $controller->login();
            break;
            
        case 'authenticate':
            $controller = new AuthController();
            $controller->authenticate();
            break;
            
        case 'register':
            $controller = new AuthController();
            if ($action === 'store') {
                $controller->store();
            } else {
                $controller->register();
            }
            break;
            
        case 'logout':
            $controller = new AuthController();
            $controller->logout();
            break;
            
        default:
            $controller = new HomeController();
            $controller->index();
            break;
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    echo "Une erreur s'est produite. Veuillez réessayer.";
}
