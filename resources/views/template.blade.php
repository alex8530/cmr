<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>CMR System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('template/assets/img/favicon.png')}}" rel="icon">
  <link href="{{ asset('template/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Fonts -->
{{--  <link href="https://fonts.googleapis.com" rel="preconnect">--}}
{{--  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>--}}
{{--  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">--}}

  <!-- Vendor CSS Files -->
  <link href="{{ asset('template/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('template/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ asset('template/assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{ asset('template/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{ asset('template/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('template/assets/css/main.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/toastr.css')}}" />
{{--    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />--}}

    <!-- =======================================================
    * Template Name: QuickStart
    * Template URL: https://bootstrapmade.com/quickstart-bootstrap-startup-website-template/
    * Updated: May 10 2024 with Bootstrap v5.3.3
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <img src="{{ asset('template/assets/img/logo.png')}}" alt="">
        <h1 class="sitename">CMR System</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="">Home</a></li>
            <li><a href="#featured-services">Featured</a></li>
            <li><a href="#about">About</a></li>

          <li><a href="#contact">Contact</a></li>


        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="{{route('admin.login')}}">Get Started</a>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section  id="hero" class="hero section">
      <div class="hero-bg">
        <img src="{{ asset('template/assets/img/hero-bg-light.webp')}}" alt="">
      </div>
      <div class="container text-center">
        <div class="d-flex flex-column justify-content-center align-items-center">
          <h1 data-aos="fade-up" class="">Welcome to <span>CMR System</span></h1>
          <p data-aos="fade-up" data-aos-delay="100" class="">Save your time and avoid printing papers anymore<br></p>
          <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
            <a href="#about" class="btn-get-started">Get Started</a>
{{--            <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>--}}
          </div>
          <img src="{{ asset('template/assets/img/hero-services-img.webp')}}" class="img-fluid hero-img" alt="" data-aos="zoom-out" data-aos-delay="300">
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- Featured Services Section -->
    <section id="featured-services" class="featured-services section">

      <div class="container">

        <div class="row gy-4">

{{--          <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="100">--}}
{{--            <div class="service-item d-flex">--}}
{{--              <div class="icon flex-shrink-0"><i class="bi bi-briefcase"></i></div>--}}
{{--              <div>--}}
{{--                <h4 class="title"><a href="#" class="stretched-link">Save Your Time</a></h4>--}}
{{--                <p class="description">There is no need to send the CMR by e-mail and follow up anymore, as it is now possible to create a CMR and send it to everyone with one click</p>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--          <!-- End Service Item -->--}}

{{--          <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="200">--}}
{{--            <div class="service-item d-flex">--}}
{{--              <div class="icon flex-shrink-0"><i class="bi bi-card-checklist"></i></div>--}}
{{--              <div>--}}
{{--                <h4 class="title"><a href="#" class="stretched-link">Saving paper printing</a></h4>--}}
{{--                <p class="description">there is no need to print a single sheet of paper anymore</p>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div><!-- End Service Item -->--}}

{{--          <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="300">--}}
{{--            <div class="service-item d-flex">--}}
{{--              <div class="icon flex-shrink-0"><i class="bi bi-bar-chart"></i></div>--}}
{{--              <div>--}}
{{--                <h4 class="title"><a href="#" class="stretched-link">Add your signature electronically</a></h4>--}}
{{--                <p class="description">The signature can be written electronically in real time or saved in your profile  and used always .</p>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div><!-- End Service Item -->--}}

            <div class="col-xl-12 col-lg-6" data-aos="fade-up" data-aos-delay="300">
                <div class="service-item d-flex">
                    <div class="icon flex-shrink-0"><i class="bi bi-bar-chart"></i></div>
                    <div>
                        <h4 class="title  stretched-link"> Features </h4>

                        <li><i class="bi bi-check-circle"></i> <span>Save time, there is no need to send the CMR by e-mail and follow up anymore, as it is now possible to create a CMR and send it to everyone with one click.</span></li>

                        <li><i class="bi bi-check-circle"></i> <span>Saving paper printing, there is no need to print a single sheet of paper anymore.</span></li>

                        <li><i class="bi bi-check-circle"></i> <span>Save all CMRS in one place and ensure that they are not lost.</span></li>
                        <li><i class="bi bi-check-circle"></i> <span>Add your signature electronically without the need to print papers</span></li>
                        <li><i class="bi bi-check-circle"></i> <span>The signature can be written electronically in real time or saved in your profile  and used always .</span></li>
                        <li><i class="bi bi-check-circle"></i> <span>The system is based on the principle of priority or role, User No. 2 is not allowed to sign the CMR before User No. 1.</span></li>
                        <li><i class="bi bi-check-circle"></i> <span>The priority of users is determined when creating the CMR </span></li>
                        <li><i class="bi bi-check-circle"></i> <span>When the CMR is created, notifications are sent to the people selected in this CMR so that they can sign it.</span></li>
                        <li><i class="bi bi-check-circle"></i> <span>The system supports sending notifications and sending messages</span></li>
                        <li><i class="bi bi-check-circle"></i> <span>You can easily know the status of the CMR and who is responsible for it to be signed</span></li>
                        <li><i class="bi bi-check-circle"></i> <span>The CMR owner can accept or reject the sent signatures.</span></li>
                        <li><i class="bi bi-check-circle"></i> <span>The system contains an admin page that can control user permissions in detail</span></li>



                    </div>
                </div>
            </div><!-- End Service Item -->



        </div>

      </div>

    </section><!-- /Featured Services Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <p class="who-we-are">Who We Are</p>
            <h3>Ali Abu Harb</h3>
            <p class="fst-italic">
              Software Engineer , Mobile Developer and Web Developer
            </p>
            <ul>
                <li><i class="bi bi-check-circle"></i> <span>Native Android development, experienced in Object Oriented Design and Android Design Patterns </span></li>

                <li><i class="bi bi-check-circle"></i> <span>Working with Model–View–ViewModel (MVVM), MVP a software architectural pattern</span></li>
                <li><i class="bi bi-check-circle"></i> <span></span>Working with chained Git repositories</li>
                <li><i class="bi bi-check-circle"></i> <span></span>Working with back-end web frameworks such as Laravel & ASP.NET</li>
                <li><i class="bi bi-check-circle"></i> <span></span>Familiar with IOS using Swift</li>
                <li><i class="bi bi-check-circle"></i> <span></span>Familiar with Restful API</li>
                <li><i class="bi bi-check-circle"></i> <span></span>Familiar with Database Oracle sql/plsql</li>
                <li><i class="bi bi-check-circle"></i> <span></span>Good knowledge in Data Structure</li>
                <li><i class="bi bi-check-circle"></i> <span></span>Good knowledge in Networking</li>
                <li><i class="bi bi-check-circle"></i> <span></span>Excellent knowledge in object-oriented programming -OOP</li>
            </ul>
            <a href="#" class="read-more"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
          </div>

          <div class="col-lg-6 about-images" data-aos="fade-up" data-aos-delay="200">
            <div class="row gy-4">
              <div class="col-lg-6">
                <img src="{{ asset('template/assets/img/about-company-1.jpg')}}" class="img-fluid" alt="">
              </div>
              <div class="col-lg-6">
                <div class="row gy-4">
                  <div class="col-lg-12">
                    <img src="{{ asset('template/assets/img/about-company-2.jpg')}}" class="img-fluid" alt="">
                  </div>
                  <div class="col-lg-12">
                    <img src="{{ asset('template/assets/img/about-company-3.jpg')}}" class="img-fluid" alt="">
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>

      </div>
    </section><!-- /About Section -->


    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>Use below data for contact</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-6">
            <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="200">
              <i class="bi bi-geo-alt"></i>
              <h3>Address</h3>
              <p>Palestine, Gaza</p>
            </div>
          </div><!-- End Info Item -->

          <div class="col-lg-3 col-md-6">
            <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-telephone"></i>
              <h3>Call Us</h3>
              <p>+970598530950</p>
            </div>
          </div><!-- End Info Item -->

          <div class="col-lg-3 col-md-6">
            <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-envelope"></i>
              <h3>Email Us</h3>
              <p>aliabuharb8530@gmail.com</p>
            </div>
          </div><!-- End Info Item -->

        </div>

        <div class="row gy-4 mt-1">
{{--          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">--}}
{{--              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13607.270759421557!2d34.46684449999999!3d31.5016946!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14fd7f054e542767%3A0x7ff98dc913046392!2sGaza!5e0!3m2!1sen!2spl!4v1717066949768!5m2!1sen!2spl" frameborder="0" style="border:0; width: 100%; height: 400px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>--}}
{{--              <iframe src="" frameborder="0" style="border:0; width: 100%; height: 400px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>--}}
{{--          </div><!-- End Google Maps -->--}}

            <div class="col-lg-3"></div>
          <div class="col-lg-6">
            <form action="{{route('admin.send.message')}}" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="400">
              @csrf
                <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
{{--                  <div class="error-message"></div>--}}
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->
        <div class="col-lg-3"></div>
        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer position-relative">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">CMR System</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Gaza</p>
            <p>Palestine</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+970598530950</span></p>
            <p><strong>Email:</strong> <span>aliabuharb8530@gmail.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter"></i></a>
            <a href="https://www.facebook.com/AlexAbuHarb/"><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href="https://ae.linkedin.com/in/alexabuharb"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">CMR System</strong><span>All Rights Reserved</span></p>
     </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>


  <!-- Bootstrap JS -->
  <script src="{{asset('backend/assets/js/bootstrap.bundle.min.js')}}"></script>
  <!--plugins-->
  <script src="{{asset('backend/assets/js/jquery.min.js')}}"></script>
  <!-- Vendor JS Files -->


  <script src="{{ asset('template/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('template/assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{ asset('template/assets/vendor/aos/aos.js')}}"></script>
  <script src="{{ asset('template/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{ asset('template/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>

  <!-- Main JS File -->
  <script type="text/javascript" src="{{asset('frontend/js/toastr.min.js')}}"></script>
  <script src="{{ asset('template/assets/js/main.js')}}"></script>


  <script>
      @if(Session::has('message'))
      var type = "{{ Session::get('alert-type','info') }}"
      switch(type){
          case 'info':
              toastr.info(" {{ Session::get('message') }} ");
              break;

          case 'success':
              toastr.success(" {{ Session::get('message') }} ");
              break;

          case 'warning':
              toastr.warning(" {{ Session::get('message') }} ");
              break;

          case 'error':
              toastr.error(" {{ Session::get('message') }} ");
              break;
      }
      @endif
  </script>



</body>

</html>
