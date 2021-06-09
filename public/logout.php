<?php
session_destroy();
unset($_SESSION['logado']);
header('Location: login.php');
