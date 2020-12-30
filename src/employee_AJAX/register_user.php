<?php
include('../db.php');

if (isset($_POST["F_name"]) && isset($_POST["L_name"]) && isset($_POST["firm"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["role"]) ) {
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] == 'AD') {

            $f_name = mysqli_real_escape_string($mysqli, $_POST["F_name"]);
            $l_name = mysqli_real_escape_string($mysqli, $_POST["L_name"]);
            $company_name = mysqli_real_escape_string($mysqli, $_POST["firm"]);
            $email = mysqli_real_escape_string($mysqli, $_POST["email"]);
            $password = mysqli_real_escape_string($mysqli, $_POST["password"]);
            $role = mysqli_real_escape_string($mysqli, $_POST["role"]);
            if (!$mysqli->connect_errno) {
                $sql = "INSERT INTO employee SET 
                            meno='{$f_name}',
                            priezvisko='{$l_name}', 
                            meno_splocnosti='{$company_name}', 
                            email='{$email}',
                            heslo=MD5('{$password}'), 
                            role='{$role}'";
                if ($result = $mysqli->query($sql)) {

                    echo '1$ Používateľ bol pridaný ' .
                        '<br> meno : ' . '<strong>' . $_POST["F_name"] . '</strong>' .
                        '<br> priezvisko : ' . '<strong>' . $_POST["L_name"] . '</strong>' .
                        '<br> meno splocnosti : ' . '<strong>' . $_POST["firm"] . '</strong>' .
                        '<br> email : ' . '<strong>' . $_POST["email"] . '</strong>' .
                        '<br> heslo : ' . '<strong>' . $_POST["password"] . '</strong>' .
                        '<br> rola : ' . '<strong>' . $_POST["role"] . '</strong>';
                }else {
                    echo 'Chyba sql <strong>employee_AJAX/register_user.php</strong> '.$sql;
                }
            } else {
                echo 'Nepodarilo sa spojit so serverom ';
            }
        } else {
            echo 'Not valid user';
        }
    }else{
        echo 'Please log <a href="../index.php">in</a>';
    }
}else{
    echo 'Neboli poslane data  ';
}


