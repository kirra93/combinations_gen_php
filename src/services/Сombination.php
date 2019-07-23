<?php

namespace App\Services;

/**
 * Class Сombination
 * @property $storeDir - directory for store text files with algorithm results
 */
class Сombination {

    private $storeDir = __DIR__;

    /**
     * Permutations constructor.
     * @param string $storeDir - directory for store text files with algorithm results.
     */
    public function __construct($storeDir = __DIR__) {
        $this->storeDir = $storeDir;
    }

    /**
     * Main method
     * @param $n
     * @param $k
     * @return
     */
    public function run($n, $k) {
        $excludeZero = $n - 1;
        if (!$this->validateInput($n, $excludeZero)) {
            return 'Incorrect values';
        }

        $triangle = $this->getPascalForTwoDimentional($n);
        $size = $triangle[$n][$k];

        if ($size < 10) {
            $this->save($size,'менее 10 вариантов');
            return 'To few values ';
        }

        $result = $this->getAll($n, $k, $size);
        $this->save($size, $result);

        return 'File was saved';
    }

    /**
     * Get all combinations
     * @param $n - items count
     * @param $k - number of elements in the sample
     * @param $size - number of options
     * @return array - array of combinations
     */
    private function getAll($n, $k, $size) {
        $c = [];
        for ($i = 0; $i < $k; $i++) {
            $c[$i] = $i + 1;
        }

        $all[] = $c;

        while (count($all) < $size) {
            $c = $this->getNext($c, $k, $n);
            $all[] = $c;
        }
        return $all;
    }

    /**
     * Get next combination in lexicographical order
     * @param $k
     * @param $n
     * @return
     */
    public function getNext($c, $k, $n) {
            $x = $this->naiveDesition($n, $k);
            $num = $this->getNumbyC($n, $k, $c);
            if ($num == $x) {
                return false;
            }

            $res = $c;

            $i = $k - 1;
            while ($res[$i] + $k - $i > $n) {
                $i--;
            }
            $res[$i]++;
            for ($j = $i + 1; $j < $k; $j++) {
                $res[$j] = $res[$j - 1] + 1;
            }
            return $res;
    }

    private function getNumbyC($n, $k, $inp) {
        $sc = 1;
        $c[] = 0;

        for ($i = 1; $i <= $k; $i++) {
            $c[$i] = $inp[$i - 1];
        }

        $SmallSc = $this->getPascalForTwoDimentional($n);

        for ($i = 1; $i <= $k; $i++) {
            for ($j = $c[$i - 1] + 1; $j <= $c[$i] - 1; $j++) {
                $sc += $SmallSc[$n - $j][$k - $i];
            }
        }
        return $sc;
    }

        private function mulInRange($a, $b) {
            $ans = 1;
            for ($i = $a; $i <= $b; $i++) {
                $ans *= $i;
            }
            return $ans;
        }

        private function naiveDesition($n, $k) {
            $m = $n - $k;
            if ($m > $k) {
                return $this->mulInRange($m + 1, $n) / $this->mulInRange(1, $k);
            }
            else {
                return $this->mulInRange($k + 1, $n) / $this->mulInRange(1, $m);
            }
        }

    /**
     * Pascal triangle for search count of combinations
     * @param $n
     * @return array
     */
    private function getPascalForTwoDimentional($n) {
        $m = $n + 1;
        $triangle = [];
        for ($i = 0; $i < $m; $i++) {
            $triangle[$i][0] = 1;
            $triangle[$i][$i] = 1;

            for ($j = 1; $j < $i; $j++) {
                $triangle[$i][$j] = $triangle[$i - 1][$j - 1] + $triangle[$i - 1][$j];
            }
        }
        return $triangle;
    }

    private function validateInput($cells, $coins) {
        return $cells > $coins || ($cells < 1 || $coins < 1);
    }

    public function save($count, $result) {
        $ans = '';
        if (is_array($result)) {
            $ans = $count . PHP_EOL;
            foreach ($result as $i => $val) {
                $ans .= implode(' ', $val) . PHP_EOL;
            }
        } else {
            $ans = $result;
        }
        $this->writeFile($ans, $this->storeDir);
    }

    private function writeFile($result, $dir = '/file.txt') {
        file_put_contents($dir, $result);
    }
}
