<?php

namespace Database\Seeders;

use App\Models\CouncilReport;
use App\Models\User;
use Illuminate\Database\Seeder;

class CouncilReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $councilUsers = User::where('role', 'council')->pluck('id');

        if ($councilUsers->isEmpty()) {
            return;
        }

        $reports = [
            [
                'user_id' => $councilUsers->random(),
                'title' => 'Regional Coordination Meeting Q2 2026',
                'description' => 'Coordination meeting discussing regional work programs and evaluation of the first quarter performance.',
                'report_type' => 'meeting',
                'activity_date' => '2026-04-15',
                'start_time' => '09:00',
                'end_time' => '12:00',
                'location' => 'DPD Office, Central Jakarta',
                'agenda' => "1. Opening and recitation\n2. Q1 performance evaluation report\n3. Q2 work program plan\n4. Budget allocation discussion\n5. Closing and prayer",
                'result' => 'Q1 performance met 85% of target. Q2 work program approved with a focus on community outreach and cadre education.',
                'recommendation' => 'Increase cadre training frequency to twice per month. Propose additional budget for community outreach programs.',
                'participants_count' => 45,
                'status' => 'approved',
            ],
            [
                'user_id' => $councilUsers->random(),
                'title' => 'Community Visit to Sukabumi District',
                'description' => 'Field visit to assess the condition of road infrastructure and public facilities in Sukabumi district.',
                'report_type' => 'visit',
                'activity_date' => '2026-04-20',
                'start_time' => '08:00',
                'end_time' => '16:00',
                'location' => 'Sukabumi District, West Java',
                'agenda' => "1. Road infrastructure inspection\n2. Meeting with village heads\n3. Community aspiration hearing\n4. Public facility assessment",
                'result' => 'Found 3 critical road segments requiring immediate repair. 2 school buildings need renovation. Community requests for clean water facilities documented.',
                'recommendation' => 'Submit urgent proposal for road repair budget. Coordinate with education department for school renovation. Initiate clean water program with local government.',
                'participants_count' => 120,
                'status' => 'submitted',
            ],
            [
                'user_id' => $councilUsers->random(),
                'title' => 'Political Education Socialization for Youth',
                'description' => 'Socialization program targeting young voters about political awareness, democratic participation, and anti-hoax education.',
                'report_type' => 'socialization',
                'activity_date' => '2026-04-25',
                'start_time' => '13:00',
                'end_time' => '17:00',
                'location' => 'State University of Jakarta Auditorium',
                'agenda' => "1. Introduction to democratic values\n2. Political participation for youth\n3. Social media literacy and anti-hoax\n4. Interactive Q&A session\n5. Youth political pledge",
                'result' => 'Over 200 students participated actively. High engagement during the Q&A session with 35 questions raised. Social media literacy module well received.',
                'recommendation' => 'Replicate this program at 5 more universities. Develop digital content for wider outreach. Create a youth political awareness WhatsApp channel.',
                'participants_count' => 215,
                'status' => 'approved',
            ],
            [
                'user_id' => $councilUsers->random(),
                'title' => 'Supervision of Social Aid Distribution',
                'description' => 'Monitoring and supervision of government social aid (Bansos) distribution to ensure it reaches the right beneficiaries.',
                'report_type' => 'supervision',
                'activity_date' => '2026-05-01',
                'start_time' => '07:00',
                'end_time' => '15:00',
                'location' => 'Tangerang Selatan Sub-districts',
                'agenda' => "1. Verify beneficiary data accuracy\n2. Monitor distribution process\n3. Interview beneficiaries\n4. Document irregularities if any",
                'result' => 'Visited 4 distribution points across 4 sub-districts. Found 12 cases of inaccurate beneficiary data. Distribution process generally orderly with minor delays.',
                'recommendation' => 'Report data inaccuracies to social affairs department. Propose beneficiary data verification mechanism. Schedule follow-up visit in 2 weeks.',
                'participants_count' => 350,
                'status' => 'approved',
            ],
            [
                'user_id' => $councilUsers->random(),
                'title' => 'Community Aspiration Hearing on Market Revitalization',
                'description' => 'Hearing session to collect community aspirations regarding the planned traditional market revitalization project.',
                'report_type' => 'aspiration',
                'activity_date' => '2026-04-28',
                'start_time' => '10:00',
                'end_time' => '13:00',
                'location' => 'Pasar Minggu Community Hall, South Jakarta',
                'agenda' => "1. Presentation of revitalization plan\n2. Merchant concerns and input\n3. Relocation timeline discussion\n4. Compensation and facility planning",
                'result' => '85 merchants attended. Main concerns: temporary relocation arrangements, compensation fairness, and new stall allocation. Community generally supports revitalization with conditions.',
                'recommendation' => 'Ensure transparent stall allocation process. Provide temporary market space within 500m radius. Establish merchant liaison committee for ongoing communication.',
                'participants_count' => 85,
                'status' => 'submitted',
            ],
            [
                'user_id' => $councilUsers->random(),
                'title' => 'Emergency Response Meeting - Flood Aftermath',
                'description' => 'Emergency coordination meeting to discuss response and recovery efforts following severe flooding in several districts.',
                'report_type' => 'meeting',
                'activity_date' => '2026-03-15',
                'start_time' => '14:00',
                'end_time' => '17:30',
                'location' => 'DPRD Building, Bekasi',
                'agenda' => "1. Damage assessment report\n2. Evacuation center status\n3. Aid distribution coordination\n4. Long-term flood prevention plan",
                'result' => '3 districts severely affected with over 500 displaced families. Aid distribution coordinated with BNPB and local NGOs. Immediate infrastructure repair prioritized.',
                'recommendation' => 'Allocate emergency budget for immediate relief. Propose river normalization project in next fiscal year. Establish early warning system in flood-prone areas.',
                'participants_count' => 60,
                'status' => 'approved',
            ],
            [
                'user_id' => $councilUsers->random(),
                'title' => 'Health Facility Inspection Report',
                'description' => 'Routine inspection of public health facilities (Puskesmas) to evaluate service quality and equipment readiness.',
                'report_type' => 'supervision',
                'activity_date' => '2026-04-10',
                'start_time' => '08:00',
                'end_time' => '14:00',
                'location' => 'Various Puskesmas, Depok City',
                'agenda' => "1. Staff availability check\n2. Medical equipment inspection\n3. Medicine stock verification\n4. Patient satisfaction survey",
                'result' => 'Visited 5 Puskesmas. 2 facilities have understaffed conditions. Medical equipment at 3 locations needs maintenance. Medicine stock adequate but specific items running low.',
                'recommendation' => 'Request additional healthcare staff deployment. Coordinate equipment maintenance with health department. Ensure timely medicine procurement before stock runs out.',
                'participants_count' => 30,
                'status' => 'draft',
            ],
            [
                'user_id' => $councilUsers->random(),
                'title' => 'Farmer Community Outreach Program',
                'description' => 'Outreach program to discuss agricultural subsidies, modern farming techniques, and market access for local farmers.',
                'report_type' => 'other',
                'activity_date' => '2026-04-05',
                'start_time' => '09:00',
                'end_time' => '12:30',
                'location' => 'Village Hall, Karawang, West Java',
                'agenda' => "1. Agricultural subsidy program overview\n2. Modern farming technique introduction\n3. Market access and cooperative formation\n4. Open discussion with farmers",
                'result' => '75 farmers attended from 8 villages. High interest in organic farming techniques. Farmers requested assistance with market access and fair pricing mechanisms.',
                'recommendation' => 'Facilitate farmer cooperative establishment. Coordinate with agricultural department for training programs. Explore partnership with local supermarket chains for direct sourcing.',
                'participants_count' => 75,
                'status' => 'submitted',
            ],
        ];

        foreach ($reports as $report) {
            $createdAt = fake()->dateTimeBetween('-1 year', 'now');
            $report['created_at'] = $createdAt;
            $report['updated_at'] = $createdAt;
            CouncilReport::create($report);
        }
    }
}
