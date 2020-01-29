<?php

namespace App\Library;

class BodyMetric {
    private $gender;
    private $age;
    private $height;
    private $weight;
    private $bmr;

    public function __construct($gender, $age, $height, $weight)
    {
        $this->gender = $gender;
        $this->age = $age;
        $this->height = $height;
        $this->weight = $weight;
        $this->calculateBmr();
    }

    public function getGender(){
        return $this->gender;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function getAge(){
        return $this->age;
    }

    public function setAge($age) {
        $this->age = $age;
    }

    public function getHeight(){
        return $this->height;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function getWeight(){
        return $this->weight;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    public function getBmr() {
        return $this->bmr;
    }

    public function setBmr($bmr) {
        $this->bmr = $bmr;
    }

    private function calculateBmr() {

        switch($this->gender) {
            case "Male":
                $this->bmr = 66.4730 + (13.7516 * $this->weight) + (5.0033 * $this->height) - (6.7550 * $this->age);
                break;
            case "Female":
                $this->bmr = 655.0955 + (9.5634 * $this->weight) + (1.8496 * $this->height) - (4.6756 * $this->age);
                break;
            default:
                $this->bmr = 66 + (13.7 * $this->weight) + (5 * $this->height) - (6.75 * $this->age);
        }
    }
}
