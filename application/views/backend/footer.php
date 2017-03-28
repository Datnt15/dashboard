				</div>
				<!-- /content-wraper -->
			</div>
			<!-- /page content -->
			<button type="button" class="btn" id="back-to-top" style="display: none; position: fixed; bottom: 10px; right: 20px; z-index: 10; -webkit-transition: all .4s ease; -moz-transition: all .4s ease; -ms-transition: all .4s ease; -o-transition: all .4s ease; transition: all .4s ease; -webkit-transform: all .4s; -moz-transform: all .4s; -ms-transform: all .4s; -o-transform: all .4s; transform: all .4s; background-color: #28343a; color: #fff;">
            	<i class="fa fa-angle-up"></i>
        	</button>
			<script>
				jQuery(document).ready(function($) {
					if ($('#back-to-top').length) {
					    var scrollTrigger = 100, // px
					        backToTop = function () {
					            var scrollTop = $(window).scrollTop();
					            if (scrollTop > scrollTrigger) {
					                $('#back-to-top').addClass('show');
					            } else {
					                $('#back-to-top').removeClass('show');
					            }
					        };
					    backToTop();
					    $(window).on('scroll', function () {
					        backToTop();
					    });
					    $('#back-to-top').on('click', function (e) {
					        e.preventDefault();
					        $('html,body').animate({
					            scrollTop: 0
					        }, 700);
					    });
					}
				});
			</script>
			<!-- <script type="text/javascript" src="assets/js/set-height.js"></script> -->
		</div>
		<!-- /page container -->
	</body>
</html>
