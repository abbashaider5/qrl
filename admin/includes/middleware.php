<?php
session_start();
function ensure_authenticated() {
    if (empty($_SESSION['admin_id'])) {
        header('Location: /qlr/admin/signin');
        exit;
    }
}
