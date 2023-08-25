@extends('frontend.page')
@section('title_prefix', 'Kontak - Sibenda')
@section('title', 'Sibenda')
@section('content')
    <section id="contact" class="contact">
        <div class="container aos-init aos-animate" data-aos="fade-up">

            <div class="section-title">
                <h2>Kontak</h2>
                <h3><span>Kontak Kami</span></h3>
                <p>Hubungi kami dengan mengisi form berikut untuk mendapatakan atau melaporkan informasi mengenai
                    kebencanaan di Provinsi Banten</p>
            </div>

            <div class="row aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-6">
                    <div class="info-box mb-4">
                        <i class="bx bx-map"></i>
                        <h3>Alamat</h3>
                        <p>Jl. Syekh Moh. Nawawi Albantani No.7 Kel,Banjaragung,Kec. Cipocok Jaya,Kota Serang</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="info-box  mb-4">
                        <i class="bx bx-envelope"></i>
                        <h3>Email</h3>
                        <p>operatorbpbdbanten@gmail.com</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="info-box  mb-4">
                        <i class="bx bx-phone-call"></i>
                        <h3>Phone</h3>
                        <p>( 0254 ) 7822841</p>
                    </div>
                </div>

            </div>

            <div class="row aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">

                <div class="col-lg-6 ">
                    <iframe class="mb-4 mb-lg-0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.927372114679!2d106.1977383!3d-6.140458799999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e41f5715d0d3e4d%3A0x673e474cb837254e!2sBPBD%20DAN%20PUSDALOPS%20PROVINSI%20BANTEN!5e0!3m2!1sid!2sid!4v1691446919821!5m2!1sid!2sid" frameborder="0" style="border:0; width: 100%; height: 384px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    {{-- <iframe class="mb-4 mb-lg-0"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26523.78320198563!2d106.12812327480054!3d-6.181222486670903!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e421f9efde7e5ab%3A0x9f124a9529695542!2sKp3b!5e0!3m2!1sid!2sid!4v1691181726485!5m2!1sid!2sid"
                        frameborder="0" style="border:0; width: 100%; height: 384px;" allowfullscreen=""></iframe> --}}
                </div>

                <div class="col-lg-6">
                    {{ Form::open(['url' => route('kontak.store'), 'method' => 'post', 'class' => 'kontak-email-form']) }}
                    <div class="row">
                        <div class="col form-group">
                            <input type="text" name="full_name" class="form-control" id="full_name"
                                placeholder="Nama Lengkap">
                            <span style="color:red !important;">{{ $errors->first('full_name') }}</span>
                        </div>
                        <div class="col form-group">
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Alamat Email">
                            <span style="color:red !important;">{{ $errors->first('email') }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject">
                        <span style="color:red !important;">{{ $errors->first('subject') }}</span>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="message" rows="5" placeholder="Pesan"></textarea>
                        <span style="color:red !important;">{{ $errors->first('message') }}</span>
                    </div>
                    <div class="my-3">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="text-center"><button type="submit" class="btn btn-primary">Kirim Pesan</button></div>
                    {{ Form::close() }}
                </div>

            </div>

        </div>
    </section>
@stop
@section('css')
    <style>
        .contact .kontak-email-form {
            box-shadow: 0 0 30px rgba(214, 215, 216, 0.4);
            padding: 30px;
        }

        .contact .kontak-email-form input {
            padding: 10px 15px;
        }

        .contact .kontak-email-form input,
        .contact .kontak-email-form textarea {
            border-radius: 0;
            box-shadow: none;
            font-size: 14px;
        }

        .contact .kontak-email-form .form-group {
            margin-bottom: 20px;
        }

        .contact .kontak-email-form button[type=submit] {
            background: #044085;
            border: 0;
            padding: 10px 30px;
            color: #fff;
            transition: 0.4s;
            border-radius: 4px;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }
    </style>
@stop
@section('js')
    <script></script>
@stop
