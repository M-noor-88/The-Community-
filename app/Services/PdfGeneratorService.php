<?php

namespace App\Services;

use App\Repositories\ComplaintsRepository;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class PdfGeneratorService
{
    private $complaintsRepo;

    public function __construct(ComplaintsRepository $complaintsRepo)
    {
        $this->complaintsRepo = $complaintsRepo;
    }

    public function getFormalBook($id): string
    {
        $complaint = $this->complaintsRepo->getComplaintById($id);
        if (! $complaint) {
            throw new \Exception('Complaint not found.');
        }
        $complaint->load('achivementImages');
        $html = view('complaints.pdf', ['complaint' => $complaint])->render();

        return $html; // Return the rendered view as a string or nul
    }

    public function downloadFormalBook($id)
    {
        $complaint = $this->complaintsRepo->getComplaintById($id);
        if (! $complaint) {
            throw new \Exception('Complaint not found.');
        }

        $data = [
            'name' => $complaint->user->name,
            'complaint_title' => $complaint->title,
            'complaint_description' => $complaint->description,
            'complaint_location' => $complaint->location->name,
            'phone' => $complaint->user->clientProfile->phone,
            'achievementImages' => $complaint->achievementImages,
        ];

        $pdf = PDF::loadView('complaints.pdf', compact('data'), [], [
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'amiri',
            'orientation' => 'P',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'mirrorMargins' => true,
            'default_font_size' => 12,
            'directionality' => 'rtl',
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
        ]);

        return $pdf;
    }
}
