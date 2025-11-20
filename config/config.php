<?php
/**
 * Configuration générale de l'application
 */

// Configuration de l'application
define('SITE_NAME', 'Bibliothèque IUT Dijon');
define('BASE_URL', 'http://localhost/SAE310_Labille');

// Chemins
define('ROOT_PATH', dirname(__DIR__));
define('MODELS_PATH', ROOT_PATH . '/models');
define('VIEWS_PATH', ROOT_PATH . '/views');
define('CONTROLLERS_PATH', ROOT_PATH . '/controllers');

// Configuration de session
define('SESSION_TIMEOUT', 3600); // 1 heure

// Timezone
date_default_timezone_set('Europe/Paris');

// Chargement de la configuration de la base de données
if (file_exists(__DIR__ . '/database.php')) {
    require_once __DIR__ . '/database.php';
}
