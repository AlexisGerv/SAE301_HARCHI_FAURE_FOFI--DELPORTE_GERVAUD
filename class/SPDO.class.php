<?php

require_once __DIR__ . '/../modeles/connect.php';

class SPDO
{
  private ?PDO $PDOInstance = null;
  private static ?SPDO $instance = null;

  // Tes identifiants adaptés (ne pas copier ceux du tuto)
  const DEFAULT_SQL_USER = 'root';
  const DEFAULT_SQL_HOST = 'localhost';
  const DEFAULT_SQL_PASS = '';
  const DEFAULT_SQL_DTB = 'bibliotheque';

  private function __construct()
  {
    try {
        $this->PDOInstance = new PDO(
            'mysql:dbname='.self::DEFAULT_SQL_DTB.';host='.self::DEFAULT_SQL_HOST,
            self::DEFAULT_SQL_USER,
            self::DEFAULT_SQL_PASS
        );
        $this->PDOInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // La ligne magique pour ton pote si besoin :
        $this->PDOInstance->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false); 
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
  }

  // Crée l'instance unique si elle n'existe pas, sinon la renvoie
  public static function getInstance(): SPDO
  {
    if (is_null(self::$instance)) {
      self::$instance = new SPDO();
    }
    return self::$instance;
  }

  // Cette méthode est cruciale car tes Managers attendent un objet PDO, pas un objet SPDO
  public function getPDO(): PDO
  {
      return $this->PDOInstance;
  }
}