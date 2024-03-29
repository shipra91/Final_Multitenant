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
            <a class="navbar-brand" href="index.php"> Dashboard</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">						
                <li>
                    <a href="{{ url('/etpl/signout') }}" class="dropdown-toggle" rel="tooltip" data-placement="bottom" title="logout">
                        <i class="material-icons">power_settings_new</i>
                        <p class="hidden-lg hidden-md">Profile</p>
                    </a>
                </li> 
                <li class="separator hidden-lg hidden-md"></li>
            </ul>
        </div>
    </div>
</nav>