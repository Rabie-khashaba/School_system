<?php

namespace App\Repository;

use App\Models\Gender;
use App\Models\Grade;
use App\Models\MyParent;
use App\Models\Nationalitie;
use App\Models\Type_bloods;

class StudentRepository implements StudentRepositoryInterface{

    public function createStudent(){
        $data['my_classes'] = Grade::all();
        $data['parents'] = MyParent::all();
        $data['Genders'] = Gender::all();
        $data['nationals'] = Nationalitie::all();
        $data['bloods'] = Type_bloods::all();
        return view('pages.Students.add',$data);
    }
}
