<?php
session_start();
echo isset($_SESSION['username']) ? 'logged_in' : 'not_logged_in';
