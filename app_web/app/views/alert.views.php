<?php
if (isset($errorMessage)) {
    echo "<div class='alert alert-danger text-center' role='alert'>$errorMessage</div>";
} elseif (isset($successMessage)) {
    echo "<div class='alert alert-success text-center' role='alert'>$successMessage</div>";
} else {
    echo "<div class='alert alert-danger text-center' role='alert'>Une erreur est survenue.</div>";
}