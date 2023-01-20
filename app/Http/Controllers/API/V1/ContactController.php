<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\ContactRequest;
use App\Http\Requests\API\V1\ContactsRequest;
use App\Http\Requests\API\V1\CreateContactRequest;
use App\Http\Requests\API\V1\DeleteContactRequest;
use App\Http\Requests\API\V1\UpdateContactRequest;
use App\Http\Resources\API\V1\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ContactController extends Controller
{
    public function index(ContactsRequest $request)
    {
        return ContactResource::collection(Contact::paginate());
    }

    public function show(ContactRequest $request, $id)
    {
        return new ContactResource(Contact::find($id));
    }

    public function store(CreateContactRequest $request)
    {
        return new ContactResource(Contact::create($request->validated()));
    }

    public function update(UpdateContactRequest $request, $id)
    {
        return new ContactResource(Contact::updateOrCreate([
            'id' => $request['contact'],
        ],
            $request->validated())
        );
    }

    public function destroy(DeleteContactRequest $request, $id)
    {
        Contact::destroy($id);
        return response()->json([
            'message' => 'success',
        ]);
    }
}
