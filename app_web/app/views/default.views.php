<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Bowl - <?= $pageTitle ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <div class="container">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <div class="col-md-3 mb-2 mb-md-0">
            <a href="index.php?game/home" class="d-inline-flex link-body-emphasis text-decoration-none fs-4">Super Bowl</a>
        </div>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="index.php?game/home" class="nav-link px-2">Accueil</a></li>
            <li><a href="index.php?game/list" class="nav-link px-2">Matchs</a></li>
            <li><a href="index.php?game/select" class="nav-link px-2">Parier</a></li>
        </ul>

        <div class="col-md-3 text-end">
            <?php if (!empty($_SESSION['user'])): ?>
                <a href="index.php?user/dashboard" class="btn btn-outline-primary me-2" role="button">Mon espace</a>
                <a href="index.php?user/logout" class="btn btn-primary" role="button">Se déconnecter</a> 
            <?php endif; ?>
            <?php if (empty($_SESSION['user'])): ?>
                <a href="index.php?user/login" class="btn btn-outline-primary me-2" role="button">Se connecter</a>
                <a href="index.php?user/signup" class="btn btn-primary" role="button">S'inscrire</a> 
            <?php endif; ?>
        </div>
        </header>
        <main>
            <?= $pageContent ?>
        </main>
        <footer class="p-4 border-top fixed-bottom container">
            <p class="text-center text-body-secondary m-0">© 2023 Super Bowl</p>
        </footer>
    </div>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/index.js"></script>
</body>
</html>