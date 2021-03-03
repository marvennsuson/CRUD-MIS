<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\BusinessPermit;
use App\Application;
use App\BusinessPermitVerification;
use Illuminate\Support\Facades\Storage;
use App\Resident;
use App\Notifications\UserElectronicReceipt;

class ApplicationController extends Controller
{
    protected $bp;
    protected $application;
    protected $bpv;
    public function __construct()
    {
        $this->application = new Application;
        $this->bp = new BusinessPermit;
        $this->bpv = new BusinessPermitVerification;
    }

    public function createBusinessPermit(Request $request)
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




        // application data
        $data = [
            'app_id' => 'BP-'.Auth::guard('resident')->user()->id.'-'.strtotime(date('Y-m-d H:i:s')),
            'user_id' => Auth::guard('resident')->user()->id,
            'status' => 1, // draft
            'type' => 1 // 1 business permit , 2 Cedula, 3 Mayor's Permit
        ];


        $createApp = $this->application->createApplicationData($data);
        
         
        if ($createApp == false) {
            $response = ['status' => false, 'msg' => 'Create application data failed'];
            return response()->json($response);
        }

        // business permit data
        $businessPermitData = [
            'app_id' => $data['app_id'],
            'permit_type' => $request->permitType,
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
        
        
        $createBusinessPermit = $this->bp->createBusinessPermit($businessPermitData);

        if ($createBusinessPermit == false) {
            $response = ['status' => false, 'msg' => 'Submission of Business permit failed'];
            return response()->json($response);
        }
        
        
        $response = ['status' => true, 'msg' => 'Submission of Business permit success', 'id' => $data['app_id'] ];
        return response()->json($response);
    }

    public function applications() {

      
        
        $userGroup = Auth::user()->user_group_id;

        if ($userGroup == 1) {
            $applications = $this->application->getApplications();
        }elseif ($userGroup == 5) {
            // treasury
            $condition = [['status', '=','3']];
            $applications = $this->application->getApplications($condition);
        }else{
            // bplo and land tax
            $applications = $this->application->getApplications();  
        }

       
        $data['applications'] = $applications;
        $data['main_page'] = 'applications';
        $data['sub_page'] = 'applications';

        return view('admin.applications.applications', $data);
    }

    public function businessPermits()
    {
        $fields = [
            'applications.status', 
            'businesspermits.app_id', 
            'applications.user_id',
            'residents.firstname as applicant_first_name', 
            'residents.lastname as applicant_last_name',
            'applications.created_at as application_registered',
            'businesspermits.permit_type',
        ];
        
        $businessPermits = $this->bp->businessPermitList($fields);
        dd( $businessPermits);
    }

    public function pending_applications() {

        $data['main_page'] = 'applications';
        $data['sub_page'] = 'pending_applications';
      
        return view('admin.applications.pending_applications', $data);
    }

    public function view_application(Request $request, $id){
        

        $verificationData = $this->bpv->readVerification($id);
        
        if ($verificationData != null) {
            $data['verify_details'] = $verificationData;
        }

        $applicationInfo = $this->application->readApplication($id);

        $data['notes'] = $applicationInfo['notes'];
        $data['amount'] = $applicationInfo['amount'];
        $data['username'] = $applicationInfo['user']['firstname'] . ' '. $applicationInfo['user']['lastname'];
        $data['user_id'] = $applicationInfo['user_id'];
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
        
        return view('admin.applications.view_application', $data);
    }



    function verifyApplication(Request $request)
    {
       

       $isExist = $this->bpv->readVerification($request->permitId);
       
        
       $verifyData = [
           'app_id' => $request->permitId,
           'locational_clearance' => $request->locational_clearance,
           'occupancy_permit' => $request->occupancy_permit,
           'barangay_clearance' => $request->barangay_clearance,
           'sanitary_permit' => $request->sanitary_permit,
           'city_environmental_certificate' => $request->city_environmental_certificate,
           'vet_clearance' => $request->vet_clearance,
           'market_clearance' => $request->market_clearance,
           'fire_cert' => $request->fire_cert,
       ];

        if ($isExist == null) {
            // create
            $this->bpv->bpvCreate($verifyData);
        }else{
            //update
            $this->bpv->bpvUpdate($verifyData, $verifyData['app_id']);
        }

        
        $data = [
            'status' => 3, // verified
            'verified_by' => Auth::user()->id,
            'verified_date'=> date('Y-m-d H:i:s')
        ];  

        $createApp = $this->application->updateApplication($data, $request->permitId);

        $response = ['status' => true, 'msg' => 'Verification Success' ];
        return response()->json($response);
    }

    public function changeStatus(Request $request)
    {

        $data = [
            'status' => $request->application_status
        ];  

        $createApp = $this->application->updateApplication($data, $request->permitId);

        $response = ['status' => true, 'msg' => 'Change Status Success' ];
        return response()->json($response);

    }


    public function downloadRequirements($filename)
    {
        $fileInfo = explode('|', $filename);
        return Storage::disk('public')->download('requirements/'.$fileInfo[0].'/'.$fileInfo[1]);
    }

    public function searchApplications(Request $request)
    {   
        
        if ($request->type == null) {
            $type = "";
        }else{
            $type = $request->type;
        }

        if ($request->status == null) {
            $status = "";
        }else{
            $status = $request->status;
        }

        if ($request->f_type == null) {
            $filter = '';
        }else{
            if ($request->f_type == 1) {
                $filter = 'app_id';
            }else{
                $filter = 'username';
            }
        }

        if ($request->search == null) {
          $search = '';
        }else{
          $search = $request->search;
        }


        $fromDate = date('Y-m-d 00:00:00', strtotime($request->from_date));
        $toDate = date('Y-m-d 23:59:00', strtotime($request->to_date));

        if (strtotime($fromDate) > strtotime($toDate)) {
            $response = ['status' => false, 'msg' => '1st date cannot be ahead on the 2nd date'];
            return response()->json($response);
        }


        $applications = $this->application->searchApplications($fromDate, $toDate, $type, $status, $filter, $search);
        
        
        $response = ['status' => true, 'msg' => 'Change Status Success', 'applications' => $applications];

        return response()->json($response);
    }


    public function saveNotes(Request $request)
    {
        $data = [
            'notes' => $request->notes,
        ];

        $updateNotes = $this->application->updateApplication($data, $request->note_app_id);
        $response = ['status' => true, 'msg' => 'Updating Notes Success'];
        return response()->json($response);

    }

    public function saveAmount(Request $request)
    {
        $data = [
            'amount' => $request->amount,
            'treasurer' => Auth::user()->id,
            'status' => '4'
        ];
        
        $updateNotes = $this->application->updateApplication($data, $request->amount_app_id);
        $response = ['status' => true, 'msg' => 'Updating Amount Success'];
        return response()->json($response);

    }

    public function transactions()
    {
        $data['main_page'] = "transactions";
        $data['sub_page'] = "transactions";

        $condition = [
            ['status', ">", 4] 
        ];
        $appTransaction = $this->application->getApplications($condition);

        $data['transactions'] = $appTransaction;

        return view('admin.transactions.transactions', $data);

    }

    public function completeTransaction(Request $request)
    {
        
        $application = Application::where('app_id', '=',$request->id)->first();
        $application->timestamps = false;
        $application->status = 6;
        $application->save();

        $user = Resident::find($application['user_id']);


        if ($application['type'] == 1) {
            $type = "Business Permit";
        } else if ($application['type'] == 2) {
            $type = "Cedula";
        }


        $info = [
            [
                'type' => $type,
                'id' => $request->id,
                'amount' => number_format( $application['amount'],2)
            ],
        ];

        $total = $application['amount'];

        $user->notify(new UserElectronicReceipt($info, number_format( $total,2)));

        $response = ['status' => true, 'msg' => 'This application is now confirmed'];
        return response()->json($response);
    }


  
  
}
