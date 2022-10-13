<?php

require 'app/config.php';

session_start();

destruir_sesion();

header('Location: ' . URL . 'login.php');

die;
