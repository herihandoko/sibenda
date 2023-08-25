<footer id="footer" style="padding: 0 0 20px 0 !important;">
    <div class="footer-top" style="background: #f1f6fe !important;">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-6 footer-contact">
                    <h3>BPBD Banten Prov<span>.</span></h3>
                    <p>
                        Jl. Syekh Moh. Nawawi Albantani No.7 Kel, Banjaragung, Kec. Cipocok Jaya, Kota Serang, Banten 42122 <br><br>
                        <strong>Phone:</strong> ( 0254 ) 7822 841<br>
                        <strong>Email:</strong> operatorbpbdbanten@gmail.com<br>
                    </p>
                </div>

                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Tautan Terkait</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="https://bnpb.go.id" target="_blank">BNPB Nasional</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="https://bpbd.bantenprov.go.id/" target="_blank">BPBD Banten</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="https://bantenprov.go.id/" target="_blank">Banten Prov.</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="https://dibi.bnpb.go.id/" target="_blank">Data Informasi Bencana</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Servis Lainnya</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ url('/laporan-kejadian') }}">Laporan Kejadian</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ url('/data-bencana') }}">Data Bencana</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ url('/grafik-kejadian') }}">Grafik</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ url('/dokumentasi') }}">Dokumentasi</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ url('/laporan-kejadian/buat-laporan') }}">Formulir Laporan Kejadian</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Sosial Media</h4>
                    <p>Sosial Media BPBD Provinsi Banten</p>
                    <div class="social-links mt-3">
                        <a href="https://twitter.com/BPBDBanten/" class="twitter"><i class="bx bxl-twitter"></i></a>
                        <a href="https://web.facebook.com/people/BPBD-Banten/100068237486806/" class="facebook"><i class="bx bxl-facebook"></i></a>
                        <a href="https://www.instagram.com/bpbd.provbanten/" class="instagram"><i class="bx bxl-instagram"></i></a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="container py-4">
        <div class="copyright" style="color: #ffffff !important;">
          © 2023 Copyright <strong><span>SIBENDA Bantenprov</span></strong>. All Rights Reserved
        </div>
        <div class="credits" style="color: #ffffff !important;">
          Designed by <a href="https://bantenprov.go.id/" style="color: #ffffff !important;">BPBD Provinsi Banten</a>
        </div>
      </div>
</footer>
@if(request()->route()->uri =! '/')
<a href="#" class="back-to-top d-flex align-items-center justify-content-center active"><i class="bi bi-arrow-up-short"></i></a>
@endif
