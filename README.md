# gaussian_generator
Just a simple PHP  gaussian bell number gen

Usage:

    <?php
      include 'GaussianGenerator/GaussianGenerator.php';



          // ------- Simple Gaussian Bell
      
      $mean = 100;
      $sigma = 15;
      $num = GaussianRandom::generate($mean,$sigma);



          // -------- Weighted Gaussian Bell
      
      $ranks  = [
        'Común' => [
            'Data' => [100,15],
            'Peso' => '2000'
        ],
        'Medio' => [
            'Data' => [120,20],
            'Peso' => '200'
        ],
        'Alto'  => [
            'Data' => [140,25],
            'Peso' => '20'
        ],
        'Élite' => [
            'Data' => [160,30],
            'Peso' => '1'
        ],
      ];
      $data = WeightedGaussianGenerator::generate($ranks);
         //Output example
       //Array => [level] => Común, [value] => 107.50999355179
      $num = $data['value'];



          // -------- Gaussian Probability
      
      $mean = 100;
      $sigma = 15;
      $limit = ($sigma * 2);
      echo 'Insuficiente ('.$mean-$limit.'-): '.(GaussianProbability::probabilityBelow(($mean-$limit), $mean, $sigma)*100).'%<br>';
      echo 'Suficiente ('.$mean-$limit.'-'.$mean+$limit.'): '.(GaussianProbability::probabilityBetween(($mean-$limit), $mean+$limit, $mean, $sigma)*100).'%<br>';
      echo 'Sobresaliente ('.$mean+$limit.'+): '.(GaussianProbability::probabilityAbove(($mean+$limit), $mean, $sigma)*100).'%<br>';
      echo 'Promedio bajo ('.$mean-$limit.'-'.$mean-($limit/2).'): '.(GaussianProbability::probabilityBetween($mean-($limit), $mean-($limit/2), $mean, $sigma)*100).'%<br>';
      echo 'Promedio medio ('.$mean-($limit/2).'-'.$mean.'): '.(GaussianProbability::probabilityBetween($mean-($limit/2), $mean, $mean, $sigma)*100).'%<br>';
      echo 'Promedio alto ('.$mean.'-'.$mean+($limit/2).'): '.(GaussianProbability::probabilityBetween($mean, $mean+($limit/2), $mean, $sigma)*100).'%<br>';
      echo 'Promedio óptimo ('.$mean+($limit/2).'-'.$mean+$limit.'): '.(GaussianProbability::probabilityBetween($mean+($limit/2), $mean+$limit, $mean, $sigma)*100).'%<br>';
      echo "<br>";
