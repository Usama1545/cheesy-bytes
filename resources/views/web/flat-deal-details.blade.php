@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.help_contact_us') }}
@endsection
@section('content')
    <div class="container">
        @foreach ($result as $deal)
            <section class="menu sec-padding position-relative">
                <div class="container">
                    <div class="row g-3 align-items-center justify-content-between mb-sm-5 mb-4">
                        <div class="col-auto menu-heading">
                            @if ($deal['offer_type'] == 1)
                                <p class="sub-lables text-capitalize mt-2 mb-0">Get every items on flat
                                    ${{ $deal['offer_amount'] }} discount</p>
                            @else
                                <p class="sub-lables text-capitalize mt-2 mb-0">Get every items on flat
                                    {{ $deal['offer_amount'] }}% discount</p>
                            @endif

                        </div>
                    </div>
                    <div class="row g-4">
                        @foreach ($deal['items'] as $itemdata)
                            @include('web.home1.flatitemview', ['itemdata' => $itemdata, 'deal' => $deal])
                        @endforeach

                    </div>
                </div>
            </section>
        @endforeach
    </div>
@endsection
<style>
    .county-details p {
        color: #8e8e8e;
        /* Apply color to all paragraphs */
    }

    .county-details h1 {
        color: #5e5e5e;
        /* Apply color to all h1 tags */
    }

    .county-details span {
        color: #8e8e8e;
        /* Apply color to all span tags */
    }

    .county-details {
        margin-top: 40px;
        display: block;
        /* Ensures the content is block-level for better layout */
        margin-bottom: 1em;
        /* Adds some space below the content */
        font-family: 'Arial', sans-serif;
        /* Sets a clean, readable font */
        line-height: 1.6;
        /* Increases line height for better readability */
        color: #989898 !important;
        /* Sets the text color to a dark gray for contrast */
        padding: 10px;
        /* Adds padding around the content for better spacing */
        /*border: 1px solid #ddd; !* Adds a subtle border for structure *!*/
        border-radius: 5px;
        /* Adds rounded corners for a more modern look */
        /*background-color: #f9f9f9; !* Light background color to enhance readability *!*/
    }


    /* Optional: Add responsive styling if needed */
    @media (max-width: 768px) {
        .county-details {
            font-size: 14px;
            /* Adjust font size for smaller screens */
            padding: 8px;
            /* Reduce padding for smaller screens */
        }
    }

    @media (min-width: 1440px) {
        .col-lg-2-4 {
            flex: 0 0 20%;
            /* Makes the columns take up 20% of the container on large screens */
            max-width: 20%;
        }
    }

    .round-button {
        width: 70px;
        /* adjust to your desired width */
        height: 70px;
        /* adjust to your desired height */
        border-radius: 50% !important;
        /* make the corners fully rounded */
        border: 1px solid;
        cursor: pointer;
        background-color: #f48384;
        transition: background-color 0.3s ease;
        /* Smooth transition for background color */

    }

    .round-button:hover {
        background-color: #DE1616 !important;
        /* Hover color for all buttons */
        color: #fff !important;
        /* Optional: Change text color on hover */
    }

    .round-button.selected {
        background-color: #DE1616 !important;
        color: #fff;
        /* Optional: Change text color for better visibility */
    }


    .topping-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        /* Two columns with equal width */
        gap: 16px;
        /* Adjust gap between rows and columns */

        align-items: center;
        /* Center items vertically */
    }

    .topping-grid .topping-item {
        width: 100%;
        /* Ensure consistent width */
        text-align: center;
        /* Center content */
        padding: 10px;
        border: 1px solid #ccc;
        /* Optional: Add a border for visual clarity */
        border-radius: 8px;
        /* Optional: Add rounded corners */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        /* Optional: Add a subtle shadow */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        /* Optional: Add hover effects */
    }

    .topping-grid .topping-item:hover {
        transform: translateY(-5px);
        /* Lift item slightly on hover */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        /* Enhance shadow on hover */
    }

    .text-sm {
        font-size: 14px;
        color: grey;
    }

    .btn-outline-primary {
        padding: 9px !important;
        font-size: 12px;
        font-weight: 500;
        color: #DE1616 !important;
    }

    .btn-outline-primary:hover {
        background-color: #DE1616 !important;
        /* Hover color for all buttons */
        color: #fff !important;
        /* Optional: Change text color on hover */
    }


    .btn.btn-primary {
        padding: 9px !important;
        font-weight: 500;
        font-size: 12px;
        color: white;
    }

    .btn.active {
        background-color: #DE1616 !important;
        /* Hover color for all buttons */
        color: #fff !important;
        /* Optional: Change text color on hover */
        border-color: #DE1616 !important;
    }

    .btn.btn-primary:hover {
        background-color: #DE1616 !important;
        /* Hover color for all buttons */
        color: #fff !important;
        /* Optional: Change text color on hover */
        border-color: #DE1616 !important;
    }

    .pizza-topping__part {
        display: inline-flex;
        flex-direction: column;
        /* Stack SVG and label vertically */
        align-items: center;
        /* Center align SVG and label */
        margin: 5px;
        cursor: pointer;
    }

    .pizza-topping__icon {
        width: 30px;
        height: 30px;
        fill: lightgray;
        /* Default icon color */
        transition: fill 0.3s;
    }

    .pizza-topping__part input:checked+svg {
        fill: #DE1616;
        /* Highlight color on selection */
    }

    .pizza-topping__label {
        margin-top: 5px;
        /* Add some space between SVG and label */
        font-size: 14px;
        color: #333;
    }

    #myPizzaCard {
        position: sticky;
        top: 15px;
        /* Adjust the top position for the sticky card */
        z-index: 1050;
        /* Ensure it's above other content */
    }

    @media (max-width: 767px) {
        #myPizzaCard {
            position: relative;
            /* For mobile screens, we can revert to a non-sticky position */
            margin-top: 10px;
            /* Add a bit of spacing on top for smaller screens */
        }
    }

    @media (min-width: 992px) {

        .modal-lg,
        .modal-xl {
            --bs-modal-width: 900px;
        }
    }
</style>
