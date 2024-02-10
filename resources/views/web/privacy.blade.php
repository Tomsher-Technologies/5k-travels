@extends('web.layouts.app')

@section('content')
    <!-- search -->
    <div class="search-overlay">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="search-overlay-layer"></div>
                <div class="search-overlay-layer"></div>
                <div class="search-overlay-layer"></div>
                <div class="search-overlay-close">
                    <span class="search-overlay-close-line"></span>
                    <span class="search-overlay-close-line"></span>
                </div>
                <div class="search-overlay-form">
                    <form>
                        <input type="text" class="input-search" placeholder="Search here...">
                        <button type="button"><i class="fas fa-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Common Banner Area -->
    <section id="common_banner"
        style="background-image: url(https://images.unsplash.com/photo-1682687982501-1e58ab814714?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D); background-size: cover;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="common_bannner_text">
                        <h2>Privacy Policy</h2>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><span><i class="fas fa-circle"></i></span> Privacy Policy</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trems_service Areas -->
    <section id="tour_details_main" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="terms_service_content">
                        <div class="terms_item">
                            <h4>Overview</h4>
                            <p>
                                This Privacy Policy (referred to as the "Policy") outlines our practices regarding the
                                collection, use, disclosure, retention, and handling of your information across all Five
                                Thousand Travel Agency services, encompassing the mobile app, the Five Thousand Travel
                                Agency website, and other service channels like customer support or user research avenues
                                (collectively termed the "Platforms"). To ensure relevance, we periodically review and
                                update the Policy, with the latest version available on this platform.
                            </p>
                            <p>
                                The term 'personal data' is frequently used herein, denoting any information pertaining to
                                you as an identifiable individual. This encompasses details like your name, contact
                                information, trip itinerary, internet protocol ("IP") address, cookie strings or device IDs,
                                and associated information stored with such identifiers, reflecting your usage patterns on
                                our Platforms. "Personal information" is also inclusive within this term.
                            </p>
                            <p>
                                It's important to note that this Policy solely pertains to the collection and use of your
                                information by Five Thousand Travel Agency and does not extend to other companies featuring
                                their products and services on our Platforms, such as airlines, travel agents, hotels, car
                                hire companies, activity providers, carbon offsetting providers, insurers, and travel
                                compensation specialists (collectively referred to as "Travel Providers").
                            </p>
                            <p>In instances where you make a booking or purchase through a Travel Provider, your information
                                will be processed in accordance with their individual privacy notices and terms and
                                conditions. For bookings or purchases made with a Travel Provider on the Five Thousand
                                Travel Agency Platforms, we encourage you to access the linked documents available to review
                                them before finalizing your transaction.
                            </p>
                            <p>As our practices evolve, we will update this Policy periodically. Please check this page
                                occasionally to review the current version. In the event of significant changes, we will
                                provide notice or obtain consent as required by law.</p>
                            <p>All individuals opting to register on our website www.5kravels.com will gain access to
                                seamless online transactions. You'll have the convenience of purchasing or booking the
                                various services provided on the platform.</p>
                            <p>Upon registration, we will gather both personal and non-personal information from you. The
                                personal data may encompass your name, email address, mailing address, telephone number,
                                travel preferences, passport number, user name, and password. We collect information only as
                                entered manually into our forms. This information may be stored in a cookie file on your
                                hard drive, allowing our system to recognize you on subsequent visits. This facilitates
                                saving your preferences and presenting a tailored website without requiring you to log in
                                each time.</p>
                            <p>To enhance services and personalization, we may periodically acquire information about you
                                from independent third-party sources, adding it to your registration details. Authorized
                                personnel may also update your information based on communications received from you. If you
                                reach our site through a partner's site and register with us, your registration information
                                may be shared with the partner, adhering to our policy. However, we cannot govern how the
                                partner utilizes this information.</p>
                            <p>When purchasing products or services for a third party, using your Member ID and password, we
                                collect the third party's name, contact information, and other necessary details as required
                                by the travel service provider(s). Our use of the collected personal information aims to
                                enhance your experience on our website. Registration allows for personalization, automatic
                                login, and tracking transaction history. Periodic contact may include news, important
                                information, or feedback requests. You may opt-out of marketing communications at any time
                                through www.5kravels.com.</p>
                        </div>
                        <div class="terms_item">
                            <h4>Disclosure of Your Personal Information:</h4>
                            <p>Five Thousand Travels does not sell or rent personal information, except to partners as
                                discussed in this policy. Aggregate information may be shared for marketing purposes,
                                ensuring personal identification is not possible.
                            </p>
                            <p>We share personally identifiable information with subsidiaries and sister companies globally,
                                committed to providing comprehensive travel packages. Cooperation with third parties, like
                                airlines, hotels, and insurance companies, is for specific services, with an agreement to
                                use the data solely for providing those services. In compliance with applicable laws,
                                information may also be provided to government agencies. Review and Update of Personal
                                Information: You can review and update your personal information by visiting
                                www.5kravels.com.
                            </p>
                        </div>
                        <div class="terms_item">
                            <h4>Security Measures:</h4>
                            <p>Five Thousand Travels has implemented security procedures, limiting access to personal
                                information and employing processes like password hashing and login auditing to safeguard
                                against unauthorized access.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- newsletter content -->
    @include('web.includes.newsletter')
    <!-- /newsletter content -->
@endsection
