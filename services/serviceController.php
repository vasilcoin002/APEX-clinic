<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once "ServiceService.php";
    require_once "ServiceDTO.php";

    class ServiceController {

        private ServiceService $service_service;

        public function __construct() {
            $this->service_service = new ServiceService();
        }

        // public function get_services(ServiceDTO $serviceDTO): array {
        //     echo "<a href='../index.php'>go back</a><br>";
        //     return $this->service_service->get_services($serviceDTO);
        // }

        public function add_service(ServiceDTO $serviceDTO): void {
            echo "<a href='../index.php'>go back</a><br>";
            $this->service_service->add_service($serviceDTO);
        }
    }

    $service_controller = new ServiceController();
    if (isset($_POST["action"])) {
        //TODO fix automatic converting from string to int, if it's possible to send int as int from Frontend 
        $serviceDTO = new ServiceDTO;
        if ($_POST["id"] != null) {
            if (!is_numeric($_POST["id"])) throw new InvalidArgumentException("id must be number");
            $serviceDTO->id = $_POST["id"];
        }
        if (isset($_POST["name"])) {$serviceDTO->name = $_POST["name"];}
        if (isset($_POST["category"])) {$serviceDTO->category = $_POST["category"];}
        if (isset($_POST["doctor"])) {$serviceDTO->doctor = $_POST["doctor"];}
        if ($_POST["price"] != null) {
            if (!is_numeric($_POST["price"])) throw new InvalidArgumentException("price must be number");
            $serviceDTO->price = $_POST["price"];
        }
        if ($_POST["from"] != null) {
            if (!is_numeric($_POST["from"])) throw new InvalidArgumentException("from must be number");
            $serviceDTO->from = $_POST["from"];
        }
        if ($_POST["to"] != null) {
            if (!is_numeric($_POST["to"])) throw new InvalidArgumentException("to must be number");
            $serviceDTO->to = $_POST["to"];
        }

        $endpoints = array(
            "add-service" => fn() => $service_controller->add_service($serviceDTO),
        );

        $endpoints[$_POST["action"]]();
    }

?>