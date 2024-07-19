<?php 

namespace UmamZ\UkppLubangsa\Service;

use DateTime;
use DateTimeZone;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use PHPMailer\PHPMailer\PHPMailer;
use UmamZ\UkppLubangsa\Config\Database;
use UmamZ\UkppLubangsa\Domain\Pasien;
use UmamZ\UkppLubangsa\Exception\ValidationException;
use UmamZ\UkppLubangsa\Helper\ValidationUtil;
use UmamZ\UkppLubangsa\Model\PasienAddRequest;
use UmamZ\UkppLubangsa\Model\PasienAddResponse;
use UmamZ\UkppLubangsa\Repository\PasienRepository;
use UmamZ\UkppLubangsa\Repository\PendidikanRepository;

class PasienService 
{
    private PasienRepository $pasienRepository;
    private PendidikanRepository $pendidikanRepository;

    public function __construct(PasienRepository $pasienRepository, PendidikanRepository $pendidikanRepository)
    {
        $this->pasienRepository = $pasienRepository;
        $this->pendidikanRepository = $pendidikanRepository;
    }

    public function addPasien(PasienAddRequest $request): PasienAddResponse
    {
      ValidationUtil::validate($request);
      
      $pasien = new Pasien(
        mt_rand(),
        $request->nama,
        $request->nis,
        $request->pedidikanId
      );
      
      try {
          Database::beginTransaction();
          $result = $this->pasienRepository->findById($pasien->getId());
          if ($result != null) {
              throw new ValidationException("Terjadi Kesalahan");
          }
          $this->pasienRepository->save($pasien);
          $response = new PasienAddResponse;
          $response->pasien = $pasien;
          Database::commitTransaction();
          return $response;
      } catch (\Exception $e) {
          Database::rollbackTransaction();
          throw $e;
      }
    }

    public function delete(int $pasienId) : Pasien
    {
      try {
          Database::beginTransaction();
          $pasien = $this->pasienRepository->findById($pasienId);
          if ($pasien == null) {
              throw new ValidationException("Terjadi Kesalahan");
          }
          $this->pasienRepository->deleteById($pasienId);
          Database::commitTransaction();
          return $pasien;
      } catch (\Exception $e) {
          throw $e;
      }
    }

    public function findPasienPeriksa(int $pasienId) : Pasien
    {
        $pasien = $this->pasienRepository->findById($pasienId);
        if ($pasien == null) {
            throw new ValidationException("Terjadi Kesalahan");
        }
        return $pasien;
    }

    // pasien surat
    private function htmlToPdf(array $pasienAlamat) : string
    {
      $mpdf = new Mpdf();
      $now = new DateTime();
      $now->setTimezone(new DateTimeZone('Asia/Jakarta'));
      $string = $now->format('d F Y');
      $html = '
      <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background-color: #f0f0f0;
      }
      .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
      }
      .header img {
        width: 100%;
        max-width: 100%;
      }
      .footer img {
        width: 100%;
        max-width: 100%;
      }
      .sakit {
        text-align: center;
      }
      p {
        margin-bottom: 10px;
      }
      .right {
        text-align: right;
      }
      .signature {
        margin-top: 20px;
      }
      .signature img {
        max-width: 100px;
        height: auto;
      }
      .signature p {
        margin-top: 5px;
        margin-bottom: 0;
      }
      .signature .kpo {
        text-align: center; 
        margin-top: 20px; 
      }
      .signature .row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
      }
  
      .signature .row > div {
        flex: 1;
        text-align: center;
      }
  
      .blok,
      .p2k {
        flex: 1;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="header">
        <img src="/assets/dist/img/ukpp.png" alt="Logo Rumah Sakit">
      </div>
      <h2 class="sakit">Surat Keterangan Sakit</h2>
      <p>
        Yang bertanda tangan dibawah ini pengurus Pondok Pesantren Annuqayah daerah Lubangsa Menerangkan bahwa: 
      </p>
      <p>
        Nama            : ' . $pasienAlamat['pasien'] . '<br>
        Alamat          : '. $pasienAlamat['desa'] .', '. $pasienAlamat['kecamatan'] . ', '. $pasienAlamat['kabupaten'].' <br>
        Blok            : ' . $pasienAlamat['blok'] . ' \ ' . $pasienAlamat['no'] . '  <br>
      </p>
      <h5 class="sakit">SAKIT.</h5>
      <p>
        Demikian surat keterangan ini kami buat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.
      </p>
      <p class="right">
        Guluk-Guluk,' . $string . '
      </p>
      <div class="footer">
        <img src="/assets/dist/img/signature2.png" alt="Tanda Tangan Pengurus">
      </div>
    </div>
  </body>
  </html>
  
      ';
      $pdfname = uniqid() . '.pdf';
      $mpdf->WriteHTML($html);
      $mpdf->Output('assets/dist/img/' . $pdfname,  Destination::FILE );
      return $pdfname;
    }

    public function sendEmail(array $pasienAlamat) : void
    {
      $mail = new PHPMailer(true);
  
      $pendidikan = $this->pendidikanRepository->findById($pasienAlamat['pendidikan_id']);
      try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                 //Enable SMTP authentication
        $mail->Username   = 'sirajul.umam6@gmail.com';            //SMTP username
        $mail->Password   = 'puck bzng jrxf fseb';                //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
  
        //Recipients
        $mail->setFrom('sirajul.umam6@gmail.com', 'UKPP Lubangsa');
        $mail->addAddress($pendidikan->email, $pendidikan->staff);     //Add a recipient;
        // $pdf = $this->htmlToPdf();
  
        // $padfFile = explode("/", $pdf);
        $toPdf = $this->htmlToPdf($pasienAlamat);
  
        //Attachments
        $mail->addAttachment("assets/dist/img/$toPdf", $toPdf);         //Add attachments
  
        // Content
        // $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Surat Keterangan Sakit';
        $mail->Body    = 'Berikut Adalah Lampiran Surat Keterangan Sakit';
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
  
        $mail->send();
        unlink("assets/dist/img/$toPdf");
      } catch (\Exception $e) {
        throw $e;
      }
    }

    public function count(): int
    {
      return $this->pasienRepository->countAll();
    }
}
