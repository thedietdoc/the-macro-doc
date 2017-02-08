<div class="bootstrap-scope">
<!-- hidden plugin folder path -->
    <?php $user_ID= get_current_user_id(); ?>
<span id="hiddenppath" data-Path="<?php echo plugins_url(); ?>">hiddenppath</span>
<span id="hiddenuserid" data-userid="<?php echo $user_ID; ?>">hiddenppath</span>

<form id="bmibmrCalc" method="post" action="<?php echo plugins_url( 'bmibmr_calculations.php' , __FILE__ ); ?>" >
<div class="row">

  <div class="col-md-4"><div class="panel panel-default ">

	      <div class="panel-heading">
	        <h3 class="panel-title"><span class="glyphicon glyphicon-th"></span> Menu</h3>
	      </div>
	      <div class="panel-body">
	        <ul class="nav nav-pills nav-stacked">

                <?php if( current_user_can('editor') || current_user_can('administrator') ) { ?>

                      <li>Trainer</li>
                      <li><a id="clients" href="#" data-formPath="<?php echo plugins_url( 'includes/clients.php' , __FILE__ ); ?>">Clients</a></li>
                      <!--<li><a href="#">Schedule</a></li>
                      <li><a href="#">Calendar</a></li>
                      <li><a href="#">Inbox</a></li>-->

                      <hr>
                <?php } ?>

		      <li>Calculate</li>
		      <li><a id="bmi" href="#" data-formPath="<?php echo plugins_url( 'includes/bmi_form.php' , __FILE__ ); ?>">BMI</a></li>
		      <li><a id="bmr" href="#" data-formPath="<?php echo plugins_url( 'includes/bmr_form.php' , __FILE__ ); ?>">BMR</a></li>

		      <?php if(is_user_logged_in()) { ?>



		      <!--
		      <hr>
		      <li>Entries</li>
		      <li><a href="#">April</a></li>
		      <li><a href="#">May</a></li>
		      <li><a href="#">June</a></li>
		      -->
		      <?php } ?>
		    </ul>
	      </div>
	</div>
  </div>

  <div id="data-panel">
	  <div class="col-md-8">
	  	<div class="well">


      <?php
        $savedRows =  get_saved_macrodoc($user_ID);
      	$user_info = get_userdata($user_ID);
      ?>
	  		<?php
		      	if($savedRows) {
		      		?>
		      		<h3>Hello <strong><?php echo $user_info->user_login; ?></strong>!</h3>
		      		<p>Welcome back!</p>
		      		<hr><h4>You have previously saved data that is listed below!</h4>
		      		<?php
		      	}
		      	else {
		      		?>
		      		<h3>Hello!</h3>
			  		<p>Welcome!</p>
			  		<p>Here you can calculate your bmi and bmr.</p>
			  		<p>Choose option on the left.</p>
		      		<?php
		      	}
		    ?>

	  	</div>
	  </div>
  </div>
</div>
</form>

<div class="calcValues"></div>
<div id="calcFront" data-calcFront="<?php echo plugins_url( 'includes/front_calc.php' , __FILE__ ); ?>" ></div>

</form>
<div id="bmibmrRes" data-saveBDataURL="<?php echo plugins_url( 'bmibmr_save.php' , __FILE__ ); ?>" style="clear:both; margin-top:26px; border-top:3px solid #B4B4B4;width: 100%; padding-top: 12px;" >
</div>


<div id="savedDataBmiBmr">
    <?php
        //include('bmibmr_saved.php');
    ?>
</div>


<!-- Button trigger modal -->
<button id="clientlistbtn" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" style="display: none;" ></button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Client list</h4>
            </div>
            <div class="modal-body">
                <div id="clientlist" ></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



</div>