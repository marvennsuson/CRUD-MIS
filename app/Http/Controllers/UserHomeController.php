<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\View;
use Psy\TabCompletion\Matcher\FunctionsMatcher;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Application;
use App\BusinessPermit;
use App\ApplicationHistory;
use App\Notifications\UserVerification;
use App\Resident;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserHomeController extends Controller
{
    protected $app;
    public function __construct()
    {
        $this->app = new Application;
        $this->bp = new BusinessPermit;
        $this->ah = new ApplicationHistory;
        // this->middleware('userlevel1');
    }

    public function dashboard(){
        $data['main_page'] = 'permit';
        $data['sub_page'] = 'application_status';

        $data['applications'] =  $this->app->getAuthApplications();

        $data['main_page'] = 'dashboard';
        $data['sub_page'] = '';
        return view('users.dashboard.home', compact('data'));
    }

    public function apply(Request $request)
    {
        $data['main_page'] = 'permit';
        $data['sub_page'] = 'avail_permit';
        $bpApp = $this->app->getBpApplications();

        if ($bpApp != null) {
            $data['businesspermit'] = $bpApp->status;
        }

        return view('users.permits.home', compact('data'));
    }

    public function businessPermit()
    {
        // page active and show
        $data['main_page'] = 'permit';
        $data['sub_page'] = 'business_permit';
        return view('users.permits.businesspermit', compact('data'));
    }





    public function UserProfile(){
        $user = Resident::findOrFail(Auth::guard('resident')->user()->id);
        $data['main_page'] = 'Profile';
        $data['sub_page'] = 'User Profile';
        return view('users.profile.User_profile',compact('data','user'));
    }

    public function create(Request $request){


        $input = $request->all();

        $validator = Validator::make($request->all(),
            [
                // 'username' => 'required',
                'useravatar' => 'mimes:jpeg,jpg,png,gif|max:100000',
                'email' => 'required|email|unique:users,email|unique:residents,email,'.Auth::guard('resident')->user()->id,
            ]
        );

        if($validator->fails()){
            // return back()->withErrors($validator)->withInput();
            return response()->json(['status' => false,'msg'=>$validator->errors()]);
        }else{
          if ($request->hasFile('useravatar')) {
             if ($request->file('useravatar')->isValid()) {
               $file = $request->useravatar;
        $image_name = rand(10,10000).'_'.time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/'), $image_name);
               $data = [
            //    'username' => $input['username'],
               'email' => $input['email'],
               'firstname' => $input['firstname'],
               'middlename' => $input['middlename'],
               'lastname' => $input['lastname'],
            //    'exname' => $input['exname'],
               'gender' => $input['gender'],
               'age' => $input['age'],
               'dob' => $input['dob'],
               'address' => $input['address'],
               'mobile'=> $input['mobile'],
               'province' => $input['province'],
               'city' => $input['city'],
               'postalcode' => $input['postalcode'],
               'barangay' => $input['barangay'],
            //    'housenumber' => $input['housenumber'],
            //    'streetname' => $input['streetname'],
               'otherinfo' => $input['otherinfo'],
               'avatar' => $image_name,

               ];
               
               Resident::where('id', Auth::guard('resident')->user()->id)->update($data);
               $response = ['status' => true, 'msg' => 'Successfull'];
               return response()->json($response);
             }
           }
           $data = [
        //    'username' => $input['username'],
           'email' => $input['email'],
           'firstname' => $input['firstname'],
           'middlename' => $input['middlename'],
           'lastname' => $input['lastname'],
        //    'exname' => $input['exname'],
           'gender' => $input['gender'],
           'age' => $input['age'],
           'dob' => $input['dob'],
           'address' => $input['address'],
           'mobile'=> $input['mobile'],
           'province' => $input['province'],
           'city' => $input['city'],
           'postalcode' => $input['postalcode'],
           'barangay' => $input['barangay'],
        //    'housenumber' => $input['housenumber'],
        //    'streetname' => $input['streetname'],
           'otherinfo' => $input['otherinfo'],

           ];
           Resident::where('id', Auth::guard('resident')->user()->id)->update($data);
            $response = ['status' => true, 'msg' => 'Successfull'];
            return response()->json($response);
        }


    }

    public function verify(Request $request)
    {
        if($request->get('status') == md5(Auth::guard('resident')->user()->email)){
            $up = Resident::find(Auth::guard('resident')->user()->id);
            $up->verify = 1;
            $up->save();
            $request->session()->flash('status', 'Great! Your account is now verified!');
            $request->session()->flash('preload', 'Great! Your account is now verified!');
            return redirect(route('users.home'));
        }

        $status = Auth::guard('resident')->user()->verify;
        $user = Auth::guard('resident')->user();

        if($status == 0) {
            $user->notify(new UserVerification());
            $up = Resident::find(Auth::guard('resident')->user()->id);
            $up->verify = 2;
            $up->save();
            $request->session()->flash('status', 'Verification mail was sent to your email. If you don\'t see an email, check your spam inbox.');
        }  elseif ($status == 2) {
            $request->session()->flash('status', 'Verification mail was sent to your email. If you don\'t see an email, check your spam inbox.');
        } 
        else {
            return redirect(route('users.home'));
        }

        $data['main_page'] = '';
        $data['sub_page'] = '';
        return view('users.verification.verification', compact('data'));
    }
    public function verified(Request $request)
    {
        $status = Auth::guard('resident')->user()->verify;
        $user = Auth::guard('resident')->user();
        
        if($status == 2) {
            $user->notify(new UserVerification());
            $request->session()->flash('status', 'Verification mail was resent to your email. If you don\'t see an email, check your spam inbox.');
        }
        $data['main_page'] = '';
        $data['sub_page'] = '';
        
        return view('users.verification.verification', compact('data'));
    }


    // User View Application Status
    public function application_status(){



        $data['main_page'] = 'permit';
        $data['sub_page'] = 'application_status';

        $data['applications'] =  $this->app->getAuthApplications();

        return view('users.permits.application_status', compact('data'));
    }

    public function view_application(Request $request, $id){

        
        $applicationInfo = $this->app->readApplication($id);

        $data['amount'] = $applicationInfo['amount'];
        if ($applicationInfo['type'] == 1) {
            $bpInfo =  $this->bp->readBusinessPermitInfo($id);
            $data['business_permit_info'] = $bpInfo;

            if ($applicationInfo['status'] == 1) {
                $data['app_status'] = 'Draft';
            }else if ($applicationInfo['status'] == 2){
                $data['app_status'] = 'Pending';
            }else if ($applicationInfo['status'] == 3){
                $data['app_status'] = 'Verified';
            }else if ($applicationInfo['status'] == 4){
                $data['app_status'] = 'Waiting for Payment';
            }else if ($applicationInfo['status'] == 5){
                $data['app_status'] = 'Processing';
            }else if ($applicationInfo['status'] == 6){
                $data['app_status'] = 'Completed';
            }else if ($applicationInfo['status'] == 7){
                $data['app_status'] = 'Rejected';
            }

            $data['status_no'] = $applicationInfo['status'];
            $data['user_notes'] = $applicationInfo['user_notes'];

            if ($bpInfo['attachments'] != null || $bpInfo['attachments'] != NULL) {
                $data['attachments'] = json_decode($bpInfo['attachments'], true);
            }

            $data['app_type'] = "Business Permit - ". $bpInfo['permit_type'];
        }
        $finalRequireMents = [];
        $requirements = array();
        if ($bpInfo['permit_type'] == 'New' ) {
            $requirements['new'] = [
                'baranggay_clearance' =>
                [
                    'required' => true,
                    'where' => 'Respective Barangay Hall',
                    'name' => 'Baranggay Clearance',
                    'desc' => 'Baranggay Clearance w/ Official Receipt'
                ],
                'home_owners_clearance' => [
                    'required' => false,
                    'where' => 'Respective Homeowners Association',
                    'name' => 'Homeowner\'s Clearance',
                    'desc' => 'Homeowner\'s Clearance (if applicable)'
                ],
                'market_cert' => [
                    'required' => true,
                    'where' => 'CAdO-Economic Enterprise Division',
                    'name' => 'Market Certification',
                    'desc' => 'Market Certification for Public Market  Stallholders'
                ],
                'authority_over_land' => [
                    'required' => false,
                    'where' => 'Property Owner(s)/ Lessor',
                    'name' => 'Authority over land/property',
                    'desc' => 'Authority over land/property, if applicable'
                ],
                'authority_to_process' => [
                    'required' => false,
                    'where' => 'Owner  of Business',
                    'name' => 'Authority to Process',
                    'desc' => 'Authority to Process - if the processor is not the owner or company official'
                ],
                'franchise_agreement' => [
                    'required' => false,
                    'where' => 'Franchiser',
                    'name' => 'Franchise Agreement',
                    'desc' => 'Franchise Agreement for franchise business'
                ],
                'tax_declaration' => [
                    'required' => true,
                    'where' => 'City Assessor\'s Office',
                    'name' => 'Tax Declaration of Lot/Building/Machinery',
                    'desc' => 'Tax Declaration of Lot/Building/Machinery'
                ],
                'real_property_tax_receipt' => [
                    'required' => true,
                    'where' => 'Land Tax Division-City Treasurer\'s Office' ,
                    'name' => 'Updated Real Property Tax Receipt',
                    'desc' => 'Updated Real Property Tax Receipt'
                ],
                'occupational_permit' => [
                    'required' => false,
                    'where' => 'City Permits and Licensing Office' ,
                    'name' => 'Occupational Permit',
                    'desc' => 'Occupational Permit with CTC/Masterlist of employees (with 5 employees or more)'
                ],
                'cert_occupancy' => [
                    'required' => false,
                    'where' => 'Bulding Permit Division-City Engineeer\'s Office',
                    'name' => 'Certificate of Occupancy',
                    'desc' => 'Certificate of Occupancy (if necessary)'
                ],
                'locational_clearance' => [
                    'required' => true,
                    'where' => 'Plans and Program Division-City Planning and Development Office',
                    'name' => 'Locational Clearance',
                    'desc' => 'Locational Clearance',
                ],
                'fire_safety_cert' => [
                    'required' => true,
                    'where' => 'Bureau of Fire Protection',
                    'name' => 'Fire Safety Inspection Certificate',
                    'desc' => 'Fire Safety Inspection Certificate',
                ],
                'sanitary_permit' => [
                    'required' => true,
                    'where' => 'City Health Office',
                    'name' => 'Sanitary Permit',
                    'desc' => 'Sanitary Permit to Operate',
                ],
                'ptr' => [
                    'required' => false,
                    'where' => 'Local Treasury Division-City Treasurer\'s Office',
                    'name' => 'Professional Tax Receipt',
                    'desc' => 'Professional Tax Receipt (if applicable)',
                ],
                'cctv_cert' => [
                    'required' => false,
                    'where' => 'CCTV Installer',
                    'name' => 'CCTV Certification',
                    'desc' => 'CCTV Certification (for establishments covered under Gen. Ordinance No. 1-Series of 2013)'
                ],
                'cenro_clearance' =>[
                    'required' => false,
                    'where' => 'City Environment and Natural Resources Office',
                    'name' => 'CENRO Clearance',
                    'desc' => 'CENRO Clearance (for specific line of  businesses like piggeries, poultry, feedmills,
                    ,subdivisions,gasoline stations, hospitals,medical clinics/laboratories and others)'
                ],
                'veterinary_clearance' => [
                    'required' => false,
                    'where' => 'City Veterinarian\'s Office',
                    'name' => 'Veterinary Clearance',
                    'desc' => 'Veterinary Clearance (for specific businesses, i.e. Meat shop, veterinary clinic & supplies,
                    frozen & processed meat products)'
                ],
                'special_use_permit' => [
                    'required' => false,
                    'where' => 'Office of the City Mayor',
                    'name' => 'Special Use Permit',
                    'desc' => 'Special User Permit (for specific establihments *enumerated under Special Ordinance Nos. 12-98, 11-2004, 63-2016
                    and 183-2017)'
                ],
                'registration_doc' =>[
                    'required' => true,
                    'where' => 'Department of Trade and Industry (DTI)|Securities and Exchange Commission (SEC)|Cooperative Development Authority',
                    'name' => 'Registration Document',
                    'desc' => 'DTI Registration (for single proprietorship)|SEC Registation with Articles of Incorporation/Partnership and by Laws (for corporation / partnership)
                    |CDA Registration for Cooperative'
                ],
                'authority_land_property' =>[
                    'required' => true,
                    'where' => 'Property Owner(s)/Lessor',
                    'name' => 'Authority over Land/Property',
                    'desc' => 'Updated/Notarized Lease Contract with photocpy of lessor\'s mayors permit (if business place is rented)|
                    SPA or written consent of property owner(s), duly notarized and if not, photocopies of ID\'s with signatures of owner(s)
                    (if place is being used for free)|Authority to Sub-Lease -to be secured from the lessor or the registered property owner
                    (if the lessee is sub-leasing portion of leased premises)'
                ],
                'other_documents' => [
                    'required' => true,
                    'where' => '',
                    'name' => 'Other Documents',
                    'desc' => 'Certificate of Authority (COA) or valid Provisional Certificate of Authority (PCOA) - (for pawnshop head office) or BSP Letter
                    on the issuance of Code for Pawnshop Officers other than Head Office (for pawnshops branches)|Certificate of Registration
                    (COR) or valid Provisional Certificate of Registration(PCOR) - (for money service businesses (MSB) Head Office) or BSP Letter on the Issuance
                    of Code for MSB officeers other than head office - (for MSB Branches)|DTI Accreditation (for electronic & motor repair shop)|DOLE/POEA Registration
                     (for Employment/Manpower)|Certificate of Compliance(for gasoline stations)|PNP Clearance(for guns and ammunition/ fireworks Retailer/Dealer)|DOT Accreditation
                     (for Hotels/Resorts/Travel Agencies)|TESDA Certificate (for massage/masseur services)|TESDA Accreditation (for training centers/ vocational schools)|
                     FDA License to Operate (for Pharmacy/Drugstore Vape shops/END/ENDS)|Accreditation/Clearance from NTC (for Radio Stations)|CHED/DEPED Accreditation (for schools)|
                     PNP licence to operate(for security agencies)|Water Permit (for water system management)|Certificate of exemption(for establishments claiming tax exception)|DOH
                     Accreditation/License to Operate (for Hospitals/Lying in clinics/Medical Clinics/Laboratories)|Authority to operate (for private express and messengerial delivery services)'
                ]
            ];
            $finalRequireMents = $requirements['new'];
        }


        if ($bpInfo['permit_type'] == 'Renewal') {
            $requirements['renewal'] = [
                'baranggay_clearance' =>
                [
                    'required' => true,
                    'where' => 'Respective Barangay Hall',
                    'name' => 'Baranggay Clearance',
                    'desc' => 'Baranggay Clearance w/ Official Receipt'
                ],
                'community_tax_cert' =>
                [
                    'required' => true,
                    'where' => 'City Treasurer\'s Office',
                    'name' => 'Community Tax Certificate',
                    'desc' => 'Community Tax Certificate'
                ],
                'real_property_tax_receipt' =>
                [
                    'required' => true,
                    'where' => 'Land Tax Division-City Treasurer\'s Office' ,
                    'name' => 'Real Property Tax Receipt',
                    'desc' => 'Updated Real Property Tax Receipt'
                ],
                'occupational_permit' =>
                [
                    'required' => true,
                    'where' => 'City Permits and Licensing Office' ,
                    'name' => 'Occupational Permit',
                    'desc' => 'Occupational Permit with CTC/Masterlist of employees (with 5 employees or more)'
                ],
                'fire_safety_cert' => [
                    'required' => true,
                    'where' => 'Bureau of Fire Protection',
                    'name' => 'Fire Safety Inspection Certificate',
                    'desc' => 'Fire Safety Inspection Certificate',
                ],
                'sanitary_permit' => [
                    'required' => true,
                    'where' => 'City Health Office',
                    'name' => 'Sanitary Permit to Operate',
                    'desc' => 'Sanitary Permit to Operate',
                ],
                'authority_to_process' => [
                    'required' => false,
                    'where' => 'Owner  of Business',
                    'name' => 'Authority to Process',
                    'desc' => 'Authority to Process - if the processor is not the owner or company official'
                ],
                'ptr' => [
                    'required' => false,
                    'where' => 'Local Treasury Division-City Treasurer\'s Office',
                    'name' => 'Professional Tax Receipt',
                    'desc' => 'Professional Tax Receipt (if applicable)',
                ],
                'lease_contract' => [
                    'required' => true,
                    'where' => 'Property Owner(s)/Lessor',
                    'name' => 'Lease Contract',
                    'desc' => 'Updated/Notarized Lease Contract'
                ],
                'lessors_mayor_permit' => [
                    'required' => true,
                    'where' => 'Property Owner(s)/Lessor',
                    'name' => 'Lessor\'s Mayor Permit',
                    'desc' => 'Lessor\'s Mayor Permit, if applicable'
                ],
                'registration_doc' =>[
                    'required' => true,
                    'where' => 'Department of Trade and Industry (DTI)|Securities and Exchange Commission (SEC)',
                    'name' => 'Registration Document',
                    'desc' => 'DTI Registration (for single proprietorship)|SEC Registation with Articles of Incorporation/Partnership and by Laws (for corporation / partnership)'
                ],
                'transfer_of_ownership' =>[
                    'required' => true,
                    'where' => 'Business Owner\'s',
                    'name' => 'Transfer of Ownership Documents',
                    'desc' => 'Transfer of Ownership Documents whichever is applicable|Deed of sale|Former Owner\'s Affidavit of transfer of ownership (for single proprietorship or Board Resolution
                    of Secretary\'s Certificate (for corporation/partnership) of the new owner/corporation or partnership )'
                ],
            ];

            $finalRequireMents = $requirements['renewal'];
        }



        if ($bpInfo['permit_type'] == 'Transfer of Business Location') {
            $requirements['tobl'] = [
                'notice_transfer_location' =>
                [
                    'required' => true,
                    'where' => 'Business Owner(s)',
                    'name' => 'Notice transfer of location',
                    'desc' => 'Affidavit of transfer location (Single Proprietorship) or |Board Resolution of Secretary\'s Certificate
                    authorizing the transfer of business location (Corporation/Partnership)'
                ],
                'baranggay_clearance' =>
                [
                    'required' => true,
                    'where' => 'Respective Barangay Hall',
                    'name' => 'Baranggay Clearance',
                    'desc' => 'Baranggay Clearance w/ Official Receipt'
                ],
                'last_mayors_permit' =>
                [
                    'required' => true,
                    'where' => 'Business Ownere',
                    'name' => 'Last Mayor\'s permit',
                    'desc' => 'Last Mayor\'s permit Issued'
                ],
                'locational_clearance' => [
                    'required' => true,
                    'where' => 'Plans and Program Division-City Planning and Development Office',
                    'name' => 'Locational Clearance',
                    'desc' => 'Locational Clearance',
                ],
                'cert_occupancy' => [
                    'required' => false,
                    'where' => 'Bulding Permit Division-City Engineeer\'s Office',
                    'name' => 'Certificate of Occupancy',
                    'desc' => 'Certificate of Occupancy (if necessary)'
                ],
                'authority_land_property' =>[
                    'required' => true,
                    'where' => 'Property Owner(s)/Lessor',
                    'name' => 'Autority over Land/Property',
                    'desc' => 'Updated/Notarized Lease Contract with photocpy of lessor\'s mayors permit (if business place is rented)|
                    SPA or written consent of property owner(s), duly notarized and if not, photocopies of ID\'s with signatures of owner(s)
                    (if place is being used for free)|Authority to Sub-Lease -to be secured from the lessor or the registered property owner
                    (if the lessee is sub-leasing portion of leased premises)'
                ],
                'tax_declaration' => [
                    'required' => true,
                    'where' => 'City Assessor\'s Office',
                    'name' => 'Tax Declaration of Lot/Building/Machinery',
                    'desc' => 'Tax Declaration of Lot/Building/Machinery'
                ],
                'authority_to_process' => [
                    'required' => false,
                    'where' => 'Owner  of Business',
                    'name' => 'Authority to Process',
                    'desc' => 'Authority to Process - if the processor is not the owner or company official'
                ],
                'cctv_cert' => [
                    'required' => false,
                    'where' => 'CCTV Installer',
                    'name' => 'CCTV Certification',
                    'desc' => 'CCTV Certification (for establishments covered under Gen. Ordinance No. 1-Series of 2013)'
                ],
                'special_use_permit' => [
                    'required' => false,
                    'where' => 'Office of the City Mayor',
                    'name' => 'Special Use Permit',
                    'desc' => 'Special User Permit (for specific establihments *enumerated under Special Ordinance Nos. 12-98, 11-2004, 63-2016
                    and 183-2017)'
                ],
            ];

            $finalRequireMents = $requirements['tobl'];
        }

        if ($bpInfo['permit_type'] == 'Transfer of Business Ownership') {
            $requirements['tobo'] = [
                'transfer_of_ownership' =>[
                    'required' => true,
                    'where' => 'Business Owner\'s',
                    'name' => 'Transfer of Ownership Documents',
                    'desc' => 'Transfer of Ownership Documents whichever is applicable|Deed of sale|Former Owner\'s Affidavit of transfer of ownership (for single proprietorship or Board Resolution
                    of Secretary\'s Certificate (for corporation/partnership) of the new owner/corporation or partnership )'
                ],
                'registration_doc' =>[
                    'required' => true,
                    'where' => 'Department of Trade and Industry (DTI)|Securities and Exchange Commission (SEC)',
                    'name' => 'Registration Document',
                    'desc' => 'DTI Registration (for single proprietorship)|SEC Registation with Articles of Incorporation/Partnership and by Laws (for corporation / partnership) of the new owner/corporation
                    or partnership'
                ],
                'last_mayors_permit' =>
                [
                    'required' => true,
                    'where' => 'Business Ownere',
                    'name' => 'Last Mayor\'s permit',
                    'desc' => 'Last Mayor\'s permit Issued'
                ],
                'authority_land_property' =>[
                    'required' => true,
                    'where' => 'Property Owner(s)/Lessor',
                    'name' => 'Autority over Land/Property',
                    'desc' => 'Updated/Notarized Lease Contract with photocpy of lessor\'s mayors permit (if business place is rented)|
                    SPA or written consent of property owner(s), duly notarized and if not, photocopies of ID\'s with signatures of owner(s)
                    (if place is being used for free)|Authority to Sub-Lease -to be secured from the lessor or the registered property owner
                    (if the lessee is sub-leasing portion of leased premises)'
                ],
                'authority_to_process' => [
                    'required' => false,
                    'where' => 'Owner  of Business',
                    'name' => 'Authority to Process',
                    'desc' => 'Authority to Process - if the processor is not the owner or company official'
                ],

            ];

            $finalRequireMents = $requirements['tobo'];
        }








        $data['requirements'] = $finalRequireMents;
        $data['id'] = $id;
        $data['type'] = $applicationInfo['type'];
        $data['main_page'] = 'applications';
        $data['sub_page'] = 'applications';

        return view('users.permits.view_application', compact('data'));
    }


    public function requirementsList($permitType)
    {
        $finalRequireMents = [];
        $requirements = array();
        if ($permitType == 'New' ) {
            $requirements['new'] = [
                'baranggay_clearance' =>
                [
                    'required' => true,
                    'where' => 'Respective Barangay Hall',
                    'name' => 'Baranggay Clearance',
                    'desc' => 'Baranggay Clearance w/ Official Receipt'
                ],
                'home_owners_clearance' => [
                    'required' => false,
                    'where' => 'Respective Homeowners Association',
                    'name' => 'Homeowner\'s Clearance',
                    'desc' => 'Homeowner\'s Clearance (if applicable)'
                ],
                'market_cert' => [
                    'required' => true,
                    'where' => 'CAdO-Economic Enterprise Division',
                    'name' => 'Market Certification',
                    'desc' => 'Market Certification for Public Market  Stallholders'
                ],
                'authority_over_land' => [
                    'required' => false,
                    'where' => 'Property Owner(s)/ Lessor',
                    'name' => 'Authority over land/property',
                    'desc' => 'Authority over land/property, if applicable'
                ],
                'authority_to_process' => [
                    'required' => false,
                    'where' => 'Owner  of Business',
                    'name' => 'Authority to Process',
                    'desc' => 'Authority to Process - if the processor is not the owner or company official'
                ],
                'franchise_agreement' => [
                    'required' => false,
                    'where' => 'Franchiser',
                    'name' => 'Franchise Agreement',
                    'desc' => 'Franchise Agreement for franchise business'
                ],
                'tax_declaration' => [
                    'required' => true,
                    'where' => 'City Assessor\'s Office',
                    'name' => 'Tax Declaration of Lot/Building/Machinery',
                    'desc' => 'Tax Declaration of Lot/Building/Machinery'
                ],
                'real_property_tax_receipt' => [
                    'required' => true,
                    'where' => 'Land Tax Division-City Treasurer\'s Office' ,
                    'name' => 'Updated Real Property Tax Receipt',
                    'desc' => 'Updated Real Property Tax Receipt'
                ],
                'occupational_permit' => [
                    'required' => false,
                    'where' => 'City Permits and Licensing Office' ,
                    'name' => 'Occupational Permit',
                    'desc' => 'Occupational Permit with CTC/Masterlist of employees (with 5 employees or more)'
                ],
                'cert_occupancy' => [
                    'required' => false,
                    'where' => 'Bulding Permit Division-City Engineeer\'s Office',
                    'name' => 'Certificate of Occupancy',
                    'desc' => 'Certificate of Occupancy (if necessary)'
                ],
                'locational_clearance' => [
                    'required' => true,
                    'where' => 'Plans and Program Division-City Planning and Development Office',
                    'name' => 'Locational Clearance',
                    'desc' => 'Locational Clearance',
                ],
                'fire_safety_cert' => [
                    'required' => true,
                    'where' => 'Bureau of Fire Protection',
                    'name' => 'Fire Safety Inspection Certificate',
                    'desc' => 'Fire Safety Inspection Certificate',
                ],
                'sanitary_permit' => [
                    'required' => true,
                    'where' => 'City Health Office',
                    'name' => 'Sanitary Permit',
                    'desc' => 'Sanitary Permit to Operate',
                ],
                'ptr' => [
                    'required' => false,
                    'where' => 'Local Treasury Division-City Treasurer\'s Office',
                    'name' => 'Professional Tax Receipt',
                    'desc' => 'Professional Tax Receipt (if applicable)',
                ],
                'cctv_cert' => [
                    'required' => false,
                    'where' => 'CCTV Installer',
                    'name' => 'CCTV Certification',
                    'desc' => 'CCTV Certification (for establishments covered under Gen. Ordinance No. 1-Series of 2013)'
                ],
                'cenro_clearance' =>[
                    'required' => false,
                    'where' => 'City Environment and Natural Resources Office',
                    'name' => 'CENRO Clearance',
                    'desc' => 'CENRO Clearance (for specific line of  businesses like piggeries, poultry, feedmills,
                    ,subdivisions,gasoline stations, hospitals,medical clinics/laboratories and others)'
                ],
                'veterinary_clearance' => [
                    'required' => false,
                    'where' => 'City Veterinarian\'s Office',
                    'name' => 'Veterinary Clearance',
                    'desc' => 'Veterinary Clearance (for specific businesses, i.e. Meat shop, veterinary clinic & supplies,
                    frozen & processed meat products)'
                ],
                'special_use_permit' => [
                    'required' => false,
                    'where' => 'Office of the City Mayor',
                    'name' => 'Special Use Permit',
                    'desc' => 'Special User Permit (for specific establihments *enumerated under Special Ordinance Nos. 12-98, 11-2004, 63-2016
                    and 183-2017)'
                ],
                'registration_doc' =>[
                    'required' => true,
                    'where' => 'Department of Trade and Industry (DTI)|Securities and Exchange Commission (SEC)|Cooperative Development Authority',
                    'name' => 'Registration Document',
                    'desc' => 'DTI Registration (for single proprietorship)|SEC Registation with Articles of Incorporation/Partnership and by Laws (for corporation / partnership)
                    |CDA Registration for Cooperative'
                ],
                'authority_land_property' =>[
                    'required' => true,
                    'where' => 'Property Owner(s)/Lessor',
                    'name' => 'Authority over Land/Property',
                    'desc' => 'Updated/Notarized Lease Contract with photocpy of lessor\'s mayors permit (if business place is rented)|
                    SPA or written consent of property owner(s), duly notarized and if not, photocopies of ID\'s with signatures of owner(s)
                    (if place is being used for free)|Authority to Sub-Lease -to be secured from the lessor or the registered property owner
                    (if the lessee is sub-leasing portion of leased premises)'
                ],
                'other_documents' => [
                    'required' => true,
                    'where' => '',
                    'name' => 'Other Documents',
                    'desc' => 'Certificate of Authority (COA) or valid Provisional Certificate of Authority (PCOA) - (for pawnshop head office) or BSP Letter
                    on the issuance of Code for Pawnshop Officers other than Head Office (for pawnshops branches)|Certificate of Registration
                    (COR) or valid Provisional Certificate of Registration(PCOR) - (for money service businesses (MSB) Head Office) or BSP Letter on the Issuance
                    of Code for MSB officeers other than head office - (for MSB Branches)|DTI Accreditation (for electronic & motor repair shop)|DOLE/POEA Registration
                     (for Employment/Manpower)|Certificate of Compliance(for gasoline stations)|PNP Clearance(for guns and ammunition/ fireworks Retailer/Dealer)|DOT Accreditation
                     (for Hotels/Resorts/Travel Agencies)|TESDA Certificate (for massage/masseur services)|TESDA Accreditation (for training centers/ vocational schools)|
                     FDA License to Operate (for Pharmacy/Drugstore Vape shops/END/ENDS)|Accreditation/Clearance from NTC (for Radio Stations)|CHED/DEPED Accreditation (for schools)|
                     PNP licence to operate(for security agencies)|Water Permit (for water system management)|Certificate of exemption(for establishments claiming tax exception)|DOH
                     Accreditation/License to Operate (for Hospitals/Lying in clinics/Medical Clinics/Laboratories)|Authority to operate (for private express and messengerial delivery services)'
                ]
            ];
            $finalRequireMents = $requirements['new'];
        }


        if ($permitType == 'Renewal') {
            $requirements['renewal'] = [
                'baranggay_clearance' =>
                [
                    'required' => true,
                    'where' => 'Respective Barangay Hall',
                    'name' => 'Baranggay Clearance',
                    'desc' => 'Baranggay Clearance w/ Official Receipt'
                ],
                'community_tax_cert' =>
                [
                    'required' => true,
                    'where' => 'City Treasurer\'s Office',
                    'name' => 'Community Tax Certificate',
                    'desc' => 'Community Tax Certificate'
                ],
                'real_property_tax_receipt' =>
                [
                    'required' => true,
                    'where' => 'Land Tax Division-City Treasurer\'s Office' ,
                    'name' => 'Real Property Tax Receipt',
                    'desc' => 'Updated Real Property Tax Receipt'
                ],
                'occupational_permit' =>
                [
                    'required' => true,
                    'where' => 'City Permits and Licensing Office' ,
                    'name' => 'Occupational Permit',
                    'desc' => 'Occupational Permit with CTC/Masterlist of employees (with 5 employees or more)'
                ],
                'fire_safety_cert' => [
                    'required' => true,
                    'where' => 'Bureau of Fire Protection',
                    'name' => 'Fire Safety Inspection Certificate',
                    'desc' => 'Fire Safety Inspection Certificate',
                ],
                'sanitary_permit' => [
                    'required' => true,
                    'where' => 'City Health Office',
                    'name' => 'Sanitary Permit to Operate',
                    'desc' => 'Sanitary Permit to Operate',
                ],
                'authority_to_process' => [
                    'required' => false,
                    'where' => 'Owner  of Business',
                    'name' => 'Authority to Process',
                    'desc' => 'Authority to Process - if the processor is not the owner or company official'
                ],
                'ptr' => [
                    'required' => false,
                    'where' => 'Local Treasury Division-City Treasurer\'s Office',
                    'name' => 'Professional Tax Receipt',
                    'desc' => 'Professional Tax Receipt (if applicable)',
                ],
                'lease_contract' => [
                    'required' => true,
                    'where' => 'Property Owner(s)/Lessor',
                    'name' => 'Lease Contract',
                    'desc' => 'Updated/Notarized Lease Contract'
                ],
                'lessors_mayor_permit' => [
                    'required' => true,
                    'where' => 'Property Owner(s)/Lessor',
                    'name' => 'Lessor\'s Mayor Permit',
                    'desc' => 'Lessor\'s Mayor Permit, if applicable'
                ],
                'registration_doc' =>[
                    'required' => true,
                    'where' => 'Department of Trade and Industry (DTI)|Securities and Exchange Commission (SEC)',
                    'name' => 'Registration Document',
                    'desc' => 'DTI Registration (for single proprietorship)|SEC Registation with Articles of Incorporation/Partnership and by Laws (for corporation / partnership)'
                ],
                'transfer_of_ownership' =>[
                    'required' => true,
                    'where' => 'Business Owner\'s',
                    'name' => 'Transfer of Ownership Documents',
                    'desc' => 'Transfer of Ownership Documents whichever is applicable|Deed of sale|Former Owner\'s Affidavit of transfer of ownership (for single proprietorship or Board Resolution
                    of Secretary\'s Certificate (for corporation/partnership) of the new owner/corporation or partnership )'
                ],
            ];

            $finalRequireMents = $requirements['renewal'];
        }



        if ($permitType == 'Transfer of Business Location') {
            $requirements['tobl'] = [
                'notice_transfer_location' =>
                [
                    'required' => true,
                    'where' => 'Business Owner(s)',
                    'name' => 'Notice transfer of location',
                    'desc' => 'Affidavit of transfer location (Single Proprietorship) or |Board Resolution of Secretary\'s Certificate
                    authorizing the transfer of business location (Corporation/Partnership)'
                ],
                'baranggay_clearance' =>
                [
                    'required' => true,
                    'where' => 'Respective Barangay Hall',
                    'name' => 'Baranggay Clearance',
                    'desc' => 'Baranggay Clearance w/ Official Receipt'
                ],
                'last_mayors_permit' =>
                [
                    'required' => true,
                    'where' => 'Business Ownere',
                    'name' => 'Last Mayor\'s permit',
                    'desc' => 'Last Mayor\'s permit Issued'
                ],
                'locational_clearance' => [
                    'required' => true,
                    'where' => 'Plans and Program Division-City Planning and Development Office',
                    'name' => 'Locational Clearance',
                    'desc' => 'Locational Clearance',
                ],
                'cert_occupancy' => [
                    'required' => false,
                    'where' => 'Bulding Permit Division-City Engineeer\'s Office',
                    'name' => 'Certificate of Occupancy',
                    'desc' => 'Certificate of Occupancy (if necessary)'
                ],
                'authority_land_property' =>[
                    'required' => true,
                    'where' => 'Property Owner(s)/Lessor',
                    'name' => 'Autority over Land/Property',
                    'desc' => 'Updated/Notarized Lease Contract with photocpy of lessor\'s mayors permit (if business place is rented)|
                    SPA or written consent of property owner(s), duly notarized and if not, photocopies of ID\'s with signatures of owner(s)
                    (if place is being used for free)|Authority to Sub-Lease -to be secured from the lessor or the registered property owner
                    (if the lessee is sub-leasing portion of leased premises)'
                ],
                'tax_declaration' => [
                    'required' => true,
                    'where' => 'City Assessor\'s Office',
                    'name' => 'Tax Declaration of Lot/Building/Machinery',
                    'desc' => 'Tax Declaration of Lot/Building/Machinery'
                ],
                'authority_to_process' => [
                    'required' => false,
                    'where' => 'Owner  of Business',
                    'name' => 'Authority to Process',
                    'desc' => 'Authority to Process - if the processor is not the owner or company official'
                ],
                'cctv_cert' => [
                    'required' => false,
                    'where' => 'CCTV Installer',
                    'name' => 'CCTV Certification',
                    'desc' => 'CCTV Certification (for establishments covered under Gen. Ordinance No. 1-Series of 2013)'
                ],
                'special_use_permit' => [
                    'required' => false,
                    'where' => 'Office of the City Mayor',
                    'name' => 'Special Use Permit',
                    'desc' => 'Special User Permit (for specific establihments *enumerated under Special Ordinance Nos. 12-98, 11-2004, 63-2016
                    and 183-2017)'
                ],
            ];

            $finalRequireMents = $requirements['tobl'];
        }

        if ($permitType == 'Transfer of Business Ownership') {
            $requirements['tobo'] = [
                'transfer_of_ownership' =>[
                    'required' => true,
                    'where' => 'Business Owner\'s',
                    'name' => 'Transfer of Ownership Documents',
                    'desc' => 'Transfer of Ownership Documents whichever is applicable|Deed of sale|Former Owner\'s Affidavit of transfer of ownership (for single proprietorship or Board Resolution
                    of Secretary\'s Certificate (for corporation/partnership) of the new owner/corporation or partnership )'
                ],
                'registration_doc' =>[
                    'required' => true,
                    'where' => 'Department of Trade and Industry (DTI)|Securities and Exchange Commission (SEC)',
                    'name' => 'Registration Document',
                    'desc' => 'DTI Registration (for single proprietorship)|SEC Registation with Articles of Incorporation/Partnership and by Laws (for corporation / partnership) of the new owner/corporation
                    or partnership'
                ],
                'last_mayors_permit' =>
                [
                    'required' => true,
                    'where' => 'Business Ownere',
                    'name' => 'Last Mayor\'s permit',
                    'desc' => 'Last Mayor\'s permit Issued'
                ],
                'authority_land_property' =>[
                    'required' => true,
                    'where' => 'Property Owner(s)/Lessor',
                    'name' => 'Autority over Land/Property',
                    'desc' => 'Updated/Notarized Lease Contract with photocpy of lessor\'s mayors permit (if business place is rented)|
                    SPA or written consent of property owner(s), duly notarized and if not, photocopies of ID\'s with signatures of owner(s)
                    (if place is being used for free)|Authority to Sub-Lease -to be secured from the lessor or the registered property owner
                    (if the lessee is sub-leasing portion of leased premises)'
                ],
                'authority_to_process' => [
                    'required' => false,
                    'where' => 'Owner  of Business',
                    'name' => 'Authority to Process',
                    'desc' => 'Authority to Process - if the processor is not the owner or company official'
                ],

            ];

            $finalRequireMents = $requirements['tobo'];
        }

        return $finalRequireMents;
    }


    public function uploadRequirements(Request $request)
    {
        
        if ($request->hasFile('file')) {


            $fileName =  $request->file_key.'.'. $request->file->extension();

            $requirements = [];

            $businessPermitInfo = $this->bp->readBusinessPermitInfo($request->id);

            if ( $businessPermitInfo->attachments == null || $businessPermitInfo->attachments == NULL) {
                // first upload
                $path = $request->file('file')->storeAs(
                    'requirements/'.Auth::guard('resident')->user()->id,$fileName,'public'
                );
                $requirements[$request->file_key] = $fileName;
            }else{
                $requirements = json_decode($businessPermitInfo->attachments, true);

                if (array_key_exists($request->file_key, $requirements)) {
                    $currentfile = 'requirements/'.Auth::guard('resident')->user()->id.'/'.$requirements[$request->file_key];
                    if (Storage::disk('public')->exists($currentfile)) {
                        Storage::disk('public')->delete($currentfile);
                    }

                    foreach ($requirements as $ck => $rv) {
                        if ($request->file_key == $ck) {
                            $requirements[$ck] = $fileName;
                        }else{
                            $requirements[$ck] = $rv;
                        }
                    }
                }else{
                    $requirements[$request->file_key] = $fileName;
                }

                $path = $request->file('file')->storeAs(
                    'requirements/'.Auth::guard('resident')->user()->id,$fileName,'public'
                );
            }

            $requirements_list = $this->requirementsList($businessPermitInfo['permit_type']);

            // application history
            $historyData = [
                'app_id' => $request->id,
                'user_id' => Auth::guard('resident')->user()->id,
                'action' => 'upload',
                'description' => 'Upload '.$requirements_list[$request->file_key]['name']
            ];
            $new_app_history =  $this->ah->newHistory($historyData);

            // update business permits
            $updateData['attachments'] = json_encode($requirements);
            $this->bp::where('app_id', $request->id)->update($updateData);

            $response = ['status' => true, 'msg' => 'Upload successful'];
            return response()->json($response);
        }


    }


    public function updateDraft(Request $request)
    {
        if (empty($request->lineOfBusines) ||  empty($request->capitalization) || empty($request->noOfUnits)) {
            $response = ['status' => false, 'msg' => 'Business Activities cannot be empty'];
            return response()->json($response);
        }else{
            $businessActivities = [];
            for ($i=0; $i < count($request->lineOfBusines); $i++) {
                $businessActivities[$i]['line_of_business'] = $request->lineOfBusines[$i];
                $businessActivities[$i]['capitalization'] = $request->capitalization[$i];
                $businessActivities[$i]['units'] = $request->noOfUnits[$i];
             }
        }





        // business permit data
        $businessPermitData = [
            // 'app_id' => $request->permitId,
            // 'permit_type' => $request->permitType,
            'mode_of_payment' => $request->modeOfPayment,
            'business_type' => $request->typeOfBusiness,
            'registration_no' => $request->dti,
            'application_date' =>  date('Y-m-d', strtotime($request->date_of_application)),
            'tin_no' => $request->tin,
            'amendment' => $request->amendment,
            'amendment_from' => $request->from,
            'amendment_to' => $request->to,
            'is_change_owner' => $request->previousOwner != null && $request->newOwner != null ? 1 : 0,
            'prev_owner' => $request->previousOwner != null ? $request->previousOwner: 'N/A',
            'new_owner' => $request->newOwner  != null ?  $request->newOwner  : 'N/A',
            'is_enjoy_tax' => isset($request->enjoyTaxIncentive) ? 1: 0,
            'tax_entity' => isset($request->enjoyTaxIncentive) ? $request->taxIncentiveEntity:  'N/A',
            'tp_last_name' => $request->lastName,
            'tp_first_name' => $request->firstName,
            'tp_middle_name' => $request->middleName,
            'business_name' => $request->businessName,
            'civil_status' => $request->civilStatus,
            'company_rep' => $request->companyRepresentative,
            'company_position' => $request->position,
            'trade_name' => $request->tradeName,
            'business_address' => $request->businessAddress,
            'business_postal' => $request->postalCode,
            'business_email' => $request->email,
            'business_tel' => $request->tel,
            'business_mobile' => $request->mobile,
            'owner_address' => $request->ownersHomeAddress,
            'owner_postal' => $request->ownersPostalCode,
            'owner_email' => $request->ownersEmail,
            'owner_tel' => $request->ownersTelNo,
            'owner_mobile' => $request->ownersMobileNo,
            'emergency_contact' => $request->emergencyContactName,
            'emergency_email' => $request->emergencyEmail,
            'emergency_tel' => $request->emergencyTelNo,
            'emergency_mobile' => $request->emergencyMobileNo,
            'business_area' => $request->business_area,
            'male_in_establishments' => $request->maleEmployeesInEstablishment,
            'female_in_establishments' => $request->femaleEmployeesInEstablishment,
            'male_in_lgu' => $request->maleEmployeesResidingWithinTheLGU,
            'female_in_lgu' => $request->femaleEmployeesResidingWithinTheLGU,
            'is_business_rented' => isset($request->rented)  ? 1: 0,
            'lessor_name' => isset($request->rented) ? $request->lessorFullName : 'N/A',
            'lessor_address' => isset($request->rented) ? $request->lessorFullAddress : 'N/A',
            'lessor_contact' => isset($request->rented) ? $request->lessorMobileNumber:  'N/A',
            'monthly_rental' => isset($request->rented) ?  $request->monthlyRental : '0',
            'business_activities' => json_encode( $businessActivities),
        ];


        $createBusinessPermit = $this->bp->updateBusinessPermit($businessPermitData, $request->permitId);

        if ($createBusinessPermit == false) {
            $response = ['status' => false, 'msg' => 'Update of Business permit failed'];
            return response()->json($response);
        }

        $historyData = [
            'app_id' => $request->permitId,
            'user_id' => Auth::guard('resident')->user()->id,
            'action' => 'update',
            'description' => 'Update Draft Application'
        ];
        $new_app_history =  $this->ah->newHistory($historyData);



        $response = ['status' => true, 'msg' => 'Update of Business permit success'];
        return response()->json($response);
    }



    public function submitApplication(Request $request)
    {
        if (empty($request->lineOfBusines) ||  empty($request->capitalization) || empty($request->noOfUnits)) {
            $response = ['status' => false, 'msg' => 'Business Activities cannot be empty'];
            return response()->json($response);
        }else{
            $businessActivities = [];
            for ($i=0; $i < count($request->lineOfBusines); $i++) {
                $businessActivities[$i]['line_of_business'] = $request->lineOfBusines[$i];
                $businessActivities[$i]['capitalization'] = $request->capitalization[$i];
                $businessActivities[$i]['units'] = $request->noOfUnits[$i];
             }
        }

        $data = [
            'status' => 2, // pending
        ];

        $createApp = $this->app->updateApplication($data, $request->permitId);



        // business permit data
        $businessPermitData = [
            // 'app_id' => $request->permitId,
            // 'permit_type' => $request->permitType,
            'mode_of_payment' => $request->modeOfPayment,
            'business_type' => $request->typeOfBusiness,
            'registration_no' => $request->dti,
            'application_date' =>  date('Y-m-d', strtotime($request->date_of_application)),
            'tin_no' => $request->tin,
            'amendment' => $request->amendment,
            'amendment_from' => $request->from,
            'amendment_to' => $request->to,
            'is_change_owner' => $request->previousOwner != null && $request->newOwner != null ? 1 : 0,
            'prev_owner' => $request->previousOwner != null ? $request->previousOwner: 'N/A',
            'new_owner' => $request->newOwner  != null ?  $request->newOwner  : 'N/A',
            'is_enjoy_tax' => isset($request->enjoyTaxIncentive) ? 1: 0,
            'tax_entity' => isset($request->enjoyTaxIncentive) ? $request->taxIncentiveEntity:  'N/A',
            'tp_last_name' => $request->lastName,
            'tp_first_name' => $request->firstName,
            'tp_middle_name' => $request->middleName,
            'business_name' => $request->businessName,
            'civil_status' => $request->civilStatus,
            'company_rep' => $request->companyRepresentative,
            'company_position' => $request->position,
            'trade_name' => $request->tradeName,
            'business_address' => $request->businessAddress,
            'business_postal' => $request->postalCode,
            'business_email' => $request->email,
            'business_tel' => $request->tel,
            'business_mobile' => $request->mobile,
            'owner_address' => $request->ownersHomeAddress,
            'owner_postal' => $request->ownersPostalCode,
            'owner_email' => $request->ownersEmail,
            'owner_tel' => $request->ownersTelNo,
            'owner_mobile' => $request->ownersMobileNo,
            'emergency_contact' => $request->emergencyContactName,
            'emergency_email' => $request->emergencyEmail,
            'emergency_tel' => $request->emergencyTelNo,
            'emergency_mobile' => $request->emergencyMobileNo,
            'business_area' => $request->business_area,
            'male_in_establishments' => $request->maleEmployeesInEstablishment,
            'female_in_establishments' => $request->femaleEmployeesInEstablishment,
            'male_in_lgu' => $request->maleEmployeesResidingWithinTheLGU,
            'female_in_lgu' => $request->femaleEmployeesResidingWithinTheLGU,
            'is_business_rented' => isset($request->rented)  ? 1: 0,
            'lessor_name' => isset($request->rented) ? $request->lessorFullName : 'N/A',
            'lessor_address' => isset($request->rented) ? $request->lessorFullAddress : 'N/A',
            'lessor_contact' => isset($request->rented) ? $request->lessorMobileNumber:  'N/A',
            'monthly_rental' => isset($request->rented) ?  $request->monthlyRental : '0',
            'business_activities' => json_encode( $businessActivities),
        ];


        $createBusinessPermit = $this->bp->updateBusinessPermit($businessPermitData, $request->permitId);

        if ($createBusinessPermit == false) {
            $response = ['status' => false, 'msg' => 'Update of Business permit failed'];
            return response()->json($response);
        }

        $historyData = [
            'app_id' => $request->permitId,
            'user_id' => Auth::guard('resident')->user()->id,
            'action' => 'submit',
            'description' => 'Submit application : "Status:Pending"'
        ];

        $new_app_history =  $this->ah->newHistory($historyData);

        $response = ['status' => true, 'msg' => 'Update of Business permit success'];
        return response()->json($response);
    }


    public function deleteApplication(Request $request)
    {
        $data = [
            'status' => 0, // deleted
        ];

        $createApp = $this->app->updateApplication($data, $request->id);
        $response = ['status' => true, 'msg' => 'Delete of Business permit success'];
        return response()->json($response);

    }

    public function saveNotes(Request $request)
    {
        $data = [
            'user_notes' => $request->notes,
        ];

        $updateNotes = $this->app->updateApplication($data, $request->note_app_id);

        $historyData = [
            'app_id' => $request->note_app_id,
            'user_id' => Auth::guard('resident')->user()->id,
            'action' => 'update',
            'description' => 'Update Notes "'.$request->notes.'"'
        ];
        $new_app_history =  $this->ah->newHistory($historyData);


        $response = ['status' => true, 'msg' => 'Updating Notes Success'];


        return response()->json($response);

    }

    public function topay(){

        $data['applications'] =   Application::where('user_id', Auth::guard('resident')->user()->id)->where('status','!=', 0)->where('status','>=', 4)->get()->toArray();
        
        $data['main_page'] = 'permit';
        $data['sub_page'] = 'topay';
        
        return view('users.permits.topay', compact('data'));
    }

    public function payment_gateway($applicationid){
        $data['main_page'] = 'permit';
        $data['sub_page'] = 'topay';
        $data['ApplicationInfo'] = Application::where(['app_id' => $applicationid ,'user_id' => Auth::guard('resident')->user()->id])->get();
      
        return view('users.permits.payment', compact('data'));
    }

    public function paymentTransaction(Request $request){

        $validator =Validator::make($request->all(),[
            'paymentMethod' => 'required',
            'appid' => 'required',
            'amount' => 'required',
         ]);
         if ($validator->fails()) {
            return response()->json(['status' => false, 'msg'=>$validator->errors()]);
         }else{
            $data = [
                'status' => 5,
                'paymentType' => $request->paymentMethod,
                'dateofPay' => date('Y-m-d H:i:s'),
            ];
            Application::where(['app_id' =>$request->appid , 'user_id' => Auth::guard('resident')->user()->id])->update($data);
            $response = ['status' => true, 'msg' => 'Create User Successfully'];
        return response()->json($response);
         }
 
    }



    public function userApplicationHistory(Request $request)
    {
        $condition = [
            ['application_histories.app_id' , '=', $request->id],
        ];
        
        $fields = [
            'application_histories.app_id',
            'application_histories.user_id',
            'residents.firstname as rfn',
            'residents.lastname as rln',
            'application_histories.action',
            'application_histories.description',
            'application_histories.created_at',
        ];
        $rHistoryList  = $this->ah->userAppHistoryList($fields,$condition, 'user');

 
        $finalResidentHistory = [];
        foreach ($rHistoryList as $rhk => $rhv) {
            $finalResidentHistory[$rhk]['app_id'] = $rhv['app_id'];
            $finalResidentHistory[$rhk]['fullname'] = $rhv['rfn'] . " ". $rhv['rln'];
            $finalResidentHistory[$rhk]['description'] = 'You '.$rhv['description'];
            $finalResidentHistory[$rhk]['date'] = date('m/d/Y H:i:s', strtotime($rhv['created_at']));
        } 

     

        $afields = [
            'application_histories.app_id',
            'application_histories.admin_id',
            'users.firstname as rfn',
            'users.lastname as rln',
            'application_histories.action',
            'application_histories.description',
            'application_histories.created_at',
        ];

        $aHistoryList  = $this->ah->userAppHistoryList($afields,$condition, 'admin');

        $finalAdminHistory = [];
        foreach ($aHistoryList as $ahk => $ahv) {
            $finalAdminHistory[$ahk]['app_id'] = $ahv['app_id'];
            $finalAdminHistory[$ahk]['fullname'] = $ahv['rfn'] . " ". $ahv['rln'];
            $finalAdminHistory[$ahk]['description'] = $ahv['rfn'].' '.$ahv['rln'].' '.$ahv['description'];
            $finalAdminHistory[$ahk]['date'] = date('m/d/Y H:i:s', strtotime($ahv['created_at']));
        } 


        
        $response = ['status' => true, 'msg' => 'Updating Notes Success', 'user_history' => $finalResidentHistory, 'admin_history' => $finalAdminHistory];
        
        return response()->json($response);

        
    }
}
