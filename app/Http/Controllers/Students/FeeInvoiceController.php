<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Fee_invoice;
use App\Repository\FeeInvoicesRepositoryInterface;
use Illuminate\Http\Request;

class FeeInvoiceController extends Controller
{
    protected $FeeInvoice;

    public function __construct(FeeInvoicesRepositoryInterface $FeeInvoice)
    {
        $this->FeeInvoice = $FeeInvoice;
    }

    public function index()
    {
        return $this->FeeInvoice->index();
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        return $this->FeeInvoice->store($request);
    }


    public function show($id)
    {
        return $this->FeeInvoice->show($id);
    }


    public function edit(string $id)
    {
        return $this->FeeInvoice->edit($id);
    }

    public function update(Request $request)
    {
        return $this->FeeInvoice->update($request);
    }

    public function destroy(Request $request)
    {
        return $this->FeeInvoice->destroy($request);
    }


}
