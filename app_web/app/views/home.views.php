<div class="row flex-lg-row-reverse align-items-center g-5 py-5">
    <div class="col-10 col-sm-8 col-lg-6">
        <img src="assets/images/home_image.jpg" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
    </div>
    <div class="col-lg-6">
        <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">Le Super Bowl,<br>un événement unique</h1>
        <p class="lead">Le Super Bowl est la finale du championnat organisé par la National Football League (NFL), ligue américaine de football américain. C'est l'événement sportif le plus regardé à la télévision aux États-Unis, et l'un des événements sportifs les plus suivis au monde.</p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
            <a class="btn btn-primary btn-lg px-4 me-md-2" href="index.php?game/list" role="button">Matchs</a>
            <a class="btn btn-outline-secondary btn-lg px-4" href="index.php?game/select" role="button">Parier</a>
        </div>
    </div>
</div>
<div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
    <div class="list-group">
        <h2 class="text-center mb-3">Matchs du jour</h2>
        <?php if (isset($games)): ?>
        <?php foreach($games as $game): ?>
            <a href="index.php?game/show/<?=$game['id_game']?>" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                        <h6 class="mb-0"><?=$game['t1_name']?> vs <?=$game['t2_name']?></h6>
                    </div>
                    <small class="opacity-50 text-nowrap"><?=$game['game_date']?></small>
                </div>
            </a>
        <?php endforeach; ?>                  
        <?php endif; ?>
        <?php
            if (isset($errorMessage)) {
                echo "<div class='alert alert-primary text-center' role='alert'>$errorMessage</div>";
            }
        ?>
    </div>
</div>