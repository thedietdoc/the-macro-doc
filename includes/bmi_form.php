<div class="col-md-8"><div class="panel panel-default textcenter">
	  <div class="panel-body">
	  	<div class="panel panel-default">
	      <div class="panel-heading">
	        <h3 class="panel-title">BMI calculator</h3>
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
				    <input type="radio" name="uVal" id="option1" value="lbs" required> Imperial
				  </label>
				  <label class="btn btn-primary" id="uVal2">
				    <input type="radio" name="uVal" id="option2" value="kg" required> Metric
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
		      <span class="input-group-addon"  id="height">centimeters (cm)</span>
		      <input type="text" class="form-control"  name="height">
		    </div>

		    <div class="bodyFat_cont" style="display:none;" >
				<small><input readonly="readonly" checked="checked" type="checkbox" name="calculateauto" id="calculateauto">Let the calculator extrapolate my body fat % based on entered data (BMI result) </small><br>
			</div>

		    <textarea class="form-control" rows="3" style="min-height:100px;" placeholder="notes to yourself..." name="descriptionB"></textarea>
		    <button type="submit" class="btn btn-default btn-large calcbtn">Calculate</button>
	  </div>
	</div>
	</div>