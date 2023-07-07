<?php

namespace App\Http\Livewire;

use App\Models\MyParent;
use App\Models\Nationalitie;
use App\Models\ParentAttachment;
use App\Models\Religion;
use App\Models\Type_bloods;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

use Livewire\WithFileUploads;

class AddParent extends Component
{
    use WithFileUploads;

    public $successMessage = '';

    public $catchError,$updateMode = false,$photos,$show_table = true,$Parent_id;
    public $currentStep = 1,

        // Father_INPUTS

        $Email, $Password,
        $Name_Father, $Name_Father_en,
        $National_ID_Father, $Passport_ID_Father,
        $Phone_Father, $Job_Father, $Job_Father_en,
        $Nationality_Father_id, $Blood_Type_Father_id,
        $Address_Father, $Religion_Father_id,

        // Mother_INPUTS
        $Name_Mother, $Name_Mother_en,
        $National_ID_Mother, $Passport_ID_Mother,
        $Phone_Mother, $Job_Mother, $Job_Mother_en,
        $Nationality_Mother_id, $Blood_Type_Mother_id,
        $Address_Mother, $Religion_Mother_id;




    //validation
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'Email' => 'required|email',
            'National_ID_Father' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
            'Passport_ID_Father' => 'min:10|max:10',
            'Phone_Father' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'National_ID_Mother' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
            'Passport_ID_Mother' => 'min:10|max:10',
            'Phone_Mother' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
        ]);
    }

    public function render()
    {
        return view('livewire.add-parent',[
            'Nationalities'=>Nationalitie::all(),
            'Type_Bloods'=>Type_bloods::all(),
            'Religions'=>Religion::all(),

            'my_parents' => MyParent::all(),
        ]);
    }


    //firstStepSubmit
    public function firstStepSubmit(){

        // before move to next slide validate this fields
        $this->validate([
            'Email' => 'required|unique:my_parents,Email,'.$this->id,
            'Password' => 'required',
            'Name_Father' => 'required',
            'Name_Father_en' => 'required',
            'Job_Father' => 'required',
            'Job_Father_en' => 'required',
            'National_ID_Father' => 'required|unique:my_parents,National_ID_Father,' . $this->id,
            'Passport_ID_Father' => 'required|unique:my_parents,Passport_ID_Father,' . $this->id,
            'Phone_Father' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'Nationality_Father_id' => 'required',
            'Blood_Type_Father_id' => 'required',
            'Religion_Father_id' => 'required',
            'Address_Father' => 'required',
        ]);
        $this->currentStep = 2;
    }

    //secondStepSubmit
    public function secondStepSubmit(){
        $this->validate([
            'Name_Mother' => 'required',
            'Name_Mother_en' => 'required',
            'National_ID_Mother' => 'required|unique:my_parents,National_ID_Mother,' . $this->id,
            'Passport_ID_Mother' => 'required|unique:my_parents,Passport_ID_Mother,' . $this->id,
            'Phone_Mother' => 'required',
            'Job_Mother' => 'required',
            'Job_Mother_en' => 'required',
            'Nationality_Mother_id' => 'required',
            'Blood_Type_Mother_id' => 'required',
            'Religion_Mother_id' => 'required',
            'Address_Mother' => 'required',
        ]);

        $this->currentStep = 3;
    }

    public function submitForm(){

        try {
            $My_Parent = new MyParent();
            // Father_INPUTS
            $My_Parent->Email = $this->Email;
            $My_Parent->Password = Hash::make($this->Password);
            $My_Parent->Name_Father = ['en' => $this->Name_Father_en, 'ar' => $this->Name_Father];
            $My_Parent->National_ID_Father = $this->National_ID_Father;
            $My_Parent->Passport_ID_Father = $this->Passport_ID_Father;
            $My_Parent->Phone_Father = $this->Phone_Father;
            $My_Parent->Job_Father = ['en' => $this->Job_Father_en, 'ar' => $this->Job_Father];
            $My_Parent->Passport_ID_Father = $this->Passport_ID_Father;
            $My_Parent->Nationality_Father_id = $this->Nationality_Father_id;
            $My_Parent->Blood_Type_Father_id = $this->Blood_Type_Father_id;
            $My_Parent->Religion_Father_id = $this->Religion_Father_id;
            $My_Parent->Address_Father = $this->Address_Father;

            // Mother_INPUTS
            $My_Parent->Name_Mother = ['en' => $this->Name_Mother_en, 'ar' => $this->Name_Mother];
            $My_Parent->National_ID_Mother = $this->National_ID_Mother;
            $My_Parent->Passport_ID_Mother = $this->Passport_ID_Mother;
            $My_Parent->Phone_Mother = $this->Phone_Mother;
            $My_Parent->Job_Mother = ['en' => $this->Job_Mother_en, 'ar' => $this->Job_Mother];
            $My_Parent->Passport_ID_Mother = $this->Passport_ID_Mother;
            $My_Parent->Nationality_Mother_id = $this->Nationality_Mother_id;
            $My_Parent->Blood_Type_Mother_id = $this->Blood_Type_Mother_id;
            $My_Parent->Religion_Mother_id = $this->Religion_Mother_id;
            $My_Parent->Address_Mother = $this->Address_Mother;

            $My_Parent->save();

            if (!empty($this->photos)){
                foreach ($this->photos as $photo) {
                    //save photo on server
                    $photo->storeAs($this->National_ID_Father, $photo->getClientOriginalName(), $disk = 'parent_attachments');
                    //save photo on database
                    ParentAttachment::create([
                        'file_name' => $photo->getClientOriginalName(),
                        'parent_id' => MyParent::latest()->first()->id,   // get last id from MyParent
                    ]);
                }
            }

           //$this->successMessage = trans('messages.success');
           $this->clearForm();
           $this->currentStep = 1;
            $notification = array(
                'message' => 'Data Saved successfully',
                'alert-type'=> 'success',
            );
            return redirect()->to('/Add_parent')->with($notification);
        }

        catch (\Exception $e) {
            $this->catchError = $e->getMessage();
        };
    }


    //clearForm
    public function clearForm()
    {
        $this->Email = '';
        $this->Password = '';
        $this->Name_Father = '';
        $this->Job_Father = '';
        $this->Job_Father_en = '';
        $this->Name_Father_en = '';
        $this->National_ID_Father ='';
        $this->Passport_ID_Father = '';
        $this->Phone_Father = '';
        $this->Nationality_Father_id = '';
        $this->Blood_Type_Father_id = '';
        $this->Address_Father ='';
        $this->Religion_Father_id ='';

        $this->Name_Mother = '';
        $this->Job_Mother = '';
        $this->Job_Mother_en = '';
        $this->Name_Mother_en = '';
        $this->National_ID_Mother ='';
        $this->Passport_ID_Mother = '';
        $this->Phone_Mother = '';
        $this->Nationality_Mother_id = '';
        $this->Blood_Type_Mother_id = '';
        $this->Address_Mother ='';
        $this->Religion_Mother_id ='';

    }

    //show form add
    public function showformadd(){
        $this->show_table=false;
    }


    //edit
    public function edit($id)
    {
        $this->show_table = false;  // table list
        $this->updateMode = true;   // edit buttons
        $My_Parent = MyParent::where('id',$id)->first();
        $this->Parent_id = $id;
        $this->Email = $My_Parent->Email;
        $this->Password = $My_Parent->Password;
        $this->Name_Father = $My_Parent->getTranslation('Name_Father', 'ar');
        $this->Name_Father_en = $My_Parent->getTranslation('Name_Father', 'en');
        $this->Job_Father = $My_Parent->getTranslation('Job_Father', 'ar');;
        $this->Job_Father_en = $My_Parent->getTranslation('Job_Father', 'en');
        $this->National_ID_Father =$My_Parent->National_ID_Father;
        $this->Passport_ID_Father = $My_Parent->Passport_ID_Father;
        $this->Phone_Father = $My_Parent->Phone_Father;
        $this->Nationality_Father_id = $My_Parent->Nationality_Father_id;
        $this->Blood_Type_Father_id = $My_Parent->Blood_Type_Father_id;
        $this->Address_Father =$My_Parent->Address_Father;
        $this->Religion_Father_id =$My_Parent->Religion_Father_id;

        $this->Name_Mother = $My_Parent->getTranslation('Name_Mother', 'ar');
        $this->Name_Mother_en = $My_Parent->getTranslation('Name_Father', 'en');
        $this->Job_Mother = $My_Parent->getTranslation('Job_Mother', 'ar');;
        $this->Job_Mother_en = $My_Parent->getTranslation('Job_Mother', 'en');
        $this->National_ID_Mother =$My_Parent->National_ID_Mother;
        $this->Passport_ID_Mother = $My_Parent->Passport_ID_Mother;
        $this->Phone_Mother = $My_Parent->Phone_Mother;
        $this->Nationality_Mother_id = $My_Parent->Nationality_Mother_id;
        $this->Blood_Type_Mother_id = $My_Parent->Blood_Type_Mother_id;
        $this->Address_Mother =$My_Parent->Address_Mother;
        $this->Religion_Mother_id =$My_Parent->Religion_Mother_id;


    }


    //firstStepSubmit edit
    public function firstStepSubmit_edit()
    {
        $this->updateMode = true;
        $this->currentStep = 2;

    }

    //secondStepSubmit_edit
    public function secondStepSubmit_edit()
    {
        $this->updateMode = true;
        $this->currentStep = 3;

    }


    // submit form edit

    public function submitForm_edit(){

        if ($this->Parent_id){
            $parent = MyParent::find($this->Parent_id);
            $parent->update([

            'Email' => $this->Email,
            'Password' => Hash::make($this->Password),
            'Name_Father' => ['en' => $this->Name_Father_en, 'ar' => $this->Name_Father],
            'National_ID_Father' => $this->National_ID_Father,
            'Passport_ID_Father' => $this->Passport_ID_Father,
            'Phone_Father' => $this->Phone_Father,
            'Job_Father' => ['en' => $this->Job_Father_en, 'ar' => $this->Job_Father],
            'Passport_ID_Father' => $this->Passport_ID_Father,
            'Nationality_Father_id' => $this->Nationality_Father_id,
            'Blood_Type_Father_id' => $this->Blood_Type_Father_id,
            'Religion_Father_id' => $this->Religion_Father_id,
            'Address_Father' => $this->Address_Father,

            // Mother_INPUTS
            'Name_Mother' => ['en' => $this->Name_Mother_en, 'ar' => $this->Name_Mother],
            'National_ID_Mother' => $this->National_ID_Mother,
            'Passport_ID_Mother' => $this->Passport_ID_Mother,
            'Phone_Mother' => $this->Phone_Mother,
            'Job_Mother' => ['en' => $this->Job_Mother_en, 'ar' => $this->Job_Mother],
            'Passport_ID_Mother' => $this->Passport_ID_Mother,
            'Nationality_Mother_id' => $this->Nationality_Mother_id,
            'Blood_Type_Mother_id' => $this->Blood_Type_Mother_id,
            'Religion_Mother_id' => $this->Religion_Mother_id,
            'Address_Mother' => $this->Address_Mother,

            ]);

        }
        $notification = array(
            'message' => 'Updated successfully',
            'alert-type'=> 'success',
        );
        return redirect()->to('/Add_parent')->with($notification);
    }

    //delete
    public function delete($id){

        // get parent_id  in array and get numbers
        $parentattachments =ParentAttachment::where('parent_id' , $id)->pluck('parent_id');

        if($parentattachments->count()==0){
            MyParent::findOrFail($id)->delete();   // delete main only
            $notification = array(
                'message' => 'Main Parent Deleted successfully ,Have not Attachment',
                'alert-type'=> 'error',
            );
            return redirect()->to('/Add_parent')->with($notification);
        }else{
            // if has count > 0 , delete main and attachment
            MyParent::findOrFail($id)->delete();
            ParentAttachment::where('parent_id' , $id)->delete();
            $notification = array(
                'message' => 'Main Parent And Attachment Deleted successfully',
                'alert-type'=> 'error',
            );
            return redirect()->to('/Add_parent')->with($notification);
        }



    }



    //back
    public function back($step){
        $this->currentStep = $step;
    }







}
