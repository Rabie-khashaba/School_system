<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Repository\StudentPromotionRepositoryInterface;
use Illuminate\Http\Request;

class PromotionsController extends Controller
{


    protected $Promotions;

    public function __construct(StudentPromotionRepositoryInterface $Promotions)
    {
        $this->Promotions = $Promotions;
    }

    public function index()
    {
        return $this->Promotions->index();
    }


    public function create()
    {
        return $this->Promotions->create();
    }


    public function store(Request $request)
    {
        return $this->Promotions->store($request);
    }


    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(Request $request)
    {
        return $this->Promotions->destroy($request);
    }
}
