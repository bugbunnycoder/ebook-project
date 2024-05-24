<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FPDF;
use App\Models\Ebook;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EbookController extends Controller
{
    public function index()
    {
        $ebooks = Ebook::all()->sortByDesc('id');
        return view('ebooks.index', compact('ebooks'));
    }

    public function create()
    {
        return view('ebooks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'paragraph' => 'required',
            'front_cover' => 'required|image',
            'back_cover' => 'required|image',
            'front_title' => 'required',
            'front_description' => 'required',
            'back_title' => 'required',
            'back_description' => 'required',
            'author_image' => 'required|image',
        ]);

        $frontCoverPath = $request->file('front_cover')->store('public/covers');
        $backCoverPath = $request->file('back_cover')->store('public/covers');
        $authorImagePath = $request->file('author_image')->store('public/authors');

        $ebook = Ebook::create([
            'title' => $request->title,
            'author' => $request->author,
            'paragraph' => $request->paragraph,
            'front_cover' => $frontCoverPath,
            'back_cover' => $backCoverPath,
            'front_title' => $request->front_title,
            'front_description' => $request->front_description,
            'back_title' => $request->back_title,
            'back_description' => $request->back_description,
            'author_image' => $authorImagePath
        ]);

        // Create PDF
        $pdfDirectory = storage_path('app/public/ebooks');
        if (!file_exists($pdfDirectory)) {
            mkdir($pdfDirectory, 0777, true);
        }

        $pdf = new FPDF();
        $pdf->AddPage('P', 'A4');

        // Front Cover
        $pdf->Image(storage_path('app/' . $frontCoverPath), 0, 0, 210, 297);
        $pdf->SetFont('Arial', 'B', 22);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetXY(10, 80);
        $pdf->Cell(0, 10, $request->front_title, 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(10, 150);
        $pdf->MultiCell(0, 10, $request->front_description);

        // New Page for Content
        // $pdf->AddPage('P', 'A4');
        // $pdf->SetFont('Arial', '', 12);
        // $pdf->SetTextColor(0, 0, 0);
        // $pdf->MultiCell(0, 10, $request->description);
        $description = $request->paragraph;
        $pdf->AddPage('L');
        // Get the width and height of the page
        $pageWidth = $pdf->GetPageWidth();
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(0, 0, 0);
        $columnWidth = $pageWidth / 2 - 20; // Adjust 20 for some padding
        $lineHeight = 10;
        // die($yPosition);
        $pdf->Image(storage_path('app/cloud.png'),0, 10, 300, 0);
        
        if (strlen($description) > 1100) {
            $part1 = substr($description, 0, 1100);
            $part2 = substr($description, 1100);

            // First column
            $pdf->SetXY(10, 10);
            $pdf->MultiCell($columnWidth, $lineHeight, $part1);

            // Second column
            $pdf->SetXY($columnWidth + 30, 10);
            $pdf->MultiCell($columnWidth, $lineHeight, $part2);
        } else {
            // Single column
            $pdf->SetXY(10, 10);
            $pdf->MultiCell($columnWidth, $lineHeight, $description);
        }

        // Back Cover
        $pdf->AddPage('P', 'A4');
        $pdf->Image(storage_path('app/' . $backCoverPath), 0, 0, 210, 297);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetXY(10, 40);
        $pdf->Cell(0, 10, $request->back_title, 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(10, 160);
        $pdf->MultiCell(130, 10, $request->back_description);

        // Author Image on Back Cover
        $pdf->SetXY(145, 160);
        $pdf->Image(storage_path('app/' . $authorImagePath), null, null, 50, 0); // Adjust position and size as needed

        // Define the PDF output path
        $outputPath = $pdfDirectory . '/' . $request->title . '.pdf';
        $pdf->Output($outputPath, 'F');

        // Update the eBook record with the actual PDF path
        $ebook->update(['file_path' => 'public/ebooks/' . $request->title . '.pdf']);

        return redirect()->route('ebooks.index')->with('success', 'Ebook created successfully.');
    }
    public function show()
    { 
        $frontCoverPath = "C:\Users\Admin\Desktop\img1.jpg";
        $backCoverPath = "C:\Users\Admin\Desktop\img2.jpg";
        $authorImagePath = "C:\Users\Admin\Desktop\IMG-20210212-WA0007.jpg";
        // Create PDF
        $pdfDirectory = storage_path('app/public/ebooks');
        if (!file_exists($pdfDirectory)) {
            mkdir($pdfDirectory, 0777, true);
        }

        $pdf = new FPDF();
        $pdf->AddPage('P', 'A4');

        // Front Cover
        $pdf->Image($frontCoverPath, 0, 0, 210, 297);
        $pdf->SetFont('Arial', 'B', 22);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetXY(10, 80);
        $pdf->Cell(0, 10, "Test title for submission", 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(10, 150);
        $pdf->MultiCell(0, 10, "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum");

        // New Page for Content
        $description = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting. To find out the word and character count of your writing, simply copy and paste text into the tool or write directly into the text area.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting. To find out the word and character count of your writing, simply copy and paste text into the tool or write directly into the text area.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting. To find out the word and character count of your writing, simply copy and paste text into the tool or write directly into the text area.";

        $pdf->AddPage('L');
        // Get the width and height of the page
        $pageWidth = $pdf->GetPageWidth();
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(0, 0, 0);
        $columnWidth = $pageWidth / 2 - 20; // Adjust 20 for some padding
        $lineHeight = 10;
        // die($yPosition);
        $pdf->Image(storage_path('app/cloud.png'),0, 10, 300, 0);
        
        if (strlen($description) > 1100) {
            $part1 = substr($description, 0, 1100);
            $part2 = substr($description, 1100);

            // First column
            $pdf->SetXY(10, 10);
            $pdf->MultiCell($columnWidth, $lineHeight, $part1);

            // Second column
            $pdf->SetXY($columnWidth + 30, 10);
            $pdf->MultiCell($columnWidth, $lineHeight, $part2);
        } else {
            // Single column
            $pdf->SetXY(10, 10);
            $pdf->MultiCell($columnWidth, $lineHeight, $description);
        }

        // Back Cover
        $pdf->AddPage('P', 'A4');
        $pdf->Image($backCoverPath, 0, 0, 210, 297);
        $pdf->SetFont('Arial', 'B', 22);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetXY(10, 40);
        $pdf->Cell(0, 10, "Test title for submission", 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(10, 160);
        $pdf->MultiCell(130, 10, "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting. To find out the word and character count of your writing, simply copy and paste text into the tool or write directly into the text area.");

        // Author Image on Back Cover
        $pdf->SetXY(145, 160);
        $pdf->Image($authorImagePath,null, null, 50, 0); // Adjust position and size as needed

        // Define the PDF output path
        $outputPath = $pdfDirectory . '/test.pdf';
        $pdf->Output($outputPath, 'F');
        
    }
}
