<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NTLL Booking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .required-asterisk {
            color: #e53935;
            font-weight: bold;
            /* margin-left: 1px; */
        }
        body {
            font-family: Arial, sans-serif;
            background: #f2f6ff;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .open-btn {
            margin-top: 100px;
            padding: 15px 30px;
            font-size: 18px;
            background: #02047e;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            overflow-y: auto;
        }

        .modal-content {
            background: #fff;
            width: 90%;
            max-width: 700px;
            margin: 40px auto;
            padding: 25px;
            border-radius: 8px;
            position: relative;
            text-align: left;
        }

        .close {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 22px;
            cursor: pointer;
            color: #02047e;
            font-weight: bold;
        }

        h2 {
            text-align: center;
            color: #02047e;
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #02047e;
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            padding: 7px;
        }
        


        input,select {
            width: 100%;
            height: 44px;              /* Force same height */
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            box-sizing: border-box;    /* Critical */
        }


        .submit-btn {
            width: 100%;
            padding: 12px;
            background: #02047e;
            color: #fff;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .left-col,.right-col{
            margin-right: 24px;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg fill='navy' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 36px;
        }

        /* ===== FORM GRID ===== */
        /* .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        } */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 30px;
            row-gap: 18px;
            align-items: start; /* prevents uneven stretching */
        }
        .field {
            width: 100%;
        }

        /* Mobile: single column (default DOM order) */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            row-gap: 18px;
        }

        .select-icon-wrapper {
            position: relative;
        }

        .select-icon-wrapper select {
            padding-left: 46px; /* space for icon */
        }

        .car-icon {
            position: absolute;
            top: 75%;
            left: 10px;
            transform: translateY(-50%);
            color: #02047e;
            font-size: 25px;
            pointer-events: none; /* click goes to select */
        }

        /* Desktop layout */
        @media (min-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr 1fr;
                column-gap: 30px;
                grid-template-areas:
                    "car-type package"
                    "name mobile"
                    "from to"
                    "pickup pickup"
                    "submit submit";
            }

            .car-type { grid-area: car-type; }
            .package  { grid-area: package; }
            .name     { grid-area: name; }
            .mobile   { grid-area: mobile; }
            .from     { grid-area: from; }
            .to       { grid-area: to; }
            .pickup   { grid-area: pickup; }

            .submit-btn {
                grid-area: submit;
            }
        }



        /* ===== DESKTOP VIEW ===== */
        @media (min-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr 1fr;
                gap: 30px;
            }

            .submit-btn {
                grid-column: span 2;
            }
        }
    </style>

    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <button class="open-btn" onclick="openModal()">Book a Taxi</button>

    <div class="modal" id="bookingModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>

            <h2>NTLL Taxi Booking</h2>

            <form id="bookingForm" name="bookingForm" method="POST" autocomplete="off">
                <div class="form-grid">
                    <!-- Car Type -->
                    <div class="field car-type select-icon-wrapper">
                        <label>Car Type <span class="required-asterisk">*</span></label>
                        <i class="fa-solid fa-car-side car-icon"></i>
                        <select name="car_type" id="carType" required tabindex="1">
                            <option value="">Select Car Type</option>
                            <option>Mini</option>
                            <option>Sedan</option>
                            <option>MUV</option>
                            <option>MUV Prime</option>
                            <option>SUV</option>
                            <option>Luxury</option>
                            <option>Tempo Travels</option>
                        </select>
                    </div>
                    <!-- Package -->
                    <div class="field package">
                        <label>Package <span class="required-asterisk">*</span></label>
                        <select name="package" required tabindex="2">
                            <option value="">Select Package</option>
                            <option>Local Trip</option>
                            <option>One Trip</option>
                            <option>Long Trip</option>
                        </select>
                    </div>
                    <!-- Name -->
                    <div class="field name">
                        <label>Name <span class="required-asterisk">*</span></label>
                        <input type="text" name="name" required tabindex="3">
                    </div>
                    <!-- Mobile -->
                    <div class="field mobile">
                        <label>Mobile Number <span class="required-asterisk">*</span></label>
                        <input type="number" name="mobile" required tabindex="4">
                    </div>
                    <!-- From -->
                    <div class="field from">
                        <label>From <span class="required-asterisk">*</span></label>
                        <input type="text" name="from_location" required tabindex="5">
                    </div>
                    <!-- To -->
                    <div class="field to">
                        <label>To <span class="required-asterisk">*</span></label>
                        <input type="text" name="to_location" required tabindex="6">
                    </div>
                    <!-- Pickup -->
                    <div class="field pickup">
                        <label>Pickup Date & Time <span class="required-asterisk">*</span></label>
                        <input type="datetime-local" name="pickup_datetime" required tabindex="7">
                    </div>
                    <button type="submit" class="submit-btn">Book Now</button>
                </div>
            </form>
            <div id="bookingResult" style="margin-top:15px;"></div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById("bookingModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("bookingModal").style.display = "none";
        }

        window.onclick = function(event) {
            let modal = document.getElementById("bookingModal");
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }

        // --- JS Form Validation & AJAX Submission ---
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('bookingForm');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                // Client-side validation
                let errors = [];
                const car_type = form.car_type.value.trim();
                const packageVal = form.package.value.trim();
                const name = form.name.value.trim();
                const mobile = form.mobile.value.trim();
                const from_location = form.from_location.value.trim();
                const to_location = form.to_location.value.trim();
                const pickup_datetime = form.pickup_datetime.value.trim();

                if (!car_type) errors.push('Car type is required.');
                if (!packageVal) errors.push('Package is required.');
                if (!name || !/^[a-zA-Z\s]{2,}$/.test(name)) errors.push('Valid name is required.');
                if (!mobile || !/^[0-9]{10,15}$/.test(mobile)) errors.push('Valid mobile number is required.');
                if (!from_location) errors.push('Pickup location is required.');
                if (!to_location) errors.push('Drop location is required.');
                if (!pickup_datetime) errors.push('Pickup date & time is required.');

                if (errors.length > 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: errors.join('<br>'),
                    });
                    return;
                }

                // AJAX submit
                const formData = new FormData(form);
                fetch('booking.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message || 'Booking successful!',
                            confirmButtonColor: '#02047e'
                        }).then(() => {
                            form.reset();
                            closeModal();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Booking Failed',
                            html: (data.errors ? data.errors.join('<br>') : 'Booking failed.')
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred. Please try again.'
                    });
                });
            });
        });


        /* Car Icon Mapping */
        const carIcons = {
            "": "fa-car",
            "Mini": "fa-car-rear",
            "Sedan": "fa-car-side",
            "MUV": "fa-van-shuttle",
            "MUV Prime": "fa-van-shuttle",
            "SUV": "fa-truck-pickup",
            "Luxury": "fa-car", // or "fa-car-side"
            "Tempo Travels": "fa-van-shuttle"
        };

        const carSelect = document.getElementById("carType");
        const carIcon = document.querySelector(".car-icon");

        carSelect.addEventListener("change", function () {
            carIcon.className = "fa-solid car-icon " + (carIcons[this.value] || "fa-car-side");
        });

    </script>
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>
    <script>
        new google.maps.places.Autocomplete(
            document.getElementById('from_location')
        );
        new google.maps.places.Autocomplete(
            document.getElementById('to_location')
        );
    </script> -->

</body>
</html>
