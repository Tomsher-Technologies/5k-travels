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
                        <h2>Terms Of Service</h2>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><span><i class="fas fa-circle"></i></span> Terms Of Service</li>
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
                            <h4>Who we are?</h4>
                            <p>We, the Five Thousand Travel Agency with a website (www.5ktravels.com) offer online travel
                                sales services, encompassing flights, hotels, and car rentals, car rentals, holidays, visas
                                and insurance along with other travel-related services (collectively referred to as the
                                "Services"). These Services are extended to global travelers through our websites, apps, and
                                platforms.</p>
                            <p>It is important to note that Five Thousand Travel Agency is a travel agent and does not
                                assume responsibility for establishing, setting, or controlling all the prices associated
                                with any of the travel options or products available through our services instead Five
                                Thousand Travel Agency benefits from a small markup added to most of the services. The
                                actual Products, promotion and services are provided by independent entities such as API
                                providers, airlines, hotels, tour API operators/providers, or other third-party providers
                                ("Travel Providers"). The terms and conditions governing these products are determined by
                                the respective entities sold and distributed through us.</p>
                            <p>The Services and Platforms are facilitated by Five Thousand Travel Agency Limited, a private
                                limited company incorporated and registered in the United Arab Emirates in Dubai with
                                company license number 1186946. The term "Five Thousand Travel Agency" in these terms may
                                encompass other entities that have direct or indirect control, are controlled by, or share
                                common control with Five Thousand Travel Agency. Detailed information, including our
                                correspondence address and registered office, can be found on our Company page.</p>
                        </div>
                        <div class="terms_item">
                            <h4>Terms of Use:</h4>
                            <p>These terms and conditions ("Terms") govern your access to and utilization of our Services
                                and Platforms, in conjunction with our privacy policy, cookie policy, and community
                                guidelines. By accessing or utilizing the Services or Platforms, you affirm that you have
                                perused, comprehended, and consented to these Terms, as well as the terms outlined in the
                                privacy policy, cookie policy, and community guidelines.</p>
                            <p>Certain Services and Platforms we offer, such as our 'Five Thousand Travel Agency' products,
                                may enforce distinct terms and conditions specific to their usage. In such instances, you
                                will receive clear notifications, and those terms will apply instead of or in conjunction
                                with these overarching Terms as applicable.</p>
                            <p>We retain the right to modify these Terms at our discretion. Any amendments will be promptly
                                published, and your ongoing use of our Services or Platforms following the display of
                                revised terms will be considered as acceptance of the modifications. If you do not agree to
                                all these Terms, it is advisable to refrain from using our Services or Platforms.</p>
                        </div>
                        <div class="terms_item">
                            <h4>Utilizing Our Services</h4>
                            <p>Five Thousand Travels has implemented security procedures, limiting access to personal
                                information and employing processes like password hashing and login auditing to safeguard
                                against unauthorized access.
                            </p>
                            <p>In adherence to relevant laws and for lawful intents, you are permitted to use our Services
                                and Platforms. By accepting these Terms, you are granted a non-transferable, non-exclusive
                                license allowing you to download, access, and employ our Services and Platforms solely for
                                your personal and commercial use and no other purpose contradicting the law. This license is
                                provided under the condition that you undertake not to:</p>
                            <p>Refrain from utilizing Five Thousand Travel Agency's Services or Platforms for any
                                inappropriate, unlawful purposes, or posting, sharing, or transmitting any material that is
                                defamatory, offensive, obscene, or objectionable; breaches confidence, privacy, or any third
                                party's rights, including copyright, trademark, or other intellectual property rights; is
                                intended for self-promotion or promoting third parties; is misleading about your identity or
                                falsely implies sponsorship, affiliation, or connection with Five Thousand Travel Agency; or
                                is made available without proper rights or permissions.</p>
                            <p>1- Avoid using Five Thousand Travel Agency's Services or Platforms for any illegal purposes
                                or in any way that may harm the reputation of Five Thousand Travel Agency or bring it into
                                disrepute.</p>
                            <p>2- Do not disassemble, reverse engineer, or decompile any software, applications, updates, or
                                hardware within or accessible through Five Thousand Travel Agency's Services or Platforms,
                                except where legally permitted.</p>
                            <p>3- Refrain from copying, distributing, publicly communicating, selling, renting, lending, or
                                otherwise using Five Thousand Travel Agency's Services or Platforms, or attempting to
                                violate or circumvent security measures restricting access to these services.</p>
                            <p>4- Avoid using or interfering with Five Thousand Travel Agency's Services or Platforms in a
                                manner that could harm, disable, overload, impair, or compromise the systems or security, or
                                disrupt other users.</p>
                            <p>5- Do not introduce disruptive or malicious code, viruses, worms, trojan horses, or engage in
                                'denial of service' or 'spam' attacks through Five Thousand Travel Agency's Services or
                                Platforms.</p>
                            <p>6- Do not remove, alter, or replace any notices of authorship, trademarks, business names,
                                logos, or other designations of origin on Five Thousand Travel Agency's Services or
                                Platforms, or attempt to misrepresent them as the product of any entity other than Five
                                Thousand Travel Agency.</p>
                            <p>Furthermore, you commit to refraining from using any unauthorized automated computer program,
                                software agent, bot, spider, or other software or application to scan, copy, index, sort, or
                                exploit our Services or Platforms and the associated data. Five Thousand Travel Agency has
                                invested significantly in collecting, processing, and presenting extensive travel data from
                                numerous suppliers, offering access on a commercial API basis. Any violation of this
                                provision constitutes a material breach of these terms, and Five Thousand Travel Agency
                                reserves the right to undertake technical or legal measures to identify and restrict
                                unauthorized automated access to our Services and Platforms.</p>
                            <p>In cases where you register for our Services or Platforms using a log-in account or password,
                                it is your responsibility to maintain the confidentiality and security of those details.
                                Should you become aware or suspect any compromise in the security of your log-in
                                information, please promptly notify us through our Helpdesk helpdesk@5ktravels.com.</p>
                            <p>Our Services and Platforms are not designed for individuals under lawful age or minors, and
                                no one below this age is permitted to provide information through our Services or Platforms.
                                We do not knowingly collect personal information from individuals under 16, and upon
                                discovering any such information, we will promptly delete it in accordance with our Privacy
                                Policy.</p>
                            <p>If a portion of our Services or Platforms is hosted on a third-party website, such as
                                Facebook or another social media platform, and there exist separate terms of use for that
                                specific website, you agree to adhere to those terms and conditions in conjunction with
                                these overarching Terms.</p>

                        </div>
                        <div class="terms_item">
                            <h4>Sharing Information with Us</h4>
                            <p>We prioritize your privacy and consistently adhere to relevant data protection laws. You
                                recognize that any personal data (as defined in our privacy policy) submitted to or via our
                                Services or Platforms may be utilized by us in line with our privacy policy. By agreeing to
                                these Terms, you commit to ensuring the accuracy and currency of all personal data provided
                                to us, obtaining any necessary consents, licenses, or approvals required for us to utilize
                                that information in accordance with these Terms, our community guidelines, and our privacy
                                policy.</p>
                            <p>In cases where our Services or Platforms enable you to post, upload, transmit, or otherwise
                                share information, images, videos, or other data with Five Thousand Travel Agency or other
                                users ("User Content"), you explicitly agree that:</p>
                            <p>1- You bear sole responsibility for the User Content you upload, and you affirm and undertake
                                not to share anything for which you lack the necessary permission or rights, and for which
                                you cannot provide the license detailed in paragraph 2 below</p>
                            <p>2- While you or your licensors retain ownership of all intellectual property rights in any
                                User Content, and you have the liberty to share it with others, you hereby grant Five
                                Thousand Travel Agency and its affiliated companies a non-exclusive, perpetual,
                                royalty-free, global, transferable, and sub-licensable right to host, use, electronically or
                                otherwise reproduce, publicly display, distribute, modify, adapt, publish, translate, and
                                generate derivative works from all such User Content. This includes purposes such as
                                advertising and marketing our Services and Platforms. For instance, we may share User
                                Content with our business partners or other affiliated companies within the Five Thousand
                                Travel Agency Group to showcase on their respective platforms. You maintain control over the
                                User Content uploaded to Five Thousand Travel Agency Services and can revoke this license at
                                any time by either deleting the User Content or your Five Thousand Travel Agency account.
                                Deleted User Content will be promptly removed within 48 hours.</p>
                            <p>3- We bear no obligation to store, retain, publish, or make available any User Content
                                uploaded by you, and you are responsible for creating backups of your own User Content.</p>
                            <p>Should you offer us any suggestions, comments, improvements, ideas, or other feedback
                                ("Feedback"), you are hereby granting us an irrevocable assignment of ownership for all
                                intellectual property rights related to that feedback. Additionally, you acknowledge that we
                                have the authority to utilize and share such Feedback for any purpose of our choosing. Feel
                                free to provide feedback through the 'feedback' tab or via our Helpdesk.</p>
                        </div>

                        <div class="terms_item">
                            <h4>Ownership of Five Thousand Travel Agency Assets</h4>
                            <p>With the exception of provisions outlined elsewhere in these Terms, all intellectual property
                                rights, including copyrights (including those in computer software), patents, trademarks or
                                business names, design rights, database rights, know-how, trade secrets, and rights of
                                confidence present in our Services and Platforms (collectively referred to as "Intellectual
                                Property Rights"), are either owned by or licensed to Five Thousand Travel Agency. It is
                                acknowledged that, through your utilization of the Services or Platforms, you do not gain
                                any rights, titles, or interests in or to these Intellectual Property Rights, except for the
                                limited license granted by these Terms for your use. Furthermore, it is recognized that
                                there is no entitlement to access any of the Services or Platforms in source-code form
                                unless explicitly released under a license allowing such access.</p>
                        </div>

                        <div class="terms_item">
                            <h4>Respecting Intellectual Property Rights</h4>
                            <p>At Five Thousand Travel Agency, we uphold the intellectual property rights of others. If you
                                suspect that your copyright is being violated by any content on our Services or Platforms,
                                please submit a written notification detailing the alleged infringement to email, directed
                                to the attention of our Legal Department. Alternatively, you can communicate with us in
                                writing at:
                            <p>
                            <p>Five Thousand Travel Agency Main Office
                            <p>
                            <p>808, XL Damac Towers, Business Bay, Dubai, United Arab Emirates.
                            <p>
                            <p>To facilitate the resolution of any alleged infringement and, when applicable, to comply with
                                the Digital Millennium Copyright Act (for which the Legal Department serves as the
                                designated agent), please include the following details in your notice:
                            <p>
                            <p>1- Identification of the copyrighted work claimed to be infringed.
                            <p>
                            <p>2- Identification of the alleged infringing material, accompanied by sufficient information
                                to enable us to locate it on our Services (including the URL(s) of the materials).
                            <p>
                            <p>3- Adequate contact information for Five Thousand Travel Agency to reach you, such as an
                                address, telephone number, and, if available, an email address.
                            <p>
                            <p>4- A statement affirming your good faith belief that the disputed use is not authorized by
                                the copyright owner, its agent, or the law.
                            <p>
                            <p>5- For claims under the DMCA only, a sworn statement asserting, under penalty of perjury, the
                                accuracy of the information provided in your notification, confirming that you are the
                                copyright owner or authorized to act on their behalf, and including your physical or
                                electronic signature.
                            <p>

                        </div>


                        <div class="terms_item">
                            <h4>Security Measures</h4>
                            <p>In order to guarantee the security of online payments and any other transactions involving
                                personal data, the website employs SSL (Secure Socket Layer) technology. SSL encrypts all
                                communication between your computer/mobile device and our server, ensuring that the
                                information is comprehensible and accessible only to us. A secure connection is typically
                                indicated by a closed lock on your browser window. Refer to your browser's security
                                specifications for more details. Transactions are automatically secured if your browser
                                supports SSL. A closed lock at the bottom of the browser is the widely recognized indicator
                                of a secure site. Your information remains secure and encrypted as long as the lock icon
                                remains closed, preventing any potential misuse.
                            <p>
                            <p>If, after clicking the secure transaction link, the closed lock is not visible, it may be due
                                to the window being nested in another frame. To confirm a secure connection (in Internet
                                Explorer), right-click and select "Properties," then navigate to "Certificates." This will
                                indicate whether the connection is secure. Alternatively, in Netscape Navigator, right-click
                                and choose 'View Frame Info' at the bottom of the text to access security information.
                            <p>
                        </div>

                        <div class="terms_item">
                            <h4>Credit Card Usage</h4>
                            <p>Please ensure the accurate provision of your credit card billing details. Failure to supply
                                the correct billing address and/or cardholder information for your credit or debit card may
                                lead to delays in ticket issuance and potential overall cost increases. We retain the right
                                to cancel issued tickets in the event of payment declines or the provision of inaccurate
                                credit card details.</p>
                            <p>Furthermore, to mitigate credit card fraud, we reserve the right to conduct random checks.
                                Consequently, before finalizing ticket issuance, we may request additional documentation,
                                such as a fax or postal copy proving your address, a copy of your credit card, and a recent
                                statement.</p>
                        </div>


                        <div class="terms_item">
                            <h4>Passports & Visas Advisory</h4>
                            <p>Kindly ensure the validity of your passport for the entire duration of your trip or if you
                                are travel agent ensure aforementioned for your customer, considering that certain
                                destinations may have specific validity requirements, typically around 6 months post the
                                completion of travel. Additionally, some destinations, including transit points, may mandate
                                obtaining a visa, and it is incumbent upon you to secure one before your journey.</p>
                            <p>When completing a booking, it is crucial to verify that your name, as well as the names of
                                any individuals for whom the booking is made, exactly matches the names in the respective
                                passport(s).</p>
                            <p>For detailed information on passport and visa prerequisites, please reach out to our helpdesk
                                or consult the embassy of the country you intend to visit.</p>
                            <p>Failure to travel with the correct documentation could lead to potential denial of boarding,
                                entry refusal at your destination or stop-over, deportation, or even incarceration. In such
                                instances, any associated costs, losses, or damages incurred by you, us, or our agents will
                                be solely your responsibility. We bear no responsibility for customers lacking the requisite
                                documents and visas.</p>
                        </div>

                        <div class="terms_item">
                            <h4>Airport Taxes</h4>
                            <p>At certain airports, passengers may be subject to an airport departure tax, which must be
                                paid locally at the airport. Details regarding these charges are not included in our quoted
                                fares and are solely the responsibility of the passenger.</p>

                            </p>
                        </div>
                        <div class="terms_item">
                            <h4>Health/Insurance Requirements</h4>
                            <p>Immunization recommendations or requirements for your destination or stopover points should
                                be verified with your doctor. It is advisable to acquire sufficient travel insurance for all
                                international travel.
                            </p>
                        </div>

                        <div class="terms_item">
                            <h4>Website Bookings</h4>
                            <p>We reserve the right to modify any aspect of the website or its content, including the
                                availability of suppliers, features, information, or other content, without prior notice.
                                While every effort is made to ensure the accuracy of information and prices, occasional
                                errors may occur. In the event of an obvious price discrepancy due to a system error, we are
                                not obligated by such prices. Prices and discounts displayed on the website apply
                                exclusively to www.5ktravels.com and may differ from those offered for the same holidays by
                                other businesses. Prices for UAE-based hotels, transfers, marhaba, and insurance are
                                inclusive of VAT.</p>
                            <p>All website bookings are subject to the relevant supplier's/tour operator's booking
                                conditions, in addition to the terms and conditions outlined here. It is recommended to
                                print a copy of the applicable booking conditions during the reservation process, as they
                                contain limitations, exclusions of liability, and specify cancellation and amendment charges
                                applicable if a booking is altered or canceled after confirmation.</p>
                            <p>A reservation is considered incomplete until a confirmed booking reference is provided, which
                                occurs after credit card approval is received from your card issuer, and the supplier
                                confirms your reservation. Until this confirmation, the fare and availability are subject to
                                change.</p>
                            <p>Ensure not to share your booking reference with anyone outside your immediate household. Take
                                necessary precautions to maintain the confidentiality and security of your booking
                                reference.</p>

                        </div>
                        <div class="terms_item">
                            <h4>Security and Privacy Commitment</h4>
                            <p>Our commitment is to employ all reasonable measures to maintain the confidentiality and
                                safeguard the information you transmit through the website from unauthorized access. While
                                we take these precautions, we cannot guarantee that unauthorized access will never occur.
                                Our liability for any unauthorized access is limited to cases solely caused by our gross
                                negligence. In such an event, you may be entitled to compensation, capped at the maximum
                                value of the services purchased by you. All processing of personal data will adhere to the
                                guidelines outlined in our Privacy Policy.</p>

                        </div>
                        <div class="terms_item">
                            <h4>Legal Provisions</h4>
                            <p>- Jurisdiction and Governing Law</p>
                            <p>Your access to this website is contingent upon your acceptance that all information within it
                                and any issues arising between you and us will be subject to the laws of Dubai, United Arab
                                Emirates. Additionally, you agree that any disputes will fall under the exclusive
                                jurisdiction of the Courts of Dubai. We retain the right to pursue legal action for breaches
                                of these terms and conditions in your country of residence or any other relevant country.
                            </p>
                            <p>Agreement between You and Five Thousand Travel Agency also known as 5ktravels: </p>
                            <p>The ownership and operation of the website lie with Five Thousand Travel Agency also named
                                and called as 5K Travels, referred to as 'Five Thousand Travel Agency' herein, with its
                                principal office at 808, XL Damac Towers, Business Bay, Dubai, United Arab Emirates. Five
                                Thousand Travel Agency (5K Travels) is a Dubai corporation established under Decree No.3 of
                                1989 (as amended) by the Government of Dubai.</p>
                            <p>By utilizing the website, you affirm that:</p>
                            <p>You have the legal right and capacity to enter into this Agreement and use the website in
                                accordance with these terms and conditions.</p>
                            <p>You are of legal age to engage in binding contracts via the website and acknowledge
                                responsibility for all payments associated with bookings made using your login information.
                            </p>
                            <p>All information provided about yourself and others is truthful and accurate.</p>
                            <p>• Please ensure you have read and accepted our Privacy Policy</p>
                        </div>
                        <div class="terms_item">
                            <h4>General:</h4>
                            <p>You acknowledge that engaging in unauthorized use of our Services or Platforms may lead to
                                significant and irreparable harm to Five Thousand Travel Agency and/or its affiliates or
                                licensors, for which monetary compensation would be inadequate. Consequently, in the event
                                of such unauthorized use, we and our affiliates and/or licensors (as applicable) reserve the
                                right, in addition to other legal remedies, to promptly seek an injunction against you.</p>
                        </div>

                        <div class="terms_item">
                            <h4>General:</h4>
                            <p>You acknowledge that engaging in unauthorized use of our Services or Platforms may lead to
                                significant and irreparable harm to Five Thousand Travel Agency and/or its affiliates or
                                licensors, for which monetary compensation would be inadequate. Consequently, in the event
                                of such unauthorized use, we and our affiliates and/or licensors (as applicable) reserve the
                                right, in addition to other legal remedies, to promptly seek an injunction against you.</p>

                            <p>The invalidity or unenforceability of any provision, whether in whole or part, within these
                                Terms will not impact the validity or enforceability of the remaining provisions. If a court
                                of competent jurisdiction deems any provision, in whole or part, invalid or unenforceable,
                                that specific provision will be considered deleted from these Terms. These Terms are
                                specific to you, and you are not entitled to assign them, either in whole or in part, to any
                                third party without our prior written consent.</p>
                            <p>Representing the entire agreement between us and you, these Terms supersede and replace any
                                prior terms, conditions, agreements, and arrangements regarding your use of Five Thousand
                                Travel Agency's Services or Platforms.</p>
                            <p>Prompt action will be taken by us in response to any indications of User Content breaching
                                these Terms. If you become aware of or suspect any illegal activities, please contact us
                                through our helpdesk.</p>
                            <p>Our failure to enforce any of these Terms does not constitute a waiver or limit the right to
                                subsequently enforce them. Individuals who are not parties to these Terms have no right to
                                enforce any provision herein.</p>
                            <p>Regardless of the country from which you access or use Services or Platforms, these Terms and
                                your use are governed by the laws of Dubai, and you are deemed to have submitted to the
                                non-exclusive jurisdiction of the court of Dubai to resolve any disputes. If you use the
                                Platforms or Services for commercial purposes or via an unauthorized computer program, as
                                further described and prohibited under the "using our services" section of these Terms, you
                                submit to the exclusive jurisdiction of the court of Dubai for any disputes unless there is
                                an existing commercial agreement between us governing your use, which specifies otherwise.
                            </p>


                        </div>

                        <div class="terms_item">
                            <h4>Get in Touch</h4>
                            <p>For additional information about Five Thousand Travel Agency or if you have any suggestions
                                on enhancing our Services or Platforms, feel free to reach out to our helpdesk.
                                Alternatively, you can send us correspondence at 808, XL Damac Tower, Business Bay, Dubai,
                                UAE.</p>
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
