<?php
  // Index used for master detail
  $masterDetailIndex = array();
  $masterDetailIndex["countries"] = array( array( "cou_con_id", array("continents", "con_id") ));
  $masterDetailIndex["customers"] = array(array( "cu_a_id", array("addresses", "a_id")), array( "cu_cou_id", array ("countries", "cou_id") ) );
  $masterDetailIndex["telephones"] = array( array( "t_cu_id", array("customers", "cu_id") ));
  $masterDetailIndex["orders"] = array( array( "o_cu_id", array("customers", "cu_id") ));
  $masterDetailIndex["order_lines"] = array( array( "ol_o_id", array("orders", "o_id")), array( "ol_p_id", array ("parts", "p_id") ) );

  $tablekeys = array(
    'addresses'   => 'a_id',
    'continents'  => 'con_id',
    'countries'   => 'cou_id',
    'customers'   => 'cu_id',
    'telephones'  => array('t_cu_id', 't_number'),
    'orders'      => 'o_id',
    'parts'       => 'p_id',
    'order_lines' => array('ol_o_id', 'ol_p_id')
  );

  $tablenames = array_keys($tablekeys);
?>
