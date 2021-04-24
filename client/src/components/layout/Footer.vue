<template>
	<footer class="site-footer">
        <div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-5">
				<h6>Επικοινωνια</h6>
				<ul class="footer-links">
					<li><a class="phone" href="tel: 210-27-69696"><i class="fa fa-phone"></i> 210-xxxxxxx</a></li>
					<li><a class="email" href="mailto: support@cofy.gr"><i class="fa fa-envelope"></i> support@cofy.gr</a></li>
					<li class="text-white">Η ομάδα μας είναι στη διάθεσή σου, κάθε μέρα, 07:00 - 03:00, για να σε βοηθήσει με οποιαδήποτε ερώτηση έχεις.</li>
				</ul>
				</div>
				<div class="col-xs-6 col-md-4">
				<h6>Χρησιμα</h6>
				<ul class="footer-links">
					<li><a href="#">Ρυθμίσεις Cookies</a></li>
					<li><a href="#">Όροι Χρήσης</a></li>
					<li><a href="#">Πολιτική Προστασίας Δεδομένων</a></li>
					<li><a href="#">Συχνές Ερωτήσεις</a></li>
				</ul>
				</div>
				<div class="col-xs-6 col-md-3">
					<h6>Ακολουθησε το Cofy στα social media!</h6>
					<ul class="social-icons float-left">
						<li><a class="facebook" href="#"><i class="fab fa-facebook"></i></a></li>
						<li><a class="twitter" href="#"><i class="fab fa-twitter"></i></a></li>
						<li><a class="instagram" href="#"><i class="fab fa-instagram"></i></a></li>   
					</ul>
				</div>
			</div>
			<hr>
        </div>
        <div class="container">
			<div class="row">
				<div class="col-12">
					<p class="copyright-text text-muted text-center">&copy;{{ year }} Cofy. Handcrafted by z3r0Luck.</p>
				</div>
			</div>
        </div>
    </footer>
</template>

<script>
export default {
	name: "Footer",
	data() {
		return {
			year: new Date().getFullYear()
		}
	},
}
</script>

<style>
.site-footer {
  background-color: #210f04;
  padding: 45px 0 20px;
  font-size: 15px;
  line-height: 24px;
}

.site-footer hr {
  border-top-color: #bbb;
  opacity: 0.5;
}

.site-footer hr.small {
  margin: 20px 0;
}

.site-footer h6 {
  color: #fff;
  font-size: 16px;
  text-transform: uppercase;
  margin-top: 5px;
  letter-spacing: 2px;
}

.footer-links {
  padding-left: 0;
  list-style: none;
}

.footer-links li {
  display: block;
  padding: 4px;
}

.footer-links.inline li {
  display: inline-block;
  padding: 2%;
}

.site-footer .social-icons a {
  width: 40px;
  height: 40px;
  line-height: 40px;
  margin-left: 6px;
  margin-right: 0;
  border-radius: 100%;
  background-color: #33353d;
}

.copyright-text {
  margin: 0;
}

@media (max-width: 991px) {
  .site-footer [class^="col-"] {
    margin-bottom: 30px;
  }
}

@media (max-width: 767px) {
  .site-footer {
    padding-bottom: 0;
  }

  .site-footer .copyright-text,
  .site-footer .social-icons {
    text-align: center;
  }
}

.social-icons {
  padding-left: 0;
  margin-bottom: 0;
  list-style: none;
}

.social-icons li {
  display: inline-block;
  margin-bottom: 4px;
}

.social-icons li.title {
  margin-right: 15px;
  text-transform: uppercase;
  color: #96a2b2;
  font-weight: 700;
  font-size: 13px;
}

.social-icons a {
  background-color: #eceeef;
  color: #818a91;
  font-size: 16px;
  display: inline-block;
  line-height: 44px;
  width: 44px;
  height: 44px;
  text-align: center;
  margin-right: 8px;
  border-radius: 100%;
  -webkit-transition: all 0.2s linear;
  -o-transition: all 0.2s linear;
  transition: all 0.2s linear;
}

.social-icons a:active,
.social-icons a:focus,
.social-icons a:hover {
  color: #fff;
  background-color: #bb6b00;
}

.social-icons.size-sm a {
  line-height: 34px;
  height: 34px;
  width: 34px;
  font-size: 14px;
}

.social-icons a.facebook:hover {
  background-color: #bb6b00;
}

.social-icons a.twitter:hover {
  background-color: #bb6b00;
}

@media (max-width: 767px) {
  .social-icons li.title {
    display: block;
    margin-right: 0;
    font-weight: 600;
  }
}

</style>