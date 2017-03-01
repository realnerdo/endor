<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'company' => 'Endor',
            'email' => 'endor@grupoendor.com',
            'phone' => '9999999999',
            'address' => '230 Int. local, C.P. 97116 C. 49 x 26 y 28 Num. Ext. Colonia San Antonio Cucul Mérida Yucatán, México',
            'bank_details' => 'Banco: BANORTE (Banco mercantil del norte, S.A.)
            Razón social: ADN DIFERENTE SA DE CV
            No. de cuenta: 0259308834
            CLABE: 072 910 00259308834 1
            RFC: ADI141027150'
        ]);
    }
}
