
    
    <div class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div>
                <img src="{{ asset('backend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
            </div>
            <div>
                <h4 class="logo-text">Hotel App</h4>
            </div>
            <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
            </div>
        </div>
        <!--navigation-->
        <ul class="metismenu" id="menu">

            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <div class="parent-icon"><i class='bx bx-home-alt'></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>

            @if (Auth::user()->can('team.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-category"></i>
                    </div>
                    <div class="menu-title">Manage Teams</div>
                </a>
                <ul>
                    @if (Auth::user()->can('team.all'))
                    <li> <a href="{{ route('team.all') }}"><i class='bx bx-radio-circle'></i>All Team List</a>
                    </li>
                    @endif
                    @if (Auth::user()->can('team.add'))
                    <li> <a href="{{ route('team.add') }}"><i class='bx bx-radio-circle'></i>Add Team Member</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            @if (Auth::user()->can('team.booking.area.menu'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-category"></i>
                    </div>
                    <div class="menu-title">Manage Booking Area</div>
                </a>
                <ul>
                    @if (Auth::user()->can('team.booking.area.edit'))
                    <li> <a href="{{ route('team.booking.area.edit') }}"><i class='bx bx-radio-circle'></i>Update Booking Area</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-category"></i>
                    </div>
                    <div class="menu-title">Manage Room Type</div>
                </a>
                <ul>
                    <li> <a href="{{ route('room.type.list') }}"><i class='bx bx-radio-circle'></i>Room Type List</a>
                    </li>
                </ul>
            </li>
            <li class="menu-label">Manage Bookings</li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-cart'></i>
                    </div>
                    <div class="menu-title">Booking</div>
                </a>
                <ul>
                    <li> <a href="{{ route('booking.list') }}"><i class='bx bx-radio-circle'></i>Booking List</a>
                    </li>
                    <li> <a href="{{ route('room.list.add') }}"><i class='bx bx-radio-circle'></i>Add Booking</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                    </div>
                    <div class="menu-title">Manage Room List</div>
                </a>
                <ul>
                    <li> <a href="{{ route('room.list.view') }}"><i class='bx bx-radio-circle'></i>Room List</a>
                    </li>
                    
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                    </div>
                    <div class="menu-title">Settings</div>
                </a>
                <ul>
                    <li> <a href="{{ route('smtp.setting') }}"><i class='bx bx-radio-circle'></i>SMTP Settings</a>
                    </li>
                    <li> <a href="{{ route('site.setting') }}"><i class='bx bx-radio-circle'></i>Site Settings</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                    </div>
                    <div class="menu-title">Testimonials</div>
                </a>
                <ul>
                    <li> <a href="{{ route('testimonial.all') }}"><i class='bx bx-radio-circle'></i>Testimonials List</a>
                    </li>
                    
                </ul>
                <ul>
                    <li> <a href="{{ route('testimonial.add') }}"><i class='bx bx-radio-circle'></i>Add Testimonials</a>
                    </li>
                    
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                    </div>
                    <div class="menu-title">Blog</div>
                </a>
                <ul>
                    <li> <a href="{{ route('blog.category') }}"><i class='bx bx-radio-circle'></i>Blog Category</a>
                    </li>
                </ul>
                <ul>
                    <li> <a href="{{ route('blog.post.all') }}"><i class='bx bx-radio-circle'></i>Blog Post</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                    </div>
                    <div class="menu-title">Manage Comments</div>
                </a>
                <ul>
                    <li> <a href="{{ route('comment.all') }}"><i class='bx bx-radio-circle'></i>Comments List</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                    </div>
                    <div class="menu-title">Booking Report</div>
                </a>
                <ul>
                    <li> <a href="{{ route('booking.report') }}"><i class='bx bx-radio-circle'></i>Booking Report</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                    </div>
                    <div class="menu-title">Hotel Gallery</div>
                </a>
                <ul>
                    <li> <a href="{{ route('gallery.all') }}"><i class='bx bx-radio-circle'></i>Gallery List</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                    </div>
                    <div class="menu-title">Contact Message</div>
                </a>
                <ul>
                    <li> <a href="{{ route('contact.message') }}"><i class='bx bx-radio-circle'></i>Contact Message</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                    </div>
                    <div class="menu-title">Role and Permission</div>
                </a>
                <ul>
                    <li> <a href="{{ route('permission.all') }}"><i class='bx bx-radio-circle'></i>All Permissions</a>
                    </li>
                </ul>
                <ul>
                    <li> <a href="{{ route('role.all') }}"><i class='bx bx-radio-circle'></i>All Roles</a>
                    </li>
                </ul>
                <ul>
                    <li> <a href="{{ route('role.permission.add') }}"><i class='bx bx-radio-circle'></i>Role in Permission</a>
                    </li>
                </ul>
                <ul>
                    <li> <a href="{{ route('role.permission.all') }}"><i class='bx bx-radio-circle'></i>All Roles and Permissions</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                    </div>
                    <div class="menu-title">Manage Admin User</div>
                </a>
                <ul>
                    <li> <a href="{{ route('admin.all') }}"><i class='bx bx-radio-circle'></i>All Admin</a>
                    </li>
                </ul>
                <ul>
                    <li> <a href="{{ route('admin.add') }}"><i class='bx bx-radio-circle'></i>Add Admin</a>
                    </li>
                </ul>
             
            </li>
            <li class="menu-label">Others</li>
            <li>
                <a href="#" target="_blank">
                    <div class="parent-icon"><i class="bx bx-support"></i>
                    </div>
                    <div class="menu-title">Support</div>
                </a>
            </li>
        </ul>
        <!--end navigation-->
    </div>

   