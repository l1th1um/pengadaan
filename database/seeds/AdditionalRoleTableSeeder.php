<?php

use Illuminate\Database\Seeder;
use qilara\Models\AdditionalRole;

class AdditionalRoleTableSeeder extends Seeder
{

    public function run()
    {

        AdditionalRole::create(array(
            'name'     => 'ppk_tata_kelola',
            'display_name' => 'Pejabat Pembuat Komitmen Tata Kelola',
            'description'    => 'Pejabat Pembuat Komitmen Tata Kelola',
            'parent' => 1
        ));

        AdditionalRole::create(array(
            'name'     => 'ppk_keg_mandiri',
            'display_name' => 'Pejabat Pembuat Komitmen Kegiatan Mandiri',
            'description'    => 'Pejabat Pembuat Komitmen Kegiatan Mandiri',
            'parent' => 1
        ));

        AdditionalRole::create(array(
            'name'     => 'koord_kelti_metrologi',
            'display_name' => 'Koordinator Keltian Metrology in Chemistry',
            'description'    => 'Koordinator Keltian Metrology in Chemistry',
            'parent' => 2
        ));

        AdditionalRole::create(array(
            'name'     => 'koord_kelti_farmasi',
            'display_name' => 'Koordinator Keltian Natural Product and Pharmaceutical Chemistry',
            'description'    => 'Koordinator Keltian Natural Product and Pharmaceutical Chemistry',
            'parent' => 2
        ));

        AdditionalRole::create(array(
            'name'     => 'koord_kelti_katalis',
            'display_name' => 'Koordinator Keltian Technology Process and Catalysis',
            'description'    => 'Koordinator Keltian Technology Process and Catalysis',
            'parent' => 2
        ));

        AdditionalRole::create(array(
            'name'     => 'koord_kelti_polimer',
            'display_name' => 'Koordinator Keltian Polymer Chemistry',
            'description'    => 'Koordinator Keltian Polymer Chemistry',
            'parent' => 2
        ));

        AdditionalRole::create(array(
            'name'     => 'koord_kelti_pangan',
            'display_name' => 'Koordinator Keltian Food Chemistry',
            'description'    => 'Koordinator Keltian Food Chemistry',
            'parent' => 2
        ));

        AdditionalRole::create(array(
            'name'     => 'koord_kelti_analitik',
            'display_name' => 'Koordinator Keltian Computational and Analytical Chemistry',
            'description'    => 'Koordinator Keltian Computational and Analytical Chemistry',
            'parent' => 2
        ));

        AdditionalRole::create(array(
            'name'     => 'koord_kelti_limbah',
            'display_name' => 'Koordinator Keltian Waste Treatment',
            'description'    => 'Koordinator Keltian Waste Treatment',
            'parent' => 2
        ));

        AdditionalRole::create(array(
            'name'     => 'koord_kelti_biomassa',
            'display_name' => 'Koordinator Keltian Biomass and Environmental Chemistry',
            'description'    => 'Koordinator Keltian Biomass and Environmental Chemistry',
            'parent' => 2
        ));

        AdditionalRole::create(array(
            'name'     => 'koord_kelti_bersih',
            'display_name' => 'Koordinator Keltian Cleaner Production',
            'description'    => 'Koordinator Keltian Cleaner Production',
            'parent' => 2
        ));
    }

}