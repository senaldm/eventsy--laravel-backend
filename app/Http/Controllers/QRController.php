<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use app\Models\Ticket;
use Intervention\Image\ImageManagerStatic as Image;
use Barryvdh\DomPDF\Facade\Pdf;

// use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class QRController extends Controller
{
    public function createQR(Request $request)
    {
        $ticketImage=$request->file('sample_ticket');
        $image = Image::make($ticketImage);
        
        $data=$request->all();

        $size = $data['qrcode_size'];
        $count = $data['no_of_tickets'];
        $type = $data['ticket_type'];
        $qrLocation = $data['qrcode_location'];
        $token =(string) Str::random(4);             
        // dd($token);

        $QRCodes=[];
        $Tickets=[];
        
        for ($i=0; $i < $count; $i++) { 

            $key=(string) Str::uuid();
         
            $encryptedKey=Hash::make($key);
 
            $details= "$encryptedKey,$type,$token";
            $qrCode = QrCode::size($size)->generate($encryptedKey);
dd($qrCode);
            Ticket::create(['ticketKey' => $qrCode,
                            'ticketType'=>$type,
                            'userToken'=>$token]);
            $QRCodes[]=$qrCode;

            
            $copied=$image;
            $copied->insert($qrCode, $qrLocation);

            $marginSize=10;
            $copied->border($marginSize,'ffffff');


            $Tickets[]=$copied;





        }

        $pdf=PDF::loadView('tickets.pdf',compact('Tickets'));
        $pdfContent = $pdf->output();
        $pdfFileName = storage_path('app/tickets.pdf');
        file_put_contents($pdfFileName, $pdfContent);





// ... (previous code)

// Send the PDF to the React.js backend via API
// $apiEndpoint = 'https://your-react-backend/api/receive-pdf'; // Adjust the API endpoint
// $response = Http::attach('pdf', file_get_contents($pdfFileName), 'tickets.pdf')
//                ->post($apiEndpoint);



            //make as a set of png ->zipped file ->download



                    $zip = new ZipArchive;
                    $zipFileName = 'tickets.zip';
                    $temporaryDirectory = 'app/tickets.pdf';

                    if ($zip->open($zipFileName, ZipArchive::CREATE) === true) {
                        foreach ($Tickets as $key => $ticket) {
                            $ticket->insert($qrCode, 'bottom-right');
                            $pngData = $ticket->encode('png');
                            $pngFileName = $key . '.png'; // You can generate unique filenames here

                            Storage::put($temporaryDirectory . '/' . $pngFileName, $pngData);
                            $zip->addFile($temporaryDirectory . '/' . $pngFileName, $pngFileName);
                        }

                        $zip->close();

                        return 
                        response()->download($zipFileName)->deleteFileAfterSend(true);
                    }

    }
}
