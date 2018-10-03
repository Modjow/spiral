<?php

class Spiral {

    public $startNumber;
    public $endNumber;
    public $direction;
    public $isClockwise;

    private $positionsTable;

    public function __construct( $startNumber, $endNumber, $direction = "down", $isClockwise = false ) {
        $this->startNumber = $startNumber < $endNumber ? $startNumber : $endNumber;
        $this->endNumber = $startNumber < $endNumber ? $endNumber : $startNumber;
        $this->direction = in_array( $direction, ['up','right','down','left'] ) ? $direction : "down" ;
        $this->isClockwise = $isClockwise;
    }

    private function calculate() {
        $x = 0;
        $y = 0;
        $segmentLength = 1;
        $segmentLengthCounter = 1;
        $direction = $this->direction;

        $this->positionsTable = [];

        for ($i = $this->startNumber; $i <= $this->endNumber; $i++) {

            $this->positionsTable[$y][$x] = $i;

            ksort($this->positionsTable[$y]);
            ksort($this->positionsTable);

            switch ( $direction ) {
                case 'up':
                    $y--;
                break;
                case 'left':
                    $x--;
                break;
                case 'down':
                    $y++;
                break;
                case 'right':
                    $x++;
                break;
            }

            if( $segmentLengthCounter == $segmentLength || $segmentLengthCounter == $segmentLength * 2){
                switch ($direction) {
                    case 'up':
                        $direction = $this->isClockwise ? 'right' : 'left';
                    break;
                    case 'left':
                        $direction = $this->isClockwise ? 'up' : 'down';
                    break;
                    case 'down':
                        $direction = $this->isClockwise ? 'left' : 'right';
                    break;
                    case 'right':
                        $direction = $this->isClockwise ? 'down' : 'up';
                    break;
                }
            }
            if( $segmentLengthCounter < $segmentLength * 2 ){
                $segmentLengthCounter++;
            }else{
                $segmentLength++;
                $segmentLengthCounter = 1;
            }
        }

        // Filling blanks
        for ($i = $segmentLengthCounter; $i <= $segmentLength * 2; $i++) {
            $this->positionsTable[$y][$x] = "";
            ksort($this->positionsTable[$y]);
            ksort($this->positionsTable);
            switch ( $direction ) {
                case 'up':
                    $y--;
                break;
                case 'left':
                    $x--;
                break;
                case 'down':
                    $y++;
                break;
                case 'right':
                    $x++;
                break;
            }
        }
    }

    public function getResult() {
        if( empty($this->positionsTable) ){
            $this->calculate();
        }
        return $this->positionsTable;
    }

    public function display() {
        echo "<h1>Spiral from $this->startNumber to $this->endNumber</h1>";
        echo "<table>";
        foreach( $this->getResult() as $y => $cols ){
            echo "<tr>";
            foreach( $cols as $x => $value ){
                echo "<td>$value</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

}

$spiral = new Spiral(10, 27, 'down', false);
$spiral->display();
