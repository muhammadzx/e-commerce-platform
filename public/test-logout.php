<?php

session_start();

unset($_SESSION["user_id"]);

header("Location: index.php?page=product&id=1");
exit;