<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipCard;
use Barryvdh\DomPDF\Facade\Pdf;

class MembershipCardDownloadController extends Controller
{
    public function __invoke(MembershipCard $membershipCard)
    {
        abort_if(! $membershipCard->is_active, 403, 'Card is not yet approved.');

        $pdf = Pdf::loadView('pdf.membership-card', [
            'card' => $membershipCard->load('user', 'celebrity'),
        ]);

        $filename = 'membership-card-'.$membershipCard->card_number.'.pdf';

        return $pdf->download($filename);
    }
}
