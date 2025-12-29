    </main>
    
    <!-- Footer -->
    <footer class="footer-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-egg-fried me-2"></i>LAUK RESTO
                        </h5>
                        <p class="text-muted">Menyajikan makanan enak dan berkualitas dengan cita rasa autentik sejak 2025.</p>
                        <div class="social-links">
                            <a href="#" class="social-link" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="social-link" title="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="social-link" title="Twitter">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="#" class="social-link" title="WhatsApp">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-title">Quick Links</h6>
                    <ul class="footer-links">
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="menu.php">Menu</a></li>
                        <li><a href="about.php">Tentang</a></li>
                        <li><a href="contact.php">Kontak</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-title">Kontak Info</h6>
                    <ul class="footer-links">
                        <li>
                            <i class="bi bi-geo-alt me-2"></i>Jl. Restoran No. 123, Jakarta
                        </li>
                        <li>
                            <i class="bi bi-telephone me-2"></i>(021) 1234-5678
                        </li>
                        <li>
                            <i class="bi bi-envelope me-2"></i>info@laukresto.com
                        </li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-title">Jam Operasional</h6>
                    <ul class="footer-links">
                        <li><strong>Senin - Minggu</strong></li>
                        <li>10:00 - 22:00 WIB</li>
                        <li class="mt-2">
                            <small class="text-muted">Termasuk hari libur nasional</small>
                        </li>
                    </ul>
                </div>
            </div>
            
            <hr class="footer-divider">
            
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="mb-0">&copy; 2025 Lauk Restoran. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-0">Made with <i class="bi bi-heart-fill text-danger"></i> for good food</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS dengan path yang dinamis -->
    <?php
    $is_admin = strpos($_SERVER['REQUEST_URI'], '/admin/') !== false;
    $js_path = $is_admin ? '../assets/js/app.js' : 'assets/js/app.js';
    ?>
    <script src="<?= $js_path ?>"></script>
</body>
</html>