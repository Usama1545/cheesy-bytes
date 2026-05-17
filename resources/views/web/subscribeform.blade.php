 <!-- newsletter section start Here -->
 <section class="theme-2-newsletter mt-5">
     <div class="container">
         <div class="">
             <form action="{{ route('subscribe') }}" method="POST" class="mb-0">
                 @csrf
                 <div class="row align-items-center text-center justify-content-center py-md-5 py-3">
                     <div class="col-auto newsletter-heading">
                         <h1 class="text-uppercase my-3">{{ trans('labels.newsletter') }}</h1>
                         <p class="sub-lables text-capitalize my-3">{{ trans('labels.subscribe_title') }}</p>
                         <p>{{ trans('labels.subscribe_description') }}</p>
                         <div class="form-floating d-flex pb-1">
                             <input type="email" name="subscribe_email" class="w-100 p-3 rounded-3 border-0"
                                 placeholder="{{ trans('labels.email') }}" required>
                             <button type="submit"
                                 class="btn btn-primary px-md-5 px-2 fs-md-6 fs-7 text-uppercase rounded-3 {{ session()->get('direction') == '2' ? 'me-2' : 'ms-2' }}">{{ trans('labels.subscribe') }}</button>
                         </div>
                     </div>
                 </div>
             </form>
         </div>
     </div>
 </section>
 <!-- newsletter section end Here -->
