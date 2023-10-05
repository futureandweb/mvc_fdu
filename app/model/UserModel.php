<?php
class UserModel {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function addUser(string $username, string $password): bool {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO utilisateurs (username, password) VALUES (?, ?)");
        return $stmt->execute([$username, $hashedPassword]);
    }

    public function validateUser(string $username, string $password): bool {
        $stmt = $this->db->prepare("SELECT password FROM utilisateurs WHERE username = ?");
        $stmt->execute([$username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['password'])) {
            return true;
        }
        return false;
    }

    // UserModel.php - Méthode pour vérifier si un utilisateur existe
    public function userExists($username) {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM utilisateurs WHERE username = ?");
            $stmt->execute([$username]);

            // Récupérez le nombre de lignes résultat
            $count = $stmt->fetchColumn();

            // Si $count est supérieur à zéro, l'utilisateur existe déjà
            return $count > 0;
        } catch (PDOException $e) {
            // Gérez les erreurs de la base de données ici
            // Vous pouvez enregistrer les erreurs dans un journal ou renvoyer une exception personnalisée
            return false;
        }
    }

}
?>
