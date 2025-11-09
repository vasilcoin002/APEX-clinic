<?php

    class Service {

        private ?int $id;
        private string $name;
        private string $category;
        private string $doctor;
        private int $price;

        public function __construct($id, $name, $category, $doctor, $price) {
            $this->id = $id;
            $this->name = $name;
            $this->category = $category;
            $this->doctor = $doctor;
            $this->price = $price;
        }

        public function get_id(): int {
            return $this->id;
        }

        public function set_id(int $id) {
            $this->id = $id;
        }

        public function get_name(): string {
            return $this->name;
        }

        public function set_name(string $name) {
            $this->name = $name;
        }

        public function get_category(): string {
            return $this->category;
        }

        public function set_category(string $category) {
            $this->category = $category;
        }

        public function get_doctor(): string {
            return $this->doctor;
        }

        public function set_doctor(string $doctor) {
            $this->doctor = $doctor;
        }

        public function get_price(): int {
            return $this->price;
        }

        public function set_price(int $price) {
            $this->price = $price;
        }

        public function toAssociativeArray(): array {
            return array(
                "id" => $this->get_id(),
                "name" => $this->get_name(),
                "category" => $this->get_category(),
                "doctor" => $this->get_doctor(),
                "price" => $this->get_price(),
            );
        }
    }

?>