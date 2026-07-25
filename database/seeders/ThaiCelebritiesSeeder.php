<?php

namespace Database\Seeders;

class ThaiCelebritiesSeeder extends BaseCelebritySeeder
{
    public function run(): void
    {
        set_time_limit(0);
        $country = 'Thailand';

        $this->command?->info("Seeding {$country}...");

        $this->createCelebrities([
            'Tony Jaa', 'Mario Maurer', 'Chakrit Yamnam', 'Nadech Kugimiya',
            'Matt Willis', 'Sonic Saeteurn', 'Ananda Everingham', 'Pong Nawat',
            'Weir Sukollawat', 'Om Akapan', 'Mike Piang', 'Porshe Saran',
            'Toni Rakkaen', 'Grate Warintorn', 'Alek Teeradetch', 'Jirayu La-ongmanee',
            'Son Yuke', 'Ken Theeradeth', 'Tik Jesadaporn', 'Chai Chatayodom',
        ], 'movie_star', 'male', $country);

        $this->createCelebrities([
            'Davika Hoorne', 'Mai Davika', 'Urassaya Sperbund', 'Chompoo Araya',
            'Kim Kimberley', 'Janie Tienphosuwan', 'Aum Patchrapa', 'Kwan Usamanee',
            'Aff Taksaorn', 'Noon Woranuch', 'Matt Peeranee', 'Mint Chalida',
            'Bella Ranee', 'Taew Natapohn', 'Mew Nittha', 'Preem Ranida',
            'Yaya Urassaya', 'Margie Rasri', 'Mo Monchanok', 'Sammy Cowell',
        ], 'movie_star', 'female', $country);

        $this->createCelebrities([
            'Bird Thongchai', 'Mike Piang', 'Nichkhun', 'Bam Bam',
            'Li Zi', 'Ten', 'Kim Jaejoong', 'Kong Huai',
            'Captain Prawit', 'Ryu Ji-hyun', 'Beam', 'James Pramote',
            'Guy', 'Fluke', 'Pawin', 'Pong',
        ], 'musician', 'male', $country);

        $this->createCelebrities([
            'Sunsets', 'Chinnawut', 'Tay Tawan', 'Lydia Sarunrat',
            'Da Endorphine', 'Zani', 'Gift', 'Mona',
            'Jui Warattaya', 'Honey Sri-Udom', 'Pancake', 'Earn',
        ], 'musician', 'female', $country);

        $this->createCelebrities([
            'Bird Thongchai', 'Ken Theerapong', 'Jirasak', 'Phong',
            'Santi', 'Chalit', 'Sakda', 'Thongchai',
            'Preecha', 'Somchai',
        ], 'country_singer', 'male', $country);

        $this->createCelebrities([
            'Sunaree Rachasima', 'Duangporn', 'Tidapan', 'Prai',
            'Sai', 'Orathai', 'Wanida', 'Nok',
            'Somsri', 'Rachanee',
        ], 'country_singer', 'female', $country);

        $this->createCelebrities([
            'Noppadon', 'Surachai', 'Somkiat', 'Prawit',
            'Chaiwat', 'Sathaporn', 'Wanchai', 'Anan',
        ], 'adult_star', 'male', $country);

        $this->createCelebrities([
            'Chonlada', 'Saowalak', 'Pimpisa', 'Nattaya',
            'Siriwan', 'Arada', 'Khamchan', 'Jintana',
        ], 'adult_star', 'female', $country);

        $this->createCelebrities([
            'Buakaw Banchamek', 'Saenchai', 'Tony Jaa', 'Chaiya',
            'Rodtang Jitmuangnon', 'Yodsanklai Fairtex', 'Samart Payakaroon', 'Pongsaklek',
            'Seksan', 'Kongnapa', 'Sompong', 'Panya',
            'Somsak', 'Thongchai', 'Apichatpong Weerasethakul', 'Santi',
        ], 'general', 'male', $country);

        $this->createCelebrities([
            'Nong-O', 'Sylvia von Duuglas-Ittu', 'Jidapa', 'Panipak Wongpattanakit',
            'Ratchanok Inthanon', 'Pornnappan', 'Benyapa', 'Namtarn',
            'Kulwadee', 'Piyawan', 'Sujitra', 'Waraporn',
        ], 'general', 'female', $country);

        $this->command?->info("{$country} seeding complete.");
    }
}
