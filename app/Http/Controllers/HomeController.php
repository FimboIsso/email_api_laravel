<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailLog;
use App\Models\SiteVisit;
use App\Models\User;
use App\Models\MailConfiguration;

class HomeController extends Controller
{
    public function index()
    {
        // Statistiques de visites
        $totalVisits = SiteVisit::count();
        $uniqueVisitors = SiteVisit::distinct('ip_address')->count();

        // Statistiques d'emails
        $totalEmails = EmailLog::count();
        $successfulEmails = EmailLog::where('status', 'sent')->count();

        // Statistiques d'utilisateurs et configurations
        $totalUsers = User::count();
        $totalConfigurations = MailConfiguration::count();

        return view('welcome', compact(
            'totalVisits',
            'uniqueVisitors',
            'totalEmails',
            'successfulEmails',
            'totalUsers',
            'totalConfigurations'
        ));
    }
}
