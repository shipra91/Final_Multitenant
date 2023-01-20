<nav class="navbar navbar-transparent navbar-absolute">
    <div class="container-fluid">
        <div class="navbar-minimize">
            <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                <i class="material-icons visible-on-sidebar-mini">view_list</i>
            </button>
        </div>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- <a class="navbar-brand" href="index.php"> Dashboard</a> -->
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">

                @if(count(session('allUsers')) > 0)
                <li class="mr-15">
                    <div class="input-group">
                        <div class="form-group">
                            <select class="selectpicker user_change" name="user_change" id="user_change"
                                data-style="select-with-transition" data-size="4"
                                title="Select User" data-live-search="true">
                                    @foreach(session('allUsers') as $user)
                                        <option value="{{ $user['id'] }}" @if(session('userId') == $user['id']) {{ "selected" }} @endif>{{ $user['name'] }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                </li>
                @endif

                @if(count(session('allInstitutions')) > 0)
                <li class="mr-15">
                    <div class="input-group">
                        <div class="form-group">
                            <select class="selectpicker institution_change" name="institution_change" id="institution_change"
                                data-style="select-with-transition" data-size="4"
                                title="Select Institution" data-live-search="true">
                                    @foreach(session('allInstitutions') as $institution)
                                        <option value="{{ $institution['id'] }}" @if(session('institutionId') == $institution['id']) {{ "selected" }} @endif>{{ $institution['name'] }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                </li>
                @endif

                <li>
                    <div class="input-group">
                        <div class="form-group">
                            <select class="selectpicker academic_year_change" name="academic_year_change" id="academic_year_change"
                                data-style="select-with-transition" data-size="4"
                                title="Select Academic Year" data-live-search="true">
                                @php
                                    $academicYears = Helper::fetchAcademicYears();
                                @endphp

                                @foreach($academicYears as $academicData)
                                    <option value="{{ $academicData['id'] }}" data-name="{{ $academicData['name'] }}" @if(session('academicYear') == $academicData['id']) {{ "selected" }} @endif>{{ $academicData['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="{{ route('signout') }}" class="dropdown-toggle" rel="tooltip" data-placement="bottom" title="logout">
                        <i class="material-icons">power_settings_new</i>
                        <p class="hidden-lg hidden-md">Profile</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
