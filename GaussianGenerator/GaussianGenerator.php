<?php 
    if(!defined($sitename)){
        die('Acceso no autorizado.');
    }
    include '_scripts/GaussianGenerator/_include/GaussianRandom.php';
    LoadingTime::mark('GaussianRandom.php');
    include '_scripts/GaussianGenerator/_include/GaussianProbability.php';
    LoadingTime::mark('GaussianProbability.php');
    include '_scripts/GaussianGenerator/_include/WeightedGaussianGenerator.php';
    LoadingTime::mark('WeightedGaussianGenerator.php');
?>