<?php

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $phone = $_POST["phone"];
    $bday = $_POST["bday"];
    $role = "user";

    

    try {
        require_once "dbh.inc.php";

        //Creare cos
        $queryCos = "INSERT INTO cos (isBought) VALUES (0)";
        $pdo->exec($queryCos);
        $id_cos = $pdo->lastInsertId();

        $query = "INSERT INTO user (fname, lname, email, password, phone, bday, role, id_cos) VALUES (:fname, :lname, :email, :pwd, :phone, :bday, :role, :id_cos);";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":fname", $fname);
        $stmt->bindParam(":lname", $lname);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":pwd", $pwd);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":bday", $bday);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":id_cos", $id_cos);

        $stmt->execute();

        session_start();
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['user_fname'] = $fname;
        $_SESSION['user_lname'] = $lname;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_phone'] = $phone;
        $_SESSION['user_bday'] = $bday;
        $_SESSION['user_role'] = $role;
        $_SESSION['user_cos'] = $id_cos;

        $pdo = null;
        $stmt = null;

        header("Location: ../index.php");

        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
else {
    header("Location: ../index.php");
}