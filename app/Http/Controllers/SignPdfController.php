<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Str;

class SignPdfController extends Controller
{
    //
    public function uploadPdf ()
    {
        return view('cmr.upload_pdf');
    }




    public function uploadPdfPost(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:10000',
        ]);

        $path = $request->file('pdf')->store('public/pdfs');
        // dd( $path);
        //    $file = $request->file('pdf') ;

        // By default, this value is set to the storage/app directory
        // $path=   Storage::disk('public')->put('public/pdfs/', file_get_contents($file));


        // $request->file('pdf')->move(public_path('upload/filePDF/'),$name_gen);
        // $path =public_path('upload/filePDF/' .$name_gen);
        return view('cmr.view_pdf',['path' => $path]);

    }


    public function saveSignature(Request $request)
    {

        // dd($request);
        $request->validate([
            'signature' => 'required|string',
            'pdf_path' => 'required|string',
            'position' => 'required|array',
            'position.x' => 'required|numeric',
            'position.y' => 'required|numeric',
            'canvas_width' => 'required|numeric',
            'canvas_height' => 'required|numeric',
            'signature_way'=>'required'
        ]);

        $signatureDataUrl = $request->input('signature');
        $pdfPath = $request->input('pdf_path');
        $position = $request->input('position');
        $canvasWidth = $request->input('canvas_width');
        $canvasHeight = $request->input('canvas_height');
        $page_num = $request->input('page_num');
        $signature_way = $request->input('signature_way');


        $pdfFullPath = storage_path('app/' . $pdfPath);
        $signaturePath = 'signatures/' . Str::random(40) . '.png';


        if ($signature_way=='1'){//predefined_signature
            $signatureFullPath=  storage_path('app/public/' . auth()->user()->signaturePath);
        }elseif($signature_way=='2'){//hand_way_signature
            Storage::disk('public')->put($signaturePath, base64_decode(explode(',', $signatureDataUrl)[1]));
            $signatureFullPath = storage_path('app/public/' . $signaturePath);
        }

       info("alex:: signatureFullPath " . $signatureFullPath);

        // try {
        /*
        $pdf = new FPDI();
        $pdf->AddPage();
        $pdf->setSourceFile($pdfFullPath);
        $templateId = $pdf->importPage(1);
        $pdf->useTemplate($templateId, 0, 0,333,333, false);
        */


        $pdf = new FPDI();

        $pageCount =  $pdf->setSourceFile($pdfFullPath);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            // info ( 'alex:: arraysize ' .json_encode( $size) );

            // create a page (landscape or portrait depending on the imported page size)
            if ($size['width'] > $size['height']) {
                $pdf->AddPage('L', array($size['width'], $size['height']));
            } else {
                $pdf->AddPage('P', array($size['width'], $size['height']));
            }
            // use the imported page
            $pdf->useTemplate($templateId);

            $pdf->SetFont('Helvetica');
            // $pdf->SetXY(5, 5);


            list($imgWidth, $imgHeight) = getimagesize($signatureFullPath);

            // Convert the coordinates to PDF scale
            // $pdfWidth = $pdf->GetPageWidth();
            // $pdfHeight = $pdf->GetPageHeight();
            $pdfWidth = $pdf->GetPageWidth();
            $pdfHeight = $pdf->GetPageHeight();


            $x = ($position['x'] / $canvasWidth) * $pdfWidth;
            $y = ($position['y'] / $canvasHeight) * $pdfHeight;
            info ( 'alex:: XX ' .$x);
            info ( 'alex:: YY ' . $y);
            info ( 'alex:: canvasWidth ' . $canvasWidth);
            info ( 'alex:: canvasHeight ' . $canvasHeight);
            info ( 'alex:: pdfWidth ' . $pdfWidth);
            info ( 'alex:: pdfHeight ' . $pdfHeight);
            info ( 'alex:: imgWidth ' . $imgWidth);
            info ( 'alex:: imgHeight ' . $imgHeight);
            // info ( 'alex:: $pdfHeight - $y - ($imgHeight / 4) ' . ($pdfHeight - $y - ($imgHeight / 4)));
            info ( 'alex:: $pdfHeight - $y - ($imgHeight / 4) ' . ($imgWidth * ($imgWidth / $pdfWidth)));
            info ( 'alex::  $imgWidth / 9 ' . ( $imgWidth / 9));

            if ($pageNo == $page_num) {
                $pdf->Image($signatureFullPath, $x,  $y  , $imgWidth /10, $imgHeight / 10);

            }
        }
        $outputPath = storage_path('app/public/signed_pdfs/' . basename($pdfPath));
        $pdf->Output($outputPath, 'F');

        return response()->download($outputPath);

        // } catch (\Throwable $th) {
        //throw $th;
        // info('alex::err ' . $th);
        // }

    }

}
