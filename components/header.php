<?php
$username = $password = $confirm_password = "";
$username_err = $password_err = "";
$username_err_reg = $password_err_reg = $confirm_password_err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['confirm_password']) {
    if (empty(trim($_POST["username"]))) {
        $username_err_reg = "Пожалуйста, введите Ваш логин.";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err_reg = "Этот логин уже занят";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Что-то пошло не так";
            }
        }
        mysqli_stmt_close($stmt);
    }
    if (empty(trim($_POST["password"]))) {
        $password_err_reg = "Пожалуйста, введите Ваш пароль.";
    } elseif (strlen(trim($_POST["password"])) < 3) {
        $password_err_reg = "Пароль должен содержать больше 3 символов";
    } else {
        $password = trim($_POST["password"]);
    }
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Подтвердите пароль";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err_reg) && ($password != $confirm_password)) {
            $confirm_password_err = "Пароль не совпадает";
        }
    }
    if (empty($username_err_reg) && empty($password_err_reg) && empty($confirm_password_err)) {
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            if (mysqli_stmt_execute($stmt)) {
                session_start();
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username;
                header("location: tree.php");
            } else {
                echo "Что-то пошло не так";
            }
            $sql = "UPDATE users SET `rights`='user' WHERE `username`='$username'";
            mysqli_query($link,$sql);
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);  
}else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Пожалуйста, введите Ваш логин.";
    } else {
        $username = trim($_POST["username"]);
    }
    if (empty(trim($_POST["password"]))) {
        $password_err = "Пожалуйста, введите Ваш пароль.";
    } else {
        $password = trim($_POST["password"]);
    }
    if (trim($_POST["username"]) == "admin" && trim($_POST["password"]) == "admin") {
        header("location: admin.php");
        session_start();
        $_SESSION["admin"] = true;
    }
    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            header("location: tree.php");
                        } else {
                            $password_err = "Неправильный пароль.";
                        }
                    }
                } else {
                    $username_err = "Эта учетная запись не существует";
                }
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en" <?php if(!empty($username_err) || !empty($password_err)){echo 'style="overflow:hidden"';} ?>>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Familytree</title>
    <link rel="stylesheet" href="css/mystyles.css">
    <link rel="stylesheet" href="css/bulma-checkradio.min.css">
    <link rel="stylesheet" href="css/modal-fx.min.css">
    <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
    <link rel="manifest" href="images/favicon/site.webmanifest">
</head>

<body>
    <section class="section is-header" style="height: 50px; margin-top: -40px;">
        <div class="container">
            <nav id="navbar" class="bd-navbar navbar is-spaced is-fixed-top">
                <div class="container">
                    <div class="navbar-brand">
                        <a class="navbar-item" href="index.php"><img src="images/logo.png" alt="Brochure" width="112" height="28"></a>
                        <div id="navbarBurger" class="navbar-burger burger" data-target="navMenuDocumentation">
                            <span></span><span></span><span></span>
                        </div>
                    </div>
                    <div class="navbar-end">
                        <div class="navbar-item">
                            <?php
                            if ($logged == false) {
                            ?>
                                <a class="button modal-button" data-target="#login">
                                    <span class="icon has-text-info">
                                        <i class="far fa-user has-text-link"></i>
                                    </span>
                                    <span>Войти</span>
                                </a>
                            <?php
                            } else if ($logged == true) {
                            ?>
                                <div class="navbar-item has-dropdown is-hoverable">
                                    <a class="navbar-link" role="presentation">Мой аккаунт</a>
                                    <div class="navbar-dropdown"><a class="navbar-item" href="tree.php">Дерево</a><a class="navbar-item" href="settings.php">Настройки</a>
                                        <hr class="navbar-divider">
                                        <a class="navbar-item" href="logout.php">Выйти</a>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
        </div>
        </nav>
        </div>
    </section>
    <div id="#login" class="modal modal-fx-fadeInScale <?php if(!empty($username_err) || !empty($password_err)||!empty($password_err_reg)||!empty($username_err_reg)||!empty($confirm_password_err_reg)){echo 'is-active';} ?>">
        <div class="modal-background"></div>
        <div class="modal-content modal-card">
            <header class="modal-card-head">
                <nav class="tabs" style="margin-bottom: -1.25rem;flex-grow:1;">
                    <div class="container">
                        <ul>
                            <li class="tab is-active" onclick="openTab(event,'loginid')"><a>Войти</a></li>
                            <li class="tab" onclick="openTab(event,'regid')"><a>Зарегистрироваться</a></li>
                        </ul>
                    </div>
                </nav>
                <button class="modal-button-close delete" aria-label="close"></button>
            </header>
            <div id="loginid" class="content-tab">
                <section class="modal-card-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <?php if(!empty($password_err_reg)||!empty($username_err_reg)||!empty($confirm_password_err_reg)){echo '<span class="help is-danger">Регистрация не удалась</span>';} ?>
                        <div class="field">
                            <label class="label">Логин</label>
                            <div class="control has-icons-left has-icons-right">
                                <input type="text" class="input" name="username" placeholder="Username"><span class="help is-danger"><?php echo $username_err; ?></span>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Пароль</label>
                            <div class="control has-icons-left has-icons-right">
                                <input type="password" class="input" name="password" placeholder="Password">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-key"></i>
                                </span>
                            </div>
                        </div>
                        <br>
                        <div class="field is-grouped">
                            <div class="control">
                                <input class="button is-link" type="submit" name="signin" value="Войти" value="<?php echo md5($date . $ip); ?>"><span class="help is-danger"><?php echo $password_err; ?></span>
                            </div>
                        </div>
                    </form>
                </section>
                <footer class="modal-card-foot">
                    <a href="account-recovery.php" class="">Проблемы со входом в систему?</a>
                </footer>
            </div>
            <div id="regid" class="content-tab" style="display:none">
                <section class="modal-card-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="field">
                            <label class="label">Логин</label>
                            <div class="control has-icons-left has-icons-right">
                                <input type="text" class="input" name="username" placeholder="Username"><span class="help is-danger"><?php echo $username_err_reg; ?></span>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                        </div>
                       
                        <div class="field">
                            <label class="label">Пароль</label>
                            <div class="control has-icons-left has-icons-right">
                                <input type="password" class="input" name="password" placeholder="Password"><span class="help is-danger"><?php echo $password_err_reg; ?></span>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-key"></i>
                                </span>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Подтвердите пароль</label>
                            <div class="control has-icons-left has-icons-right">
                                <input type="password" class="input" name="confirm_password" placeholder="Password"><span class="help is-danger"><?php echo $confirm_password_err; ?></span>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-key"></i>
                                </span>
                            </div>
                        </div>
                        <br>
                        <div class="field is-grouped">
                            <div class="control">
                                <input class="button is-link" type="submit" name="signup" value="Зарегистрироваться" value="<?php echo md5($date . $ip); ?>">
                            </div>
                        </div>
                    </form>
                </section>
                <footer class="modal-card-foot">
                    <a href="account-recovery.php" class="">Проблемы со входом в систему?</a>
                </footer>
            </div>
        </div>
    </div>