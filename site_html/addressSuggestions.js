///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////// Скрипт для подсказок адреса
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// ДЛЯ АДРЕСА ПРОЖИВАНИЯ И ПРОПИСКИ ЮЗЕРА

let token = "f5ec0001e943952ccacb455a036dc9511e03d1e0";

let type = "ADDRESS";
let $legalAddressRegion = $("#legal_address_region");
let $legalAddressCity = $("#legal_address_location");
let $legalAddressStreet = $("#legal_address_street");
let $legalAddressHouse = $("#legal_address_building");

let $realAddressRegion = $("#real_address_region");
let $realAddressCity = $("#real_address_location");
let $realAddressStreet = $("#real_address_street");
let $realAddressHouse = $("#real_address_building");

// Подсказки для адреса по прописке

// регион и район
$legalAddressRegion.suggestions({
    token: token,
    type: type,
    hint: false,
    bounds: "region-area"
});

// город и населенный пункт
$legalAddressCity.suggestions({
    token: token,
    type: type,
    hint: false,
    bounds: "city-settlement",
    constraints: $legalAddressRegion
});

// улица
$legalAddressStreet.suggestions({
    token: token,
    type: type,
    hint: false,
    bounds: "street",
    constraints: $legalAddressCity,
    count: 15
});

// дом
$legalAddressHouse.suggestions({
    token: token,
    type: type,
    hint: false,
    noSuggestionsHint: false,
    bounds: "house",
    constraints: $legalAddressStreet
});

// Подсказки для адреса фактического проживания

// регион и район
$realAddressRegion.suggestions({
    token: token,
    type: type,
    hint: false,
    bounds: "region-area"
});

// город и населенный пункт
$realAddressCity.suggestions({
    token: token,
    type: type,
    hint: false,
    bounds: "city-settlement",
    constraints: $realAddressRegion,
});

// улица
$realAddressStreet.suggestions({
    token: token,
    type: type,
    hint: false,
    bounds: "street",
    constraints: $realAddressCity,
    count: 15
});

// дом
$realAddressHouse.suggestions({
    token: token,
    type: type,
    hint: false,
    noSuggestionsHint: false,
    bounds: "house",
    constraints: $realAddressStreet,
});




// ДЛЯ АДРЕСА ОБЪЕКТА В ЗАЯВКАХ

let $objectAddressRegion = $("#object_address_region");
let $objectAddressCity = $("#object_address_location");
let $objectAddressStreet = $("#object_address_street");
let $objectAddressHouse = $("#object_address_building");

// Подсказки для адреса объекта

// регион и район
$objectAddressRegion.suggestions({
    token: token,
    type: type,
    hint: false,
    bounds: "region-area"
});

// город и населенный пункт
$objectAddressCity.suggestions({
    token: token,
    type: type,
    hint: false,
    bounds: "city-settlement",
    constraints: $objectAddressRegion
});

// улица
$objectAddressStreet.suggestions({
    token: token,
    type: type,
    hint: false,
    bounds: "street",
    constraints: $objectAddressCity,
    count: 15
});

// дом
$objectAddressHouse.suggestions({
    token: token,
    type: type,
    hint: false,
    noSuggestionsHint: false,
    bounds: "house",
    constraints: $objectAddressStreet
});
