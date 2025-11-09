<?php

    require_once "ServiceRepository.php";
    require_once "Service.php";
    require_once "ServiceDTO.php";

    class ServiceService {

        private ServiceRepository $service_repository;

        public function __construct() {
            $this->service_repository = new ServiceRepository();
        }

        public function check_paging_request(ServiceDTO $serviceDTO) {
            if ($serviceDTO->from == null) {
                throw new BadMethodCallException("From is not provided");
            }
            if ($serviceDTO->to == null) {
                throw new BadMethodCallException("To is not provided");
            }
            if ($serviceDTO->from > $serviceDTO->to) {
                throw new InvalidArgumentException('"from" can\'t be bigger than "to"');
            }
        }

        // public function get_services(ServiceDTO $serviceDTO): array {
        //     $this->check_paging_request($serviceDTO);
        //     $all_services = $this->service_repository->get_services();

        //     return 
        // }

        // public function get_number_of_services(): int {
        //     return count($this->service_repository->get_services());
        // }

        public function check_if_service_dto_is_complete(ServiceDTO $serviceDTO, bool $check_id) {
            if (
                $this->service_repository->field_is_empty($serviceDTO->name) ||
                $this->service_repository->field_is_empty($serviceDTO->category) ||
                $this->service_repository->field_is_empty($serviceDTO->doctor) ||
                $serviceDTO->price == null
            ) {throw new BadMethodCallException("Some required values are empty");}
            if ($check_id && $serviceDTO->id == null) {
                throw new BadMethodCallException("Service does not contain id. Please, provide it");
            }
            if ($serviceDTO->price < 0) {
                throw new InvalidArgumentException("Price can't be negative");
            }
        }

        // TODO make it accessible for admins only
        public function add_service(ServiceDTO $serviceDTO): void {
            $this->check_if_service_dto_is_complete($serviceDTO, false);
            $service = new Service(
                null,
                $serviceDTO->name,
                $serviceDTO->category,
                $serviceDTO->doctor,
                $serviceDTO->price
            );
            
            $this->service_repository->add_service($service);
        }
    }

?>