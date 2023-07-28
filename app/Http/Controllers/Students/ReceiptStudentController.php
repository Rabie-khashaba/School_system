<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Repository\ReceiptStudentsRepositoryInterface;
use Illuminate\Http\Request;

class ReceiptStudentController extends Controller
{

    protected $ReceiptStudent;

    public function __construct(ReceiptStudentsRepositoryInterface $ReceiptStudent)
    {
        $this->ReceiptStudent = $ReceiptStudent;
    }

    public function index()
    {
        return $this->ReceiptStudent->index();
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        return $this->ReceiptStudent->store($request);
    }


    public function show($id)
    {
        return $this->ReceiptStudent->show($id);
    }


    public function edit($id)
    {
        return $this->ReceiptStudent->edit($id);
    }


    public function update(Request $request)
    {
        return $this->ReceiptStudent->update($request);
    }


    public function destroy(Request $request)
    {
        return $this->ReceiptStudent->destroy($request);
    }
}
