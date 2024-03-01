<div class="dashboard_sidebar">
    <div class="dashboard_sidebar_user">
        @php
            $userDetails = getUserDetails(Auth::user()->id);
            $user = Auth::user();
        @endphp
        <a href="{{ route('agent.profile') }}">
            @if ($userDetails[0]->logo != '')
                <img src="{{ asset($userDetails[0]->logo) }}" alt="img">
            @else
                <img src="{{ asset('assets/img/avatar-place.png') }}" alt="img">
            @endif
        </a>
        <h3><a href="{{ route('agent.profile') }}" style="color: inherit;">{{ Auth::user()->name }}</a></h3>
        <!-- <p><a href="javascript::void(0)">{{ Auth::user()->name }}</a></p> -->
        <p><a href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a></p>

        @if ($user->user_type !== 'user')
            <p>Wallet Balance : USD {{ $userDetails[0]->credit_balance }}</p>
        @endif
    </div>
    <div class="dashboard_menu_area">
        <ul>
            <li><a href="{{ route('web-dashboard') }}" class="{{ $type == 'my_bookings' ? 'active' : '' }}"><i
                        class="fas fa-arrow-right"></i>My Bookings</a></li>
            <li><a href="{{ route('upcoming') }}" class="{{ $type == 'upcoming' ? 'active' : '' }}"><i
                        class="fas fa-arrow-right"></i>Upcoming</a></li>
            <li><a href="{{ route('completed') }}" class="{{ $type == 'completed' ? 'active' : '' }}"><i
                        class="fas fa-arrow-right"></i>Completed</a></li>
            <li><a href="{{ route('cancelled') }}" class="{{ $type == 'cancelled' ? 'active' : '' }}"><i
                        class="fas fa-arrow-right"></i>Cancelled</a></li>
            <li><a href="{{ route('rescheduled') }}" class="{{ $type == 'rescheduled' ? 'active' : '' }}"><i
                        class="fas fa-arrow-right"></i>Rescheduled</a></li>
            @if ($user->user_type !== 'user')
                <li><a href="{{ route('sub-agents') }}" class="{{ $type == 'sub_agents' ? 'active' : '' }}"><i
                            class="fas fa-arrow-right"></i>Sub-agents</a></li>
                <li><a href="{{ route('credit-usage') }}" class="{{ $type == 'credit_usage' ? 'active' : '' }}"><i
                            class="fas fa-arrow-right"></i>Credit Usage</a></li>
            @endif
            <li><a href="{{ route('agent.profile') }}" class="{{ $type == 'profile' ? 'active' : '' }}"><i
                        class="fas fa-user-circle"></i>My profile</a></li>
            <!-- <li><a href="#"><i class="fas fa-bell"></i>Notifications</a></li> -->
            <li><a href="{{ route('web.logout') }}"><i class="fas fa-sign-out-alt"></i>Logout </a></li>
        </ul>
    </div>
</div>
