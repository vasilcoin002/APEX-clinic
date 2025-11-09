<?php

    class ServiceRepository {

        private string $db_path = "../services/services.json";
        private array|null $services = null;

        public function get_db_path(): string {
            return $this->db_path;
        }

        public function get_services(): array {
            if ($this->services != null) {
                return $this->services;
            }

            $file_contents = file_get_contents($this->get_db_path());
            $decoded_array = json_decode($file_contents, true);
            if (!isset($decoded_array)) {
                return [];
            }

            $services_array = [];

            foreach ($decoded_array as $elem) {
                $service = new Service(
                    $elem["id"],
                    $elem["name"],
                    $elem["category"],
                    $elem["doctor"],
                    $elem["price"],
                );
                $services_array[] = $service;
            };
            return $services_array;
        }

        public function var_dump_pretty($var): void {
            echo '<pre>';
            var_dump($var);
            echo '</pre>';
        }

        // here goes array with Services, but not with associative array representation of services
        private function rewrite_db(array $new_services): void {

            $new_db_associative_array = [];
            foreach ($new_services as $service) {
                $new_db_associative_array[] = $service->toAssociativeArray();
            }

            $json_encoded_db = json_encode($new_db_associative_array, JSON_PRETTY_PRINT);
            file_put_contents($this->db_path, $json_encoded_db);

            $this->services = $new_services;
        }

        public function add_service(Service $service): Service {
            $this->check_if_service_is_complete($service, false);
            $services = $this->get_services();

            # cheking if db is not empty
            if (count($services) > 0) {
                $service->set_id(end($services)->get_id() + 1);
            } else {
                $service->set_id(1);
            }

            $services[] = $service;
            $this->rewrite_db($services);

            return $service;
        }

        public function delete_service(Service $service): void {
            $service_id = $service->get_id();
            if (!isset($service_id)) {
                throw new InvalidArgumentException("Service does not have id. Please, provide service with id");
            }

            $services = $this->get_services();
            foreach ($services as $i=>$current_service) {
                if ($current_service->get_id() == $service->get_id()) {
                    unset($services[$i]);
                    $this->rewrite_db($services);
                    break;
                }
            }
        }

        public function field_is_empty(?string $field): bool {
            return $field == null || trim($field) == "";
        }

        public function check_if_service_is_complete(Service $service, bool $check_id): void {
            if (
                $check_id && $service->get_id() == null || 
                $this->field_is_empty($service->get_name()) ||
                $this->field_is_empty($service->get_category()) ||
                $this->field_is_empty($service->get_doctor()) ||
                $service->get_price() < 0
            ) {
                throw new InvalidArgumentException("Service does not contain all required values. ");
            }
        }

        public function update_service(Service $service) {
            $this->check_if_service_is_complete($service, true);

            $services = $this->get_services();
            foreach ($services as $i=>$current_service) {
                if ($current_service->get_id() == $service->get_id()) {
                    $services[$i] = $service;
                    $this->rewrite_db($services);
                    break;
                }
            }

            return $service;
        }
    }

?>