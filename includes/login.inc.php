<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    require_once "dbh.inc.php";

    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    try {
        // Caută utilizatorul în baza de date
        $query = "SELECT * FROM user WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $pwd === $user["password"]) {
            // LOGIN reușit
            $_SESSION["user_id"] = $user["id_user"];
            $_SESSION["user_fname"] = $user["fname"];
            $_SESSION["user_lname"] = $user["lname"];
            $_SESSION["user_email"] = $user["email"];
            $_SESSION["user_phone"] = $user["phone"];
            $_SESSION["user_bday"] = $user["bday"];
            $_SESSION["user_role"] = $user["role"];

            header("Location: ../profile.php");
            exit();
        } else {
            $_SESSION["login_error"] = "Email sau parolă incorectă.";
            header("Location: ../login.php");
            exit();
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    header("Location: ../profile.php");
    exit();
}
?>
