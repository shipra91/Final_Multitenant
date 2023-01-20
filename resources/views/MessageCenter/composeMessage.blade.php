@php

@endphp

@extends('layouts.master')
@section('content')
<style>
    /* .checkbox+.checkbox, .radio+.radio {
        margin-top: 0px!important;
    } */
    .checkbox .checkbox-material {
        top: 1px!important;
    }
</style>
<div class="wrapper">
    @include('sliderbar')
    <div class="main-panel">
        @include('navigation')
        <div class="content">
			<form id="composeMessageForm" method="POST" data-destroy="false">
				<input type="hidden" name="send_to" id="send_to" value="ALL" />
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-12 col-sm-offset-0">
							<div class="card">
								<div class="card-header card-header-tabs p-0" data-background-color="mediumaquamarine">
									<div class="nav-tabs-navigation">
										<div class="nav-tabs-wrapper">
											<span class="nav-tabs-title font-16">Compose Message</span>
											<ul class="nav nav-tabs" data-tabs="tabs"></ul>
										</div>
									</div>
								</div>

								<div class="card-content">
									<div class="tab-content mt-0" style="padding: 10px 0px;">
										<div class="row">
											<div class="col-md-5">
                                                <div class="form-group">
												    <label class="control-label mt-0">SMS Template</label>
                                                    <select class="selectpicker" name="sms_template" id="sms_template" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select">
														@foreach($details['smsTemplateDetails'] as $smsTemplates)
															<option value="{{$smsTemplates->id}}">{{$smsTemplates->template_name}}</option>
														@endforeach
                                                    </select>
                                                </div>
											</div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Description</label>
                                                    <textarea class="form-control" name="description" id="description" rows="3" onFocus="countChars('char_count',160)" onKeyDown="countChars('char_count',160)" onKeyUp="countChars('char_count',160)" required ></textarea>
                                                </div>
                                            </div>

										    {{-- <div class="col-md-12">
											    <div class="form-group">
												    <label>Description</label>
												    <div class="form-group label-floating">
													<textarea class="form-control" name="description" id="description" rows="5" onFocus="countChars('char_count',160)" onKeyDown="countChars('char_count',160)" onKeyUp="countChars('char_count',160)" required ></textarea>
												</div>
											</div> --}}

                                            <div class="col-sm-12">
                                                <div class="card-footer1">
                                                    <div class="stats1">
                                                        <span id="char_count">Character Count: 0/160</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row d-none" id="message_type_details">
						<div class="col-sm-12 col-sm-offset-0">
							<div class="card">
								<div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
									<div class="nav-tabs-navigation">
										<div class="nav-tabs-wrapper">
											<ul class="nav nav-tabs" data-tabs="tabs">
												<li class="active" onclick="send_to('ALL')">
													<a href="#all" data-toggle="tab">
														<i class="material-icons">message</i> All
														<div class="ripple-container"></div>
													</a>
												</li>

												<li class="" onclick="send_to('STAFF')">
													<a href="#staff" data-toggle="tab">
														<i class="material-icons">message</i> Staff
														<div class="ripple-container"></div>
													</a>
												</li>

												<li class="" onclick="send_to('STUDENT')">
													<a href="#student" data-toggle="tab">
														<i class="material-icons">message</i> Student
														<div class="ripple-container"></div>
													</a>
												</li>

												<li class="" onclick="send_to('GROUP')">
													<a href="#group" data-toggle="tab">
														<i class="material-icons">message</i> Group
														<div class="ripple-container"></div>
													</a>
												</li>

												<li class="" onclick="send_to('INDIVIDUAL')">
													<a href="#individual" data-toggle="tab">
														<i class="material-icons">message</i> Individual
														<div class="ripple-container"></div>
													</a>
												</li>

												<li class="" onclick="send_to('CLASSWISE')">
													<a href="#classwise" data-toggle="tab">
														<i class="material-icons">message</i> Class Wise
														<div class="ripple-container"></div>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</div>

								<div class="card-content">
									<div class="tab-content">
										<div class="tab-pane wizard-pane active" id="all">
											<div class="checkbox-radios">
												<div class="row">
													<div class="checkbox col-lg-2 mt-0">
														<label>
															<input type="checkbox" name="message_type[]" id="alls" value="all" data-count="0" class="messageType">ALL
															<span class="badge" style="margin-top: -4px; margin-left: 4px;">{{$details['all_count']}}</span>
														</label>
													</div>

													<div class="checkbox col-lg-2 mt-0">
														<label>
															<input type="checkbox" name="message_type[]" id="staffs" value="allStaff" class="cb-all messageType" data-count="{{$details['all_staff_count']}}">STAFF
                                                            <span class="badge" style="margin-top: -4px; margin-left: 4px;">{{$details['all_staff_count']}}</span>
														</label>
													</div>

													<div class="checkbox col-lg-2 mt-0">
														<label>
															<input type="checkbox" name="message_type[]" id="students" value="allStudent" class="cb-all messageType" data-count="{{$details['all_student_count']}}">STUDENT
                                                            <span class="badge" style="margin-top: -4px; margin-left: 4px;">{{$details['all_student_count']}}</span>
														</label>
													</div>
												</div>
											</div>
										</div>

										<div class="tab-pane wizard-pane" id="staff">
											<div class="checkbox-radios">
												<div class="row">
													<div class="checkbox col-lg-3 mt-0">
														<label>
															<input type="checkbox" name="staff_category[]" value="all" id="allStaffCategory"  class="messageType" data-count="0"> ALL<span class="badge" style="margin-top: -4px; margin-left: 4px;">{{$details['all_staff_count']}}</span>
														</label>
													</div>
													@foreach($details['staffCategoryDetails'] as $categoryDetails)
														<div class="checkbox col-lg-3 mt-0">
															<label>
																<input type="checkbox" name="staff_category[]" id="staff_category" value="{{$categoryDetails->label}}" class="cb-staff messageType" data-count="{{$categoryDetails->count}}" />{{$categoryDetails->name}}<span class="badge" style="margin-top: -4px; margin-left: 4px;">{{$categoryDetails->count}}</span>
															</label>
														</div>
													@endforeach
												</div>
											</div>
										</div>

										<div class="tab-pane wizard-pane" id="student">
											<div class="checkbox-radios">
												<div class="row">
													<div class="checkbox col-lg-4 mt-0">
														<label>
														    <input type="checkbox" name="institutionStandard[]" id="allStandardStudents" value="all" class="messageType" data-count="0"> ALL
														    <span class="badge" style="margin-top: -4px; margin-left: 4px;">{{$details['all_student_count']}}</span>
                                                        </label>
													</div>
												</div>

												<div class="row">
													@foreach($details['institutionStandardDetails'] as $institutionStandard)
														<div class="checkbox col-lg-4 mt-0">
															<label>
															    <input type="checkbox" name="institutionStandard[]" value="{{$institutionStandard['id']}}" class="cb-student messageType" data-count = "{{$institutionStandard['standard_student_count']}}">{{$institutionStandard['name']}}
															    <span class="badge" style="margin-top: -4px; margin-left: 4px;">{{$institutionStandard['standard_student_count']}}</span>
                                                            </label>
														</div>
													@endforeach
												</div>
											</div>
										</div>

										<div class="tab-pane wizard-pane" id="group">
											<div class="checkbox-radios">
												@foreach($details['messageGroupDetails'] as $groupDetails)
													@if($groupDetails->count > 0)
                                                        <div class="row">
                                                            <div class="checkbox col-lg-4 mt-0">
                                                                <label>
                                                                    <input type="checkbox" name="groups[]" value="{{$groupDetails->id}}" id="" data-count = "{{$groupDetails['count']}}" class="cb-g messageType">
                                                                    {{$groupDetails->group_name}}<span class="badge" style="margin-top: -4px; margin-left: 4px;">{{$groupDetails['count']}}</span>
                                                                </label>
                                                            </div>
                                                        </div>
													@endif
												@endforeach
											</div>
										</div>

										<div class="tab-pane wizard-pane" id="individual">
											<div class="row">
												<input type="hidden" id="individual_phone_number" name="individual_phone_number" />
												<input type="hidden" id="individual_id_staff_student" name="individual_id_staff_student" />
												<div class="col-lg-8 col-lg-offset-2">
													<div class="form-group">
														<input type="text" class="form-control autocomplete" id="autocomplete" placeholder="Type name or phone number here" />
													</div>
												</div>

												<div class="col-lg-12 col-lg-offset-0 mb-20">
													<table class="table table-striped table-no-bordered table-hover mt-30">
														<thead style="font-size:12px;">
															<tr>
																<th width="20%"><b>Name</b></th>
																<th width="30%"><b>Standard</b></th>
																<th width="30%"><b>Phone Number</b></th>
																<th width="10%"><b>Type</b></th>
																<th width="10%"><b>Remove</b></th>
															</tr>
														</thead>
														<tbody id="selectedStudent">

														</tbody>
													</table>
												</div>
											</div>
										</div>

										<div class="tab-pane wizard-pane" id="classwise">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="input" class="classwise-input">
                                                        <input type="text" data-role="tagsinput" id="tagsinput" name="tagsinput" readonly /></input>
                                                    </div>
                                                </div>
                                            </div>
											<input type="hidden" id="tag_phone" name="tag_phone" />
											<input type="hidden" id="student_id_details" name="student_id_details" />
                                            <div class="row mt-10">
                                                @foreach($details['institutionStandardDetails'] as $institutionStandard)
                                                    <div class="col-md-4">
                                                        <a href="javascript:void(0);" data-id="{{$institutionStandard['id']}}" rel="tooltip" title="View Student" class="btn btn-warning btn-raised btn-block institutionStandard">{{$institutionStandard['name']}}</a>
                                                    </div>
                                                @endforeach
                                            </div>
										</div>
									</div>
                    			</div>
                			</div>
						</div>
					</div>

					<div class="row d-none" id="credit_details">
                        <div class="col-sm-12 col-sm-offset-0">
                            <div class="card mt-0">
                                <div class="card-content">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th width="25%"><b>Total Credit</b></th>
                                                <th width="25%"><b>Balance Credit</b></th>
                                                <th width="25%"><b>Sending Recipients</b></th>
                                                <th width="25%"><b>Consuming Credit</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="25%">{{$details['msgCreditDetails']['total_credit']}}</td>
                                                <td width="25%" id="balance_credit_count">{{$details['msgCreditDetails']['balance_credit']}}</td>
                                                <td width="25%" id="recipients_count">0</td>
                                                <td width="25%" id="consuming_credit_count"></td>
                                            </tr>
                                        </tbody>

                                    </table>

                                    <div class="pull-right d-none" id="submitButton">
                                        <div class="form-group">
                                            <button type="submit" id="submit" class="btn btn-fill btn-wd btn btn-info">Send Message</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Class wise modal -->
<div id="student_modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header m-h">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
				    <i class="material-icons m-i">clear</i>
				</button>
				<h4 class="modal-title m-t" id="standardName"></h4>
			</div>

			<div class="modal-body">
				<div class="row">
                    <div class="col-lg-12" id="student_details">

                    </div>
				</div>
            </div>

			<div class="modal-footer">
                <div class="row">
                    <div class="col-lg-12">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script-content')
<script>
	function send_to(method){

		$("#send_to").val(method);
		var totalSmsCount = 0;
		var totalConsumingCount = 0 ;
		var html = '';
		var phoneNumber = '';
		$('#recipients_count').html(totalSmsCount);
		$('#consuming_credit_count').html(totalConsumingCount);
		document.getElementById("alls").checked = false;
		document.getElementById("staffs").checked = false;
		document.getElementById("students").checked = false;
		document.getElementById("allStaffCategory").checked = false;
		document.getElementById("staff_category").checked = false;
		document.getElementById("tagsinput").value = '';
		$('#tag_phone').val(phoneNumber);
		$('.bootstrap-tagsinput').html(html);
		$("#selectedStudent").html(html);
		$('#student_id_details').val(html);

		$('input[type="checkbox"]:checked').each(function(){
			$(this).prop('checked', false);
		});
	}

	function getConsumingCredit(totalSmsCount, count){

		var balanceCreditCount = 0;
		var method = $("#send_to").val();

		if($('#balance_credit_count').html()){
			balanceCreditCount = $('#balance_credit_count').html();
		}

		totalConsumingCount = totalSmsCount * Math.ceil(count/160);
		$('#consuming_credit_count').html(totalConsumingCount);

		if(totalSmsCount > 0 && totalConsumingCount > 0){

			$('#submitButton').removeClass('d-none');

			if(totalConsumingCount > balanceCreditCount){

				alert("Your SMS credits is low please contact eGenius service team");
				$('#submitButton').addClass('d-none');
				send_to(method);
    		}

		}else{

			$('#submitButton').addClass('d-none');
		}
	}

	function countChars(counter, max){

		count = $('#description').val().replace(/\s\s+/g, ' ').length;

		var round_off = Math.ceil(count/156);
		var count1 = $('#description').val().length - max;

		if (count > max) { document.getElementById(counter).innerHTML = "<span>Character Count: " + count + "/"+max+"</span> <span style=\"color: red;\">Character exceeded by: " + count1 + ". This amounts to "+round_off+" SMS per user.</span>"; }
		else { document.getElementById(counter).innerHTML = "<span>Character Count: " + count + "/"+max+"</span>"; }
		$('#description').text($('#description').val().replace(/\s\s+/g, ' '));
		$('#description').text($('#description').val().replace(/['"]/g,''));

		var totalSmsCount = $('#recipients_count').html();
		getConsumingCredit(totalSmsCount, count);
	}

	function getIndividualCount(){

		var phoneNumberArray = [];
		var phoneNumbers = $('#individual_phone_number').val();
		// console.log(phoneNumbers);

		count = $('#description').val().replace(/\s\s+/g, ' ').length;
		var phoneNumberDetails = phoneNumbers.split(",");

		for(var i = 0; i < phoneNumberDetails.length; i++){
			if(phoneNumberDetails[i] != ''){
				phoneNumberArray.push(phoneNumberDetails[i]);
			}
        }
		var totalSmsCount = phoneNumberArray.length;
		$('#recipients_count').html(totalSmsCount);
		getConsumingCredit(totalSmsCount, count);
	}

	function addDetails(main, item){
		if(main != ""){
			if(main == ','){
				main ='';
			}else{
				main = main + "," +  item;
				main = main.replace(",,", ",");
			}
		}else{
			main =  item;
		}
		return main;
	}

	function removeDetails(main){

		if(main == ','){
			main = '';
		}else{
			main = main.replace(",,", ",");
		}
		return main;
	}

    $(document).ready(function(){

		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

		$('body').delegate('.messageType', 'change', function(event){
            event.preventDefault();

			var totalSmsCount = 0;

			count = $('#description').val().replace(/\s\s+/g, ' ').length;
			$('.messageType:checked').each(function(){
				totalSmsCount = parseInt(totalSmsCount)+parseInt($(this).attr('data-count'));
			});

			$('#recipients_count').html(totalSmsCount);
			getConsumingCredit(totalSmsCount, count);
		});

		// Get description for template Id
		$('#sms_template').on('change', function(event){
        	event.preventDefault();

			var method = $("#send_to").val();
			send_to(method);
            var smsTemplateId =  $(this).val();

            $.ajax({
                url:"/sms-template-details",
                type:"POST",
                data: {smsTemplateId : smsTemplateId},
                success: function(data){
					var description = $(data.template_detail).text();
					description = description.replace(/\s\s+/g, ' ');
					description = description.replace(/['"]/g,'');

                    $("#description").text(description);
					countChars('char_count', '160')
					$('#message_type_details').removeClass('d-none');
					$('#credit_details').removeClass('d-none');
                }
            });
        });

		// For all selection
		$('#alls').change(function (){
			$('.cb-all').prop('checked',this.checked);
		});

		$('.cb-all').change(function (){
		 	if($('.cb-all:checked').length == $('.cb-all').length){
		  		$('#alls').prop('checked',true);
		 	}else{
		  		$('#alls').prop('checked',false);
		 	}
		});

		// For staff selection
		$('#allStaffCategory').change(function (){
			$('.cb-staff').prop('checked',this.checked);
		});

		$('.cb-staff').change(function (){
		 	if($('.cb-staff:checked').length == $('.cb-staff').length){
		  		$('#allStaffCategory').prop('checked',true);
		 	}else{
		  		$('#allStaffCategory').prop('checked',false);
		 	}
		});

		// For student selection
		$('#allStandardStudents').change(function (){
			$('.cb-student').prop('checked',this.checked);
		});

		$('.cb-student').change(function (){
		 	if($('.cb-student:checked').length == $('.cb-student').length){
		  		$('#allStandardStudents').prop('checked',true);
		 	}else{
		  		$('#allStandardStudents').prop('checked',false);
		 	}
		});

        // Get students
        $('#autocomplete').autocomplete({

			source: function(request, response){

				$.ajax({
					type: "POST",
					url: '{{ url("staff-student-search-mc") }}',
					dataType: "json",
					data: {
						term: request.term
					},
					success: function(data){
						response(data);
						response($.map(data, function(item){
							var code = item.split("@");
							// console.log(code);
							var code1 = item.split("|");
							return {
								label: code[0],
								value: code[0],
								data: item
							}
						}));
					}
				});
			},
			autoFocus: true,
			minLength: 2,
			select: function(event, ui){
				var names = ui.item.data.split("@");
				var insert = true;
				var length = $('#selectedStudent tr').length;

				if (length > 0){

					$('#selectedStudent tr').each(function(){

						if ($(this).attr("id") == names[4]){

							swal({
								title: "Phone Number Already Added!",
								buttonsStyling: false,
								confirmButtonClass: "btn btn-success"
							}).catch(swal.noop)
							$("#autocomplete").val("");
							insert = false;
						}
					});
				}

				if (insert == true){

					$("#selectedStudent").append('<tr id=' + names[4] +
						'><td>' + names[2] + '</td><td>' + names[3] +
						'</td> <td>' + names[4] + '</td><td>' + names[6] +
						'</td><td><button type="button" rel="tooltip" class="btn btn-danger btn-xs deleteStudent" data-id = ' +
						names[4] +
						' data-id_staff_student = ' +
						names[1] +
						' title=""  data-original-title="delete"><i class="material-icons">close</i><div class="ripple-container"></div></button></td></tr>');

					var individualPhoneNumber = addDetails($('#individual_phone_number').val(), names[4]) ;
					var individualIdStaffStudent = addDetails($('#individual_id_staff_student').val(), names[1]);

					$('#individual_phone_number').val(individualPhoneNumber);
					$('#individual_id_staff_student').val(individualIdStaffStudent);

					$("#autocomplete").val("");
				}
				getIndividualCount();

				return false;
			}
		});

		// Remove student or staff
		$("body").delegate(".deleteStudent", "click", function(event){
            event.preventDefault();

            var phoneNumber = $(this).attr('data-id');
			var phoneNumber = $(this).attr('data-id');
			var idStaffStudent = $(this).attr('data-id_staff_student');

            $("#selectedStudent tr#" + phoneNumber).remove();
            var length = $('#selectedStudent tr').length;

			var individualPhoneNumber = removeDetails($('#individual_phone_number').val().replace(phoneNumber, ""));
			var individualIdStaffStudent = removeDetails($('#individual_id_staff_student').val().replace(idStaffStudent, ""));

			$('#individual_phone_number').val(individualPhoneNumber);
			$('#individual_id_staff_student').val(individualIdStaffStudent);

			getIndividualCount();
        });

		// Get student for standard for classwise selection
        $("body").delegate(".institutionStandard", "click", function(event){
            event.preventDefault();

            var standardId=$(this).attr('data-id');

            $.ajax({
                url:"{{ url('/get-standard-students') }}",
                type : "post",
                dataType : "json",
                data : {standardId:standardId},
                success : function(response){
                    var html = '';
					var details = '';
					var standard = '';
					var existingPhones = $("#tag_phone").val();
					var existingPhoneArray = existingPhones.split(',');

					details += '<div class="row">';
					response.forEach((item)=>
                    {
						var checked = '';

						if(item.phone_number != '0' && item.phone_number != ''){
							if(existingPhoneArray.includes(item.phone_number)){
								checked = 'checked';
							}
							details += '<div class="checkbox message-checkbox col-lg-3">';
							details += '<label><input type="checkbox" class="studentName" name="student_details" id="student_id'+item.id_student+'" data-id="'+item.id_student+'" value="'+item.phone_number+'" data-storage="false" '+checked+'>'+item.name+'</label>';
							details += '</div>';
							standard = item.class;
						}
					});
					details += '</div>';

					$("#student_modal").find("#standardName").html(standard);
					$("#student_modal").find("#student_details").html(details);
                    $("#student_modal").find('tbody').html(html);
                    $("#student_modal").modal('show');
                }
            });
        });

		// To display checked student number in tag input for classwise selection
		$('body').delegate("input:checkbox[class=studentName]", "change", function(event){
            event.preventDefault();

            var id = $(this).attr('data-id');
			var phone = $(this).val();
			var studentDetails = '';
			var phoneNumberArray = [];
			count = $('#description').val().replace(/\s\s+/g, ' ').length;

			if($(this).is(":checked")){

				var tagsinput = addDetails($('#tag_phone').val(), phone);
				var studentIdDetails = addDetails($('#student_id_details').val(), id);

				var html = '<span class="tag label label-info" id="'+ phone +'">' + phone + '<span data-role="remove"></span></span>';
				$('.bootstrap-tagsinput').append(html);
				$('#tag_phone').val(tagsinput);
				$('#student_id_details').val(studentIdDetails);

			}else{

				$("#"+phone).remove();

				var tagsinput = removeDetails($('#tag_phone').val().replace(phone, ""));
				var studentIdDetails = removeDetails($('#student_id_details').val().replace(id, ""));

				$('#tag_phone').val(tagsinput);
				$('#student_id_details').val(studentIdDetails);
			}

			var phoneNumberDetails = tagsinput.split(",");
			for(var i = 0; i < phoneNumberDetails.length; i++){
				if(phoneNumberDetails[i] != ''){
					phoneNumberArray.push(phoneNumberDetails[i]);
				}
        	}
			var totalSmsCount = phoneNumberArray.length;
			$('#recipients_count').html(totalSmsCount);
			getConsumingCredit(totalSmsCount, count);
		});

		// Send message
		$('body').delegate('#composeMessageForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

			if(confirm("Are you sure want to send the message?")){

				$.ajax({
					url:"/compose-message",
					type:"POST",
					dataType:"json",
					data: new FormData(this),
					contentType: false,
					processData:false,
					beforeSend:function(){
						btn.html('Sending...');
						btn.attr('disabled',true);
					},
					success:function(result){
						btn.html('Submit');
						btn.attr('disabled',false);

						if(result['status'] == "200"){

							if(result.data['signal'] == "success"){

								swal({
									title: result.data['message'],
									buttonsStyling: false,
									confirmButtonClass: "btn btn-success"
								}).then(function() {
									window.location.reload();
								}).catch(swal.noop)

							}else if(result.data['signal'] == "exist"){

								swal({
									title: result.data['message'],
									buttonsStyling: false,
									confirmButtonClass: "btn btn-warning"
								});

							}else{

								swal({
									title: result.data['message'],
									buttonsStyling: false,
									confirmButtonClass: "btn btn-danger"
								});
							}

						}else{

							swal({
								title: 'Server error',
								buttonsStyling: false,
								confirmButtonClass: "btn btn-danger"
							})
						}
					}
				});
			}
        });
    });
</script>
@endsection
