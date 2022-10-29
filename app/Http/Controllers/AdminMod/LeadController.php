<?php

namespace App\Http\Controllers\AdminMod;

use App\Exports\LeadsExport;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\Product;
use App\Models\Source;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class LeadController extends Controller
{
    public function createLead(Request $request)
    {
        $sources = Source::select('id', 'name')->orderBy("name", "ASC")->get();
        $contacts = Contact::select('id', 'name')->orderBy("created_at", "DESC")->get();
        $products = Product::select('id', 'name')->orderBy("name", "ASC")->get();
        $businesses = Business::select('id', 'name')->orderBy("name", "ASC")->get();

        return view('admin-mod.lead.create-lead', compact('sources', 'contacts', 'products', 'businesses'));
    }

    public function postCreateLead(Request $request)
    {
        $request->validate([
            "name" => "required|unique:leads,name",
            "description" => "required",
            "value" => "required|numeric",
            "source_id" => "required",
            "progress" => "required|in:new,follow up,prospect,negotiation,won,lost",
            "close_date" => "required",
            "contact_id" => "required",
            "product_id" => "required",
            "business_id" => "required",
            "quantity" => "required|integer",
        ]);

        // check the close date
        $close_date = new Carbon($request->close_date);
        $now_date = Carbon::now()->timezone('Asia/Yangon');
        if (strtotime($now_date) >= strtotime($close_date)) {
            return redirect()->back()->withErrors(["close_date" => "Please choose the future date!"]);
        }

        // calculate amount
        $product = Product::where('id', $request->product_id)->first();
        if (!$product) {
            return redirect()->back()->with("error", "Product not found!");
        }
        $amount = $product->price * $request->quantity;

        $moderator_id = 0;
        $admin_id = 0;
        if (Auth::guard('moderator')->check()) {
            $moderator_id = Auth::guard('moderator')->user()->id;
        }
        if (Auth::guard('admin')->check()) {
            $admin_id = Auth::guard('admin')->user()->id;
        }

        $lead = Lead::create([
            "name" => $request->name,
            "slug" => Str::slug(uniqid() . $request->name),
            "description" => $request->description,
            "value" => $request->value,
            "source_id" => $request->source_id,
            "progress" => $request->progress,
            "moderator_id" => $moderator_id,
            "admin_id" => $admin_id,
            "close_date" => $request->close_date,
            "contact_id" => $request->contact_id,
            "product_id" => $request->product_id,
            "quantity" => $request->quantity,
            "amount" => $amount,
            "business_id" => $request->business_id,
        ]);

        if (!$lead) {
            return redirect()->back()->with("error", "Something went wrong!");
        }
        return redirect()->back()->with("success", "$lead->name has been created!");
    }

    public function viewLead(Request $request)
    {
        $contact_slug = "";
        $by = "anyone";
        $business_slug = "";
        $source_slug = "";
        if ($request->by) {
            $by = $request->by;
        }
        if ($request->contact_slug) {
            $contact_slug = $request->contact_slug;
        };
        if ($request->business_slug) {
            $business_slug = $request->business_slug;
        }
        if ($request->source_slug) {
            $source_slug = $request->source_slug;
        }
        return view("admin-mod.lead.view-lead", compact('by', 'contact_slug', 'business_slug', 'source_slug'));
    }

    public function editLead($slug)
    {
        $lead = Lead::where('slug', $slug)->first();
        if (!$lead) {
            return redirect()->back()->with("error", "Something went wrong!");
        }
        $sources = Source::select('id', 'name')->orderBy("name", "ASC")->get();
        $contacts = Contact::select('id', 'name')->orderBy("created_at", "DESC")->get();
        $products = Product::select('id', 'name')->orderBy("name", "ASC")->get();
        $businesses = Business::select('id', 'name')->orderBy("name", "ASC")->get();

        return view('admin-mod.lead.edit-lead', compact('lead', 'sources', 'contacts', 'products', 'businesses'));
    }

    public function postEditLead(Request $request, $slug)
    {
        $lead = Lead::where('slug', $slug)->first();
        if (!$lead) {
            return redirect()->back()->with("error", "Something went wrong!");
        }
        $request->validate([
            "name" => "required|unique:leads,name,$lead->id",
            "description" => "required",
            "value" => "required|numeric",
            "source_id" => "required",
            "progress" => "required|in:new,follow up,prospect,negotiation,won,lost",
            "close_date" => "required",
            "contact_id" => "required",
            "product_id" => "required",
            "business_id" => "required",
            "quantity" => "required|integer",
        ]);

        // check the close date
        $close_date = new Carbon($request->close_date);
        $now_date = Carbon::now()->timezone('Asia/Yangon');
        if (strtotime($now_date) >= strtotime($close_date)) {
            return redirect()->back()->withErrors(["close_date" => "Please choose the future date!"]);
        }

        // calculate amount
        $product = Product::where('id', $request->product_id)->first();
        if (!$product) {
            return redirect()->back()->with("error", "Product not found!");
        }
        $amount = $product->price * $request->quantity;

        $moderator_id = 0;
        $admin_id = 0;
        if (Auth::guard('moderator')->check()) {
            $moderator_id = Auth::guard('moderator')->user()->id;
        }
        if (Auth::guard('admin')->check()) {
            $admin_id = Auth::guard('admin')->user()->id;
        }
        $lead_slug = Str::slug(uniqid() . $request->name);

        Lead::where('id', $lead->id)->update([
            "name" => $request->name,
            "slug" => $lead_slug,
            "description" => $request->description,
            "value" => $request->value,
            "source_id" => $request->source_id,
            "progress" => $request->progress,
            "moderator_id" => $moderator_id,
            "admin_id" => $admin_id,
            "close_date" => $request->close_date,
            "contact_id" => $request->contact_id,
            "product_id" => $request->product_id,
            "quantity" => $request->quantity,
            "amount" => $amount,
            "business_id" => $request->business_id,
        ]);

        return redirect("/lead/edit/$lead_slug")->with("success", "$request->name has been updated!");
    }

    public function downloadLead($year)
    {
        return Excel::download(new LeadsExport($year), "leads_$year.xlsx");
    }
}
