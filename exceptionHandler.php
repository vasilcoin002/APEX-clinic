<?php

    function exception_handler() {
        echo json_encode($GLOBALS["errors"]);
    };

?>