<?php
define('allow_access_to_this_script', true);
require_once("CONFIG.PHP");

// ПРИСЛАНА ФОРМА ЗАЯВКИ

//определяем id юзера
$id = $_SESSION['front_id'];

//определяем юзера по id
$user = db_selectOne('user', ['id' => $id]);
$result = array();


if (isset($_POST['request_type'])) {
    if (strlen(trim($_POST['request_type'])) != 0) {
        $reason = test_input($_POST['request_type']);
    } else {
        $reason = 0;
    }
} else {
    $reason = 0;
}

if (isset($_POST['object_type'])) {
    if (strlen(trim($_POST['object_type'])) > 0) {
        $object_type = test_input($_POST['object_type']);
    } else {
        $object_type = '';
    }
} else {
    $object_type = '';
}

if (isset($_POST['object_name'])) {
    if (strlen(trim($_POST['object_name'])) > 0) {
        $object_name = test_input($_POST['object_name']);
    } else {
        $object_name = '';
    }
} else {
    $object_name = '';
}

if (isset($_POST['object_address_region'])) {
    if (strlen(trim($_POST['object_address_region'])) > 0) {
        $object_region = test_input($_POST['object_address_region']);
    } else {
        $object_region = '';
    }
} else {
    $object_region = '';
}

if (isset($_POST['object_address_location'])) {
    if (strlen(trim($_POST['object_address_location'])) > 0) {
        $object_city = test_input($_POST['object_address_location']);
    } else {
        $object_city = '';
    }
} else {
    $object_city = '';
}


if (isset($_POST['object_address_street'])) {
    if (strlen(trim($_POST['object_address_street'])) > 0) {
        $object_street = test_input($_POST['object_address_street']);
    } else {
        $object_street = '';
    }
} else {
    $object_street = '';
}


if (isset($_POST['object_address_building'])) {
    if (strlen(trim($_POST['object_address_building']))) {
        $object_building = test_input($_POST['object_address_building']);
    } else {
        $object_building = '';
    }
} else {
    $object_building = '';
}

if (isset($_POST['cad_number'])) {
    if (strlen(trim($_POST['cad_number'])) > 0 && $_POST['cad_number'] !== '-') {
        $cadastral_number = test_input($_POST['cad_number']);
    } else {
        $cadastral_number = '';
    }
} else if (isset($_POST['uslov_number'])) {
    if (strlen(trim($_POST['uslov_number'])) > 0 && $_POST['uslov_number'] !== '-') {
        $cadastral_number = test_input($_POST['uslov_number']);
    } else {
        $cadastral_number = '';
    }
} else {
    $cadastral_number = '';
}

if (isset($_POST['own_number'])) {
    if (strlen(trim($_POST['own_number'])) > 0) {
        $ownership = test_input(($_POST['own_number']));
    } else {
        $ownership = '';
    }
} else {
    $ownership = '';
}

///////////////////////////////////////////////////////////

if (isset($_POST['watt_after'])) {
    if (strlen(trim($_POST['watt_after'])) > 0) {
        if (!is_numeric($_POST['watt_after'])) {
            $result [] = "error_watt_after";
            $wattage_after = 0;
        } else {
            $wattage_after = test_input($_POST['watt_after']);
        }
    } else {
        $wattage_after = 0;
    }
} else {
    $wattage_after = 0;
}

if (isset($_POST['volt_after'])) {
    if (strlen(trim($_POST['volt_after'])) > 0) {
        if (!is_numeric($_POST['volt_after'])) {
            $result [] = "error_volt_after";
            $voltage_after = 0;
        } else {
            $voltage_after = test_input($_POST['volt_after']);
        }
    } else {
        $voltage_after = 0;
    }
} else {
    $voltage_after = 0;
}

if (isset($_POST['watt_total'])) {
    //если выбрана причина заявки-новое строительство, полей before и total нет
    if ($reason == 1 || $reason == 0) {
        $wattage_total = $wattage_after;
    } else {
        //если причина не новое строительство, проверяем на пустоту строки
        if (strlen(trim($_POST['watt_total'])) > 0) {
            //строка не пустая, проверяем число ли это
            if (is_numeric($_POST['watt_total'])) {
                $wattage_total = test_input($_POST['watt_total']);
            } else {
                // если не число , отправляем ошибку
                $wattage_total = 0;
                $result [] = "error_watt_total";
            }
            //если строка пустая
        } else {
            $wattage_total = 0;
        }
    }
} else {
    $wattage_total = 0;
}

if (isset($_POST['watt_before'])) {
    //если выбрана причина заявки-новое строительство, полей before и total нет
    if ($reason == 1 || $reason == 0) {
        $wattage_before = $wattage_after;
    } else {
        //если причина не новое строительство, проверяем на пустоту строки
        if (strlen(trim($_POST['watt_before'])) > 0) {
            //строка не пустая, проверяем число ли это
            if (is_numeric($_POST['watt_before'])) {
                $wattage_before = test_input($_POST['watt_before']);
            } else {
                // если не число , отправляем ошибку
                $wattage_before = 0;
                $result [] = "error_watt_before";
            }
            //если строка пустая
        } else {
            $wattage_before = 0;
        }
    }
} else {
    $wattage_before = 0;
}

if (isset($_POST['volt_total'])) {
    //если выбрана причина заявки-новое строительство, полей before и total нет
    if ($reason == 1 || $reason == 0) {
        $voltage_total = $voltage_after;
    } else {
        //если причина не новое строительство, проверяем на пустоту строки
        if (strlen(trim($_POST['volt_total'])) > 0) {
            //строка не пустая, проверяем число ли это
            if (is_numeric($_POST['volt_total'])) {
                $voltage_total = test_input($_POST['volt_total']);
            } else {
                // если не число , отправляем ошибку
                $voltage_total = 0;
                $result [] = "error_volt_total";
            }
            //если строка пустая
        } else {
            $voltage_total = 0;
        }
    }
} else {
    $voltage_total = 0;
}

if (isset($_POST['volt_before'])) {
    //если выбрана причина заявки-новое строительство, полей before и total нет
    if ($reason == 1 || $reason == 0) {
        $voltage_before = $voltage_after;
    } else {
        //если причина не новое строительство, проверяем на пустоту строки
        if (strlen(trim($_POST['volt_before'])) > 0) {
            //строка не пустая, проверяем число ли это
            if (is_numeric($_POST['volt_before'])) {
                $voltage_before = test_input($_POST['volt_before']);
            } else {
                // если не число , отправляем ошибку
                $voltage_before = 0;
                $result [] = "error_volt_before";
            }
            //если строка пустая
        } else {
            $voltage_before = 0;
        }
    }
} else {
    $voltage_before = 0;
}

///////////////////////////////////////////////////////////

if (isset($_POST['secure_category'])) {
    if (strlen(trim($_POST['secure_category'])) > 0) {
        $safe_category = test_input($_POST['secure_category']);
    } else {
        $safe_category = 0;
    }
} else {
    $safe_category = 0;
}


if (isset($_POST['garant_supplier'])) {
    if (strlen(trim($_POST['garant_supplier']))) {
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
//    if (strlen($_POST['plan_term_project_1']) === 0 ||
//        strlen($_POST['plan_term_end_1']) === 0 ||
//        strlen($_POST['max_watt_1']) === 0 ||
//        strlen($_POST['secure_categ_1']) === 0) {
//        echo "emptyRows";
//        die();
//    }
    if ($i > 1) $project_date .= "^";
    $project_date .= test_input($_POST['plan_term_project_' . $i]) . "|" . test_input($_POST['plan_term_end_' . $i]) . "|" . test_input($_POST['max_watt_' . $i]) . "|" . test_input($_POST['secure_categ_' . $i]);


    require_once("site_php/user_create_pd.php");
}


// если все проверки пройдены, то записываем в БД
if (empty($result)) {

    $post = [
        'id_user' => $id,
        'date' => date("Y-m-d H:i:s"),
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


} else {
    $response = array(
        'type' => 'error',
        'msg' => $result
    );
}
echo json_encode($response);


//для удаления спецсимволов
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = str_replace(array("^", "|", "\\"), "", $data);
    $data = htmlspecialchars($data);
    return $data;

}


?>