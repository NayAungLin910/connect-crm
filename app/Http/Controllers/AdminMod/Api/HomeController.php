<?php

namespace App\Http\Controllers\AdminMod\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getYearBarData(Request $request)
    {
        // Yearly Bar Data
        $year_year_bar = $request->year_year_bar;
        $labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        $news = [
            "label" => "New",
            "data" => [],
            "backgroundColor" => "rgb(180, 211, 209, 0.7)",
        ];
        $follow_ups = [
            "label" => "Follow Up",
            "data" => [],
            "backgroundColor" => "rgb(57, 202, 231, 0.7)",
        ];
        $prospects = [
            "label" => "Prospect",
            "data" => [],
            "backgroundColor" => "rgb(125, 231, 113, 0.7)",
        ];
        $negotiations = [
            "label" => "Negotiate",
            "data" => [],
            "backgroundColor" => "rgb(94, 233, 53, 0.7)",
        ];
        $wons = [
            "label" => "Won",
            "data" => [],
            "backgroundColor" => "rgb(206, 65, 234, 0.7)",
        ];
        $losts = [
            "label" => "Lost",
            "data" => [],
            "backgroundColor" => "rgb(241, 121, 61, 0.7)",
        ];

        for ($i = 1; $i <= 12; $i++) {
            // new leads
            $newCount = Lead::whereYear("created_at", $year_year_bar)->whereMonth("created_at", $i)->where("progress", "new")->count();
            $news["data"][] = $newCount;
            // follow up leads
            $followUpCount = Lead::whereYear("created_at", $year_year_bar)->whereMonth("created_at", $i)->where("progress", "follow up")->count();
            $follow_ups["data"][] = $followUpCount;
            // prospect leads
            $prospectCount = Lead::whereYear("created_at", $year_year_bar)->whereMonth("created_at", $i)->where("progress", "prospect")->count();
            $prospects["data"][] = $prospectCount;
            // negotaition leads
            $negotationCount = Lead::whereYear("created_at", $year_year_bar)->whereMonth("created_at", $i)->where("progress", "negotiation")->count();
            $negotiations["data"][] = $negotationCount;
            // won lead
            $wonCount = Lead::whereYear("created_at", $year_year_bar)->whereMonth("created_at", $i)->where("progress", "won")->count();
            $wons["data"][] = $wonCount;
            // lost lead
            $lostCount = Lead::whereYear("created_at", $year_year_bar)->whereMonth("created_at", $i)->where("progress", "lost")->count();
            $losts["data"][] = $lostCount;
        }

        return response()->json([
            "success" => "true",
            "status" => 200,
            "data" => [
                "labels" => $labels,
                "datasets" => [$news, $follow_ups, $prospects, $negotiations, $wons, $losts],
            ]
        ]);
    }

    public function getLeadPieData(Request $request)
    {
        $year_year_bar = $request->year_year_bar;
        $labels = ["New", "Follow Up", "Prospect", "Negociate", "Won", "Lost"];
        $new_count = Lead::where("progress", "new")->whereYear("created_at", $year_year_bar)->count();
        $follow_up_count = Lead::where('progress', "follow up")->whereYear("created_at", $year_year_bar)->count();
        $prospect_count = Lead::where('progress', 'prospect')->whereYear("created_at", $year_year_bar)->count();
        $negotiate_count = Lead::where('progress', 'negotiation')->whereYear("created_at", $year_year_bar)->count();
        $won_count = Lead::where('progress', 'won')->whereYear("created_at", $year_year_bar)->count();
        $lost_count = Lead::where('progress', 'lost')->whereYear("created_at", $year_year_bar)->count();
        $dataset = [
            "label" => "Total Percentage of each type of lead in $year_year_bar",
            "data" =>  [$new_count, $follow_up_count, $prospect_count, $negotiate_count, $won_count, $lost_count],
            "backgroundColor" => [
                "rgb(180, 211, 209, 0.4)",
                "rgb(57, 202, 231, 0.4)",
                "rgb(125, 231, 113, 0.4)",
                "rgb(94, 233, 53, 0.4)",
                "rgb(206, 65, 234, 0.4)",
                "rgb(241, 121, 61, 0.4)"
            ],
            "borderColor" => [
                "rgb(180, 211, 209, 1)",
                "rgb(57, 202, 231, 1)",
                "rgb(125, 231, 113, 01)",
                "rgb(94, 233, 53, 1)",
                "rgb(206, 65, 234, 1)",
                "rgb(241, 121, 61, 1)"
            ],
        ];

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => [
                "labels" => $labels,
                "datasets" => [$dataset],
            ]
        ]);
    }

    public function getTopLeadData(Request $request)
    {
        $year_top_lead = $request->year_top_lead;
        $month_top_lead = $request->month_top_lead;
        $number_top_lead = $request->number_top_lead;

        $dataset = [
            "label" => "Leads",
            "data" => [],
            "borderColor" => "rgb(255, 99, 132)",
            "backgroundColor" => "rgb(255, 99, 132, 0.5)",
        ];
        $labels = [];

        $leads = Lead::whereYear("created_at", $year_top_lead)
            ->whereMonth("created_at", $month_top_lead)
            ->orderBy("amount", "DESC")
            ->take($number_top_lead)
            ->get();

        foreach ($leads as $lead) {
            $labels[] = $lead->name;
            $dataset["data"][] = $lead->amount;
        }

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => [
                "labels" => $labels,
                "datasets" => [$dataset],
            ]
        ]);
    }

    public function getRevenueLeadData(Request $request)
    {
        $year = $request->year_revenue_lead;
        $labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        $revenues = [
            "label" => "Revenues",
            "data" => [],
            "borderColor" => "rgb(57, 202, 231, 1)",
            "backgroundColor" => "rgb(57, 202, 231, 0.5)",
        ];

        for ($i = 1; $i <= 12; $i++) {
            $revenues["data"][] = Lead::where('progress', 'won')->whereMonth("created_at", $i)->whereYear("created_at", $year)->sum('amount');
        }

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => [
                "labels" => $labels,
                "datasets" => [$revenues],
            ]
        ]);
    }
}
