<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MessageDataTable;
use App\Http\Controllers\Controller;
use App\Models\Message;

class MessageController extends Controller
{
    //
    function __construct()
    {
        $this->middleware('permission:message|message-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:message-delete', ['only' => ['destroy']]);
    }

    public function index(MessageDataTable $roleDataTable)
    {
        return $roleDataTable->render('admin.messageIndex');
    }

    public function destroy($id)
    {
        Message::where('id', $id)->delete();
    }
}
