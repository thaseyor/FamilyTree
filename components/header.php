<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Brochure</title>
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
    <div id="#login" class="modal modal-fx-fadeInScale">
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
                    <form method="POST" action="login.php">
                        <div class="field">
                            <label class="label">Логин</label>
                            <div class="control has-icons-left has-icons-right">
                                <input type="text" class="input" name="username" placeholder="Username">
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
                                <input class="button is-link" type="submit" name="signin" value="Войти" value="<?php echo md5($date . $ip); ?>">
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
                    <form method="POST" action="register.php">
                        <div class="field">
                            <label class="label">Логин</label>
                            <div class="control has-icons-left has-icons-right">
                                <input type="text" class="input" name="username" placeholder="Username">
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
                        <div class="field">
                            <label class="label">Подтвердите пароль</label>
                            <div class="control has-icons-left has-icons-right">
                                <input type="password" class="input" name="confirm_password" placeholder="Password">
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