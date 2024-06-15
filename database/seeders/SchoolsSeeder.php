<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schools;


class SchoolsSeeder extends Seeder
{

    public function run(): void
    {

    // List scrapped from
    // https://en.wikipedia.org/wiki/List_of_universities_in_Nigeria
    $schoolList = [
      "Abia State University",
      "Abubakar Tafawa Balewa University",
      "Achievers University",
      "Adamawa State University",
      "Adekunle Ajasin University",
      "Adeleke University",
      "Afe Babalola University",
      "Ahmadu Bello University",
      "Ajayi Crowther University",
      "Akwa Ibom State University (formerly Akwa Ibom State University of Science and Technology)",
      "Al-Hikmah University",
      "Ambrose Alli University",
      "American University of Nigeria",
      "Bauchi State University",
      "Babcock University",
      "Bayero University",
      "Baze University",
      "Bells University of Technology",
      "Benson Idahosa University",
      "Benue State University",
      "Bowen University",
      "Bukar Abba Ibrahim University",
      "Caleb University",
      "Caritas University",
      "CETEP City University",
      "Chukwuemeka Odumegwu Ojukwu University (formerly Anambra State University)",
      "City University of Technology",
      "Covenant University",
      "Crawford University",
      "Crawford University",
      "Crescent University",
      "University of Cross River State (formerly Cross River University of Technology)",
      "Delta State University, Abraka",
      "Delta State University of Science and Technology, Ozoro",
      "Dennis Osadebe University, Asaba",
      "Ebonyi State University",
      "ECWA Bingham University",
      "Edo State University",
      "Elizade University",
      "Enugu State University of Science and Technology (formerly Anambra State University of Technology)",
      "Evangel University, Akaeze",
      "Federal University of Agriculture, Abeokuta",
      "Federal University Oye-Ekiti",
      "Federal University, Dutsin-Ma",
      "Federal University, Gusau",
      "Federal University of Technology Akure",
      "Federal University Ndufe Alike, Ikwo",
      "Federal University of Technology Owerri",
      "Fountain University, Osogbo",
      "Godfrey Okoye University",
      "Gregory University",
      "Igbinedion University",
      "Joseph Ayo Babalola University",
      "Kings University",
      "Koladaisi University",
      "Lagos State University",
      "Landmark University",
      "Michael and Cecilia Ibru University",
      "Nasarawa State University",
      "National Open University of Nigeria",
      "Nile University of Nigeria",
      "Nnamdi Azikiwe University, Awka",
      "Obafemi Awolowo University",
      "Oduduwa University",
      "Philomath University",
      "Plateau State University",
      "Redeemer's University Nigeria",
      "Skyline University Nigeria",
      "Taraba State University",
      "Umaru Musa Yar'adua University Katsina",
      "University of Benin",
      "University of Calabar",
      "University of Delta, Agbor",
      "University of Ibadan",
      "University of Jos",
      "University of Lagos",
      "University of Nigeria, Nsukka",
      "University of Port Harcourt",
      "Veritas University (Catholic University of Nigeria) Abuja",
      "Westland University, Iwo"
    ];

        foreach($schoolList as $item){
            $school = new Schools();
            $school->name = $item;
            $school->save();
        }

    }
}
