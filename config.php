<?php
/**
 * 配置文件
 */
session_start();
if(empty($_SESSION['loginStatus']['status']) || !$_SESSION['loginStatus']['status']) {
    header('Location:/login.php');// 跳转到登录页面
    exit;
}