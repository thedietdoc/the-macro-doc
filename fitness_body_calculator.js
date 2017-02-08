jQuery(document).ready(function($) {

    ///////////////////
    $("#bmibmrCalc").submit(function(e)
    {
        e.preventDefault();

        var formData = $("#bmibmrCalc").serializeArray();
        var URL = $("#bmibmrCalc").attr("action");
        $.post(URL,
                formData,
                function(data, textStatus, jqXHR)
                {
                    calculateDivMetric(data);
                }).fail(function(jqXHR, textStatus, errorThrown)
        {
        });
    });

    ///////////////////
    function calculateDivMetric(outData) {
        var parsData = jQuery.parseJSON(outData);
        formdataSave = outData;
        if (parsData.uVal == 'kg') {
            var bmiindex = parsData.weight / ((parsData.height / 100) * (parsData.height / 100));
        }
        else {
            var bmiindex = parsData.weight / ((parsData.height) * (parsData.height)) * 703;
        }

        if (parsData.height && parsData.weight) {
            $('#bmibmrRes').html('<h3>Your BMI is: <strong>' + bmiindex + '</strong></h3>');
            //$('#bmibmrRes').append('<br>Note:<br> '+parsData.descriptionB);

            $('#bmibmrRes').append('<div id="data-panel"> \
		  	<div class="col-md-6">\
				<table class="table table-striped">\
				  <tr>\
				  	<td>Underweight</td>\
				  	<td>less than 20</td>\
				  </tr>\
				   <tr>\
				  	<td>Normal</td>\
				  	<td>20-25</td>\
				  </tr>\
				  <tr>\
				  	<td>Overweight</td>\
				  	<td>25-30</td>\
				  </tr>\
				  <tr>\
				  	<td>Obese</td>\
				  	<td>30-40</td>\
				  </tr>\
				  <tr>\
				  	<td>Morbidly Obese</td>\
				  	<td>more than 40</td>\
				  </tr>\
				</table>\
			</div>\
		</div>');

            $('#bmiloggedin').html('<hr> Because you are logged in, you can <strong><a id="saveBData" href="#">Save data</a></strong> and retrieve it anytime by logging in!');
            $('.notauser').html('<h4 style="color:#FF5C00;">Logged in users can save data for later reference!</h4>');



            if ($('#bmrCheck').val()) {
                var calcFront = $("#bmibmrCalc").serializeArray();
                var URL = $("#calcFront").attr("data-calcFront");
                $.post(URL,
                        calcFront,
                        function(data, textStatus, jqXHR)
                        {
                            //bmibmrRes
                            $("#bmibmrRes").prepend(data);
                        }).fail(function(jqXHR, textStatus, errorThrown)
                {
                });
            }
            ;


        }
        else {
            $('#bmibmrRes').html('<h3 style="color:red;">Enter ALL data</h3>');
            $('#bmiloggedin').empty();
        }
    }

    $('.calcValues').on("change", "#uVal", function() {
        var element = $(this).find('option:selected');
        var byTag = element.attr("data-matchV");
        $('#mVal option[data-matchV="' + byTag + '"]').attr('selected', 'selected');
    });
    $('.calcValues').on("change", "#mVal", function() {
        //$("#uVal").val($(this).val());
        var element = $(this).find('option:selected');
        var byTag = element.attr("data-matchV");
        $('#uVal option[data-matchV="' + byTag + '"]').attr('selected', 'selected');
    });

    ///////////////////
    $('.calcValues').on("click", "#bfatguide_btn", function(ev) {
        ev.preventDefault();
        $(".bfatguide").slideDown();
    });

    ///////////////////
    $('.calcValues').on("click", "#f_close", function(ev) {
        ev.preventDefault();
        ev.stopPropagation;
        $(".bfatguide").slideUp();

    });

    ///////////////////

    $('#bmi').click(function(eve) {
        eve.preventDefault();
        var datapanel = $("#data-panel");
        $(datapanel).hide();
        var formPath = $(this).attr("data-formPath");
        $(datapanel).load(formPath);
        $(datapanel).fadeIn("fast");
    });
    $('#bmr').click(function(eve) {
        eve.preventDefault();
        var datapanel = $("#data-panel");
        $(datapanel).hide();
        var formPath = $(this).attr("data-formPath");
        $(datapanel).load(formPath);
        $(datapanel).fadeIn("fast");
    });


    $('#clients').click(function(eve) {
        eve.preventDefault();

        var URL = $(this).attr("data-formPath");
        $.post(URL,
            function(data, textStatus, jqXHR)
            {
                $("#clientlist").empty();
                var userData =  $.parseJSON(data);

                $("#clientlist").append("<ul>");
                $.each(userData, function(){
                    $("#clientlist").append("<li class='clientitem' data-userid='"+this.ID+"' ><strong>" + this.user_login +"</strong>, <i>"+this.user_email+"</i></li>");
                });
                $("#clientlist").append("</ul>");
                $("#clientlistbtn").click();

            }).fail(function(jqXHR, textStatus, errorThrown)
            {
            });
    });

    $(document).on("click", '.clientitem', function() {


        var pluginURL  = $("#hiddenppath").attr("data-Path");
        //console.log(pluginURL);

        var clientID = $(this).attr("data-userid");
        //console.log(clientID);


        $.ajax({
            url: pluginURL+"/bmi-bmr-calculator/includes/client.php",
            data: {
                'clientid': clientID
            },
            success: function(data) {
                console.log(data);

                var datapanel = $("#data-panel");
                $(datapanel).empty();
                $(datapanel).hide();
                $(datapanel).html(data);
                $(datapanel).fadeIn("fast");

                //hide modal
                $('#myModal').modal('hide');
                getSavedData(clientID);


            },
            error: function(errorThrown) {
                //console.log(errorThrown);
            }
        });


    });



//////////////////////////////////
    function bmibmr_save() {
        var holdData = jQuery.parseJSON(formdataSave);
        console.log(holdData);
        $.ajax({
            url: ajaxurl,
            data: {
                'action': 'bmibmr_save',
                'holdData': holdData
            },
            success: function(data) {
                location.reload(true);
            },
            error: function(errorThrown) {
                //console.log(errorThrown);
            }
        });
    }

///////////////////////////////
    $(document).on("click", "#saveBData", function(ev) {
        ev.preventDefault();
        bmibmr_save();
    });

//////////////////////////////
    $('.btn-group').button();



    $('body').on("click", "#uVal1", function(ev) {
        $("#weight").html("pounds (lbs)");
        $("#height").html("inches (in)");
    });

    $('body').on("click", "#uVal2", function(ev) {
        $("#weight").html("kilograms (kg)");
        $("#height").html("centimeters (cm)");
    });


    //get saved data
    function getSavedData(clientid) {

        var pluginURL  = $("#hiddenppath").attr("data-Path");

        if (clientid === undefined) {
            var clientID = '';
        }
        else {
            var clientID = clientid;
        }

        console.log(clientID);


        $.ajax({
            url: pluginURL+"/bmi-bmr-calculator/bmibmr_saved.php",
            data: {
                'clientid': clientID
            },
            success: function(data) {
                $("#savedDataBmiBmr").html(data);

            },
            error: function(errorThrown) {
                //console.log(errorThrown);
            }
        });
    }

    var hiddenUserID  = $("#hiddenuserid").attr("data-userid");

    getSavedData(hiddenUserID);


});
