<?php

// Interface: contact
$contact = array(
    'id'    => null,
    'name'  => '0',
    'type_id' => 2,     // contact
    'link' => null      // references to link (1-wire)
);

// Interface:RJ45
$rj45 = array(
    'id'        => null,
    'name'      => 'Port №1',
    'type_id'   => INTERFACE_RJ45,
    'links'     => [],  // references to link (patch-cord or cable)
    'interfaces' => [   // references to nested interfaces (contacts)
        0 => null,
        1 => null,
        2 => null,
        3 => null,
        4 => null,
        5 => null,
        6 => null,
        7 => null
    ]
);

// Interface: RJ11
$rj11 = array(
    'id'        => null,
    'name'      => 'Port №1',
    'type_id'   => INTERFACE_RJ11,
    'links'     => [],          // references to links
    'interfaces' => [               // references to nested interfaces (contacts)
        0 => null,
        1 => null,
        2 => null,
        3 => null
    ]
);

// Interface: pin
$pin = array(
    'id'    => null,
    'name'  => 'A1',
    'type_id' => 1,             // pin
    'interfaces' => [null, null]     // references to LINK objects
);

// Device: 'PSP box (60p)'
$pspBox = array(
    'id'        => null,
    'name'      => 'C11',
    'type_id'   => DEVICE_PSP_BOX_LEGACY_60,
    'interfaces' => [   // references to nested interfaces (pins)
        0 => null,
        1 => null,
        2 => null,
        3 => null
    ]
);

// Device: 'Cisco router'
$ciscoRouter = array(
    'id'        => null,
    'name'      => 'router1',
    'type_id'   => DEVICE_ROUTER,
    'manufacturer_id'   => MANUFACTURER_CISCO,
    'model_id'   => MODEL_2911,
    'interfaces' => [   // references to nested interfaces
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
    'modules' => [      // references to nested modules

    ]
);
