<?php
  class WeightedGaussianGenerator
  {
      private array $levels = [];
      private array $cumulativeWeights = [];
      private int $totalWeight = 0;
  
      public function __construct(array $levels)
      {
          $this->levels = $levels;
          $this->initializeWeights();
      }
  
      // Inicializa los pesos acumulados para selección eficiente
      private function initializeWeights(): void
      {
          $cumulative = 0;
          foreach ($this->levels as $level => $info) {
              $cumulative += $info['Peso'];
              $this->cumulativeWeights[$level] = $cumulative;
          }
          $this->totalWeight = $cumulative;
      }
  
      // Genera un valor aleatorio gaussiano usando Box-Muller
      private function gaussianRandom(float $mean, float $stdDev): float
      {
          $u = mt_rand() / mt_getrandmax();
          $v = mt_rand() / mt_getrandmax();
          $z = sqrt(-2 * log($u)) * cos(2 * M_PI * $v);
          return $z * $stdDev + $mean;
      }
  
      // Selecciona un nivel aleatorio según pesos
      private function selectLevel(): string
      {
          $rand = mt_rand(1, $this->totalWeight);
          foreach ($this->cumulativeWeights as $level => $cumWeight) {
              if ($rand <= $cumWeight) {
                  return $level;
              }
          }
          // Fallback (no debería pasar)
          return array_key_last($this->levels);
      }
  
      // Genera N valores aleatorios
      public function generate(int $N): array
      {
          $data = [];
          for ($i = 0; $i < $N; $i++) {
              $level = $this->selectLevel();
              [$mean, $stdDev] = $this->levels[$level]['Data'];
              $data[] = [
                  'level' => $level,
                  'value' => $this->gaussianRandom($mean, $stdDev)
              ];
          }
          return $data;
      }
  }
?>
