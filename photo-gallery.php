<?php include 'INCLUDE/header.php'?>
<link rel="stylesheet" href="css/photo_gallery.css">


<!--==============================
=            Schedule            =
===============================-->


<section class="section gallery">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center mb-5">
				<div class="section-title">
					<h3>Photo <span class="alternate">Gallery</span></h3>
				</div>
			</div>
		</div>
		<div class="row" id="gallery-container">
			<!-- Images will be dynamically inserted here by JavaScript -->
		</div>
	</div>
</section>

    <!-- Modal for Image Preview -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h5 class="modal-title" id="imageModalLabel">Image Preview</h5> -->
					 <div></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="#" alt="Image Preview">
                </div>
            </div>
        </div>
    </div>

<!--====  End of Schedule  ====-->


<!--===========================================
=            Call to Action Ticket            =
============================================-->

<section class="cta-ticket bg-ticket overlay-dark" style="margin-top: 90px;">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<!-- Get ticket info -->
				<div class="content-block">
					<h2>Register Yourself <span class="alternate">Now!</span></h2>
					<p>Please click the button below to register for the event.</p>
					<a href="https://docs.google.com/forms/d/e/1FAIpQLSfHYJUquRWsA82sgLhLhQBKPWgHjFMsmXmYB1NNu90Ao44r_g/viewform?usp=sf_link" target="_blank" class="btn btn-main-md">Register</a>
				</div>
			</div>
			<div class="col-md-3 banner p-0">
				<!-- Content Block -->
				<div class="block content-block">
					<!-- Coundown Timer -->
					<div class="timer"></div>
		</div>
		</div>
	</div>
	</div>
	<!-- <div class="image-block"><img src="images/inidan-woman.png" alt="" class="img-fluid"></div> -->
</section>

<!--====  End of Call to Action Ticket  ====-->

<!--============================
=            Footer            =
=============================-->

<footer class="footer-main">
    <div class="container-fluid px-4">
      <div class="row">

          <!--Grid column-->
		  <div class="col-md-4">
			<div class="block text-center">
			  <div class="footer-logo">
				<img src="images/virocon-icon.png" alt="logo" class="img-fluid logo">
			  </div>
			  <!-- <ul class="social-links-footer list-inline">
				<li class="list-inline-item">
				  <a href="#"><i class="fa fa-facebook"></i></a>
				</li>
				<li class="list-inline-item">
				  <a href="#"><i class="fa fa-twitter"></i></a>
				</li>
				<li class="list-inline-item">
				  <a href="#"><i class="fa fa-instagram"></i></a>
				</li>
				<li class="list-inline-item">
				  <a href="#"><i class="fa fa-rss"></i></a>
				</li>
				<li class="list-inline-item">
				  <a href="#"><i class="fa fa-vimeo"></i></a>
				</li>
			  </ul> -->
			</div>
			
		  </div>
		  <div class="col-md-8">
			<!-- Links -->
			<h6 class="text-uppercase fw-bold text-white">Contact</h6>
			<hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px">
			<div class="row justify-content-around">
				<div class="col-12 col-md-5 mb-4">
					<p>Prof. Dr Yashpal Singh Malik</p>
					<p>Secretary General, Indian Virological Society (IVS)</p>
					<p>National Agricultural Sciences Complex</p>
					<p>New Delhi-110012</p>
					<p>secretary@ivs.net.in; secretaryivs@gmail.com</p>
				</div>
				<div class="col-12 col-md-5 mb-4">
					<p>Dr. P. K. Dash</p>
					<p>Organizing Secretary, VIROCON-2024</p>
					<p>DRDE</p>
					<p>Jhansi Road, Gwalior, IN-474002</p>
					<p>virocon2024@yahoo.com; virocon2024@gmail.com</p>  
				</div>
			</div>
		</div>
          <!--Grid column-->
          
      </div>
    </div>
</footer>
<!-- Subfooter -->
<footer class="subfooter">
  <div class="container">
    <div class="row">
      <div class="col-md-6 align-self-center">
        <div class="copyright-text">
          <p><a href="#">VIROCON</a> &#169; 2024 All Right Reserved</p>
        </div>
      </div>
      <div class="col-md-6">
		<a href="#" class="to-top"><i class="fa fa-angle-up"></i></a> 
		<p>Powered By <span class="alternate">ClickClack</span></p>
      </div>
    </div>
  </div>
</footer>



  <!-- JAVASCRIPTS -->
  <script>
	document.addEventListener('DOMContentLoaded', function() {
		// Array of image file names in your 'photo_gallery' folder
		const images = [
    'images/photo_gallery/DSC_0016.jpg',
    'images/photo_gallery/DSC_0031.jpg',
    'images/photo_gallery/DSC_0040.jpg',
    'images/photo_gallery/DSC_0089.jpg',
    'images/photo_gallery/DSC_0096.jpg',
    'images/photo_gallery/DSC_0100.jpg',
    'images/photo_gallery/DSC_0104.jpg',
    'images/photo_gallery/DSC_0107.jpg',
    'images/photo_gallery/DSC_0110.jpg',
    'images/photo_gallery/DSC_0114.jpg',
    'images/photo_gallery/DSC_0127.jpg',
    'images/photo_gallery/DSC_0130.jpg',
    'images/photo_gallery/DSC_0146.jpg',
    'images/photo_gallery/DSC_0161.jpg',
    'images/photo_gallery/DSC_0174.jpg',
    'images/photo_gallery/DSC_0190.jpg',
    'images/photo_gallery/DSC_0194.jpg',
    'images/photo_gallery/DSC_0199.jpg',
    'images/photo_gallery/DSC_0201.jpg',
    'images/photo_gallery/DSC_0203.jpg',
    'images/photo_gallery/DSC_0205.jpg',
    'images/photo_gallery/DSC_0208.jpg',
    'images/photo_gallery/DSC_0219.jpg',
    'images/photo_gallery/DSC_0250.jpg',
    'images/photo_gallery/DSC_0253.jpg',
    'images/photo_gallery/DSC_0260.jpg',
    'images/photo_gallery/DSC_0263.jpg',
    'images/photo_gallery/DSC_0277.jpg',
    'images/photo_gallery/DSC_0326.jpg',
    'images/photo_gallery/DSC_0330.jpg',
    'images/photo_gallery/DSC_0427.jpg',
    'images/photo_gallery/DSC_0466.jpg',
    'images/photo_gallery/DSC_0492.jpg',
    'images/photo_gallery/DSC_0510.jpg',
    'images/photo_gallery/DSC_0512.jpg',
    'images/photo_gallery/DSC_0755.jpg',
    'images/photo_gallery/DSC_0760.jpg',
    'images/photo_gallery/DSC_0764.jpg',
    'images/photo_gallery/DSC_0830.jpg',
    'images/photo_gallery/DSC_0861%20-%20Copy.jpg',
    'images/photo_gallery/DSC_0884.jpg',
    'images/photo_gallery/DSC_0939.jpg',
    'images/photo_gallery/DSC_0950.jpg',
    'images/photo_gallery/DSC_0990.jpg',
    'images/photo_gallery/DSC_0992.jpg',
    'images/photo_gallery/DSC_1020.jpg',
    'images/photo_gallery/DSC_1046.jpg',
    'images/photo_gallery/DSC_1055.jpg',
    'images/photo_gallery/DSC_1088.jpg',
    'images/photo_gallery/DSC_1091.jpg',
    'images/photo_gallery/DSC_1100.jpg',
    'images/photo_gallery/DSC_1105.jpg',
    'images/photo_gallery/DSC_1107.jpg',
    'images/photo_gallery/DSC_1108.jpg',
    'images/photo_gallery/DSC_1183.jpg',
    'images/photo_gallery/DSC_1188.jpg',
    'images/photo_gallery/DSC_1256.jpg',
    'images/photo_gallery/DSC_1270.jpg',
    'images/photo_gallery/DSC_1311.jpg',
    'images/photo_gallery/DSC_1322.jpg',
    'images/photo_gallery/DSC_1326.jpg',
    'images/photo_gallery/DSC_2426.jpg',
    'images/photo_gallery/DSC_2429.jpg',
    'images/photo_gallery/DSC_2431.jpg',
    'images/photo_gallery/DSC_2432.jpg',
    'images/photo_gallery/DSC_2441.jpg',
    'images/photo_gallery/DSC_2451.jpg',
    'images/photo_gallery/DSC_2452.jpg',
    'images/photo_gallery/DSC_2453.jpg'
];

		const galleryContainer = document.getElementById('gallery-container');

		// Loop through the image array and create image elements
		images.forEach(function(imageSrc, index) {
		    console.log(483, index);
			const colDiv = document.createElement('div');
			colDiv.classList.add('col-lg-3', 'col-md-4', 'col-sm-6', 'mb-4');

			const galleryItemDiv = document.createElement('div');
			galleryItemDiv.classList.add('gallery-item');

			const img = document.createElement('img');
			img.src = imageSrc;
			img.alt = 'Gallery Image';
			img.classList.add('img-fluid');
			img.setAttribute('data-toggle', 'modal');
			img.setAttribute('data-target', '#imageModal');
			img.setAttribute('data-img', imageSrc); // Custom attribute to store the image source

			galleryItemDiv.appendChild(img);
			colDiv.appendChild(galleryItemDiv);
			galleryContainer.appendChild(colDiv);
		});

		// Modal Image Preview
		$('#imageModal').on('show.bs.modal', function (event) {
			var imageSrc = $(event.relatedTarget).attr('data-img');
			$('#modalImage').attr('src', imageSrc);
		});
	});
</script>
//   <script>
// 	document.addEventListener('DOMContentLoaded', function() {
// 		// Array of image file names in your 'photo_gallery' folder
// 		const images = [
//     'images/photo_gallery/DSC_0016.jpg',
//     'images/photo_gallery/DSC_0031.jpg',
//     'images/photo_gallery/DSC_0040.jpg',
//     'images/photo_gallery/DSC_0089.jpg',
//     'images/photo_gallery/DSC_0096.jpg',
//     'images/photo_gallery/DSC_0100.jpg',
//     'images/photo_gallery/DSC_0104.jpg',
//     'images/photo_gallery/DSC_0107.jpg',
//     'images/photo_gallery/DSC_0110.jpg',
//     'images/photo_gallery/DSC_0114.jpg',
//     'images/photo_gallery/DSC_0127.jpg',
//     'images/photo_gallery/DSC_0130.jpg',
//     'images/photo_gallery/DSC_0146.jpg',
//     'images/photo_gallery/DSC_0161.jpg',
//     'images/photo_gallery/DSC_0174.jpg',
//     'images/photo_gallery/DSC_0190.jpg',
//     'images/photo_gallery/DSC_0194.jpg',
//     'images/photo_gallery/DSC_0199.jpg',
//     'images/photo_gallery/DSC_0201.jpg',
//     'images/photo_gallery/DSC_0203.jpg',
//     'images/photo_gallery/DSC_0205.jpg',
//     'images/photo_gallery/DSC_0208.jpg',
//     'images/photo_gallery/DSC_0219.jpg',
//     'images/photo_gallery/DSC_0250.jpg',
//     'images/photo_gallery/DSC_0253.jpg',
//     'images/photo_gallery/DSC_0260.jpg',
//     'images/photo_gallery/DSC_0263.jpg',
//     'images/photo_gallery/DSC_0277.jpg',
//     'images/photo_gallery/DSC_0326.jpg',
//     'images/photo_gallery/DSC_0330.jpg',
//     'images/photo_gallery/DSC_0427.jpg',
//     'images/photo_gallery/DSC_0466.jpg',
//     'images/photo_gallery/DSC_0492.jpg',
//     'images/photo_gallery/DSC_0510.jpg',
//     'images/photo_gallery/DSC_0512.jpg',
//     'images/photo_gallery/DSC_0755.jpg',
//     'images/photo_gallery/DSC_0760.jpg',
//     'images/photo_gallery/DSC_0764.jpg',
//     'images/photo_gallery/DSC_0830.jpg',
//     'images/photo_gallery/DSC_0861 - Copy.jpg',
//     'images/photo_gallery/DSC_0884.jpg',
//     'images/photo_gallery/DSC_0939.jpg',
//     'images/photo_gallery/DSC_0950.jpg',
//     'images/photo_gallery/DSC_0990.jpg',
//     'images/photo_gallery/DSC_0992.jpg',
//     'images/photo_gallery/DSC_1020.jpg',
//     'images/photo_gallery/DSC_1046.jpg',
//     'images/photo_gallery/DSC_1055.jpg',
//     'images/photo_gallery/DSC_1088.jpg',
//     'images/photo_gallery/DSC_1091.jpg',
//     'images/photo_gallery/DSC_1100.jpg',
//     'images/photo_gallery/DSC_1105.jpg',
//     'images/photo_gallery/DSC_1107.jpg',
//     'images/photo_gallery/DSC_1108.jpg',
//     'images/photo_gallery/DSC_1183.jpg',
//     'images/photo_gallery/DSC_1188.jpg',
//     'images/photo_gallery/DSC_1256.jpg',
//     'images/photo_gallery/DSC_1270.jpg',
//     'images/photo_gallery/DSC_1311.jpg',
//     'images/photo_gallery/DSC_1322.jpg',
//     'images/photo_gallery/DSC_1326.jpg',
//     'images/photo_gallery/DSC_2426.jpg',
//     'images/photo_gallery/DSC_2429.jpg',
//     'images/photo_gallery/DSC_2431.jpg',
//     'images/photo_gallery/DSC_2432.jpg',
//     'images/photo_gallery/DSC_2441.jpg',
//     'images/photo_gallery/DSC_2451.jpg',
//     'images/photo_gallery/DSC_2452.jpg',
//     'images/photo_gallery/DSC_2453.jpg'
// ];


// 		const galleryContainer = document.getElementById('gallery-container');

// 		// Loop through the image array and create image elements
// 		images.forEach(function(imageSrc) {
// 			const colDiv = document.createElement('div');
// 			colDiv.classList.add('col-lg-3', 'col-md-4', 'col-sm-6', 'mb-4');

// 			const galleryItemDiv = document.createElement('div');
// 			galleryItemDiv.classList.add('gallery-item');

// 			const img = document.createElement('img');
// 			img.src = imageSrc;
// 			img.alt = 'Gallery Image';
// 			img.classList.add('img-fluid');

// 			galleryItemDiv.appendChild(img);
// 			colDiv.appendChild(galleryItemDiv);
// 			galleryContainer.appendChild(colDiv);
// 		});
// 	});
// </script>
<script src="../code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

  <!-- jQuey -->
  <script src="plugins/jquery/jquery.js"></script>
  <!-- Popper js -->
  <script src="plugins/popper/popper.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
  <!-- Smooth Scroll -->
  <script src="plugins/smoothscroll/SmoothScroll.min.js"></script>  
  <!-- Isotope -->
  <script src="plugins/isotope/mixitup.min.js"></script>  
  <!-- Magnific Popup -->
  <script src="plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
  <!-- Slick Carousel -->
  <script src="plugins/slick/slick.min.js"></script>  
  <!-- SyoTimer -->
  <script src="plugins/syotimer/jquery.syotimer.min.js"></script>
  <!-- Google Mapl -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
  <script type="text/javascript" src="plugins/google-map/gmap.js"></script>
  <!-- Custom Script -->
  <script src="js/custom.js"></script>
  <script>
  $(document).ready(function () {
    $('.timer').syotimer({
      year: 2025,
      month: 12,
      day: 10,
      hour: 0,
      minute: 0,
      second: 0,
      layout: 'dhms',
      periodic: false,
      afterDeadline: function (timerBlock) {
        timerBlock.html('<p style="color: red; font-size: 20px;">Event Started</p>');
      }
    });
  });
</script>
</body>

<script>'undefined'=== typeof _trfq || (window._trfq = []);'undefined'=== typeof _trfd && (window._trfd=[]),_trfd.push({'tccl.baseHost':'secureserver.net'},{'ap':'cpsh-oh'},{'server':'sg2plzcpnl493867'},{'dcenter':'sg2'},{'cp_id':'10012341'},{'cp_cl':'8'}) // Monitoring performance to make your website faster. If you want to opt-out, please contact web hosting support.</script><script src='../img1.wsimg.com/signals/js/clients/scc-c2/scc-c2.min.js'></script>
<!-- Mirrored from virocon2024.in/photo-gallery.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 26 Jun 2025 04:42:08 GMT -->
</html>



