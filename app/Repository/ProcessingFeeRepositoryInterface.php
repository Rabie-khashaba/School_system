<?php

namespace App\Repository;

interface ProcessingFeeRepositoryInterface
{
    public function index();
    public function store($request);
    public function show($id);
    public function edit($id);
    public function update( $request);
    public function destroy($request);

}
