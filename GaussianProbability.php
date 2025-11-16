class GaussianProbability {

    // Distribución normal acumulada (CDF)
    private static function phi($z) {
        return 0.5 * (1 + erf($z / sqrt(2)));
    }

    private static function zscore($x, $mean, $sigma) {
        return ($x - $mean) / $sigma;
    }

    /**
     * Probabilidad acumulada: P(X <= x)
     */
    public static function probabilityBelow($x, $mean, $sigma) {
        $z = self::zscore($x, $mean, $sigma);
        return self::phi($z); // 0–1
    }

    /**
     * Probabilidad inversa: P(X >= x)
     */
    public static function probabilityAbove($x, $mean, $sigma) {
        return 1 - self::probabilityBelow($x, $mean, $sigma);
    }

    /**
     * Probabilidad dentro de un rango: P(a <= X <= b)
     */
    public static function probabilityBetween($a, $b, $mean, $sigma) {
        return self::probabilityBelow($b, $mean, $sigma)
             - self::probabilityBelow($a, $mean, $sigma);
    }
}
