<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Ticket;
use Intervention\Image\ImageManagerStatic as Image;
use Barryvdh\DomPDF\Facade\PDF;

// use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class QRController extends Controller
{
    public function createQR(Request $request)
    {
        $ticketImage=$request->file('sample_ticket');
        $size= $ticketImage->getSize();

        $copied = Image::make($ticketImage);
      
        // $paddingSize = 20;

        // // Calculate the new dimensions with padding
        // $newWidth = $canvas->width() + 2 * $paddingSize;
        // $newHeight = $canvas->height() + 2 * $paddingSize;

        // // Create a new image with padding
        // $image = Image::canvas($newWidth, $newHeight, '#FFFFFF'); // You can specify the background color

        // // Insert the original image onto the canvas with padding
        // $image->insert($canvas, 'bottom-right', $paddingSize, $paddingSize);
   
        $data=$request->all();

        $size = $data['qrcode_size'];
        $count = $data['no_of_tickets'];
        $type = $data['ticket_type'];
        $qrLocation = $data['qrcode_location'];
        $width=$size[0];
        $height= $size[1];
        $token =(string) Str::random(4);             

        $QRCodes=[];
        $Tickets=[];

        // $NewImage = $image->ResizeWPreserve($width);

        // $NewImage = $image->ResizeHPreserve($height);
        // $finalImage = $image->ResizeCanvas($width, $height);

        for ($i=0; $i < $count; $i++) { 

            $key=(string) Str::uuid();
            $encryptedKey=Hash::make($key);
            $qrCode = QrCode::format('png')->generate($encryptedKey);
            $qrCodeconverted = Image::make($qrCode);
            $qr=$qrCodeconverted->resize(300, 300); 

            Ticket::create(['ticketKey' => $encryptedKey,
                            'ticketType'=>$type,
                            'userToken'=>$token]);
           
            $QRCodes[]= $qr;
            // $copied= $finalImage;
            $copied->insert($qr, $qrLocation);
         
            $marginSize=10;
            // $copied->border($marginSize,'ffffff');
            // $copied->encode('png');
            // dd($copied);
            $Tickets[]= $copied;
        }

        //Generate pdf
        //  $pdf = PDF::loadView('tickets',compact('Tickets'));



        // $pdfContent = $pdf->output();
        // $pdfFileName = storage_path('app/tickets.pdf');
        // $tempdir='app/downloads';
        // file_put_contents($pdfFileName, $pdfContent);
        // if (!is_dir($tempdir)) {
        //     mkdir($tempdir, 0755, true);
        // }

        // $filename='tickets';
        // if (!file_exists($filename)) {
        //     file_put_contents($filename, $pdfContent, FILE_APPEND);
        // }
        // else {
        //     file_put_contents($filename, $pdfContent, FILE_APPEND);
        // }
         // return $pdf->download('tickets.pdf');

        //  return view('Tickets', compact('Tickets'));


        //make as a set of png ->zipped file ->download

        $zip = new ZipArchive;
        $zipFileName = 'tickets.zip';
        $temporaryDirectory = 'app';

        if ($zip->open($zipFileName, ZipArchive::CREATE) === true) {
            foreach ($Tickets as $key => $ticket) {
                
                
               $pngData = $ticket->encode('png');
              
                // dd($pngData);
                $pngFileName = $key . '.png';
                 Storage::put($temporaryDirectory . '/' . $pngFileName, $pngData, FILE_APPEND);
                $filePath = $temporaryDirectory . '/' . $pngFileName;
                if (!is_dir($temporaryDirectory)) {
                    mkdir($temporaryDirectory, 0755, true);
                }

              
                
                if (!file_exists($filePath)) {
                    $content = '';
                    

                      file_put_contents($filePath, $content);
                }
                
                 file_put_contents($filePath, $pngData, FILE_APPEND);
            
                
                    $zip->addFile($filePath, $pngData);
                
                 
                //  $zip->addFile(storage_path('app/' . $ticket), $ticket);
            }

             $zip->close();

            return
                response()->download($zipFileName)->deleteFileAfterSend(true);
        }

        // $zipFileName = 'tickets.zip';
        // $zip = new ZipArchive;
        // if ($zip->open($zipFileName, ZipArchive::CREATE) === true) {
        //     foreach ($Tickets as $pngFileName) {
        //         $zip->addFile(storage_path('app/' . $pngFileName), $pngFileName);
        //     }
        //     $zip->close();

        //     // Download the zip file and delete it after sending
        //     return response()->download($zipFileName)->deleteFileAfterSend(true);
        // }





                   
    }

    public function validateQR($userCode)
    {
        $tickets=Ticket::where('userToken',$userCode)->get();
        if (count($tickets) > 0) {
            return response()->json(['isValid' => true, 'tickets' => $tickets], 200);
        } else {
            return response()->json(['isValid' => false], 404);
        }

    }
}
// ... (previous code)

// Send the PDF to the React.js backend via API
// $apiEndpoint = 'https://your-react-backend/api/receive-pdf'; // Adjust the API endpoint
// $response = Http::attach('pdf', file_get_contents($pdfFileName), 'tickets.pdf')
//                ->post($apiEndpoint);
