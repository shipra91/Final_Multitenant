<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Multitenant Egenius</title>

    <!-- Core CSS -->
    <link type="text/css" rel="stylesheet" href="{{ asset('//cdn.egenius.in/css/bootstrap.min.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons')}}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('https://fonts.googleapis.com/icon?family=Material+Icons')}}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css')}}" />

    <!-- Custom CSS -->
    <link type="text/css" rel="stylesheet" href="{{ asset('//cdn.egenius.in/css/material-dashboard.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('//cdn.egenius.in/css/demo.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/styles.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/parsley.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('dist/jquery.plugin.full-modal.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.css') }}" />
    {{-- <link type="text/css" rel="stylesheet" href="{{ asset('https://transloadit.edgly.net/releases/uppy/v1.6.0/uppy.min.css') }}"> --}}
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" integrity="sha512-Velp0ebMKjcd9RiCoaHhLXkR1sFoCCWXNp6w4zj1hfMifYB5441C+sKeBl/T/Ka6NjBiRfBBQRaQq65ekYz3UQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />

    <!-- Jquery -->
    <script type="text/javascript" src="{{asset('https://code.jquery.com/jquery-2.1.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/jquery-3.2.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('https://code.jquery.com/ui/1.12.0/jquery-ui.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js" integrity="sha512-Y2IiVZeaBwXG1wSV7f13plqlmFOx8MdjuHyYFVoYzhyRr3nH/NMDjTBSswijzADdNzMyWNetbLMfOpIPl6Cv9g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body class="fix-header fix-sidebar">

    @yield('content')

    <!-- Jquery -->
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/material.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/perfect-scrollbar.jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/arrive.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/chartist.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/jquery.bootstrap-wizard.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/bootstrap-notify.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/bootstrap-datetimepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/jquery-jvectormap.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/nouislider.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/jquery.select-bootstrap.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/jquery.datatables.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/sweetalert2.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/jasny-bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/jquery.tagsinput.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/material-dashboard.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/demo.js')}}"></script>
    <script type="text/javascript" src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/ckeditorNew/ckeditor.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/datePicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/timePicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/input-restriction.js')}}"></script>
    <script type="text/javascript" src="{{asset('dist/jquery.plugin.full-modal.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('https://cdn.jsdelivr.net/momentjs/2.14.1/moment-with-locales.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js')}}"></script>
    <script type="text/javascript" src="{{asset('//cdn.egenius.in/js/garlic.js')}}"></script>
    <script type="text/javascript" src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/jquery-typeahead/2.11.2/jquery.typeahead.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js')}}" ></script>

    {{-- <script src="{{asset('https://transloadit.edgly.net/releases/uppy/v1.6.0/uppy.min.js')}}"></script> --}}

    <script>
        $(document).ready(function(){

            demo.initMaterialWizard();
            setTimeout(function() {
                $('.card.wizard-card').addClass('active');
            }, 600);

            // Tooltip on focus of text input
            $('body .input').tooltip({
                'trigger': 'focus',
                'title': 'Only string with white space, commas, dot, - and \' expressions are allowed '
            });

            $('body .input-address').tooltip({
                'trigger': 'focus',
                'title': 'Only string with white space, commas, hyphen, dot, #,  \' and / expressions are allowed'
            });

            $('body .input-number').tooltip({
                'trigger': 'focus',
                'title': 'Only numbers are allowed'
            });

            // Set session on institution change
            $(document).on('change', '#institution_change', function(){

                var institutionId = $(this).val();

            $.ajax({ 
                url: "{{ url('set-institution-session') }}",
                data: {'institutionId': institutionId},
                type: 'get',
                success: function(response){
                    console.log(response);
                    window.location.reload();
                }
            });
        });        

        // SET SESSION ON USER CHANGE
        $(document).on('change', '#user_change', function(){

            var userId = $(this).val();

            $.ajax({ 
                url: "{{ url('set-user-session') }}",
                data: {'userId': userId},
                type: 'get',
                success: function(response){
                    console.log(response);
                    window.location.reload();
                }
            });
        });

            // Set session on academic year change
            $(document).on('change', '#academic_year_change', function(){

                var academicValue = $(this).val();//alert(academicValue);
                var academicName = $(this).attr('data-name');

                $.ajax({
                    url: "{{ url('set-session') }}",
                    data: {'academicValue': academicValue, 'academicName': academicName},
                    type: 'get',
                    success: function(response){
                        // console.log(response);
                        window.location.reload();
                    }
                });
            });

            // Start date - end date validation
            $(' .startDate, .endDate').on('dp.change', function(){

                var assignment_start_date = $(".startDate").val();
                var assignment_end_date = $(".endDate").val();
                var startDate = assignment_start_date.split("/");
                var endDate = assignment_end_date.split("/");
                var assignmentStartDate = 0;
                var assignmentEndDate = 0;

                if(assignment_start_date != ''){

                    var startDay = startDate[0];
                    var startMonth = startDate[1];
                    var startYear = startDate[2];
                    assignmentStartDate = startYear+'-'+startMonth+'-'+startDay;
                    assignmentStartDate = new Date(assignmentStartDate).getTime();;
                }

                if(assignment_end_date != ''){

                    var endDay = endDate[0];
                    var endMonth = endDate[1];
                    var endYear = endDate[2];
                    assignmentEndDate = endYear+'-'+endMonth+'-'+endDay;
                    assignmentEndDate = new Date(assignmentEndDate).getTime();;
                }

                if(assignmentEndDate != 0){

                    var date = assignment_start_date;

                    if(assignmentStartDate == 0){
                        alert('Please select start date');
                        $(".startDate").val(date);
                    }else if(assignmentStartDate > assignmentEndDate){
                        alert('Start date is lesser than end date');
                        $(".endDate").val(date);
                    }
                }
            });

            // Wizard parsley validation
            var $sections = $('.wizard-pane');

            function navigateTo(index){
                // Mark the current section with the class 'current'
                $sections
                    .removeClass('current')
                    .eq(index)
                    .addClass('current');
                // Show only the navigation buttons that make sense for the current section:
                $('.wizard-footer .btn-previous').toggle(index > 0);
                var atTheEnd = index >= $sections.length - 1;
                $('.wizard-footer .btn-next').toggle(!atTheEnd);
                $('.wizard-footer [type=submit]').toggle(atTheEnd);
            }

            function curIndex() {
                // Return the current index by looking at which section has the class 'current'
                return $sections.index($sections.filter('.current'));
            }

            // btn-previous button is easy, just go back
            $('.wizard-footer .btn-previous').click(function(){
                navigateTo(curIndex() - 1);
            });

            // Next button goes forward if current block validates
            $('.wizard-footer .btn-next').click(function(){
                $('.demo-form').parsley().whenValidate({
                    group: 'block-' + curIndex()
                }).done(function() {
                    navigateTo(curIndex() + 1);
                });
            });

            // Prepare sections by setting the `data-parsley-group` attribute to 'block-0', 'block-1', etc.
            $sections.each(function(index, section) {
                $(section).find(':input').attr('data-parsley-group', 'block-' + index);
            });
            navigateTo(0); // Start at the beginning
        });
    </script>
    @yield('script-content')
</body>
</html>
