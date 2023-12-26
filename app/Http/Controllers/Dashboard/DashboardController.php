<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Survey\Survey;
use App\Models\Survey\Type;
use App\Models\User\User;
use App\Models\Regulator\Regulator;
use Illuminate\Http\Response;
use Carbon\Carbon;
use PhpParser\Node\Stmt\Else_;
use Tymon\JWTAuth\Facades\JWTAuth;
class DashboardController extends Controller
{
    public function getInfo()
    {
        $user         = JWTAuth::parseToken()->authenticate();
        $barSurveyType = [];

        if($user->type_id == 1){
            $today = Carbon::today();
            $totalServiceProviderToday = Survey::
            whereDate('created_at', $today)
            ->count();
            $totalServiceProvider = Survey::whereMonth('created_at', Carbon::now()->month)
            ->count();
            $barSurveyType = [
                'normal'            => Survey::whereDate('created_at', $today)->where('type_id', 1)->count(),
                'satisfied'         => Survey::whereDate('created_at', $today)->where('type_id', 2)->count(),
                'very_satisfied'    => Survey::whereDate('created_at', $today)->where('type_id', 3)->count(),
                'dissatisfied'      => Survey::whereDate('created_at', $today)->where('type_id', 4)->count(),
                'very_dissatisfied' => Survey::whereDate('created_at', $today)->where('type_id', 5)->count(),
            ];
        }else{
            
            $today = Carbon::today();
            $totalServiceProviderToday = Survey::where('regulator_id', $user->id)
            ->whereDate('created_at', $today)
            ->count();
            $totalServiceProvider = Survey::whereMonth('created_at', Carbon::now()->month)
            ->count();
            $barSurveyType = [
                'normal'            => Survey::whereDate('created_at', $today)->where(['type_id' => 1, 'regulator_id' => $user->id])->count(),
                'satisfied'         => Survey::whereDate('created_at', $today)->where(['type_id' => 2, 'regulator_id' => $user->id])->count(),
                'very_satisfied'    => Survey::whereDate('created_at', $today)->where(['type_id' => 3, 'regulator_id' => $user->id])->count(),
                'dissatisfied'      => Survey::whereDate('created_at', $today)->where(['type_id' => 4, 'regulator_id' => $user->id])->count(),
                'very_dissatisfied' => Survey::whereDate('created_at', $today)->where(['type_id' => 5, 'regulator_id' => $user->id])->count(),
            ];
        }
        
        $data = [
            'bar_survey_type'               => $barSurveyType,
            'total_service_provider_today'  => $totalServiceProviderToday,
            'total_service_provider'        => $totalServiceProvider,
            'regulator'                     => Regulator::where('is_active', 1)->count(),
            'survey_type'                   => Type::count()
        ];
        return response()->json($data, Response::HTTP_OK); 
    }

    public function getDataChart(){

        $user         = JWTAuth::parseToken()->authenticate();

        if($user->type_id == 1){
            $today              = Carbon::today();
            $very_satisfied     = Survey::whereDate('created_at', $today)->where('type_id', 1)->count();
            $satisfied          = Survey::whereDate('created_at', $today)->where('type_id', 2)->count();
            $normal             = Survey::whereDate('created_at', $today)->where('type_id', 3)->count();
            $dissatisfied       = Survey::whereDate('created_at', $today)->where('type_id', 4)->count();
            $very_dissatisfied  = Survey::whereDate('created_at', $today)->where('type_id', 5)->count();
            
            $series = [$very_satisfied, $satisfied, $normal, $dissatisfied, $very_dissatisfied];
        }else{
            $today = Carbon::today();
            $very_satisfied     = Survey::whereDate('created_at', $today)->where(['type_id' => 1, 'regulator_id' => $user->id])->count();
            $satisfied          = Survey::whereDate('created_at', $today)->where(['type_id' => 2, 'regulator_id' => $user->id])->count();
            $normal             = Survey::whereDate('created_at', $today)->where(['type_id' => 3, 'regulator_id' => $user->id])->count();
            $dissatisfied       = Survey::whereDate('created_at', $today)->where(['type_id' => 4, 'regulator_id' => $user->id])->count();
            $very_dissatisfied  = Survey::whereDate('created_at', $today)->where(['type_id' => 5, 'regulator_id' => $user->id])->count();
            $series = [$very_satisfied, $satisfied, $normal, $dissatisfied, $very_dissatisfied];
            // $series = [
            //     'normal'            => Survey::whereDate('created_at', $today)->where(['type_id' => 1, 'regulator_id' => $user->id])->count(),
            //     'satisfied'         => Survey::whereDate('created_at', $today)->where(['type_id' => 2, 'regulator_id' => $user->id])->count(),
            //     'very_satisfied'    => Survey::whereDate('created_at', $today)->where(['type_id' => 3, 'regulator_id' => $user->id])->count(),
            //     'dissatisfied'      => Survey::whereDate('created_at', $today)->where(['type_id' => 4, 'regulator_id' => $user->id])->count(),
            //     'very_dissatisfied' => Survey::whereDate('created_at', $today)->where(['type_id' => 5, 'regulator_id' => $user->id])->count(),
            // ];
        }

        // $survey_type = Type::get();
        $data = [
            "series" => [
                    "name" => "Inflation",
                    "data" => $series
            ],
            "plotOptions" => [
                "bar" => [
                  "distributed" => true,
                ]
            ],
            "legend"=> [
                "show" => false
            ],
            "states" => [
                "hover"=> [
                    "filter"=> [
                        "type"=> 'none'
                    ]
                ],
                "active"=> [
                    "filter"=> [
                        "type"=> 'none'
                    ]
                ]
            ],
            "chart"=> [
                "height"=> 280,
                "type"=> "bar"
            ],
            "tooltip"=> [
                "enabled"=> true,
                "fillSeriesColor"=> false,
                "theme"=> 'dark',
            ],
            "xaxis"=> [
                "categories"=> ["ពេញចិត្តខ្លាំង", "ពេញចិត្ត", "ធម្មតា", "មិនពេញចិត្ត", "មិនពេញចិត្តខ្លាំង"]
                
            ],
        ];
        return response()->json($data, Response::HTTP_OK); 
    }
}