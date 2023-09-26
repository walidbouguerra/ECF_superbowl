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
        <button class="nav-link active" id="v-pills-dashboard-tab" data-bs-toggle="pill" data-bs-target="#v-pills-dashboard" type="button" role="tab" aria-controls="v-pills-dashboard" aria-selected="true"><i class="bi bi-speedometer2 me-2"></i>Dashboard</button>
        <button class="nav-link" id="v-pills-history-tab" data-bs-toggle="pill" data-bs-target="#v-pills-history" type="button" role="tab" aria-controls="v-pills-history" aria-selected="false"><i class="bi bi-clock-history me-2"></i>Historique des mises</button>
        <button class="nav-link" id="v-pills-informations-tab" data-bs-toggle="pill" data-bs-target="#v-pills-informations" type="button" role="tab" aria-controls="v-pills-informations" aria-selected="false"><i class="bi bi-person-circle me-2"></i>Informations</button>
    </div>
    <!-- Vertical divider -->
    <div class="vr mx-4"></div>
    <div class="tab-content mx-auto w-75" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="v-pills-dashboard" role="tabpanel" aria-labelledby="v-pills-dashboard-tab" tabindex="0">
            <h2 class="mb-5 text-center">Dashboard</h2>
            <canvas id="betChart" aria-label="chart" role="img"></canvas>
        </div>
        <div class="tab-pane fade p-4" id="v-pills-history" role="tabpanel" aria-labelledby="v-pills-history-tab" tabindex="0">
            <table class="table table-striped">
                <tr>
                    <th>Équipe 1</th>
                    <th>Équipe 2</th>
                    <th>Date Match</th>
                    <th>Status</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Date mise</th>
                    <th>Mise</th>
                    <th>Gains</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
                <?php foreach ($bets as $bet) : 
                    $id_game = $bet['id_game'];
                    $id_bet = $bet['id_bet'];
                ?>
                    <tr>
                        <td><?=$bet['t1_name']?></td>
                        <td><?=$bet['t2_name']?></td>
                        <td><?=$bet['game_date']?></td>
                        <td><?=$bet['gameStatus']?></td>
                        <td><?=$bet['start']?></td>
                        <td><?=$bet['end']?></td>
                        <td><?=$bet['date_mise']?></td>
                        <td><?=$bet['amount']?></td>
                        <td><?=$bet['earnings']?></td>
                        <td><?=$bet['gameStatus'] == 'À venir' ? "<a class='btn btn-primary w-100' href='index.php?bet/show/$id_game' role='button'><i class='bi bi-pencil-square'></i></a>" : ''?></td>
                        <td><?=$bet['gameStatus'] == 'À venir' ? "<a class='btn btn-danger w-100' id='deleteBetBtn' href='index.php?bet/delete/$id_game' role='button'><i class='bi bi-trash'></i></a>" : ''?></td>
                    </tr>
                <?php endforeach ;?>
            </table>
        </div>
        <div class="tab-pane fade p-4" id="v-pills-informations" role="tabpanel" aria-labelledby="v-pills-informations-tab" tabindex="0">
            <h2 class="mb-5 text-center">Mes informations</h2>
            <ul class="list-group">
                <li class="list-group-item">Nom : <?=$_SESSION['user']['name']?></li>
                <li class="list-group-item">Prénom : <?=$_SESSION['user']['first_name']?></li>
                <li class="list-group-item">E-mail : <?=$_SESSION['user']['email']?></li>
            </ul>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Graphique des mises
    const betChart = document.getElementById('betChart');
    const bets = <?php 
        if (!empty($bets)) {
            echo json_encode($bets);
        } else echo '';
        ?>;

    if (betChart && bets) {
        let betsData = [];
        bets.forEach((bet) => {
            betsData.push({
            x: bet['game_date'],
            y: bet['earnings']
            });
        })
        const data = {
        datasets: [{
            label: 'Gains',
            data : betsData
        }]
        };
        const config = {
        type: 'line',
        data:  data,
        };
        const chart = new Chart(betChart, config);
    }
</script>
