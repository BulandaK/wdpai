<?php
session_start();
?>
<header>
    <div class="logo"><a href="/">CineReserve</a></div>
    <div class="hamburger-menu" id="hamburger-menu">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <nav id="nav-links">
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
            <a href="/adminPage">Admin Panel</a>
        <?php endif; ?>
        <a href="/main">Home</a>
        <a href="/movies">Movies</a>
        <a href="/screeningsList">Seances</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/logout">Logout (<?= htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8') ?>)</a>
        <?php else: ?>
            <a href="/login">Login</a>
        <?php endif; ?>
    </nav>
</header>
<script src="../Public/js/header.js"></script>