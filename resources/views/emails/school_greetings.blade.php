<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  </head>
  <body>
    
    {{-- <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <img src="https://schooltechindonesia.com/assets/img/Logo-SchoolTech.png" alt="Logo" style="width: 100px; height: auto;">
                </div>
            </div>
            <p>Dear, {{ $data['name'] }} team!</p>
        </div>
    </div> --}}

    <p>Salam, {{ $data['name'] }} tim!</p>

    <p>Sekolah anda telah berhasil terdaftar dalam sistem informasi modern untuk kegiatan PKL/Internship bagi siswa SMK dengan nama InternPro by SchoolTech Indonesia!
    </p>
    <p>
        Kami sangat senang menyambut anda sebagai mitra kami dalam memberikan pengalaman belajar yang lebih baik bagi siswa-siswa SMK di Indonesia. Apabila anda memiliki pertanyaan atau membutuhkan bantuan lebih lanjut, jangan ragu untuk menghubungi kami melalui email admin@schooltechindonesia.com atau melalui kontak kami +62-82244767431.
    </p>
    <p>
        Untuk mulai menggunakan sistem kami, silahkan mengunjungi website kami di <a href="{{ env('APP_URL') }}">Intern Pro by SchoolTech Indonesia</a> dan login menggunakan akun yang telah terdaftar.
    </p>

    <p>Terima kasih atas kepercayaan anda kepada kami.</p>
    <p>Salam hangat,</p>
    <p>Tim InternPro by SchoolTech Indonesia</p>
    <img src="https://schooltechindonesia.com/assets/img/Logo-SchoolTech.png" alt="Logo" style="width: 100px; height: auto;">
    
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>