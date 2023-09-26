<?php
require_once '../app/phpmailer/Exception.php';
require_once '../app/phpmailer/PHPMailer.php';
require_once '../app/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPmailer;

class UserModel extends Model {
    
    // Envoyer un mail
    public function sendmail(string $to, string $subject, string $body) : void {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = 'emailgmail.com';
            $mail->Password = '';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('email@gmail.com');
            $mail->addAddress($to); 
            $mail->isHTML(true);                                 
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->send();
        } catch (Exception $e) {
            throw new Exception("Erreur d'envoi de mail.");
        }
    }

    // Vérifier l'e-mail et le mot de passe pour connecter l'utilisateur
    public function loginVerif(string $email, string $password): void
    {
        try {
            $query = $this->pdo->prepare("SELECT * FROM user WHERE email = :email;");
            $query->execute([':email' => $email]);
            $user = $query->fetch();
            if (!empty($user)) {
                if (password_verify($password, $user['password'])) {
                    // Connexion de l'utilisateur confirmé
                    $_SESSION['user'] = $user;
                    // Supprimer le token lors de la connexion
                    $query = $this->pdo->prepare("UPDATE user SET token = :token, token_date = :token_date WHERE id_user = :id;");
                    $query->execute([
                    ':token' => null,    
                    ':token_date' => null,
                    ':id' => $user['id_user']
                    ]);
                } else {
                    throw new Exception("Mot de passe incorrect.");
                }
            } else {
                throw new Exception("E-mail inexistant.");
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur de la base de données.");
        }
    }

    // Ajouter l'utilisateur à la base de donnée
    public function addUser(string $name, string $first_name, string $email) : void
    {
        try {
            $query = "SELECT * FROM user WHERE email = :email;";
            $query = $this->pdo->prepare($query);
            $query->execute([
                ':email' => $email
            ]);
            $user = $query->fetchAll();
            if (!empty($user)) {
                throw new Exception("Vous êtes déjà inscrit.");
            } else {
                $token = bin2hex(random_bytes(16));
                $token_date = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime(date("Y-m-d H:i:s"))));
                $query = "INSERT INTO user SET name = :name, first_name = :first_name, email = :email, token = :token, token_date = :token_date;";
                $query = $this->pdo->prepare($query);
                $query->execute([
                    ':name' => $name,
                    ':first_name' => $first_name,
                    ':email' => $email,
                    ':token' => $token,
                    ':token_date' => $token_date
                ]);
                // Récupérer l'id de l'utilisateur qui vient de s'inscrire
                $id_user = $this->pdo->lastInsertId();
                $url = "http://localhost/superbowl/index.php?user/tokenverif/$id_user/$token";
                $this->sendmail(
                    $email, 
                    'Veuillez confirmer votre inscription.',
                    "Pour confirmer votre inscription veuillez cliquer sur ce lien : <a href='$url'>$url</a>."
                );
            }
        } catch (PDOExcpetion $e) {
            throw new Exception("Erreur de la base de données.");
        }
    }

    // Vérifier le token de l'utilisateur pour accéder à sa demande
    public function tokenVerif(int $id, string $token): bool
    {
        try {
            $query = "SELECT * FROM user WHERE id_user = :id AND token = :token;";
            $query = $this->pdo->prepare($query);
            $query->execute([
                ':id' => $id,
                ':token' => $token
            ]);
            $user = $query->fetch();
            if(!empty($user)) {
                if ($user['token'] > date("Y-m-d H:i:s")) {
                    return true;
                } else {
                    return false;
                }
            } else {
                throw new Exception("Utilisateur inexistant.");
                return false;
            }
            
        } catch (PDOException $e) {
            throw new Exception("Erreur de la base de données.");
        }
    }

    // Ajouter un mot de passe pour l'utilisateur
    public function addPassword(int $id, string $password) : void
    {
        try {
            $query = $this->pdo->prepare("UPDATE user SET password = :password WHERE id_user = :id;");
            $query->execute([
            ':id' => $id,
            ':password' => password_hash($password, PASSWORD_DEFAULT)
            ]);
        } catch (PDOEXception $e) {
            throw new Exception("Erreur de la base de données.");
        }
    }

    // Envoyer un e-mail de réinitialisation de mot de passe
    public function newPassword(string $name, string $first_name, string $email) : void
    {
        try {
            $query = $this->pdo->prepare("SELECT * FROM user WHERE name = :name AND first_name = :first_name AND email = :email;");
            $query->execute([
                ':name' => $name,
                ':first_name' => $first_name,
                ':email' => $email
            ]);
            $user = $query->fetch();
            if (!empty($user)) {
                $token = bin2hex(random_bytes(16));
                $token_date = date("Y-m-d H:i:s", strtotime("+10 minutes", strtotime(date("Y-m-d H:i:s"))));
                $id_user = $user['id_user'];
                $url = "http://localhost/superbowl/index.php?user/tokenverif/$id_user/$token";
                $query = $this->pdo->prepare("UPDATE user SET token = :token, token_date = :token_date WHERE id_user = $id_user;");
                $query->execute([
                    ':token' => $token,
                    ':token_date' => $token_date
                ]);
                $this->sendmail(
                    $email, 
                    'Nouveau mot de passe',
                    "Pour réinitialiser votre mot de passe veuillez cliquer sur ce lien : <a href='$url'>$url</a>"
                );
            } else {
                throw new Exception("Utilisateur introuvable.");
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur de la base de données.");
        }  
    }
}