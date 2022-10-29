<?php

namespace App\Http\CustomQueryFunctions;

use App\Models\Activity;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\Moderator;
use App\Models\Org;
use App\Models\Product;
use App\Models\Source;
use Illuminate\Support\Facades\Auth;

class QueryFunctions
{
    public static function filterPaginate($request, $type)
    {
        $startdate = "";
        $enddate = "";
        $search = "";
        $time_sort = "";
        $view = 10;
        $queryData = "";

        if ($type == "product") {
            $queryData = Product::query();
        } elseif ($type == "contact") {
            $queryData = Contact::query()->with("email:id,name,contact_id", "phone:id,number,contact_id", "org:id,name", "lead:id,name,contact_id")->withCount("lead");
        } elseif ($type == "source") {
            $queryData = Source::query()->withCount("lead");
        } elseif ($type == "org") {
            $queryData = Org::query()->withCount("contact");
        } elseif ($type == "business") {
            $queryData = Business::query()->withCount("lead");
        } elseif ($type == "lead") {
            $queryData = Lead::query()->with("source:id,name", "contact:id,name", "product:id,name", "business:id,name", "moderator:id,name", "admin:id,name");
        } elseif ($type == "activity") {
            $queryData = Activity::query()->with("admin:id,name", "moderator:id,name");
        } elseif ($type == "account-manage") {
            $queryData = Moderator::query();
        } else {
            return false;
        }

        if ($request->startdate && $request->enddate) {
            $startdate = $request->startdate;
            $enddate = $request->enddate;
            $queryData = $queryData->whereBetween('created_at', [$startdate . " 00:00:00", $enddate . " 23:59:59"]);
        }

        if ($request->start_close_date && $request->end_close_date) {
            $start_close_date = $request->start_close_date;
            $end_close_date = $request->end_close_date;
            $queryData = $queryData->whereBetween('close_date', [$start_close_date . " 00:00:00", $end_close_date . " 23:59:59"]);
        }

        // for quering startdate of activity
        if ($request->startdate_activity) {
            $startdate_activity = $request->startdate_activity;
            $queryData = $queryData->whereDate('start_date', '=', $startdate_activity);
        }
        // for quering startdate of activity
        if ($request->enddate_activity) {
            $enddate_activity = $request->enddate_activity;
            $queryData = $queryData->whereDate('end_date', '=', $enddate_activity);
        }
        // for quering activity if it is done or not
        if ($request->done) {
            if ($request->done !== "any") {
                $queryData = $queryData->where('done', $request->done);
            }
        }
        // for querying activity
        if ($request->lead_id) {
            $queryData = $queryData->where('lead_id', $request->lead_id);
        }
        // for time sorting option of activity
        if ($request->activity_time_sort) {
            $a_time_sort = $request->activity_time_sort;
            if ($a_time_sort == "oldest") {
                $queryData = $queryData->orderBy('start_date', 'ASC');
            } elseif ($a_time_sort == "latest") {
                $queryData = $queryData->orderBy('start_date', 'DESC');
            }
        }

        if ($request->by) {
            if ($request->by == "me") {
                if ($request->user_type == 'admin') {
                    $queryData = $queryData->where('admin_id', $request->user_id);
                }
                if ($request->user_type == 'moderator') {
                    $queryData = $queryData->where('moderator_id', $request->user_id);
                }
            }
        }

        if ($request->type) {
            if ($request->type !== "any") {
                $queryData = $queryData->where('type', $request->type);
            }
        }

        if ($request->search) {
            $search = $request->search;
            $queryData = $queryData->where('name', 'like', "%$search%");
        }

        if ($request->view) {
            $view = $request->view;
        }

        if ($request->time_sort) {
            $time_sort = $request->time_sort;
            if ($time_sort == "oldest") {
                $queryData = $queryData->orderBy('created_at', 'ASC');
            } elseif ($time_sort == "latest") {
                $queryData = $queryData->orderBy('created_at', 'DESC');
            }
        } else {
            $queryData = $queryData->orderBy('created_at', 'DESC');
        }

        // for query filtering lead
        if ($request->progress_option) {
            if ($request->progress_option !== "any") {
                $queryData = $queryData->where('progress', $request->progress_option);
            }
        }
        // for query filtering lead
        if ($request->fil_contact_slug) {
            $contact = Contact::where('slug', $request->fil_contact_slug)->first();
            if ($contact) {
                $queryData = $queryData->where('contact_id', $contact->id);
            }
        }
        // for query filtering lead
        if ($request->fil_business_slug) {
            $business = Business::where('slug', $request->fil_business_slug)->first();
            if ($business) {
                $queryData = $queryData->where('business_id', $business->id);
            }
        }
        // for query filtering lead
        if ($request->fil_source_slug) {
            $source = Source::where('slug', $request->fil_source_slug)->first();
            if ($source) {
                $queryData = $queryData->where('source_id', $source->id);
            }
        }
        // for query filter contact
        if ($request->fil_org_slug) {
            $org = Org::where('slug', $request->fil_org_slug)->first();
            if ($org) {
                $queryData = $queryData->where('org_id', $org->id);
            }
        }
        // for query filter account search
        if ($request->search_value) {
            if ($request->search_type == "name") {
                $queryData = $queryData->where('name', 'like',  "%$request->search_value%");
            } else {
                $queryData = $queryData->where('email', 'like', "%$request->search_value%");
            }
        }

        $queryData = $queryData->paginate($view)->appends($request->query());

        return [
            "queryData" => $queryData
        ];
    }
}
