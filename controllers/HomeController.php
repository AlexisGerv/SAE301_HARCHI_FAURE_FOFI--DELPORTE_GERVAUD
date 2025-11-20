<?php
/**
 * HomeController - Contrôleur pour la page d'accueil
 */

class HomeController {
    
    /**
     * Afficher la page d'accueil
     */
    public function index() {
        $book = new Book();
        $recentBooks = $book->getAll(6, 0); // 6 livres les plus récents
        
        $category = new Category();
        $categories = $category->getAll();
        
        $data = [
            'title' => 'Accueil',
            'recentBooks' => $recentBooks,
            'categories' => $categories
        ];
        
        $this->render('home/index', $data);
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
