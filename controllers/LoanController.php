<?php
/**
 * LoanController - Contrôleur pour la gestion des emprunts
 */

class LoanController {
    
    /**
     * Lister tous les emprunts
     */
    public function index() {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/public/index.php?page=login');
            exit;
        }
        
        $loan = new Loan();
        
        // Si l'utilisateur est étudiant, afficher seulement ses emprunts
        if ($_SESSION['user']['role'] === 'etudiant') {
            $loans = $loan->getByUser($_SESSION['user']['id']);
        } else {
            // Admin et bibliothécaire voient tous les emprunts
            $loans = $loan->getAll();
        }
        
        $data = [
            'title' => 'Mes emprunts',
            'loans' => $loans
        ];
        
        $this->render('loans/index', $data);
    }
    
    /**
     * Créer un nouvel emprunt
     * @param int $bookId
     */
    public function create($bookId) {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/public/index.php?page=login');
            exit;
        }
        
        $book = new Book();
        if ($book->read($bookId) && $book->isAvailable()) {
            $loan = new Loan();
            $loan->setUserId($_SESSION['user']['id']);
            $loan->setBookId($bookId);
            
            // Date de retour prévue : 2 semaines
            $dateRetour = date('Y-m-d H:i:s', strtotime('+2 weeks'));
            $loan->setDateRetourPrevue($dateRetour);
            $loan->setStatut('en_cours');
            
            if ($loan->create()) {
                $book->decrementAvailable();
                header('Location: ' . BASE_URL . '/public/index.php?page=loans&success=1');
            } else {
                header('Location: ' . BASE_URL . '/public/index.php?page=book&id=' . $bookId . '&error=1');
            }
        } else {
            header('Location: ' . BASE_URL . '/public/index.php?page=books');
        }
    }
    
    /**
     * Retourner un livre
     * @param int $loanId
     */
    public function return($loanId) {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/public/index.php?page=login');
            exit;
        }
        
        $loan = new Loan();
        if ($loan->read($loanId)) {
            // Vérifier que l'emprunt appartient à l'utilisateur ou que c'est un admin/bibliothécaire
            if ($loan->getUserId() == $_SESSION['user']['id'] || 
                in_array($_SESSION['user']['role'], ['admin', 'bibliothecaire'])) {
                
                if ($loan->returnBook()) {
                    $book = new Book();
                    $book->read($loan->getBookId());
                    $book->incrementAvailable();
                    header('Location: ' . BASE_URL . '/public/index.php?page=loans&returned=1');
                } else {
                    header('Location: ' . BASE_URL . '/public/index.php?page=loans&error=1');
                }
            }
        }
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
