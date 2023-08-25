<section id="counts" class="counts" style="padding: 20px 0 60px !important;">
    <div class="container aos-init aos-animate" data-aos="fade-up">
        <div class="section-title">
            <h3><span style="color: #044085 !important;">Data Bencana Provinsi Banten</span></h3>
            <p>Sumber : Badan Penanggulangan Bencana Daerah Provisi Banten Tahun {{ date('Y') }}</p>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-2 col-md-6">
                <div class="count-box">
                    <i class="bi bi-server" style="background: #044085 !important;"></i>
                    <span data-purecounter-start="0" data-purecounter-end="{{ $ttl_bencana }}"
                        data-purecounter-duration="0" class="purecounter">{{ $ttl_bencana }}</span>
                    <p>Bencana</p>
                </div>
            </div>
            @foreach ($status as $key => $val)
                <div class="col-lg-2 col-md-6">
                    <div class="count-box">
                        <i class="{{ $val->icon }}" style="background: #044085 !important;"></i>
                        <span data-purecounter-start="0" data-purecounter-end="{{ $val->ttl_korban }}"
                            data-purecounter-duration="0" class="purecounter">{{ $val->ttl_korban }}</span>
                        <p>{{ $val->name }}</p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
