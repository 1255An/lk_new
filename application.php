<?php

define('allow_access_to_this_script', true);
require_once("CONFIG.PHP");

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ПОДАЧА ЗАЯВКИ ПОЛЬЗОВАТЕЛЕМ
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$id = -1;

if (!isset($_SESSION['id'])) {

    // отправляем тут на авторизацию если не авторизован
    $response = array(
        'type' => 'errorAuth',
        'msg' => ''
    );
} else {
    $id = $_SESSION['id'];

    // в дальнейшем пользуемся $id
}


// ЗАПОЛНЕНИЕ ЛИЧНЫХ ДАННЫХ

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $user = db_selectOne('user', ['id' => $id]);

    //если юзер найден
    if ($user) {

        //нынешний timestamp
        $date = date("Y-m-d H:i:s");

        //получаем данные из заполненной формы
        switch (test_input($_POST['apply_type'])) {
            case 'Новое строительство':
                $reason = 1;
                break;
            case 'Увеличение мощности':
                $reason = 2;
                break;
            case 'Уменьшение мощности':
                $reason = 3;
                break;
            default:
                $reason = 0;
        }

        if (isset($_POST['object_type'])) {
            if (strlen($_POST['object_type']) > 0) {
                $object_type = test_input($_POST['object_type']);
            } else {
                $object_type = '';
            }
        } else {
            $object_type = '';
        }

        if (isset($_POST['object_name'])) {
            if (strlen($_POST['object_name']) > 0) {
                $object_name = test_input($_POST['object_name']);
            } else {
                $object_name = '';
            }
        } else {
            $object_name = '';
        }

        if (isset($_POST['object_address_region'])) {
            if (strlen($_POST['object_address_region']) > 0) {
                $object_region = test_input($_POST['object_address_region']);
            } else {
                $object_region = '';
            }
        } else {
            $object_region = '';
        }

        if (isset($_POST['object_address_location'])) {
            if (strlen($_POST['object_address_location'])) {
                $object_city = test_input($_POST['object_address_location']);
            } else {
                $object_city = '';
            }
        } else {
            $object_city = '';
        }


        if (isset($_POST['object_address_street'])) {
            if (strlen($_POST['object_address_street']) > 0) {
                $object_street = test_input($_POST['object_address_street']);
            } else {
                $object_street = '';
            }
        } else {
            $object_street = '';
        }


        if (isset($_POST['object_address_building'])) {
            if (strlen($_POST['object_address_building'])) {
                $object_building = test_input($_POST['object_address_building']);
            } else {
                $object_building = '';
            }
        } else {
            $object_building = '';
        }

        if (isset($_POST['watt_after'])) {
            if (strlen($_POST['watt_after']) > 0) {
                $wattage_after = test_input($_POST['watt_after']);
            } else {
                $wattage_after = 0;
            }
        } else {
            $wattage_after = 0;
        }

        if (isset($_POST['volt_after'])) {
            if (strlen($_POST['volt_after']) > 0) {
                $voltage_after = test_input($_POST['volt_after']);
            } else {
                $voltage_after = 0;
            }
        } else {
            $voltage_after = 0;
        }


        if (isset($_POST['cad_number'])) {
            if (strlen($_POST['cad_number']) > 0 && $_POST['cad_number'] !== '-') {
                $cadastral_number = test_input($_POST['cad_number']);
            } else {
                $cadastral_number = '';
            }
        } else if (isset($_POST['uslov_number'])) {
            if (strlen($_POST['uslov_number']) > 0 && $_POST['uslov_number'] !== '-') {
                $cadastral_number = test_input($_POST['uslov_number']);
            } else {
                $cadastral_number = '';
            }
        } else {
            $cadastral_number = '';
        }

        if (isset($_POST['own_number'])) {
            if (strlen($_POST['own_number']) > 0) {
                $ownership = test_input(($_POST['own_number']));
            } else {
                $ownership = '';
            }
        } else {
            $ownership = '';
        }


        if (isset($_POST['watt_total'])) {
            if (trim($_POST['watt_total']) == '') {
                $wattage_total = $wattage_after;
            } else {
                $wattage_total = test_input($_POST['watt_total']);
            }
        } else {
            $wattage_total = $wattage_after;
        }

        if (isset($_POST['watt_before'])) {
            if (trim($_POST['watt_before']) == '') {
                $wattage_before = $wattage_after;
            } else {
                $wattage_before = test_input($_POST['watt_before']);
            }
        } else {
            $wattage_before = $wattage_after;
        }

        if (isset($_POST['volt_total'])) {
            if (trim($_POST['volt_total']) == '') {
                $voltage_total = $voltage_after;
            } else {
                $voltage_total = test_input($_POST['volt_total']);
            }
        } else {
            $voltage_total = $voltage_after;
        }

        if (isset($_POST['volt_before'])) {
            if (trim($_POST['volt_before']) == '') {
                $voltage_before = $voltage_after;
            } else {
                $voltage_before = test_input($_POST['volt_before']);
            }
        } else {
            $voltage_before = $voltage_after;
        }

        if (isset($_POST['secure_category'])) {
            if (strlen($_POST['secure_category']) > 0) {
                $safe_category = test_input($_POST['secure_category']);
            } else {
                $safe_category = 0;
            }
        } else {
            $safe_category = 0;
        }


        if (isset($_POST['garant_supplier'])) {
            if (strlen($_POST['garant_supplier'])) {
                $warrant_supplier = test_input($_POST['garant_supplier']);
            } else {
                $warrant_supplier = '';
            }
        } else {
            $warrant_supplier = '';
        }

        $status_for_user = 0;
        $status_for_admin = 0;

        //считаем количество строк в таблице этапы
        $num = 0;
        foreach ($_POST as $sentence => $key) {
            if (substr_count($sentence, "plan_term_project") > 0) {
                $num++;
            }
        }

        $project_date = '';

        for ($i = 1; $i <= $num; $i++) {
            if (strlen($_POST['plan_term_project_1']) === 0 ||
                strlen($_POST['plan_term_end_1']) === 0 ||
                strlen($_POST['max_watt_1']) === 0 ||
                strlen($_POST['secure_categ_1']) === 0) {
                echo "emptyRows";
                die();
            }
            if ($i > 1) $project_date .= "^";
            $project_date .= test_input($_POST['plan_term_project_' . $i]) . "|" . test_input($_POST['plan_term_end_' . $i]) . "|" . test_input($_POST['max_watt_' . $i]) . "|" . test_input($_POST['secure_categ_' . $i]);

        }


        // если все проверки пройдены, то
        $post = [
            'id_user' => $id,
            'date' => $date,
            'reason' => $reason,
            'object_type' => $object_type,
            'object_name' => $object_name,
            'object_region' => $object_region,
            'object_city' => $object_city,
            'object_street' => $object_street,
            'object_building' => $object_building,
            'cadastral_number' => $cadastral_number,
            'ownership' => $ownership,
            'wattage_total' => $wattage_total,
            'voltage_total' => $voltage_total,
            'wattage_before' => $wattage_before,
            'voltage_before' => $voltage_before,
            'wattage_after' => $wattage_after,
            'voltage_after' => $voltage_after,
            'safe_category' => $safe_category,
            'project_date' => $project_date,
            'warrant_supplier' => $warrant_supplier,
            'status_for_user' => $status_for_user,
            'status_for_admin' => $status_for_admin
        ];

        db_insert('request', $post);
        $response = array(
            'type' => 'success',
            'msg' => ''
        );
        echo json_encode($response);


    } else {
        $response = array(
            'type' => 'errorReg',
            'msg' => ''
        );
        echo json_encode($response);
    }
}


//для удаления спецсимволов
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = str_replace(array("^", "|", "\\"), "", $data);
        $data = htmlspecialchars($data);
        return $data;

    }

//function isOnlyRusLetter($data) {
//    return preg_match(("/^[а-яё \.\,]*$/ui"), $data);
//    }
//
//function isOnlyDigit($data) {
//    return preg_match(("/^[0-9\.\,]*$/"), $data);
//    }
//
//function isCorrectCadastrNumber($data) {
//    return preg_match(("/\d{1,2}:\d{1,2}:\d{6,7}:\d{1,4}/"), $data) ;
//    }
//
//function isCorrectRegionCityStreet($data) {
//    return preg_match(("/^[а-яё0-9\'\-\,\.\/\s]+$/ui"), $data);
//    }

