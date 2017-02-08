<div class="col-md-8">

<div class="panel panel-default textcenter">
	  <div class="panel-body">

		<div class="panel panel-default">
	      <div class="panel-heading">
	        <h3 class="panel-title">BMR calculator</h3>
	      </div>
	    </div>

	    <div class="row">
		  <div class="col-md-6">
		  	<div class="panel panel-default">
		      <div class="panel-heading">
		        <h3 class="panel-title">Gender</h3>
		      </div>
		      <div class="panel-body">
		        <div class="btn-group " data-toggle="buttons">
				  <label class="btn btn-primary">
				    <input type="radio" name="sexoption" id="option1" value="M" required> Man
				  </label>
				  <label class="btn btn-primary">
				    <input type="radio" name="sexoption" id="option2" value="F" required> Woman
				  </label>
				</div>
		      </div>
		    </div>
		  </div>
		  <div class="col-md-6">
		  	<div class="panel panel-default textcenter">
		      <div class="panel-heading">
		        <h3 class="panel-title">Metric system</h3>
		      </div>
		      <div class="panel-body">
		        <div class="btn-group btn-group-sm" data-toggle="buttons">
				  <label class="btn btn-primary" id="uVal1">
				    <input type="radio" name="uVal" value="lbs" required> Imperial
				  </label>
				  <label class="btn btn-primary" id="uVal2">
				    <input type="radio" name="uVal" value="kg" required> Metric
				  </label>
				</div>
		      </div>
		    </div>
		  </div>
		</div>


	  	<hr>
	  		<div class="input-group">
		      <span class="input-group-addon">Age</span>
		      <input type="text" class="form-control" name="age">
		    </div>

	  		<div class="input-group">
		      <span class="input-group-addon" id="weight">kilograms (kg)</span>
		      <input type="text" class="form-control" name="weight">
		    </div>

		    <div class="input-group">
		      <span class="input-group-addon" id="height">centimeters (cm)</span>
		      <input type="text" class="form-control"  name="height">
		    </div>


		    <div class="bfatguide"> 
				<a id="f_close" href="#">Close X</a>
				<strong>This is how you calculate your body fat:</strong>
				<p>More accurate methods are: Ask a certified trainer to do it for you, go to the doctor, with a caliper or other more professional ways.</p>
				<p>But if you want to do it fast and by yourself, measure around these points of your body:
					<ul id="bodyf_widths">
						<?php //echo plugins_url( 'includes/bmibmr_bodyf.php' , __FILE__ ); ?>
						<li>Neck: <input id="neck_width" name="neck_width"> <small>cm or inch</small></li>
						<li>Waist: <input id="waist_width" name="waist_width"> <small>cm or inch</small></li>
						<li>Hips: <input id="hips_width" name="hips_width"> <small>cm or inch</small></li>
					</ul>
					<a href="#" id="bodyf_calc">Calculate my body fat %</a>
				</p>
			</div>
 
		    <div class="bodyFat_cont" style="display:none;" >
				<small><input readonly="readonly" checked="checked" type="checkbox" name="calculateauto" id="calculateauto">Let the calculator extrapolate my body fat % based on entered data (BMI result) </small><br>
			</div>

		    <textarea class="form-control" rows="3" style="min-height:100px;" placeholder="notes to yourself..." name="descriptionB"></textarea>
	  	<hr>
	  </div>
	</div>


<div class="panel panel-default">
      <div class="panel-heading">Average Daily Activity Levels</div>
      <div class="panel-body">
     	 	<div class="panel panel-default">
		      <div class="panel-heading"><strong>1. Couch potato Range</strong></div>
		      <div class="panel-body">
		      	<input name="adalLevel" type="radio" value="1" required="required">
				<label>No exercise</label>
				<br>
				<input name="adalLevel" type="radio" value="1.2" required="required">
				<label>Sedentary (little or no exercise)</label>
		      </div>
			</div>

			<div class="panel panel-default">
		      <div class="panel-heading"><strong>2. Fitness Buff Range</strong></div>
		      <div class="panel-body">
		      	<input name="adalLevel" type="radio" value="1.375" required="required">
				<label>Lightly active (exercise/sports 1-3 times/week)</label>
				<br>
				<input name="adalLevel" type="radio" value="1.55" required="required">
				<label>Moderately active (exercise/sports 3-5 times/week)</label>
		      </div>
			</div>

			<div class="panel panel-default">
		      <div class="panel-heading"><strong>3. Athlete Or Hard Daily Range</strong></div>
		      <div class="panel-body">
		      	<input name="adalLevel" type="radio" value="1.725" required="required">
				<label>Very active (hard exercise/sports 6-7 times/week)</label>
				<br>
				<input name="adalLevel" type="radio" value="1.9" required="required">
				<label>Extra active (very hard exercise/sports or physical job)</label>
		      </div>
			</div>
      </div>
</div>

<input type="hidden" class="form-control" id="bmrCheck" name="bmibmr" value="bmr">
<button type="submit" class="btn btn-default btn-primary calcbtn">Calculate</button>

</div>