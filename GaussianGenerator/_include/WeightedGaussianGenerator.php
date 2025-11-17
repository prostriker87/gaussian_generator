<?php
    class WeightedGaussianGenerator {
        public static function generate(array $levels, int $N=1): array {
            if ($N <= 0) {
                return [];
            }
            // 1. Ordenar por peso ascendente
            asort($levels);
            $classes = array_keys($levels);
            $numClasses = count($classes);
    
            $mean = 0;
            $sigma = 1;
    
            // Asignamos posiciones centradas en 0
            $positions = [];
            $start = -floor($numClasses / 2);
            foreach ($classes as $i => $class) {
                $positions[$class] = $start + $i;
            }
    
            // Calculamos probabilidades gaussianas
            $probs = [];
            $sum = 0;
            foreach ($classes as $class) {
                $pos = abs($positions[$class]); // negativos → positivos
                $p = $levels[$class]['Peso'] * exp(-pow($pos - $mean, 2) / (2 * pow($sigma, 2)));
                $probs[$class] = $p;
                $sum += $p;
            }
    
            // Normalizamos
            foreach ($probs as $class => $p) {
                $probs[$class] = $p / $sum;
            }
    
            // Generamos datos
            $data = [];
            for ($i = 0; $i < $N; $i++) {
                $level = self::selectGaussianClass($probs);
                [$meanVal, $stdDev] = $levels[$level]['Data'];
                if($N==1){
                    $data = [
                        'level' => $level,
                        'value' => self::gaussianRandom($meanVal, $stdDev)
                    ];
                }else{
                    $data[] = [
                        'level' => $level,
                        'value' => self::gaussianRandom($meanVal, $stdDev)
                    ];
                }
            }
    
            return $data;
        }
    
        private static function selectGaussianClass(array $probs): string
        {
            $r = mt_rand() / mt_getrandmax();
            $acc = 0;
            foreach ($probs as $class => $p) {
                $acc += $p;
                if ($r <= $acc) return $class;
            }
            return array_key_last($probs);
        }
    
        private static function gaussianRandom(float $mean, float $stdDev): float
        {
            $u = mt_rand() / mt_getrandmax();
            $v = mt_rand() / mt_getrandmax();
            $z = sqrt(-2 * log($u)) * cos(2 * M_PI * $v);
            return $z * $stdDev + $mean;
        }
    }
?>

