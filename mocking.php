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
        0 => [  // [interface_object]
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

class BaseInterface {
    var private  $id;
    var private $name;
    var private $parentId;
    var private $interfaces[];
    var private $connections[];
    
    public function __construct($parentId) {
        $this->parentId = $parentId;
        $this->interfaces = null;
        $this->connections = null;
    }

    public function isConnectable();
}

interface Connectable {
    public function connect(BaseInterface $connectTo, Link $connectBy);
    public function disconnect();
    public function getLink();
    public function getConnectedInterface();
}

// class IPoint extends BaseInterface implements Connectable {    
//     public function connect(IPoint $connectTo, LWire $connectBy) {
//         $this->connections[] = new Connection($connectTo, $connectBy);
//     }
// }

class IPin extends BaseInterface implements Connectable {
    public function connect(IPin $connectTo, LWire $connectBy) {
        $this->connections[] = new Connection($connectTo, $connectBy);
    }
}
    
class IPair extends BaseInterface implements Connectable {    
    public function __construct() {
        $this->interfaces[] = new IPin;
        $this->interfaces[] = new IPin;
    }

    public function connect(IPair $connectTo, LCrossPair $connectBy) {
        $this->connections[] = new Connection($connectTo, $connectBy);
    }
}

class LCrossPair {

}

class Connection {

}

$pair1 = new IPair;
$pair2 = new IPair;
$link1 = new LCrossPair;
$connection1 = new Connection($pair1->interface[1], $pair2->interface[0], $link1);



// Try to model API
function getContent($objId)
{
    $object = (new Object)->getById($objId);
    $content = $object->getContent();
}


    $obj = (new Object)->getById($objId);  // пом.415

    $obj->getContent();
    /*
    {id: "547", name: "ПСП №1", icon: "ico_psp", hasContent: "true"}
    СПМ №1
    Шкаф №1
    Шкаф №2
    Шкаф №3
    Шкаф №4
    Шкаф №6
    Шкаф RSNET
    Стол №1
    Стол №2
    */

    /create/node

    // Cisco 2911
    $params = [
        "typeId" => 23,     // Router
        "vendorId" => 54,   // Cisco
        "modelId" => 23,    // 2911
        "name" => "Cisco Атлас (осн.)",
        "modules" => [
            0 => "HWIC-16A"
        ],
    ];

    // Legacy box (PSP)
    $params = [
        "typeId" => 12,     // Legacy box
        "modelId" => 15,    // 60 pairs
        "name" => "Л22",
    ];



















