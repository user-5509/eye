<?php
// PIN interface
$pin = array(
    'id'    => null,
    'name'  => 'A1',
    'type_id' => 1,             // PIN
    'links' => [null, null]     // references to LINK objects
);

// RJ45 interface
$rj45 = array(
    'id'        => null,
    'name'      => 'Port №1',
    'type_id'   => INTERFACE_RJ45,
    'links'     => [null],          // references to LINK object
    'interfaces' => [	            // references to child INTERFACE objects (PIN)
        'pin_1' => null, 
        'pin_2' => null, 
        'pin_3' => null, 
        'pin_4' => null, 
        'pin_5' => null, 
        'pin_6' => null, 
        'pin_7' => null, 
        'pin_8' => null
    ]
);

// RJ11 interface
$rj11 = array(
    'id'        => null,
    'name'      => 'Port №1',
    'type_id'   => INTERFACE_RJ11,
    'links'     => [null],          // references to LINK object
    'interfaces' => [	            // references to child INTERFACE objects (PIN)
        'pin_1' => null, 
        'pin_2' => null, 
        'pin_3' => null, 
        'pin_4' => null
    ]
);

// 'PSP box (60p)' device
$pspBox = array(
    'id'        => null,
    'name'      => 'C11',
    'type_id'   => DEVICE_PSP_BOX_LEGACY_60,
    'interfaces' => [	            // references to child INTERFACE objects (PIN)
        'АБ1' => null, 
        'АБ2' => null, 
        'pin_3' => null, 
        'pin_4' => null
    ]
);

// 'cisco router' device
$ciscoRouter = array(
    'id'        => null,
    'name'      => 'router1',
    'type_id'   => DEVICE_ROUTER,
    'manufacturer_id'   => MANUFACTURER_CISCO,
    'model_id'   => MODEL_2911,
    'interfaces' => [	            // references to child INTERFACE objects (PIN)
        0 => [
            'id' => null,
            'name' => 'gi0/0',
            'type' => INTERFACE_ETHERNET_GIGABIT,
            'layers' => [
                '1' => [
                    'link' => [
                        'linked_to' => null, // interface object connected to
                        'linked_by' => null  // link object connected by
                    ]
                ]
            ]
        ]
    ],
    'modules' => [

    ]    
);