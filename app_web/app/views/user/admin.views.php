<h1 class="text-center p-4">Espace administrateur</h1>
<?php
  // Afficher un message d'erreur ou de succès
  if (isset($errorMessage)) {
    echo "<div class='alert alert-danger text-center' role='alert'>$errorMessage</div>";
  } else if (isset($successMessage)) {
    echo "<div class='alert alert-success text-center' role='alert'>$successMessage</div>";
  }
?>
<div class="d-flex align-items-start mt-5">
    <div class="nav flex-column nav-pills align-items-start" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <button class="nav-link active" id="v-pills-teams-tab" data-bs-toggle="pill" data-bs-target="#v-pills-teams" type="button" role="tab" aria-controls="v-pills-teams" aria-selected="true"><i class="bi bi-people me-2"></i>Création d'équipes</button>
        <button class="nav-link" id="v-pills-players-tab" data-bs-toggle="pill" data-bs-target="#v-pills-players" type="button" role="tab" aria-controls="v-pills-players" aria-selected="false"><i class="bi bi-person me-2"></i>Création de joueurs</button>
        <button class="nav-link" id="v-pills-game-tab" data-bs-toggle="pill" data-bs-target="#v-pills-game" type="button" role="tab" aria-controls="v-pills-game" aria-selected="false"><i class="bi bi-calendar-date me-2"></i>Plannification de matchs</button>
        <button class="nav-link" id="v-pills-informations-tab" data-bs-toggle="pill" data-bs-target="#v-pills-informations" type="button" role="tab" aria-controls="v-pills-informations" aria-selected="false"><i class="bi bi-person-circle me-2"></i>Informations</button>
    </div>
    <!-- Vertical divider -->
    <div class="vr mx-4"></div>
    <div class="tab-content mx-auto w-75" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="v-pills-teams" role="tabpanel" aria-labelledby="v-pills-teams-tab" tabindex="0">
            <h2 class="mb-5 text-center">Créer une équipe</h2>
            <form action="index.php?team/add" method="post" class="w-50 mx-auto">
                <div class="row mb-3">
                    <div class="col">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col">
                        <label for="country" class="form-label">Pays</label>
                        <input type="text" class="form-control" id="country" name="country" required>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary w-100 btn-lg">Créer</button>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="v-pills-players" role="tabpanel" aria-labelledby="v-pills-players-tab" tabindex="0">
            <h2 class="mb-5 text-center">Créer un joueur</h2>
            <form action="index.php?player/add" method="post" class="w-50 mx-auto">
                <div class="row mb-3">
                    <div class="col">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col">
                        <label for="firstname" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="firstname" name="firstName" required>
                    </div>
                </div>    
                <div class="mb-3">
                    <label for="number" class="form-label">Numéro</label>
                    <input type="number" class="form-control" id="number" name="number" required>
                </div>
                <div class="mb-3">
                    <label for="teams" class="form-label">Équipe</label>
                    <select class="form-select" aria-label="Default select example" id="teams" name="idTeam" required>
                        <?php foreach ($teams as $team) : ?>
                        <option value="<?=$team['id_team']?>"><?=$team['name']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary w-100 btn-lg">Créer</button>
                </div>
            </form>
         
        </div>
        <div class="tab-pane fade" id="v-pills-game" role="tabpanel" aria-labelledby="v-pills-game-tab" tabindex="0">
            <h2 class="mb-5 text-center">Plannifier un match</h2>
            <form action="index.php?game/add" method="post" class="w-50 mx-auto">
                <div class="row mb-3">
                    <div class="col">
                        <label for="teams1" class="form-label">Équipe 1</label>
                        <select class="form-select" aria-label="Default select example" id="teams1" name="idTeam1" required>
                            <?php foreach ($teams as $team) : ?>
                                <option value="<?=$team['id_team']?>"><?=$team['name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="cote1" class="form-label">Cote équipe 1</label>
                        <input type="number" step="0.1" class="form-control" id="cote1" name="odds1" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="teams2" class="form-label">Équipe 2</label>
                        <select class="form-select" aria-label="Default select example" id="teams2" name="idTeam2" required>
                            <?php foreach ($teams as $team) : ?>
                                <option value="<?=$team['id_team']?>"><?=$team['name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="cote2" class="form-label">Cote équipe 2</label>
                        <input type="number" step="0.1" class="form-control" id="cote2" name="odds2" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date et heure</label>
                    <input type="datetime-local" class="form-control" id="date" name="date" required>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary w-100 btn-lg">Valider</button>
                </div>
            </form>
         
        </div>
        <div class="tab-pane fade" id="v-pills-informations" role="tabpanel" aria-labelledby="v-pills-informations-tab" tabindex="0">
            <h2 class="mb-5 text-center">Mes informations</h2>
            <ul class="list-group">
                <li class="list-group-item">Nom : <?=$_SESSION['user']['name']?></li>
                <li class="list-group-item">Prénom : <?=$_SESSION['user']['first_name']?></li>
                <li class="list-group-item">E-mail : <?=$_SESSION['user']['email']?></li>
            </ul>
        </div>
    </div>
</div>