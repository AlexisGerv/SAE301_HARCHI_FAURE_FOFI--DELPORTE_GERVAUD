<?php
/**
 * AuthController - Contrôleur pour l'authentification
 */

class AuthController {
    
    /**
     * Afficher le formulaire de connexion
     */
    public function login() {
        $data = ['title' => 'Connexion'];
        $this->render('auth/login', $data);
    }
    
    /**
     * Traiter la connexion
     */
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $user = new User();
            if ($user->authenticate($email, $password)) {
                $_SESSION['user'] = [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'nom' => $user->getNom(),
                    'prenom' => $user->getPrenom(),
                    'role' => $user->getRole()
                ];
                header('Location: ' . BASE_URL . '/public/index.php');
            } else {
                header('Location: ' . BASE_URL . '/public/index.php?page=login&error=1');
            }
        }
    }
    
    /**
     * Afficher le formulaire d'inscription
     */
    public function register() {
        $data = ['title' => 'Inscription'];
        $this->render('auth/register', $data);
    }
    
    /**
     * Traiter l'inscription
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User();
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            $user->setNom($_POST['nom']);
            $user->setPrenom($_POST['prenom']);
            $user->setRole('etudiant');
            $user->setActif(true);
            
            if ($user->create()) {
                $_SESSION['user'] = [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'nom' => $user->getNom(),
                    'prenom' => $user->getPrenom(),
                    'role' => $user->getRole()
                ];
                header('Location: ' . BASE_URL . '/public/index.php');
            } else {
                header('Location: ' . BASE_URL . '/public/index.php?page=register&error=1');
            }
        }
    }
    
    /**
     * Déconnexion
     */
    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL . '/public/index.php');
    }
    
    /**
     * Rendre une vue
     * @param string $view
     * @param array $data
     */
    protected function render($view, $data = []) {
        extract($data);
        $viewPath = VIEWS_PATH . '/' . $view . '.php';
        
        if (file_exists($viewPath)) {
            require_once VIEWS_PATH . '/layouts/header.php';
            require_once $viewPath;
            require_once VIEWS_PATH . '/layouts/footer.php';
        } else {
            die("Vue non trouvée : $view");
        }
    }
}
