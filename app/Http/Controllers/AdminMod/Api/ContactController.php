<?php

namespace App\Http\Controllers\AdminMod\Api;

use App\Http\Controllers\Controller;
use App\Http\CustomQueryFunctions\QueryFunctions;
use App\Models\Contact;
use App\Models\Email;
use App\Models\Phone;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ContactController extends Controller
{
    private $queryFunctions;

    public function __construct()
    {
        $this->queryFunctions = new QueryFunctions();
    }

    public function getContact(Request $request)
    {
        $paginatedData = $this->queryFunctions->filterPaginate($request, "contact");

        if (!$paginatedData) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => "Unable to get data",
            ]);
        }

        $contacts = $paginatedData["queryData"];

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => [
                "contacts" => $contacts,
            ],
        ]);
    }

    public function deleteContact(Request $request)
    {
        $v = Validator::make($request->all(), [
            "contact_slug" => "required",
        ]);

        if ($v->fails()) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => $v->errors(),
            ]);
        }

        $contact = Contact::where("slug", $request->contact_slug)->first();

        if (!$contact) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => "Contact not found!",
            ]);
        }

        // delete contact image
        if (File::exists(public_path('/storage/images/' . $contact->image))) {
            File::delete(public_path('/storage/images/' . $contact->image));
        }
        // delete associated phones and emails
        Phone::where("contact_id", $contact->id)->delete();
        Email::where("contact_id", $contact->id)->delete();
        $contact_name = $contact->name;
        $contact->delete();

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => "$contact_name has been deleted!",
        ]);
    }

    public function deleteContactMultiple(Request $request)
    {
        $v = Validator::make($request->all(), [
            "contact_slugs" => "required",
        ]);

        if ($v->fails()) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => $v->errors(),
            ]);
        }

        $contact_slugs = json_decode($request->contact_slugs);

        foreach ($contact_slugs as $slug) {
            $contact = Contact::where("slug", $slug)->first();
            if (!$contact) {
                return response()->json([
                    "success" => false,
                    "status" => 500,
                    "data" => "Contact not found!",
                ]);
            }
            // delete contact image
            if (File::exists(public_path('/storage/images/' . $contact->image))) {
                File::delete(public_path('/storage/images/' . $contact->image));
            }
            // delete associated phones and emails
            Phone::where("contact_id", $contact->id)->delete();
            Email::where("contact_id", $contact->id)->delete();
            $contact->delete();
        }
        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => "The selected contacts has been deleted!",
        ]);
    }
}
