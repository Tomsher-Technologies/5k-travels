    <div style="max-width: 650px;margin:auto; box-shadow: rgba(135, 138, 153, 0.10) 0 5px 20px -6px;border-radius: 6px;border: 1px solid #eef1f5;overflow: hidden;background-color: #fff;">
        <div
            style="padding: 1.5rem; display: flex;gap: 8px; align-items: center; justify-content: space-between;flex-wrap: wrap;">
            <div>
                <a href="index.html"><img src="{{ asset('assets/img/logo.png') }}" alt="" height="24"></a>
            </div>
            <div style="display: flex;gap: 6px;">
                <p style="margin-bottom: 0px; font-size: 14px;font-weight: 500;margin-top: 0px;"><span
                        style="color: #878a99 !important;">Booking ID:</span> {{ $bookings[0]->unique_booking_id }}</p>
            </div>
        </div>
        <div style="padding: 1.5rem; background-color: #a9cf82; text-align: left;">
            <h5
                style="font-size: 18px;font-family: 'Poppins', sans-serif;font-weight: 600;margin-bottom: 0px;margin-top: 0px;line-height: 1.2;color: #fff !important;">
                Hi {{$name}},</h5>
            <h6
                style="font-size: 15px;font-weight: 500;margin-bottom: 12px;margin-top: 0px;line-height: 1.2;color: rgba(255, 255, 255, 0.80) !important;">
                Your Request for ticket cancellation is Completed.</h6>

            <div style="padding: 1.5rem; background-color: #fff; text-align: left; border-radius: 10px;">
                <h5
                    style="font-size: 18px;font-family: 'Poppins', sans-serif;font-weight: 600;margin-bottom: 0px;margin-top: 0px;line-height: 1.2;color: #1a7971 !important;">
                    {{ $bookings[0]->origin }} To {{ $bookings[0]->destination }} </h5>

                <!-- <p style="color: #333 !important; margin-bottom: 0px;margin-top: 0px;">One way • Fri, 14 April</p> -->

            </div>
        </div>
        <div style="padding: 1.5rem;background-color: #fafafa;">
            <div style="text-align: center;">
                <p style="color: #878a99; margin: 0;font-weight: 500;">
                    <script>document.write(new Date().getFullYear())</script> © 5K-Travels
                </p>
            </div>
        </div>
    </div>