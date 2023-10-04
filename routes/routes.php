<?php
$page = isset($_GET['page']) ? $_GET["page"] : "dashboard";

if ($page == 'dashboard') {
	require_once 'views/dashboard.php';
} else if ($page == 'judges') {
	require_once 'views/judges.php';
} else if ($page == 'users') {
	require_once 'views/users.php';
} else {
	require_once 'views/404.php';
}
