<?php

namespace App\Http\Controllers\AdminMod;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Email;
use App\Models\Org;
use App\Models\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Http\CustomQueryFunctions\QueryFunctions;

class ContactController extends Controller
{
    private $contacts;

    public function __construct()
    {
        $this->contacts = new QueryFunctions();
    }

    public function createContact()
    {
        $orgs = Org::select('id', 'name')->orderBy('name')->get();
        return view('admin-mod.contact.create-contact', compact('orgs'));
    }

    public function postCreateContact(Request $request)
    {
        $request->validate([
            "name" => "required|unique:contacts,name",
            "org_id" => "required",
            "phones.*.number" => "required|unique:phones,number",
            "emails.*.email" => "required|unique:emails,name",
            "image" => "required|image|max:5000",
        ], [
            "phones.*.number" => [
                "required" => "Please input all the phone numbers!",
                "unique" => "One of the phone numbers is already used by the another contact!",
            ],
            "emails.*.email" => [
                "required" => "Please input all the email address!",
                "unique" => "One of the emails is already used by the another contact!",
            ]
        ]);

        //move image
        $image = $request->file('image');
        $image_name = uniqid() . $image->getClientOriginalName();
        $image->move(public_path('/storage/images'), $image_name);

        // create contact
        $contact = Contact::create([
            "name" => $request->name,
            "slug" => Str::slug(uniqid() . $request->name),
            "image" => $image_name,
            "org_id" => $request->org_id,
        ]);

        if (!$contact) {
            return redirect('/contact/create')->with("error", "Something went wrong!");
        }

        //creating phone number
        foreach ($request->phones as $key => $value) {
            Phone::create([
                "number" => $value["number"],
                "contact_id" => $contact->id,
            ]);
        }

        //creating email
        foreach ($request->emails as $key => $value) {
            Email::create([
                "name" => $value["email"],
                "contact_id" => $contact->id,
            ]);
        }

        return redirect('/contact/view')->with("success", "Contact has been created!");
    }

    public function viewContact(Request $request)
    {
        $org_slug = "";
        if ($request->org_slug) {
            $org_slug = $request->org_slug;
        }
        return view('admin-mod.contact.view-contact', compact('org_slug'));
    }

    public function editContact($slug)
    {
        $contact = Contact::where('slug', $slug)->with('phone', 'email', 'org')->first();
        if (!$contact) {
            return redirect('/contact/view')->with("error", "Something went wrong!");
        }
        $orgs = Org::select('id', 'name')->orderBy('name')->get();
        return view('admin-mod.contact.edit-contact', compact('contact', 'orgs'));
    }

    public function postEditContact(Request $request)
    {
        $request->validate([
            "contact_slug" => "required",
        ]);
        $contact = Contact::where('slug', $request->contact_slug)->first();
        if (!$contact) {
            return redirect()->back()->with("error", "Something went wrong!");
        }
        $request->validate([
            "name" => "required|unique:contacts,name, $contact->id",
            "org_id" => "required",
            "phones.*.number" => "required",
            "emails.*.email" => "required",
            "image" => "image|max:5000",
        ], [
            "phones.*.number" => [
                "required" => "Please input all the phone numbers!",
            ],
            "emails.*.email" => [
                "required" => "Please input all the email address!",
            ]
        ]);

        // check if phone numbers are unique
        $phones = Phone::all();
        foreach ($phones as $p) {
            foreach ($request->phones as $rp) {
                if ($rp["number"] == $p->number && $p->contact_id !== $contact->id) {
                    return redirect()->back()->withErrors(["phones" => "One of the phone numbers is already used by the another contact!"]);
                }
            }
        }

        // check if email addresses are unique
        $emails = Email::all();
        foreach ($emails as $e) {
            foreach ($request->emails as $re) {
                if ($re["email"] == $e->name && $e->contact_id !== $contact->id) {
                    return redirect()->back()->withErrors(["emails" => "One of the email addresses is already used by the another contact!"]);
                }
            }
        }
        // After validation
        // if image exists inside the request
        $image_name = $contact->image;
        if ($request->image) {
            // delete the old image
            if (File::exists(public_path('/storage/images/' . $contact->image))) {
                File::delete(public_path('/storage/images/' . $contact->image));
            }
            // upload new image
            $image = $request->file('image');
            $image_name = uniqid() . $image->getClientOriginalName();
            $image->move(public_path('/storage/images'), $image_name);
        }

        // update the contact
        $contact->name = $request->name;
        $contact->slug = Str::slug(uniqid() . $request->name);
        $contact->image = $image_name;
        $contact->org_id = $request->org_id;
        $contact->save();

        // delete the old phones and emails
        Phone::where("contact_id", $contact->id)->delete();
        Email::where("contact_id", $contact->id)->delete();

        //creating new phone numbers
        foreach ($request->phones as $key => $value) {
            Phone::create([
                "number" => $value["number"],
                "contact_id" => $contact->id,
            ]);
        }

        //creating new email
        foreach ($request->emails as $key => $value) {
            Email::create([
                "name" => $value["email"],
                "contact_id" => $contact->id,
            ]);
        }

        return redirect('/contact/edit/' . $contact->slug)->with("success", "Contact has been updated!");
    }
}
