
<section class="newsletter mt-5">
    <div class="container">
        <div class="row align-items-center justify-content-between p-md-5 p-0">
            <div class="col-md-8 col-12 newsletter-heading">
                <h1 class="text-capitalize mt-4 mb-3">Subscribe our newsletter</h1>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                <div class="form-floating d-flex pb-4">
                    <input type="email" class="w-100 p-3 rounded-2  border-0" placeholder="Enter your email here">
                    <button type="button" class="btn btn-primary px-md-5 px-2 fs-md-6 fs-7 text-uppercase {{ session()->get('direction') == '2' ? 'me-2' : 'ms-2' }}">Subscribe</button>
                </div>
            </div>
            <div class="newsletter-img col-4 d-md-block d-none">
                <img src="{{url(env('ASSETSPATHURL').'web-assets/images/files.png')}}" class="w-100">
            </div>
        </div>
    </div>
</section>
