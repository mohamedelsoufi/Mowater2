<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class OrgContactController extends Controller
{
    private $contacts;

    public function __construct(Contact $contacts)
    {
        $this->middleware(['HasOrgContact:read'])->only(['index', 'show']);
        $this->middleware(['HasOrgContact:update'])->only('edit');

        $this->contacts = $contacts;
    }

    public function index()
    {
        try {
            $record = getModelData();
            $contacts = $record->contact;
            if(isset($contacts)){
                return view('organization.contacts.index', compact('record', 'contacts'));
            }
            $contact = '';
            return view('organization.contacts.edit', compact('record','contact'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit()
    {
        try {
            $record = getModelData();
            $contact = $record->contact;
            if(isset($contact)){
                return view('organization.contacts.edit', compact('record', 'contact'));
            }
            $contact = '';
            return view('organization.contacts.edit', compact('record','contact'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function update(ContactRequest $request)
    {
        try {
            $record = getModelData();
            $contact = $record->contact;

            if ($contact) {
                $contact->update($request->all());
            } else {
                $record->contact()->create($request->all());
            }

            return redirect()->back()->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

}
