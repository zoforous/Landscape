<?php
require_once '../includes/functions.php';

session_unset();
session_destroy();

redirect('../index.php');