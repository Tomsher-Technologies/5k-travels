<div class="dashboard_sidebar">
    <div class="dashboard_sidebar_user">
        <img src="{{ asset('assets/img/avatar-place.png') }}" alt="img">
        <h3>Sherlyn Chopra</h3>
        <p><a href="tel:+00-123-456-789">+00 123 456 789</a></p>
        <p><a href="mailto:sherlyn@domain.com">sherlyn@domain.com</a></p>
    </div>
    <div class="dashboard_menu_area">
        <ul>
            <li><a href="{{ route('web-dashboard')}}" class="active"><i class="fas fa-arrow-right"></i>My Bookings</a></li>
            <li><a href="#"><i class="fas fa-arrow-right"></i>Upcoming</a></li>
            <li><a href="#"><i class="fas fa-arrow-right"></i>Canceled</a></li>
            <li><a href="#"><i class="fas fa-arrow-right"></i>Completed</a></li>
            <li><a href="#"><i class="fas fa-user-circle"></i>My profile</a></li>
            <li><a href="#"><i class="fas fa-bell"></i>Notifications</a></li>
            <li><a href="{{ route('web.logout') }}"><i class="fas fa-sign-out-alt"></i>Logout </a></li>
        </ul>
    </div>
</div>