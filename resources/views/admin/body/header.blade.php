<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand gap-3">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
            </div>

{{--              <div class="position-relative search-bar d-lg-block d-none" data-bs-toggle="modal" data-bs-target="#SearchModal">--}}
{{--                <input class="form-control px-5" disabled type="search" placeholder="Search">--}}
{{--                <span class="position-absolute top-50 search-show ms-3 translate-middle-y start-0 top-50 fs-5"><i class='bx bx-search'></i></span>--}}
{{--              </div>--}}


              <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center gap-1">
                    <li class="nav-item mobile-search-icon d-flex d-lg-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
                        <a class="nav-link" href="avascript:;"><i class='bx bx-search'></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown dropdown-laungauge d-none d-sm-flex">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="avascript:;" data-bs-toggle="dropdown"><img src="assets/images/county/02.png" width="22" alt="">
                        </a>

                    </li>
                    <li class="nav-item dark-mode d-none d-sm-flex" >
                        <a class="nav-link dark-mode-icon" href="javascript:;"><i class='bx bx-moon'></i>
                        </a>
                    </li>


                    <li class="nav-item dropdown dropdown-large">
                        <a   class="  nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" data-bs-toggle="dropdown"><span class="alert-count" id ="notification_count" >{{auth()->user()->unreadNotifications()->count()}}</span>
                            <i class='bx bx-bell'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header">
                                    <p class="msg-header-title">Notifications</p>
                                 </div>
                            </a>
                            <div class="header-notifications-list">


                               @foreach(auth()->user()->notifications as $notification)


                                    <a class="dropdown-item" href="javascript:;" onclick="markNotificationRead('{{$notification->id}}')">
                                        <div class="d-flex align-items-center">
                                            <div class="user-online">
                                                <img src="{{asset('backend/assets/images/avatars/avatar-1.png')}}" class="msg-avatar" alt="user avatar">
                                            </div>
                                            <div class="flex-grow-1 ">
                                                <h6 class="msg-name">{{$notification->data['message']}}
                                                    <span class="msg-time float-end">
                                                        {{\Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}
                                                    </span>
                                                </h6>
                                                <p  class="msg-info">..</p>
                                                @if($notification->read_at ==null)
                                                    <p id="p_{{$notification->id}}" class="newTag msg-header-badge">New</p>
                                                @endif

                                            </div>
                                        </div>
                                    </a>


                                @endforeach

                            </div>
                            <a href="{{route('all.notification')}}">
                                <div class="text-center msg-footer">
                                    <button class="btn btn-primary w-100">View All Notifications</button>
                                </div>
                            </a>
                        </div>
                    </li>

                </ul>
            </div>

@php
        $id = Auth::user()->id;
        $profileData = App\Models\User::find($id);
@endphp

            <div class="user-box dropdown px-3">
                <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ (!empty($profileData->photo)) ? url('upload/admin_images/'.$profileData->photo) : url('upload/no_image.jpg')}}" class="user-img" alt="user avatar">
                    <div class="user-info">
                        <p class="user-name mb-0">{{$profileData->name}}</p>
                        <p class="designattion mb-0">{{$profileData->email}}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item d-flex align-items-center" href="{{route('admin.profile')}}"><i class="bx bx-user fs-5"></i><span>Profile</span></a>
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="{{route('admin.change.password')}}"><i class="bx bx-cog fs-5"></i><span>Change Password</span></a>
                    </li>
                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="{{route('admin.logout')}}"><i class="bx bx-log-out-circle"></i><span>Logout</span></a>
                    </li>
                </ul>
            </div>



        </nav>
    </div>
</header>

<script>
    function markNotificationRead(notificationId){

        fetch('/mark-notification-as-read/'+notificationId,{
            method: 'post',
            headers: {
                'Content-Type' : 'application/josn',
                'X-CSRF-TOKEN' : '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
            .then(response => response.json())
            .then(data => {
                var count = data.count;
                document.getElementById('notification_count').textContent =  count;
                $('#p_'+notificationId).css("visibility","hidden")

                console.log(count )
            })
            .catch(error => {
                console.log('Error',error)
            });
    }
</script>
