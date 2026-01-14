<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>NTLL Booking</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- <style>
    body {
        font-family: Arial, sans-serif;
        background: #f2f6ff;
        margin: 0;
        padding: 0;
        text-align: center;
    }

    /* Open Button */
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

    /* Overlay */
    .modal {
        display: none;
        position: fixed;
        z-index: 999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
    }

    /* Modal Box */
    .modal-content {
        background: #fff;
        width: 90%;
        max-width: 450px;
        margin: 50px auto;
        padding: 25px;
        border-radius: 8px;
        position: relative;
        text-align: left;
    }

    /* Close Button */
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
    }

    label {
        color: #02047e;
        font-weight: bold;
        margin-top: 10px;
        display: block;
    }

    input, select {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button.submit-btn {
        margin-top: 15px;
        width: 100%;
        padding: 12px;
        background: #02047e;
        color: #fff;
        border: none;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
    }

    button.submit-btn:hover {
        opacity: 0.9;
    }
    .text-box{
        margin-right: 24px;
    }
</style> -->

<style>
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

</head>

<body>

<button class="open-btn" onclick="openModal()">Book a Taxi</button>

<div class="modal" id="bookingModal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>

        <h2>NTLL Taxi Booking</h2>

        <!-- <form action="book_taxi.php" method="POST">

            <label>Car Type</label>
            <select name="car_type" required>
                <option value="">Select Car Type</option>
                <option>Mini</option>
                <option>Sedan</option>
                <option>MUV</option>
                <option>MUV Prime</option>
                <option>SUV</option>
                <option>Luxury</option>
                <option>Tempo Travels</option>
            </select>

            <label>Package</label>
            <select name="package" required>
                <option value="">Select Package</option>
                <option>Local Trip </option>
                <option>One Trip </option>
                <option>Long Trip </option>
            </select>
            <div class="text-box">
            <label>Name</label>
            <input type="text" name="name" required>

            <label>From</label>
            <input type="text" id="from_location" name="from_location" required>

            <label>To</label>
            <input type="text" id="to_location" name="to_location" required>

            <label>Mobile Number</label>
            <input type="text" name="mobile" required>

            <label>Pickup Date & Time</label>
            <input type="datetime-local" name="pickup_datetime" required>
            </div>

            <button type="submit" class="submit-btn">Book Now</button>
        </form> -->
        <form action="book_taxi.php" method="POST">
    <div class="form-grid">
        
         <!-- Car Type -->
        <div class="field car-type">
            <label>Car Type</label>
            <select name="car_type" required tabindex="1">
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
            <label>Package</label>
            <select name="package" required tabindex="2">
                <option value="">Select Package</option>
                <option>Local Trip</option>
                <option>One Trip</option>
                <option>Long Trip</option>
            </select>
        </div>

        <!-- Name -->
        <div class="field name">
            <label>Name</label>
            <input type="text" name="name" required tabindex="3">
        </div>

        <!-- Mobile -->
        <div class="field mobile">
            <label>Mobile Number</label>
            <input type="number" name="mobile" required tabindex="4">
        </div>

        <!-- From -->
        <div class="field from">
            <label>From</label>
            <input type="text" name="from_location" required tabindex="5">
        </div>

        <!-- To -->
        <div class="field to">
            <label>To</label>
            <input type="text" name="to_location" required tabindex="6">
        </div>

        <!-- Pickup -->
        <div class="field pickup">
            <label>Pickup Date & Time</label>
            <input type="datetime-local" name="pickup_datetime" required tabindex="7">
        </div>


        <button type="submit" class="submit-btn">Book Now</button>
    </div>
</form>

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
