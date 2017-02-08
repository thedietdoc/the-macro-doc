<?php
require( '../../../wp-load.php' );
    $savedRows =  get_saved_macrodoc($_REQUEST["clientid"]);
?>
<div class="row">
    <?php if(  !is_user_logged_in()) { ?>
        <div class="notauser"></div>
    <?php } ?>

    <?php if(  is_user_logged_in()): ?>
        <div  data-printCSS="<?php echo plugins_url( 'printcss.css' , __FILE__ ); ?>" id="bmiloggedin"></div>
        <hr>
        <!--<h3>Your previously saved data will be (is) listed here:</h3>
         <a href="#" onClick="print_me()" >Print the list</a><br><br> -->
        <div id="savedBMI" class="savedBMI" data-getBDataURL="<?php echo plugins_url( 'bmibmr_get.php' , __FILE__ ); ?>" data-userid="<?php echo get_current_user_id(); ?>">
            <?php
            foreach ($savedRows as $row) {
                $fromData_arr = json_decode($row->formdata, true);

                //echo '--++ '.$fromData_arr['bmibmr'];
                $calc_choice = '';
                if ( isset($fromData_arr['bmibmr']) && $fromData_arr['bmibmr'] == 'bmr') {
                    ////////////////////weight convert
                    if ($fromData_arr['uVal'] == 'kg') {
                        $bmr_weight = $fromData_arr['weight'];
                    }
                    else {
                        $bmr_weight = $fromData_arr['weight']/(2.2);
                    }

                    //////////////////// Male/female Coefficient
                    if ($fromData_arr['sexoption'] == 'M') { //if man
                        $coefficient_mf = 1*$bmr_weight*24;

                        //Lean factor multiplier
                        if (isset($fromData_arr['bodyfat'])) {
                            $bodyfat = $fromData_arr['bodyfat'];
                            switch($bodyfat) {
                                case ($bodyfat>=10 && $bodyfat<=14):
                                    $multiplier_factor = 1;
                                    break;
                                case ($bodyfat>=15 && $bodyfat<=20):
                                    $multiplier_factor = 0.95;
                                    break;
                                case ($bodyfat>=21 && $bodyfat<=28):
                                    $multiplier_factor = 0.90;
                                    break;
                                case ($bodyfat>28):
                                    $multiplier_factor = 0.90;
                                    break;
                            }
                        }
                        else {
                            $multiplier_factor = 1;
                        }
                    }
                    if ($fromData_arr['sexoption'] == 'F') { //if woman
                        $coefficient_mf = 0.9*$bmr_weight*24;
                        //Lean factor multiplier
                        if (isset($fromData_arr['bodyfat'])) {
                            $bodyfat = $fromData_arr['bodyfat'];
                            switch($bodyfat) {
                                case ($bodyfat>=14 && $bodyfat<=18):
                                    $multiplier_factor = 1;
                                    break;
                                case ($bodyfat>=19 && $bodyfat<=28):
                                    $multiplier_factor = 0.95;
                                    break;
                                case ($bodyfat>=29 && $bodyfat<=38):
                                    $multiplier_factor = 0.90;
                                    break;
                                case ($bodyfat>38):
                                    $multiplier_factor = 0.85;
                                    break;
                            }
                        }
                        else {
                            $multiplier_factor = 1;
                        }

                    }

                    $BMR = round($coefficient_mf*$multiplier_factor,2);
                    $daily_burn = round($BMR*$fromData_arr['adalLevel'],2);
                    //round(1.95583, 2);



                    $calc_choice = '<strong>BMR : '.$BMR.', </strong> Estimated daily caloric requirements : <strong>'.$daily_burn.'</strong><hr>';
                }
                else {
                    $calc_choice = '<strong>BMI only</strong><hr>';
                }

                //$bmi = ($fromData_arr['weight']*10000)/(pow($fromData_arr['height'],2));


                if ($fromData_arr['uVal'] == 'kg') {
                    $bmiR = ($fromData_arr['weight']*10000)/(pow($fromData_arr['height'],2));
                    $bmi = round($bmiR,2);

                    $weight_lbs = round(($fromData_arr['weight']*2.2),2);
                    $height_in = round(($fromData_arr['height']*0.393700787),2);
                    $weight_str = $fromData_arr['weight'].' kg  ( or '.$weight_lbs.' lbs)';
                    $height_str = $fromData_arr['height'].' cm  ( or '.$height_in.' in)';
                }
                else {
                    $bmiR = (($fromData_arr['weight']/(pow($fromData_arr['height'],2)))*703);
                    $bmi = round($bmiR,2);

                    $weight_kg = round(($fromData_arr['weight']/2.2),2);
                    $height_cm = round(($fromData_arr['height']*2.54),2);
                    $weight_str = $fromData_arr['weight'].' lbs or ('.$weight_kg.' kg)';
                    $height_str = $fromData_arr['height'].' in or ('.$height_cm.' cm)';
                }

                //Body fat percentage based on entered data
                //(1.20 x BMI) + (0.23 x Age) - (10.8 x gender) - 5.4
                //If you are a male, your gender number is 1. If you are a female, your gender number is 0.

                if ($fromData_arr['calculateauto']) {

                    if ($fromData_arr['sexoption'] == "M") {
                        //$bodyfatP = (1.20 * $bmi) + (0.23 * $fromData_arr['age']) - (10.8 * 1) - 5.4;
                        $gender_num = 1;
                    }
                    if ($fromData_arr['sexoption'] == "F") {
                        $gender_num = 0;
                    }

                    $bodyfatP = (1.20 * $bmi) + (0.23 * $fromData_arr['age']) - (10.8 * $gender_num) - 5.4;
                    //echo '<h4 style="color:red;">bodyfat %; '.$bodyfatP.'</h4>';

                }
                else {
                    $bodyfatP ='';
                }

                ?>
                <div class="col-md-6">
                    <div class="alert alert-warning " role="alert">
                        <div class="uListbmibmr">
                            <ul>
                                <li>
                                    <?php
                                    echo $calc_choice;
                                    ?>
                                </li>
                                <li>Saved on: <span><?php echo date("F j, Y, g:i a", strtotime($row->timeof)); ?></span></li>
                                <li>Weight: <span><?php echo $weight_str; ?></span></li>
                                <li>Height: <span><?php echo $height_str; ?></span></li>
                                <li>BMI: <span><?php echo $bmi; ?></span></li>
                                <li>Body fat %: <span><?php echo $bodyfatP; ?></span></li>
                                <li>Note: <span><?php echo $fromData_arr['descriptionB']; ?></span></li>
                            </ul>
                        </div>
                    </div>  </div>
            <?php
            }
            ?>
        </div>
    <?php endif; ?>
</div>