<?php

define('allow_access_to_this_script', true);
require_once("CONFIG.PHP");

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ЛИЧНЫЕ ДАННЫЕ ПОЛЬЗОВАТЕЛЯ
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$id = -1;

if (!isset($_SESSION['id'])) {

    // отправляем тут на авторизацию если не авторизован
    $response = array(
        'type' => 'errorAuth',
        'msg' => ''
    );
    echo json_encode($response);
} else {
    $id = $_SESSION['id'];

    // в дальнейшем пользуемся $id
}



// АВТОЗАПОЛНЕНИЕ ПОЛЯ ФОРМЫ EMAIL ИЗ СЕССИИ
if ($_SERVER['REQUEST_METHOD'] == 'GET') {


    //определяем юзера по id из сессии
    $user = db_selectOne('user', ['id' => $id]);

    //если такой юзер не найден, то отправляем на регистрацию
    if ($user) {
        //емейл показываем в форме
        $email = $user['email_login_actual'];

        $response = array(
            'type' => 'success',
            'msg' => $email,
        );
    } else {
        $response = array(
            'type' => 'errorReg',
            'msg' => ''
        );
    }
    echo json_encode($response);
}

// ЗАПОЛНЕНИЕ ЛИЧНЫХ ДАННЫХ

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // var_dump($_POST);

    //находим юзера в БД
    $user = db_selectOne('user', ['id' => $id]);

    //если такого нет, то отправлем на страницу регистрации
    if (!$user) {
        $response = array(
            'type' => 'errorReg',
            'msg' => ''
        );
    }


    //получаем данные из заполненной формы
    if (isset($_POST['lastname'])) {
        if (strlen($_POST['lastname']) > 0) {
            $fio_lastname_or_company = test_input($_POST['lastname']);
        } else {
            $fio_lastname_or_company = '';
        }
    } else {
        $fio_lastname_or_company = '';
    }


    if (isset($_POST['name'])) {
        if (strlen($_POST['name']) > 0) {
            $fio_name_or_company_short = test_input($_POST['name']);
        } else {
            $fio_name_or_company_short = '';
        }
    } else {
        $fio_name_or_company_short = '';
    }

    //тут ошибка надо исправить!!
    if (isset($_POST['checkMiddlename'])) {
        if ($_POST['checkMiddlename'] == 'on') {
            $fio_middlename = '-';
        } else {
            $fio_middlename = test_input(($_POST['middlename']));
        }
    } else {
        $fio_middlename = '-';
    }


    if (isset($_POST['birth_date'])) {
        if (strlen($_POST['birth_date']) > 0) {
            $date_of_birth = test_input($_POST['birth_date']);
        } else {
            $date_of_birth = '1000-01-01 00:00:00.000000';
        }
    } else {
        $date_of_birth = '1000-01-01 00:00:00.000000';
    }

    if (isset($_POST['user_sex'])) {
        $sex = test_input($_POST['user_sex']);
    } else {
        $sex = 0;
    }


    if (isset($_POST['phone'])) {
        if (strlen($_POST['phone']) > 0) {
            $phone = test_input($_POST['phone']);
        } else {
            $phone = '';
        }
    } else {
        $phone = '';
    }


    if (isset($_POST['passport_numb'])) {
        if (strlen($_POST['passport_numb']) > 0) {
            $passport_numb = test_input($_POST['passport_numb']);
        } else {
            $passport_numb = '';
        }
    } else {
        $passport_numb = '';
    }

    if (isset($_POST['passport_date'])) {
        if (strlen($_POST['passport_date']) > 0) {
            $passport_date = test_input($_POST['passport_date']);
        } else {
            $passport_date = '1000-01-01 00:00:00.000000';
        }
    } else {
        $passport_date = '1000-01-01 00:00:00.000000';
    }


    if (isset($_POST['passport_issued_by'])) {
        if (strlen($_POST['passport_issued_by']) > 0) {
            $passport_issued_by = test_input($_POST['passport_issued_by']);
        } else {
            $passport_issued_by = '';
        }
    } else {
        $passport_issued_by = '';
    }


    if (isset($_POST['passport_code'])) {
        if (strlen($_POST['passport_code']) > 0) {
            $passport_code = test_input($_POST['passport_code']);
        } else {
            $passport_code = '';
        }
    } else {
        $passport_code = '';
    }

    if ($_POST['inn_numb']) {
        if (strlen($_POST['inn_numb']) > 0) {
            $inn_numb = test_input($_POST['inn_numb']);
        } else {
            $inn_numb = '';
        }
    } else {
        $inn_numb = '';
    }


    if (isset($_POST['snils_numb'])) {
        if (strlen($_POST['snils_numb']) > 0) {
            $snils_numb = test_input($_POST['snils_numb']);
        } else {
            $snils_numb = '';
        }
    } else {
        $snils_numb = '';
    }


    if (isset($_POST['legal_address_region'])) {
        if (strlen($_POST['legal_address_region']) > 0) {
            $legal_address_region = test_input($_POST['legal_address_region']);
        } else {
            $legal_address_region = '';
        }
    } else {
        $legal_address_region = '';
    }


    if (isset($_POST['legal_address_location'])) {
        if (strlen($_POST['legal_address_location']) > 0) {
            $legal_address_location = test_input($_POST['legal_address_location']);
        } else {
            $legal_address_location = '';
        }
    } else {
        $legal_address_location = '';
    }

    if (isset($_POST['legal_address_street'])) {
        if (strlen($_POST['legal_address_street']) > 0) {
            $legal_address_street = test_input($_POST['legal_address_street']);
        } else {
            $legal_address_street = '';
        }
    } else {
        $legal_address_street = '';
    }

    if (isset($_POST['legal_address_building'])) {
        if (strlen($_POST['legal_address_building']) > 0) {
            $legal_address_building = test_input($_POST['legal_address_building']);
        } else {
            $legal_address_building = '';
        }
    } else {
        $legal_address_building = '';
    }


    if (isset($_POST['checkLegalApart'])) {
        if ($_POST['checkLegalApart'] == 'on') {
            $legal_address_apart = '-';
        } else {
            $legal_address_apart = test_input($_POST['legal_address_apart']);
        }
    } else {
        $legal_address_apart = '-';
    }


    if (isset($_POST['real_address_region'])) {
        if (strlen($_POST['real_address_region']) > 0) {
            $real_address_region = test_input($_POST['real_address_region']);
        } else {
            $real_address_region = '';
        }
    } else {
        $real_address_region = '';
    }

    if (isset($_POST['real_address_location'])) {
        if (strlen($_POST['real_address_location']) > 0) {
            $real_address_location = test_input($_POST['real_address_location']);
        } else {
            $real_address_location = '';
        }
    } else {
        $real_address_location = '';
    }

    if (isset($_POST['real_address_street'])) {
        if (strlen($_POST['real_address_street']) > 0) {
            $real_address_street = test_input($_POST['real_address_street']);
        } else {
            $real_address_street = '';
        }
    } else {
        $real_address_street = '';
    }

    if (isset($_POST['real_address_building'])) {
        if (strlen($_POST['real_address_building']) > 0) {
            $real_address_building = test_input($_POST['real_address_building']);
        } else {
            $real_address_building = '';
        }
    } else {
        $real_address_building = '';
    }

    if (isset($_POST['checkRealApart'])) {
        if ($_POST['checkRealApart'] == 'on') {
            $real_address_apart = '-';
        } else {
            $real_address_apart = test_input($_POST['real_address_apart']);
        }
    } else {
        $real_address_apart = '-';
    }


// для юрид лица


    if (isset($_POST['egrul_number'])) {
        if(strlen($_POST['egrul_number']) > 0) {
            $egrul_number = test_input($_POST['egrul_number']);
        } else {
            $egrul_number ='';
        }
    } else {
        $egrul_number ='';
    }

    if (isset($_POST['egrul_data'])) {
        if(strlen($_POST['egrul_data']) > 0) {
            $egrul_data = test_input($_POST['egrul_data']);
        } else {
            $egrul_data = '1000-01-01 00:00:00.000000';
        }
    } else {
        $egrul_data = '1000-01-01 00:00:00.000000';
    }

    if (isset($_POST['kpp_number'])) {
        if(strlen($_POST['kpp_number']) > 0) {
            $pay_code_of_reason = test_input($_POST['kpp_number']);
        } else {
            $pay_code_of_reason ='';
        }
    } else {
        $pay_code_of_reason ='';
    }

    if (isset($_POST['check_account_number'])) {
        if(strlen($_POST['check_account_number']) > 0) {
            $pay_checking_account = test_input($_POST['check_account_number']);
        } else {
            $pay_checking_account =0;
        }
    } else {
        $pay_checking_account =0;
    }


    if (isset($_POST['bank_name'])) {
        if(strlen($_POST['bank_name']) > 0) {
            $pay_bank = test_input($_POST['bank_name']);
        } else {
            $pay_bank ='';
        }
    } else {
        $pay_bank ='';
    }


    if (isset($_POST['bank_bic'])) {
        if(strlen($_POST['bank_bic']) > 0) {
            $pay_bank_bic = test_input($_POST['bank_bic']);
        } else {
            $pay_bank_bic ='';
        }
    } else {
        $pay_bank_bic ='';
    }

    if (isset($_POST['bank_correspond'])) {
        if(strlen($_POST['bank_correspond']) > 0) {
            $pay_correspondent_account = test_input($_POST['bank_correspond']);
        } else {
            $pay_correspondent_account ='';
        }
    } else {
        $pay_correspondent_account ='';
    }

    if (isset($_POST['tax_form'])) {
        if(strlen($_POST['tax_form']) > 0) {
            switch ($_POST['tax_form']) {
                case 0:
                default:
                    $pay_tax_form = 1;
                    break;
                case 1:
                    $pay_tax_form = 0;
                    break;
            }

        } else {
            $pay_tax_form = 1;
        }
    } else {
        $pay_tax_form = 1;
    }



        // если все проверки пройдены, то
        $post = [
            'fio_lastname_or_company' => $fio_lastname_or_company,
            'fio_name_or_company_short' => $fio_name_or_company_short,
            'fio_middlename' => $fio_middlename,
            'sex' => $sex,
            'phone' => $phone,
            'passport' => $date_of_birth . ", " . $passport_numb . ", " . $passport_date . ", " . $passport_issued_by . ", " . $passport_code,
            'inn' => $inn_numb,
            'snils' => $snils_numb,
            'legal_address_region' => $legal_address_region,
            'legal_address_location' => $legal_address_location,
            'legal_address_street' => $legal_address_street,
            'legal_address_building' => $legal_address_building,
            'legal_address_apart' => $legal_address_apart,
            'real_address_region' => $real_address_region,
            'real_address_location' => $real_address_location,
            'real_address_street' => $real_address_street,
            'real_address_building' => $real_address_building,
            'real_address_apart' => $real_address_apart,
            'egrul_number' => $egrul_number,
            'egrul_data' => $egrul_data,
            'pay_code_of_reason' => $pay_code_of_reason,
            'pay_checking_account' => $pay_checking_account,
            'pay_bank' => $pay_bank,
            'pay_bank_bic' => $pay_bank_bic,
            'pay_correspondent_account' => $pay_correspondent_account,
            'pay_tax_form' => $pay_tax_form
        ];

        db_update('user', $id, $post);
        echo "success";
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

function deleteAllSymbols($data)
{
    return preg_replace('/[^0-9]/', "", $data);
}
