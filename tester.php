<?php
/**
 * Created by PhpStorm.
 * User: ZooxPC
 * Date: 2/2/2017
 * Time: 6:38 PM
 */

namespace macro\doc;


include 'Profile.php';
include 'Calculator.php';

$profile = new Profile("Brian");
$obj = new Calculator($profile);
