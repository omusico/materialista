<?php

namespace App;

class HomeLib
{
    public static function getAdminLvl2List($operation, $typology)
    {
        //todo: validation
        switch ($operation) {
            case 0: //buy
                switch ($typology) {
                    case 0: //new development
                        //todo: new development cross-table select
                        return [];
                        break;
                    case 1: //house or apartment
                        $list = \DB::table('sell_house')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        return $list;
                        break;
                    case 4: //office
                        $list = \DB::table('sell_office')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        return $list;
                        break;
                    case 5: //business
                        $list = \DB::table('sell_business')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        return $list;
                        break;
                    case 6: //garage
                        $list = \DB::table('sell_garage')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        return $list;
                        break;
                    case 7: //land
                        $list = \DB::table('sell_land')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        return $list;
                        break;
                }
                break;
            case 1: //rent
                switch ($typology) {
                    case 0: //new development
                        //todo: new development cross-table select
                        return [];
                        break;
                    case 1: //house or apartment
                        $list = \DB::table('rent_house')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        return $list;
                        break;
                    case 2: //vacation
                        $list = \DB::table('rent_vacation')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        return $list;
                        break;
                    case 3: //room
                        $list = \DB::table('rent_room')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        return $list;
                        break;
                    case 4: //office
                        $list = \DB::table('rent_office')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        return $list;
                        break;
                    case 5: //business
                        $list = \DB::table('rent_business')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        return $list;
                        break;
                    case 6: //garage
                        $list = \DB::table('rent_garage')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        return $list;
                        break;
                    case 7: //land
                        $list = \DB::table('rent_land')->select('admin_area_lvl2')
                            ->groupBy('admin_area_lvl2')
                            ->orderBy('admin_area_lvl2', 'ASC')
                            ->get();
                        return $list;
                        break;
                }
                break;
            default: //share, room
                $list = \DB::table('rent_room')->select('admin_area_lvl2')
                    ->groupBy('admin_area_lvl2')
                    ->orderBy('admin_area_lvl2', 'ASC')
                    ->get();
                return $list;
                break;
        }
    }

    public static function getLocalityList($operation, $typology, $adminLvl2)
    {
        //todo: validation
        switch ($operation) {
            case 0: //buy
                switch ($typology) {
                    case 0: //new development
                        //todo: new dev cross-table search
                        return [];
                        break;
                    case 1: //house or apartment
                        $list = \DB::table('sell_house')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        return $list;
                        break;
                    case 4: //office
                        $list = \DB::table('sell_office')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        return $list;
                        break;
                    case 5: //business
                        $list = \DB::table('sell_business')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        return $list;
                        break;
                    case 6: //garage
                        $list = \DB::table('sell_garage')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        return $list;
                        break;
                    case 7: //land
                        $list = \DB::table('sell_land')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        return $list;
                        break;
                }
                break;
            case 1: //rent
                switch ($typology) {
                    case 0: //new development
                        //todo: new dev cross-table search
                        return [];
                        break;
                    case 1: //house or apartment
                        $list = \DB::table('rent_house')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        return $list;
                        break;
                    case 2: //vacation
                        $list = \DB::table('rent_vacation')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        return $list;
                        break;
                    case 3: //room
                        $list = \DB::table('rent_room')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        return $list;
                        break;
                    case 4: //office
                        $list = \DB::table('rent_office')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        return $list;
                        break;
                    case 5: //business
                        $list = \DB::table('rent_business')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        return $list;
                        break;
                    case 6: //garage
                        $list = \DB::table('rent_garage')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        return $list;
                        break;
                    case 7: //land
                        $list = \DB::table('rent_land')->select('locality',\DB::raw('COUNT(*) as total'))
                            ->groupBy('locality')
                            ->orderBy('locality', 'ASC')
                            ->where('admin_area_lvl2',$adminLvl2)
                            ->get();
                        return $list;
                        break;
                }
                break;
            default: //share, room
                $list = \DB::table('rent_room')->select('locality',\DB::raw('COUNT(*) as total'))
                    ->groupBy('locality')
                    ->orderBy('locality', 'ASC')
                    ->where('admin_area_lvl2',$adminLvl2)
                    ->get();
                return $list;
                break;
        }
    }
}