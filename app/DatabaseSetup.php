<?php
class DatabaseSetup {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function createDatabaseAndTable() {
        $dbName = 'fdu';

        // Vérification si la base de données existe déjà
        $stmt = $this->db->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbName'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            // La base de données n'existe pas, nous la créons
            $sql = "CREATE DATABASE $dbName";
            $this->db->exec($sql);
            echo "Base de données '$dbName' créée avec succès.";

            // Sélection de la base de données nouvellement créée
            $this->db->exec("USE $dbName");

            // Création de la table des utilisateurs
            $sql = "CREATE TABLE IF NOT EXISTS utilisateurs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL
            )";
            $this->db->exec($sql);
            echo "Table des utilisateurs créée avec succès.";
        } else {
            echo "La base de données '$dbName' existe déjà.";
        }
    }
}
?>
