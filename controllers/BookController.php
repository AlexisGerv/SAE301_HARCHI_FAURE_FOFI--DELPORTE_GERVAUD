<?php
/**
 * BookController - Contrôleur pour la gestion des livres
 */

class BookController {
    
    /**
     * Lister tous les livres
     */
    public function index() {
        $book = new Book();
        $books = $book->getAll();
        
        $data = [
            'title' => 'Catalogue des livres',
            'books' => $books
        ];
        
        $this->render('books/index', $data);
    }
    
    /**
     * Afficher les détails d'un livre
     * @param int $id
     */
    public function show($id) {
        $book = new Book();
        if ($book->read($id)) {
            $data = [
                'title' => $book->getTitre(),
                'book' => $book
            ];
            $this->render('books/show', $data);
        } else {
            header('Location: ' . BASE_URL . '/public/index.php?page=books');
        }
    }
    
    /**
     * Rechercher des livres
     */
    public function search() {
        $search = isset($_GET['q']) ? $_GET['q'] : '';
        
        $book = new Book();
        $books = $book->search($search);
        
        $data = [
            'title' => 'Résultats de recherche',
            'books' => $books,
            'search' => $search
        ];
        
        $this->render('books/search', $data);
    }
    
    /**
     * Afficher le formulaire de création
     */
    public function create() {
        // Vérifier que l'utilisateur est admin ou bibliothécaire
        if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['admin', 'bibliothecaire'])) {
            header('Location: ' . BASE_URL . '/public/index.php');
            exit;
        }
        
        $category = new Category();
        $categories = $category->getAll();
        
        $data = [
            'title' => 'Ajouter un livre',
            'categories' => $categories
        ];
        
        $this->render('books/create', $data);
    }
    
    /**
     * Traiter la création d'un livre
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $book = new Book();
            $book->setIsbn($_POST['isbn']);
            $book->setTitre($_POST['titre']);
            $book->setAuteur($_POST['auteur']);
            $book->setEditeur($_POST['editeur']);
            $book->setAnneePublication($_POST['annee_publication']);
            $book->setCategoryId($_POST['category_id']);
            $book->setNombreExemplaires($_POST['nombre_exemplaires']);
            $book->setNombreDisponibles($_POST['nombre_exemplaires']);
            $book->setDescription($_POST['description']);
            
            if ($book->create()) {
                header('Location: ' . BASE_URL . '/public/index.php?page=books&success=1');
            } else {
                header('Location: ' . BASE_URL . '/public/index.php?page=books&action=create&error=1');
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
