<?php

namespace App;

class HomeLib
{
    public static function getAdminLvl2List($operation, $typology)
    {
        switch ($operation) {
            case 0: //buy
                switch ($typology) {
                    case 0: //new development
                        $list =  \DB::select(\DB::raw("
                            SELECT admin_area_lvl2 FROM (
                              SELECT admin_area_lvl2 FROM sell_house AS t1 WHERE t1.is_new_development = 1
                              UNION
                              SELECT admin_area_lvl2 FROM sell_country_house AS t2 WHERE t2.is_new_development = 1
                              UNION
                              SELECT admin_area_lvl2 FROM sell_apartment AS t3 WHERE t3.is_new_development = 1
                            ) AS t4
                            GROUP BY t4.admin_area_lvl2
                            ORDER BY t4.admin_area_lvl2 ASC;
                        "));
                        break;
                    case 1: //house, country house or apartment
                        $list =  \DB::select(\DB::raw("
                            SELECT admin_area_lvl2 FROM (
                              SELECT admin_area_lvl2 FROM sell_house AS t1
                              UNION
                              SELECT admin_area_lvl2 FROM sell_country_house AS t2
                              UNION
                              SELECT admin_area_lvl2 FROM sell_apartment AS t3
                            ) AS t4
                            GROUP BY t4.admin_area_lvl2
                            ORDER BY t4.admin_area_lvl2 ASC;
                        "));
                        break;
                    case 4: //office
                        $list = \DB::table('sell_office')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        break;
                    case 5: //business
                        $list = \DB::table('sell_business')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        break;
                    case 6: //garage
                        $list = \DB::table('sell_garage')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        break;
                    case 7: //land
                        $list = \DB::table('sell_land')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        break;
                    case 8: //country houses (fincas rústicas)
                        $list = \DB::table('sell_country_house')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        break;
                    case 9: //country houses with cattle project (fincas rústicas con proyecto ganadero)
                        $list = \DB::table('sell_country_house')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->where('has_cattle_project',true)
                            ->get();
                        break;
                }
                break;
            case 1: //rent
                switch ($typology) {
                    case 0: //new development
                        $list =  \DB::select(\DB::raw("
                            SELECT admin_area_lvl2 FROM (
                              SELECT admin_area_lvl2 FROM rent_house AS t1 WHERE t1.is_new_development = 1
                              UNION
                              SELECT admin_area_lvl2 FROM rent_country_house AS t2 WHERE t2.is_new_development = 1
                              UNION
                              SELECT admin_area_lvl2 FROM rent_apartment AS t3 WHERE t3.is_new_development = 1
                            ) AS t4
                            GROUP BY t4.admin_area_lvl2
                            ORDER BY t4.admin_area_lvl2 ASC;
                        "));
                        break;
                    case 1: //house, country house or apartment
                        $list =  \DB::select(\DB::raw("
                            SELECT admin_area_lvl2 FROM (
                              SELECT admin_area_lvl2 FROM rent_house AS t1
                              UNION
                              SELECT admin_area_lvl2 FROM rent_country_house AS t2
                              UNION
                              SELECT admin_area_lvl2 FROM rent_apartment AS t3
                            ) AS t4
                            GROUP BY t4.admin_area_lvl2
                            ORDER BY t4.admin_area_lvl2 ASC;
                        "));
                        break;
                    case 2: //vacation
                        $list = \DB::table('rent_vacation')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        break;
                    case 3: //room
                        $list = \DB::table('rent_room')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        break;
                    case 4: //office
                        $list = \DB::table('rent_office')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        break;
                    case 5: //business
                        $list = \DB::table('rent_business')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        break;
                    case 6: //garage
                        $list = \DB::table('rent_garage')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        break;
                    case 7: //land
                        $list = \DB::table('rent_land')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        break;
                    case 8: //country houses (fincas rústicas)
                        $list = \DB::table('rent_country_house')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        break;
                    case 9: //country houses with cattle project (fincas rústicas con proyecto ganadero)
                        $list = \DB::table('rent_country_house')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->where('has_cattle_project',true)
                            ->get();
                        break;
                }
                break;
            default: //share, room
                $list = \DB::table('rent_room')->select('admin_area_lvl2')
                    ->groupBy('admin_area_lvl2')
                    ->orderBy('admin_area_lvl2', 'ASC')
                    ->get();
                break;
        }
        if(isset($list))
            return $list;
        return [];
    }

    public static function getLocalityList($operation, $typology, $adminLvl2)
    {
        switch ($operation) {
            case 0: //buy
                switch ($typology) {
                    case 0: //new development
                        $list =  \DB::select(\DB::raw("
                            SELECT locality, COUNT(*) as total FROM (
                              SELECT locality FROM sell_house AS t1 WHERE t1.is_new_development = 1 AND t1.admin_area_lvl2 = ?
                              UNION ALL
                              SELECT locality FROM sell_country_house AS t2 WHERE t2.is_new_development = 1 AND t2.admin_area_lvl2 = ?
                              UNION ALL
                              SELECT locality FROM sell_apartment AS t3 WHERE t3.is_new_development = 1 AND t3.admin_area_lvl2 = ?
                            ) AS t4
                            GROUP BY t4.locality
                            ORDER BY t4.locality ASC;
                        "),[$adminLvl2,$adminLvl2,$adminLvl2]);
                        break;
                    case 1: //house, country house or apartment
                        $list =  \DB::select(\DB::raw("
                            SELECT locality, COUNT(*) as total FROM (
                              SELECT locality FROM sell_house AS t1 WHERE t1.admin_area_lvl2 = ?
                              UNION ALL
                              SELECT locality FROM sell_country_house AS t2 WHERE t2.admin_area_lvl2 = ?
                              UNION ALL
                              SELECT locality FROM sell_apartment AS t3 WHERE t3.admin_area_lvl2 = ?
                            ) AS t4
                            GROUP BY t4.locality
                            ORDER BY t4.locality ASC;
                        "),[$adminLvl2,$adminLvl2,$adminLvl2]);
                        break;
                    case 4: //office
                        $list = \DB::table('sell_office')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        break;
                    case 5: //business
                        $list = \DB::table('sell_business')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        break;
                    case 6: //garage
                        $list = \DB::table('sell_garage')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        break;
                    case 7: //land
                        $list = \DB::table('sell_land')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        break;
                    case 8: //country houses (fincas rústicas)
                        $list = \DB::table('sell_country_house')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        break;
                    case 9: //country houses with cattle project (fincas rústicas con proyecto ganadero)
                        $list = \DB::table('sell_country_house')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->where('has_cattle_project',true)
                            ->get();
                        break;
                }
                break;
            case 1: //rent
                switch ($typology) {
                    case 0: //new development
                        $list =  \DB::select(\DB::raw("
                            SELECT locality, COUNT(*) as total FROM (
                              SELECT locality FROM rent_house AS t1 WHERE t1.is_new_development = 1 AND t1.admin_area_lvl2 = ?
                              UNION ALL
                              SELECT locality FROM rent_country_house AS t2 WHERE t2.is_new_development = 1 AND t2.admin_area_lvl2 = ?
                              UNION ALL
                              SELECT locality FROM rent_apartment AS t3 WHERE t3.is_new_development = 1 AND t3.admin_area_lvl2 = ?
                            ) AS t4
                            GROUP BY t4.locality
                            ORDER BY t4.locality ASC;
                        "),[$adminLvl2,$adminLvl2,$adminLvl2]);
                        break;
                    case 1: //house or apartment
                        $list =  \DB::select(\DB::raw("
                            SELECT locality, COUNT(*) as total FROM (
                              SELECT locality FROM rent_house AS t1 WHERE t1.admin_area_lvl2 = ?
                              UNION ALL
                              SELECT locality FROM rent_country_house AS t2 WHERE t2.admin_area_lvl2 = ?
                              UNION ALL
                              SELECT locality FROM rent_apartment AS t3 WHERE t3.admin_area_lvl2 = ?
                            ) AS t4
                            GROUP BY t4.locality
                            ORDER BY t4.locality ASC;
                        "),[$adminLvl2,$adminLvl2,$adminLvl2]);
                        break;
                    case 2: //vacation
                        $list = \DB::table('rent_vacation')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        break;
                    case 3: //room
                        $list = \DB::table('rent_room')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        break;
                    case 4: //office
                        $list = \DB::table('rent_office')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        break;
                    case 5: //business
                        $list = \DB::table('rent_business')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        break;
                    case 6: //garage
                        $list = \DB::table('rent_garage')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        break;
                    case 7: //land
                        $list = \DB::table('rent_land')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        break;
                    case 8: //country houses (fincas rústicas)
                        $list = \DB::table('rent_country_house')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        break;
                    case 9: //country houses with cattle project (fincas rústicas con proyecto ganadero)
                        $list = \DB::table('rent_country_house')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->where('has_cattle_project',true)
                            ->get();
                        break;
                }
                break;
            default: //share, room
                $list = \DB::table('rent_room')->select('locality',\DB::raw('COUNT(*) as total'))
                    ->groupBy('locality')
                    ->orderBy('locality', 'ASC')
                    ->where('admin_area_lvl2',$adminLvl2)
                    ->get();
                break;
        }
        if(isset($list))
            return $list;
        return [];
    }
}