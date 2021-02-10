<?php
include('../db.php');
session_start();

if (isset($_POST["F_name"]) && isset($_POST["L_name"]) && isset($_POST["firm"]) && isset($_POST["email"]) && isset($_POST["role"]) ) {
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] == 'AD') {

            $f_name = mysqli_real_escape_string($mysqli, $_POST["F_name"]);
            $l_name = mysqli_real_escape_string($mysqli, $_POST["L_name"]);
            $company_name = mysqli_real_escape_string($mysqli, $_POST["firm"]);
            $email = mysqli_real_escape_string($mysqli, $_POST["email"]);
            $password = 'gefcotrnava';
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

                    echo '1$ User has been added.' .
                        '<br>- name: ' . '<strong>' . $_POST["F_name"] . '</strong>' .
                        '<br>- surname: ' . '<strong>' . $_POST["L_name"] . '</strong>' .
                        '<br>- company name: ' . '<strong>' . $_POST["firm"] . '</strong>' .
                        '<br>- email: ' . '<strong>' . $_POST["email"] . '</strong>' .
                        '<br>- password: ' . '<strong>' . $password . '</strong>' .
                        '<br>- role: ' . '<strong>' . $_POST["role"] . '</strong>';
                }else {
                    echo 'Wrong SQL server <strong>employee_AJAX/register_user.php</strong> .';
                }
            } else {
                echo 'Could not connect to the server. Please check your <strong>internet connection</strong>.';
            }
        } else {
            echo 'The data is not valid.';
        }
    }else{
        echo 'Please log <a href="../index.php">in</a>';
    }
}else{
    echo 'The data was not sent.';
}


