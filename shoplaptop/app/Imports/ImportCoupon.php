<?php

namespace App\Imports;

use App\Models\Coupon;
use Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;


class ImportCoupon implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function headingRow() : int
    {
        return 1;
    }
    public function model(array $row)
    {
        return new Coupon([
            'coupon_name' => $row[0] ?? $row['coupon_name'],   
            'coupon_qty' => $row[1] ?? $row['coupon_qty'],   
            'coupon_number' => $row[2] ?? $row['coupon_number'],   
            'coupon_code' => $row[3] ?? $row['coupon_code'],   
            'coupon_condition' => $row[4] ?? $row['coupon_condition'],   
            'coupon_date_start' => $row[5] ?? $row['coupon_date_start'],   
            'coupon_date_end' => $row[6] ?? $row['coupon_date_end'],   
            'coupon_status' => $row[7] ?? $row['coupon_status'],   
        ]);
    }

    public function rules(): array
    {
        return [
            '*.coupon_name' => ['required'],
            '*.coupon_qty' => ['required', 'numeric'],
            '*.coupon_number' => ['required', 'numeric'],
            '*.coupon_code' => ['required', 'unique:coupon'],
            '*.coupon_condition' => ['required', 'numeric', 'min:0', 'max:1'],
            '*.coupon_date_start' => ['required', 'date_format:d/m/Y'],
            '*.coupon_date_end' => ['required', 'date_format:d/m/Y'],
            '*.coupon_status' => ['required', 'numeric', 'min:0', 'max:1'],
        ];
    }

    public function customValidationMessages()
    {
        if(Session::get('locale') == 'vi' || Session::get('locale') == null){
            return [
                '*.coupon_name.required' => 'Vui l??ng kh??ng ????? tr???ng !',

                '*.coupon_qty.required' => 'Vui l??ng kh??ng ????? tr???ng !',
                '*.coupon_qty.numeric' => 'Vui l??ng nh???p s???!',

                '*.coupon_number.required' => 'Vui l??ng kh??ng ????? tr???ng !',
                '*.coupon_number.numeric' => 'Vui l??ng nh???p s???!',

                '*.coupon_code.required' => 'Vui l??ng kh??ng ????? tr???ng !',
                '*.coupon_code.unique' => '???? ???????c s??? d???ng',

                '*.coupon_condition.required' => 'Vui l??ng kh??ng ????? tr???ng !',
                '*.coupon_condition.numeric' => 'Vui l??ng nh???p s???!',
                '*.coupon_condition.min' => 'Vui l??ng nh???p 0 (ph???n tr??m) ho???c 1 (ti???n)',
                '*.coupon_condition.max' => 'Vui l??ng nh???p 0 (ph???n tr??m) ho???c 1 (ti???n)',

                '*.coupon_date_start.required' => 'Vui l??ng kh??ng ????? tr???ng !',
                '*.coupon_date_start.date_format' => 'Kh??ng kh???p v???i ?????nh d???ng d/m/Y',

                '*.coupon_date_end.required' => 'Vui l??ng kh??ng ????? tr???ng!',
                '*.coupon_date_end.date_format' => 'Kh??ng kh???p v???i ?????nh d???ng d/m/Y',


                '*.coupon_status.required' => 'Vui l??ng kh??ng ????? tr???ng !',
                '*.coupon_status.numeric' => 'Vui l??ng nh???p s??? !',
                '*.coupon_status.min' => 'Vui l??ng nh???p 0 (Hi???n) ho???c 1 (???n)',
                '*.coupon_status.max' => 'Vui l??ng nh???p 0 (Hi???n) ho???c 1 (???n)',
            ];
        }else{
            return[];
        }
    }


}
