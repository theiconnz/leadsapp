<?php

namespace App\Http\Controllers;

use App\Contracts\ErrorLeadResponse;
use App\Contracts\SuccessLeadResponse;
use App\Models\EmailsModel;
use App\Models\LeadsEncryptionModel;
use App\Models\LeadsModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Mockery\Exception;
use Monarobase\CountryList\CountryListFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

Class LeadsController extends Controller
{
    /**
     * Get Countires key value
     *
     * @return array
     */
    public function getCountriesKeyValue() : array
    {
        return CountryListFacade::getList('en', 'php');
    }

    /**
     * Get referral key value
     *
     * @return array
     */
    public function getReferralKeyValue() : array
    {
        return [
            'Google'=>'Google',
            'Facebook'=>'Facebook',
            'LinkedIn'=>'LinkedIn',
            'Local Channel'=>'Local Channel',
            'Other'=>'Other',
        ];
    }

    /**
     * Get Form data
     *
     * @return json
     */
    public function getFormData() : JsonResponse
    {
        $cashedCountry=Cache::get('countries_list');

        if (Cache::has('fetch_data')) {
            $data=json_decode(Cache::get('fetch_data'));
        } else {
            $cashedCountry=$this->getCountriesKeyValue();
            $referral=$this->getReferralKeyValue();
            $data = [
                'countries'=>$cashedCountry,
                'referrals'=>$referral
            ];
            Cache::put('fetch_data', json_encode($data));
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Submit data
     *
     */
    public function leadsSave(Request $request)
    {
        $error=false;
        $request->validate([
            'firstname' => "required|max:30|string",
            'lastname' => "max:30|string|nullable",
            'email' => "required|email|unique:App\Models\EmailsModel,email",
            'mobile' => "max:20|string|nullable",
            'notes' => "max:500|string|nullable",
            'referral' => "max:30|string",
            'countrycode' => "max:3|string",
        ]);

        try {
            $emailModel = new EmailsModel();
            $emailModel->email = $request->input('email');
            $emailModel->save();

            $data = [
                'countrycode' => $request->input('countrycode'),
                'termsaccepted' => $request->input('termsaccepted')
            ];

            $leadModel = LeadsModel::create($data);
            if ($leadModel->id) {
                $dataLead = [
                    'lead' => $leadModel->id,
                    'firstname' => $request->input('firstname'),
                    'lastname' => $request->input('lastname'),
                    'email' => $request->input('email'),
                    'notes' => $request->input('notes'),
                    'mobile' => $request->input('mobile'),
                    'referral' => $request->input('referral')
                ];
                LeadsEncryptionModel::create($dataLead);
            }
        } catch (Exception $e) {
            return "Bad error";
        }

        return back(303);
    }

    public function sanitizeInput($input, $filter = FILTER_SANITIZE_STRING)
    {
        return filter_var($input, $filter);
    }


}
