<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getDataAttribute($value)
    {
        if($value) {
            $form = Form::find($this->form_id);
            $template = json_decode($form->template, true);
            $data = json_decode($value, true);
            $newData = [];

            foreach($template as $arr) {
                if(array_key_exists('name', $arr) && strpos($arr['name'], 'button') === false) {
                    $newData[] = [
                        'name' => $arr['name'],
                        'label' => $arr['label'],
                        'value' => $data[$arr['name']] ?? "N/A"
                    ];
                }
            }

            return $newData;
        }

        return [];
    }
}
