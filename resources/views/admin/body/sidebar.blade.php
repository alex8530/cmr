<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{asset('backend/assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">CMR Project</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
     </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        @can('dashboard.menu')

        <li>
            <a href="{{ route('admin.dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        @endcan 

        @can ('cmr.create')
        <li>
            <a href="{{ route('cmr.create') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Create CMR</div>
            </a>
        </li>
        @endcan 

        @can('all.user')
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">All Users</div>
            </a>
            <ul>

                @can('all.user')
                <li> 
                    <a href="{{route('users.all')}}"><i class='bx bx-radio-circle'></i>Users</a>
                </li>
                @endcan 
          
            </ul>
        </li>
        @endcan 

      
         @can('all.cmr.menu')

         {{-- @php
             
             $permissions = auth()->user()->getAllPermissions();
             $userHasPermission = auth()->user()->hasPermissionTo('all.cmr.menu');
             dd( $userHasPermission );
         @endphp --}}
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
            
                <div class="menu-title">All CMR</div>
            </a>
            <ul>
                @can('completed.cmr.menu')
                <li> 
                    <a href="{{route('cmr.complete')}}"><i class='bx bx-radio-circle'></i>Completed CMR</a>
                </li>
                @endcan

                @can('pending.cmr.menu')
                <li> 
                    <a href="{{route('cmr.pending')}}"><i class='bx bx-radio-circle'></i>Pending CMR</a>
                </li>
                @endcan
          
            </ul>
        </li>
        @endcan


  
        @if(auth()->user()->hasRole('user'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
            
     
                <div class="menu-title">My CMR</div>
            </a>
            <ul>
                @can('completed.cmr.menu')
                <li> 
                    <a href="{{route('my.cmr.complete')}}"><i class='bx bx-radio-circle'></i>Completed CMR</a>
                </li>
                @endcan

                @can('pending.cmr.menu')
                <li> 
                    <a href="{{route('my.cmr.pending')}}"><i class='bx bx-radio-circle'></i>Pending CMR</a>
                </li>
                @endcan
          
            </ul>
        </li>

        @endif


        @if(auth()->user()->hasRole('user') )
        @can('my.request.menu')
        <li>
            <a href="{{route('cmr.request')}}"  >
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">My Requests</div>
            </a>
        </li>
        @endcan
        @endif

        @can('group.menu')
        <li>
            <a href="{{route('group.all')}}"  >
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Groups</div>
            </a>
        </li>
        @endif


        @if(auth()->user()->hasRole('user') )
        @can('my.group.menu')
        <li>
            <a href="{{route('group.cmrs')}}"  >
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">My Group CMR</div>
            </a>
        </li>
        @endcan
         @endif

         @can('role.and.permission.menu')
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Role & Permission</div>
            </a>
            <ul>
                @can('all.role.menu')
                <li> 
                    <a href="{{route('all.roles')}}"><i class='bx bx-radio-circle'></i>ALL Roles</a>
                </li>
                @endcan
            
                @can('all.permission.menu')
                <li> <a href="{{ route('all.permission') }}"><i class='bx bx-radio-circle'></i>All Permission</a>
                @endcan

                @can('role.in.permission.menu')
                    <li> <a href="{{ route('add.roles.permission') }}"><i class='bx bx-radio-circle'></i>Role In Permission</a>
                @endcan

                @can('all.role.with.permission.menu')
             <li> <a href="{{ route('all.roles.permission') }}"><i class='bx bx-radio-circle'></i>All Role With Permission</a>
                @endcan

                @can('manage.role.group.menu')
                <li> <a href="{{ route('all.permission.group') }}"><i class='bx bx-radio-circle'></i>Manage Role Group</a>
                @endcan
          
            </ul>
        </li>
        @endcan

        @can('manage.admin.menu')
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-line-chart"></i>
                </div>
                <div class="menu-title">Manage Admin</div>
            </a>
            @can('manage.admin.all.menu')
            <ul>
                <li> <a href="{{ route('all.admin') }}"><i class='bx bx-radio-circle'></i>All Admin</a>
                </li> 
            </ul>
            @endcan
        </li>
        @endcan

        @can('setting')
        <li class="menu-label">Setting</li>
        @endcan

        @can('setting.smtp.menu')
        <li>
            <a href="{{ route('smtp.setting') }}" target="_blank">
                <div class="parent-icon"><i class="bx bx-folder"></i>
                </div>
                <div class="menu-title">SMTP</div>
            </a>
        </li>
        @endcan
        @can('setting.configration.menu')
        <li>
            <a href="https://themeforest.net/user/codervent" target="_blank">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Configration</div>
            </a>
        </li>
        @endcan


 
    </ul>
    <!--end navigation-->
</div>