<?php 
    class GaussianRandom {

        /**
         * Genera un número aleatorio con distribución normal (gaussiana)
         * usando la transformación de Box–Muller.
         *
         * @param float $mean  Media (mu)
         * @param float $sigma Desviación estándar (sigma)
         * @return float Número generado
         */
        public static function generate($mean = 0.0, $sigma = 1.0) {

            // Box-Muller
            do { 
                $u1 = mt_rand() / mt_getrandmax();
            } while ($u1 == 0);

            do {
                $u2 = mt_rand() / mt_getrandmax();
            } while ($u2 == 0);

            $z0 = sqrt(-2.0 * log($u1)) * cos(2.0 * M_PI * $u2);

            return $z0 * $sigma + $mean;
        }
    }

?>
