<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 19,
                'title' => 'preventivo_create',
            ],
            [
                'id'    => 20,
                'title' => 'preventivo_edit',
            ],
            [
                'id'    => 21,
                'title' => 'preventivo_show',
            ],
            [
                'id'    => 22,
                'title' => 'preventivo_delete',
            ],
            [
                'id'    => 23,
                'title' => 'preventivo_access',
            ],
            [
                'id'    => 24,
                'title' => 'clienti_create',
            ],
            [
                'id'    => 25,
                'title' => 'clienti_edit',
            ],
            [
                'id'    => 26,
                'title' => 'clienti_show',
            ],
            [
                'id'    => 27,
                'title' => 'clienti_delete',
            ],
            [
                'id'    => 28,
                'title' => 'clienti_access',
            ],
            [
                'id'    => 29,
                'title' => 'anagrafica_parent_access',
            ],
            [
                'id'    => 30,
                'title' => 'fornitore_create',
            ],
            [
                'id'    => 31,
                'title' => 'fornitore_edit',
            ],
            [
                'id'    => 32,
                'title' => 'fornitore_show',
            ],
            [
                'id'    => 33,
                'title' => 'fornitore_delete',
            ],
            [
                'id'    => 34,
                'title' => 'fornitore_access',
            ],
            [
                'id'    => 35,
                'title' => 'settings_dinamici_create',
            ],
            [
                'id'    => 36,
                'title' => 'settings_dinamici_edit',
            ],
            [
                'id'    => 37,
                'title' => 'settings_dinamici_show',
            ],
            [
                'id'    => 38,
                'title' => 'settings_dinamici_delete',
            ],
            [
                'id'    => 39,
                'title' => 'settings_dinamici_access',
            ],
            [
                'id'    => 40,
                'title' => 'scadenziario_create',
            ],
            [
                'id'    => 41,
                'title' => 'scadenziario_edit',
            ],
            [
                'id'    => 42,
                'title' => 'scadenziario_show',
            ],
            [
                'id'    => 43,
                'title' => 'scadenziario_delete',
            ],
            [
                'id'    => 44,
                'title' => 'scadenziario_access',
            ],
            [
                'id'    => 45,
                'title' => 'servizi_general_access',
            ],
            [
                'id'    => 46,
                'title' => 'alloggio_hotel_create',
            ],
            [
                'id'    => 47,
                'title' => 'alloggio_hotel_edit',
            ],
            [
                'id'    => 48,
                'title' => 'alloggio_hotel_show',
            ],
            [
                'id'    => 49,
                'title' => 'alloggio_hotel_delete',
            ],
            [
                'id'    => 50,
                'title' => 'alloggio_hotel_access',
            ],
            [
                'id'    => 51,
                'title' => 'trasporto_create',
            ],
            [
                'id'    => 52,
                'title' => 'trasporto_edit',
            ],
            [
                'id'    => 53,
                'title' => 'trasporto_show',
            ],
            [
                'id'    => 54,
                'title' => 'trasporto_delete',
            ],
            [
                'id'    => 55,
                'title' => 'trasporto_access',
            ],
            [
                'id'    => 56,
                'title' => 'servizio_extra_create',
            ],
            [
                'id'    => 57,
                'title' => 'servizio_extra_edit',
            ],
            [
                'id'    => 58,
                'title' => 'servizio_extra_show',
            ],
            [
                'id'    => 59,
                'title' => 'servizio_extra_delete',
            ],
            [
                'id'    => 60,
                'title' => 'servizio_extra_access',
            ],
            [
                'id'    => 61,
                'title' => 'voce_p_hotel_per_persona_create',
            ],
            [
                'id'    => 62,
                'title' => 'voce_p_hotel_per_persona_edit',
            ],
            [
                'id'    => 63,
                'title' => 'voce_p_hotel_per_persona_show',
            ],
            [
                'id'    => 64,
                'title' => 'voce_p_hotel_per_persona_delete',
            ],
            [
                'id'    => 65,
                'title' => 'voce_p_hotel_per_persona_access',
            ],
            [
                'id'    => 66,
                'title' => 'voce_p_hotel_per_notte_create',
            ],
            [
                'id'    => 67,
                'title' => 'voce_p_hotel_per_notte_edit',
            ],
            [
                'id'    => 68,
                'title' => 'voce_p_hotel_per_notte_show',
            ],
            [
                'id'    => 69,
                'title' => 'voce_p_hotel_per_notte_delete',
            ],
            [
                'id'    => 70,
                'title' => 'voce_p_hotel_per_notte_access',
            ],
            [
                'id'    => 71,
                'title' => 'voce_p_hotel_create',
            ],
            [
                'id'    => 72,
                'title' => 'voce_p_hotel_edit',
            ],
            [
                'id'    => 73,
                'title' => 'voce_p_hotel_show',
            ],
            [
                'id'    => 74,
                'title' => 'voce_p_hotel_delete',
            ],
            [
                'id'    => 75,
                'title' => 'voce_p_hotel_access',
            ],
            [
                'id'    => 76,
                'title' => 'voce_p_extra_per_persona_create',
            ],
            [
                'id'    => 77,
                'title' => 'voce_p_extra_per_persona_edit',
            ],
            [
                'id'    => 78,
                'title' => 'voce_p_extra_per_persona_show',
            ],
            [
                'id'    => 79,
                'title' => 'voce_p_extra_per_persona_delete',
            ],
            [
                'id'    => 80,
                'title' => 'voce_p_extra_per_persona_access',
            ],
            [
                'id'    => 81,
                'title' => 'voce_p_extra_una_tantum_create',
            ],
            [
                'id'    => 82,
                'title' => 'voce_p_extra_una_tantum_edit',
            ],
            [
                'id'    => 83,
                'title' => 'voce_p_extra_una_tantum_show',
            ],
            [
                'id'    => 84,
                'title' => 'voce_p_extra_una_tantum_delete',
            ],
            [
                'id'    => 85,
                'title' => 'voce_p_extra_una_tantum_access',
            ],
            [
                'id'    => 86,
                'title' => 'voce_p_trasporto_per_persona_create',
            ],
            [
                'id'    => 87,
                'title' => 'voce_p_trasporto_per_persona_edit',
            ],
            [
                'id'    => 88,
                'title' => 'voce_p_trasporto_per_persona_show',
            ],
            [
                'id'    => 89,
                'title' => 'voce_p_trasporto_per_persona_delete',
            ],
            [
                'id'    => 90,
                'title' => 'voce_p_trasporto_per_persona_access',
            ],
            [
                'id'    => 91,
                'title' => 'itinerari_create',
            ],
            [
                'id'    => 92,
                'title' => 'itinerari_edit',
            ],
            [
                'id'    => 93,
                'title' => 'itinerari_show',
            ],
            [
                'id'    => 94,
                'title' => 'itinerari_delete',
            ],
            [
                'id'    => 95,
                'title' => 'itinerari_access',
            ],
            [
                'id'    => 96,
                'title' => 'voce_p_trasporto_una_tantum_create',
            ],
            [
                'id'    => 97,
                'title' => 'voce_p_trasporto_una_tantum_edit',
            ],
            [
                'id'    => 98,
                'title' => 'voce_p_trasporto_una_tantum_show',
            ],
            [
                'id'    => 99,
                'title' => 'voce_p_trasporto_una_tantum_delete',
            ],
            [
                'id'    => 100,
                'title' => 'voce_p_trasporto_una_tantum_access',
            ],
            [
                'id'    => 101,
                'title' => 'email_standard_create',
            ],
            [
                'id'    => 102,
                'title' => 'email_standard_edit',
            ],
            [
                'id'    => 103,
                'title' => 'email_standard_show',
            ],
            [
                'id'    => 104,
                'title' => 'email_standard_delete',
            ],
            [
                'id'    => 105,
                'title' => 'email_standard_access',
            ],
            [
                'id'    => 106,
                'title' => 'aziende_trasporti_create',
            ],
            [
                'id'    => 107,
                'title' => 'aziende_trasporti_edit',
            ],
            [
                'id'    => 108,
                'title' => 'aziende_trasporti_show',
            ],
            [
                'id'    => 109,
                'title' => 'aziende_trasporti_delete',
            ],
            [
                'id'    => 110,
                'title' => 'aziende_trasporti_access',
            ],
            [
                'id'    => 111,
                'title' => 'profile_password_edit',
            ],
            [
                'id'    => 112,
                'title' => 'report_preventivi_per_data',
            ],
        ];

        Permission::insert($permissions);
    }
}
