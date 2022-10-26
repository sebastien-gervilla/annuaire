<?php

class TestHandler {

    public static function run(string $message, callable $testFn) {
        $result = $testFn(function (mixed $testedValue) {
            return new Expectation($testedValue);
        });

        self::display($message, $result);
    }

    private static function display(string $message, array $result) {
        echo "\e[39m--------------------------------------------\n" . $message . "\n";
        echo "Tested value : " . json_encode($result['tested']) . "\n";
        echo "Expected value : " . json_encode($result['expected']) . "\n\n";
        echo "Result : " . ($result['doMatch'] ? "\e[32mPassed !" : "\e[91mFailed !");
        echo "\n\e[39m--------------------------------------------";
    }
}

class Expectation {

    private mixed $testedValue;

    public function __construct(mixed $testedValue) {
        $this->testedValue = $testedValue;
    }

    public function toBe(mixed $expectedValue): array {
        $doMatch = $this->doMatch($expectedValue);
        return array(
            "tested" => $this->testedValue,
            "expected" => $expectedValue,
            "doMatch" => $doMatch
        );
    }

    private function doMatch(mixed $expectedValue) {
        if (is_array($expectedValue)) 
            return boolval(!array_diff($expectedValue, $this->testedValue));

        return $expectedValue === $this->testedValue;
    }
}