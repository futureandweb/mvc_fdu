<?php
class AuthController {
    private UserModel $userModel;

    public function __construct(UserModel $userModel) {
        $this->userModel = $userModel;
    }

    public function showLogin() {
        // Afficher la page de connexion (view/login.php)
        include 'app/view/login.php';
    }

   // gestion d'un message de connexion réussie
    public function processLogin() {
    // Vérifiez les informations de connexion et effectuez les vérifications nécessaires ici
        // Récupérez les données du formulaire
        $username = $_POST['username'];
        $password = $_POST['password'];

    if ($this->userModel->validateUser($username,$password)) {
        $_SESSION['message'] = "Connexion réussie ! Bienvenue.";
    } else {
        $_SESSION['message'] = "Échec de la connexion. Veuillez réessayer.";
    }

    header("Location: index.php?page=login");
    exit;
    }


    public function showRegister() {
        // Afficher la page d'inscription (view/register.php)
        include 'app/view/register.php';
    }

    // AuthController.php - Logique d'inscription
    public function processRegister() {
        echo 'test';
       
        // Récupérez les données du formulaire
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Vérifiez si l'utilisateur existe déjà dans la base de données
        if ($this->userModel->userExists($username)) {
            $_SESSION['message'] = "Ce nom d'utilisateur est déjà utilisé. Veuillez en choisir un autre.";
        } else {
            
            // Enregistrez l'utilisateur dans la base de données
            if ($this->userModel->addUser($username, $password)) {
                $_SESSION['message'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            } else {
                $_SESSION['message'] = "Échec de l'inscription. Veuillez réessayer.";
            }
        }

        header("Location: index.php?page=register");
        exit;
    }



    public function showHome() {
        // Afficher la page d'accueil (view/home.php)
        include 'app/view/home.php';
    }
}
?>
