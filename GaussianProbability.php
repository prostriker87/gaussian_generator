<?php
    class GaussianProbability {

        /**
         * Aproximación de Abramowitz–Stegun para la CDF normal
         * Devuelve Φ(z)
         */
        private static function phiApprox($z) {
            $sign = ($z < 0) ? -1 : 1;
            $z = abs($z) / sqrt(2);

            // Constantes de Abramowitz-Stegun
            $a1 = 0.254829592;
            $a2 = -0.284496736;
            $a3 = 1.421413741;
            $a4 = -1.453152027;
            $a5 = 1.061405429;
            $p  = 0.3275911;

            $t = 1 / (1 + $p * $z);

            // Aproximación a erf(z)
            $erf = 1 - (
                $a1*$t
            + $a2*(pow($t,2))
            + $a3*(pow($t,3))
            + $a4*(pow($t,4))
            + $a5*(pow($t,5))
            ) * exp(-$z*$z);

            // Convertir erf → CDF
            return 0.5 * (1 + $sign * $erf);
        }

        private static function zscore($x, $mean, $sigma) {
            return ($x - $mean) / $sigma;
        }

        private static function round6($value) {
            return round($value, 6);
        }

        /** P(X <= x) */
        public static function probabilityBelow($x, $mean, $sigma) {
            $z = self::zscore($x, $mean, $sigma);
            return self::round6(self::phiApprox($z));
        }

        /** P(X >= x) */
        public static function probabilityAbove($x, $mean, $sigma) {
            return self::round6(1 - self::probabilityBelow($x, $mean, $sigma));
        }

        /** P(a <= X <= b) */
        public static function probabilityBetween($a, $b, $mean, $sigma) {
            return self::round6(
                self::probabilityBelow($b, $mean, $sigma)
            - self::probabilityBelow($a, $mean, $sigma)
            );
        }
    }
?>
