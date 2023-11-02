<?php
$page = isset($_GET['page']) ? $_GET["page"] : "dashboard";

if ($page == 'dashboard') {
	require_once 'views/dashboard.php';
} else if ($page == 'events') {
	require_once 'views/events.php';
} else if ($page == 'event-category') {
	require_once 'views/event_category.php';
} else if ($page == 'event-details') {
	require_once 'views/event_details.php';
} else if ($page == 'judge-events') {
	require_once 'views/judge_events.php';
} else if ($page == 'judges') {
	require_once 'views/judges.php';
} else if ($page == 'participants') {
	require_once 'views/participants.php';
} else if ($page == 'users') {
	require_once 'views/users.php';
} else if ($page == 'profile') {
	require_once 'views/profile.php';
} else if ($page == 'programs') {
	require_once 'views/program.php';
} else {
	require_once 'views/404.php';
}
