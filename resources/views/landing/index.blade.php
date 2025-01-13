@extends('landing.layout.master')

@section('title', 'WashUP Laundry')

@section('content')
<div class="overflow-hidden position-relative">
    <img src="{{ asset($settings->hero_image) }}" class="position-absolute z-n1 top-0 h-100 w-100 object-fit-cover" alt="Meeting">

    <div class="overlay position-absolute z-n1 top-0 h-100 w-100 bg-dark"
        style="opacity: 0.85; mix-blend-mode: multiply; filter: contrast(1.15) brightness(0.85);">
    </div>

    <div class="container">
        <div class="min-vh-100 row align-items-center">
            <div class="col-12 col-xl-8">
                <div class="pt-9 pt-md-10 pt-xl-11 pb-7 pb-md-8 pb-xl-9 max-w-2xl mx-auto mx-xl-0">
                    <div class="mt-4 pt-2">
                        <div class="text-center text-xl-start">
                            <h1 class="m-0 text-white tracking-tight text-6xl fw-bold" data-aos-delay="0" data-aos="fade" data-aos-duration="3000">
                                {{ $settings->hero_title }}
                            </h1>
                            <p class="m-0 mt-4 text-white text-lg leading-8" data-aos-delay="100" data-aos="fade" data-aos-duration="3000">
                                {{ $settings->hero_description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal to embed vidoes!! -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
 <div class="modal-dialog modal-xl modal-dialog-centered">
     <div class="modal-content border-0" style="border-radius: 0.75rem;">
         <div class="modal-header border-0 p-0">
             <button type="button" class="btn-close bg-white border position-absolute top-0 end-0 translate-middle me-n3 me-sm-n5 mt-n4 rounded-circle p-2" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body p-0">
             <div class="ratio ratio-16x9">
                 <iframe class="embed-responsive-item iframeVideo" style="border-radius: 0.75rem;" allow="autoplay"></iframe>
             </div>
         </div>
         
     </div>
 </div>
</div>



<!-- services -->
<div class="overflow-hidden py-7 py-sm-8 py-xl-9 bg-body-tertiary">
    <div class="container">
        <div>
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="m-0 text-success-emphasis text-base leading-7 fw-semibold">
                    {{ $settings->services_title }}
                </h2>
                <p class="m-0 mt-2 text-body-emphasis text-4xl tracking-tight fw-bold">
                    {{ $settings->services_description }}
                </p>
            </div>
        </div>
        
        <!-- Regular Services -->
        <div class="mb-8">
            <div class="row row-cols-1 row-cols-xl-3 gy-5 gx-xl-4 mt-1 justify-content-center justify-content-xl-start">
                @foreach($services as $service)
                <div class="col pt-5 pt-xl-4">
                    <div class="max-w-xl mx-auto mx-xl-0" data-aos-delay="0" data-aos="fade" data-aos-duration="1000">
                        <div class="ratio" style="--bs-aspect-ratio: 46.66%;">
                            <img src="{{ asset('storage/jenis-laundry/'. $service->gambar) }}" class="rounded-3 shadow" alt="{{ $service->nama_jenis }}" loading="lazy" style="height: 200px;">
                        </div>

                        <h3 class="m-0 mt-4 text-body-emphasis text-lg leading-6 fw-semibold">
                            {{ $service->nama_jenis }}
                        </h3>

                        <p class="m-0 mt-3 text-body-secondary line-clamp-2 text-sm leading-6">
                            {{ $service->deskripsi }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4">
                <a href="{{route('landing.services')}}" class="icon-link icon-link-hover text-decoration-none text-sm leading-6 fw-bold">
                    View more
                    <span class="bi align-self-start left-to-right" aria-hidden="true">→</span>
                    <span class="bi align-self-start right-to-left" aria-hidden="true">←</span>
                </a>
            </div>
        </div>

        <!-- Membership Section -->
        <div class="mt-5 pt-8 border-top">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                    <div class="pe-lg-5">
                        <h3 class="text-success-emphasis fs-5 fw-semibold mb-3">
                            Become a Member
                        </h3>
                        <h4 class="display-6 fw-bold mb-4">
                            Join Our Exclusive Membership Program
                        </h4>
                        <p class="text-body-secondary mb-4">
                            Enjoy premium benefits and enhanced laundry services with our lifetime membership for only Rp 100.000. Get access to exclusive features and special perks!
                        </p>
                        
                        <div class="row g-4 mb-4">
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success p-2 me-3">
                                        <i class="bi bi-search text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-1">Order Tracking</h5>
                                        <p class="text-body-secondary small mb-0">Track your laundry status in real-time</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success p-2 me-3">
                                        <i class="bi bi-clock-history text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-1">Order History</h5>
                                        <p class="text-body-secondary small mb-0">View all your past laundry orders</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success p-2 me-3">
                                        <i class="bi bi-ticket-perforated text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-1">Special Vouchers</h5>
                                        <p class="text-body-secondary small mb-0">Exclusive discounts and promotions</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success p-2 me-3">
                                        <i class="bi bi-person-check text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-1">Priority Service</h5>
                                        <p class="text-body-secondary small mb-0">Get prioritized order processing</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @guest
                            <div class="d-flex gap-3">
                                <button type="button" class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#registerInfoModal">
                                    Register Now
                                </button>
                                <a href="{{ route('member.login') }}" class="btn btn-outline-secondary text-white">
                                    Member Login
                                </a>
                            </div>
                        @endguest
                    </div>
                </div>

                <div class="col-12 col-lg-6 mt-5 mt-lg-0" data-aos="fade-left" data-aos-duration="1000">
                    <div class="position-relative">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets-2/img/bg/bg10.jpg') }}" class="rounded-4 object-fit-cover" alt="Membership Benefits">
                        </div>
                        <div class="position-absolute bottom-0 end-0 bg-success text-white p-4 rounded-start-4 mb-4">
                            <h4 class="fw-bold mb-2">Rp 100.000</h4>
                            <p class="mb-0">Lifetime Membership</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- About Us -->
<div class="overflow-hidden py-7 py-sm-8 py-xl-9">
 <div class="container">
     <div class="row gy-5 align-items-center justify-content-between">
         <div class="col-12 col-xl-5 order-last">
             <div class="mx-auto max-w-2xl">
                 <h2 class="m-0 text-success-emphasis text-base leading-7 fw-semibold">
                     About Us
                 </h2>
                 <p class="m-0 mt-2 text-body-emphasis text-4xl tracking-tight fw-bold">
                     We Care About Your Clothes As Much As You Do
                 </p>
                 <p class="m-0 mt-4 text-body-secondary text-lg leading-8">
                     WashUP Laundry has been providing premium laundry services since 2020. We combine modern technology with exceptional customer service to deliver the best laundry experience.
                 </p>
                 <div class="mt-4">
                     <a href="{{route('landing.about')}}" class="icon-link icon-link-hover text-decoration-none text-sm leading-6 fw-bold">
                         View more
                         <span class="bi align-self-start left-to-right" aria-hidden="true">→</span>
                         <span class="bi align-self-start right-to-left" aria-hidden="true">←</span>
                     </a>
                 </div>
             </div>
         </div>

         <div class="col-12 col-xl-6">
             <div class="mx-auto max-w-2xl">
                 <div class="ratio ratio-4x3" data-aos-delay="0" data-aos="fade" data-aos-duration="3000">
                     <img src="{{ asset($settings->about_image) }}" class="object-fit-cover rounded-3" alt="about us" loading="lazy">
                 </div>
             </div>
         </div>
     </div>
 </div>
</div>



<!-- Testimonials -->
<div class="overflow-hidden py-7 py-sm-8 py-xl-9 bg-body-secondary">
    <div class="container">
        <div id="carouselExampleIndicators" class="carousel slide pb-5">
            <div class="carousel-indicators mb-0">
                @foreach($reviews as $key => $review)
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $key + 1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach($reviews as $key => $review)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <div class="mx-auto max-w-4xl text-center">
                        <figure class="m-0 mt-5">
                            <blockquote class="text-center fw-semibold text-body-emphasis text-2xl leading-9">
                                <p class="m-0">
                                    "{{ $review->message }}"
                                </p>
                            </blockquote>

                            <figcaption class="m-0 mt-5">
                                <div class="mt-3 d-flex align-items-center justify-content-center text-base">
                                    <div class="fw-semibold text-body-emphasis">{{ $review->name }}</div>
                                </div>
                                <div class="mt-2">
                                    @for($i = 0; $i < $review->rating; $i++)
                                    <span class="text-warning">&#9733;</span>
                                    @endfor
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Next and Previous Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>




<!-- Suppliers -->
<div class="overflow-hidden py-6 py-sm-7 py-xl-8 bg-body-tertiary">
    <div class="container">
        <div class="max-w-2xl">
            <h2 class="m-0 text-success-emphasis text-base leading-7 fw-semibold">
                {{ $settings->suppliers_title }}
            </h2>
            <div class="m-0 mt-2 text-body-emphasis text-4xl tracking-tight fw-bold">
                {{ $settings->suppliers_description }}
            </div>
        </div>

        <div class="mt-4">
            <marquee behavior="scroll" direction="left" scrollamount="6">
                @foreach($suppliers as $supplier)
                <span class="mx-4">{{ $supplier->nama_supplier }}</span>
                @endforeach
            </marquee>
        </div>
    </div>
</div>



<!-- Review Form -->
<div id="review-form" class="overflow-hidden py-7 py-sm-8 py-xl-9">
 <div class="container">
    <div class="row gy-5 gx-sm-5">
        <div class="col-12 col-xl-5 pt-4">
           <div class="mx-auto max-w-2xl">
              <h2 class="m-0 text-success-emphasis text-base leading-7 fw-semibold">
                 Leave a Review
              </h2>
              <p class="m-0 mt-2 text-body-emphasis text-3xl tracking-tight fw-bold">
                 Share your experience with us!
              </p>
           </div>

           <div class="mx-auto max-w-2xl mt-6">
              <form class="row g-4 needs-validation" id="reviewForm" novalidate>
                 <div class="col-md-6">
                    <label for="nameForm" class="form-label text-sm">
                        Full name
                        <span class="text-danger-emphasis">*</span>
                    </label>
                    <input type="text" class="form-control form-control-sm" name="nameForm" id="nameForm" required>
                    <div class="invalid-feedback text-xs">
                        Please enter your full name.
                    </div>
                 </div>

                 <div class="col-md-6">
                    <label for="emailForm" class="form-label text-sm">
                        Email address
                        <span class="text-danger-emphasis">*</span>
                    </label>
                    <input type="email" class="form-control form-control-sm" name="emailForm" id="emailForm" required>
                    <div class="invalid-feedback text-xs">
                        Please enter your email address.
                    </div>
                 </div>

                 <div class="col-md-6">
                    <label for="ratingForm" class="form-label text-sm">
                        Rating
                        <span class="text-danger-emphasis">*</span>
                    </label>
                    <div class="rating">
                        <input type="radio" name="ratingForm" id="rating5" value="5" required>
                        <label for="rating5">☆</label>
                        <input type="radio" name="ratingForm" id="rating4" value="4" required>
                        <label for="rating4">☆</label>
                        <input type="radio" name="ratingForm" id="rating3" value="3" required>
                        <label for="rating3">☆</label>
                        <input type="radio" name="ratingForm" id="rating2" value="2" required>
                        <label for="rating2">☆</label>
                        <input type="radio" name="ratingForm" id="rating1" value="1" required>
                        <label for="rating1">☆</label>
                    </div>
                    <style>
                        .rating {
                            display: flex;
                            flex-direction: row-reverse;
                            justify-content: flex-end;
                            gap: 5px; /* Spasi antar bintang */
                        }
                        
                        .rating input[type="radio"] {
                            display: none;
                        }
                        
                        .rating label {
                            font-size: 2rem;
                            color: #ddd;
                            cursor: pointer;
                            transition: color 0.2s ease-in-out;
                        }
                        
                        .rating label:hover,
                        .rating label:hover ~ label {
                            color: #ffdb4d;
                        }
                        
                        .rating input[type="radio"]:checked ~ label {
                            color: #ffc107;
                        }
                    </style>                        
                    <div class="invalid-feedback text-xs">
                        Please select a rating.
                    </div>
                 </div>

                 <div class="mb-3">
                    <label for="messageForm" class="form-label text-sm">
                        Your review
                        <span class="text-danger-emphasis">*</span>
                    </label>
                    <textarea class="form-control form-control-sm" name="messageForm" id="messageForm" rows="3" required></textarea>
                    <div class="invalid-feedback text-xs">
                        Please enter your review.
                    </div>
                 </div>

                 <div class="col-12 text-center pt-3">
                    <button type="submit" class="btn btn-lg btn-success text-white text-sm fw-semibold" id="sendReview">
                        Submit review
                    </button>
                 </div>

                 <!-- Alert message  -->
                 <div class="col-12" id="yourReviewIsSent"></div>
              </form>
           </div>
        </div>

        <div class="col-12 col-xl-7 mt-5 mt-xl-0" data-aos-delay="0" data-aos="fade" data-aos-duration="3000">
           <div class="h-100 position-relative ms-xxl-5">
              <div class="position-relative w-100 h-100 rounded-5" style="min-height: 400px;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3961.0050558438516!2d107.54755407371042!3d-6.8899966674195925!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNsKwNTMnMjQuMCJTIDEwN8KwMzMnMDAuNSJF!5e0!3m2!1sid!2sid!4v1735953025104!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
           </div>
        </div>
    </div>
 </div>
</div>

<div class="modal fade" id="registerInfoModal" tabindex="-1" aria-labelledby="registerInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-success fw-semibold" id="registerInfoModalLabel">
                    Register Member Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-4">
                    <i class="bi bi-info-circle-fill text-success" style="font-size: 3rem;"></i>
                </div>
                <h5 class="fw-bold mb-3">Want to become a member?</h5>
                <p class="text-body-secondary mb-4">
                    Please visit our laundry location to register as a member. Our staff will assist you in creating your member account and explain all the benefits you'll receive.
                </p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Close</button>
                    <a href="#review-form" class="btn btn-success text-white" data-bs-dismiss="modal">Find Our Location</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reviewForm');
    const alertContainer = document.getElementById('yourReviewIsSent');
    const submitButton = document.getElementById('sendReview');

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Disable submit button to prevent double submission
            submitButton.disabled = true;

            // Reset any existing alerts
            alertContainer.innerHTML = '';

            // Create FormData object
            const formData = new FormData();
            formData.append('nameForm', document.getElementById('nameForm').value);
            formData.append('emailForm', document.getElementById('emailForm').value);
            formData.append('ratingForm', document.querySelector('input[name="ratingForm"]:checked')?.value);
            formData.append('messageForm', document.getElementById('messageForm').value);

            // Send the AJAX request
            fetch('/reviews/submit', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Create alert element
                const alert = document.createElement('div');
                alert.className = `alert ${data.status === 'success' ? 'alert-success' : 'alert-danger'} alert-dismissible fade show`;
                
                // Add alert content
                alert.innerHTML = `
                    ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                
                // Add alert to container
                alertContainer.appendChild(alert);

                // If successful, reset the form
                if (data.status === 'success') {
                    form.reset();
                    
                    // Reset star ratings
                    document.querySelectorAll('.rating label').forEach(label => {
                        label.style.color = '#ddd';
                    });
                    
                    // Scroll to alert
                    alertContainer.scrollIntoView({ behavior: 'smooth' });
                }

                // Remove alert after 5 seconds
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            })
            .catch(error => {
                console.error('Error:', error);
                const alert = document.createElement('div');
                alert.className = 'alert alert-danger alert-dismissible fade show';
                alert.innerHTML = `
                    An error occurred while submitting your review. Please try again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                alertContainer.appendChild(alert);
            })
            .finally(() => {
                // Re-enable submit button
                submitButton.disabled = false;
            });
        });
    }

    // Star rating functionality
    const ratingInputs = document.querySelectorAll('.rating input');
    const ratingLabels = document.querySelectorAll('.rating label');

    ratingInputs.forEach(input => {
        input.addEventListener('change', function () {
            // Reset the styles for all labels
            document.querySelectorAll('.rating label').forEach(label => {
                label.style.color = '#ddd';
            });

            // Apply styles to selected and previous labels
            this.parentNode.querySelectorAll('label').forEach(label => {
                if (parseInt(label.htmlFor.replace('rating', '')) <= parseInt(this.value)) {
                    label.style.color = '#ffc107';
                }
            });
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tombol "Find Our Location"
    const findLocationBtn = document.querySelector('#registerInfoModal a[href="#review-form"]');
    
    if (findLocationBtn) {
        findLocationBtn.addEventListener('click', function (e) {
            e.preventDefault();
            
            // Menutup modal secara manual
            const modalElement = document.getElementById('registerInfoModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
            
            // Menghapus backdrop
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
            
            // Menghapus kelas modal-open dari body
            document.body.classList.remove('modal-open');
            
            // Reset gaya langsung pada body
            document.body.style.removeProperty('overflow');
            document.body.style.removeProperty('padding-right');

            // Menggulir ke elemen #review-form
            setTimeout(() => {
                const target = document.querySelector('#review-form');
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            }, 350); // Memberikan jeda untuk memastikan modal sepenuhnya tertutup
        });
    }
});
</script>


@endsection