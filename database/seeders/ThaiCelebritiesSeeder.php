<?php

namespace Database\Seeders;

class ThaiCelebritiesSeeder extends BaseCelebritySeeder
{
    private array $maleFirstNames = [
        'Somchai', 'Somsak', 'Somboon', 'Prasert', 'Thongchai',
        'Chai', 'Somkid', 'Prayuth', 'Boonlert', 'Kriangkrai',
        'Adisak', 'Boonthong', 'Charoen', 'Decha', 'Ek',
        'Foo', 'Gan', 'Hong', 'Itthipat', 'Jakkaphan',
        'Kampol', 'Lek', 'Manas', 'Narin', 'Ong',
        'Paisan', 'Rung', 'Santi', 'Thawat', 'Udom',
        'Veera', 'Wichai', 'Yod', 'Anan', 'Bunjong',
        'Chartchai', 'Damrong', 'Ekachai', 'Fuang', 'Grissana',
        'Hatai', 'Jaroen', 'Kiatisak', 'Lertsak', 'Mongkol',
        'Narong', 'Opart', 'Pichai', 'Rachan', 'Sakchai',
        'Thaweesak', 'Ukrit', 'Viroj', 'Winai', 'Yutthana',
        'Arthit', 'Banyat', 'Chalerm', 'Dokrak', 'Ekaphol',
        'Gor', 'Hiran', 'Jirawat', 'Kraiwit', 'Lap',
        'Manit', 'Nirut', 'Opas', 'Pichet', 'Rit',
        'Sathit', 'Tham', 'Uthai', 'Vicharn', 'Worapot',
        'Anusorn', 'Buddhi', 'Chuchart', 'Det', 'Ekachai',
        'Gard', 'Hansa', 'Jumrus', 'Kong', 'Luan',
    ];

    private array $femaleFirstNames = [
        'Somsri', 'Anong', 'Supaporn', 'Nongnuch', 'Malee',
        'Pranee', 'Wilai', 'Suda', 'Ratchanok', 'Narumon',
        'Boonsri', 'Chanida', 'Darunee', 'Emsiri', 'Fah',
        'Ganda', 'Hatairat', 'Jintana', 'Kannika', 'Ladda',
        'Malai', 'Nampueng', 'Orasa', 'Pensri', 'Rungtip',
        'Saipin', 'Thanyarat', 'Ubontip', 'Vilai', 'Wanida',
        'Yupin', 'Achara', 'Buppha', 'Chompu', 'Duangjai',
        'Emmie', 'Fon', 'Ganda', 'Hathairat', 'Intira',
        'Jaruwan', 'Kesinee', 'Lamai', 'Maneerat', 'Napaporn',
        'Orawan', 'Pattama', 'Rattana', 'Saowalak', 'Tassanee',
        'Uraiwan', 'Varaporn', 'Wiphada', 'Yada', 'Amara',
        'Bangon', 'Chantana', 'Daranee', 'Eka', 'Fang',
        'Gift', 'Hansa', 'Issaree', 'Janya', 'Kanya',
        'Lalita', 'Mali', 'Nalinee', 'Ora', 'Pim',
        'Rungnapa', 'Sasithorn', 'Tanaporn', 'Ubon', 'Vimol',
        'Waraporn', 'Yaowalak', 'Arada', 'Bua', 'Chalassaya',
        'Dok', 'Gaew', 'Him', 'Jit', 'Kwang',
    ];

    private array $lastNames = [
        'Saelim', 'Panya', 'Singh', 'Saeli', 'Chaiyaporn',
        'Kongkaew', 'Saetang', 'Vong', 'Saetia', 'Prathan',
        'Kham', 'Suksri', 'Somchai', 'Wong', 'Charean',
        'Phrom', 'Saejong', 'Boonmee', 'Chaisiri', 'Daeng',
        'Intaraprasert', 'Jindarat', 'Ketkaew', 'Laohaprasit', 'Meesuk',
        'Nakarin', 'Ounsin', 'Phatthana', 'Rith', 'Saechio',
        'Thongdee', 'Udomporn', 'Viwat', 'Wongpanya', 'Yossiri',
        'Arun', 'Bunluesin', 'Chanthara', 'Dokmai', 'Eksiri',
        'Fuang', 'Ganchai', 'Hiranpradit', 'Issara', 'Jaidee',
        'Kam', 'Leelawadee', 'Meechai', 'Na', 'Onsiri',
        'Preecha', 'Rak', 'Saen', 'Thongkham', 'Uthai',
        'Vanich', 'Ying', 'Anan', 'Boonyarat', 'Chandara',
        'Dee', 'Eua', 'Fah', 'Glin', 'Hongthong',
        'Intharat', 'Jit', 'Kong', 'Lek', 'Man',
        'Nimit', 'Orn', 'Pikul', 'Rung', 'Sri',
        'Tong', 'Wan', 'Yot', 'Amnuai', 'Bunsin',
        'Chonlada', 'Duang', 'Ek', 'Ging', 'Hom',
        'Itsar', 'Jan', 'Kwan', 'Lap', 'Muk',
        'Noi', 'Op', 'Pla', 'Ram', 'Som',
        'Tiew', 'Uan', 'Wai', 'Yong', 'Bua',
        'Chom', 'Duan', 'Fon', 'Gam', 'Him',
    ];

    public function run(): void
    {
        set_time_limit(0);
        $country = 'Thailand';

        $this->command?->info("Seeding {$country}...");

        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 500), 'movie_star', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 500), 'movie_star', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 200), 'musician', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 200), 'musician', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 50), 'country_singer', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 50), 'country_singer', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 100), 'adult_star', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 100), 'adult_star', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 150), 'general', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 150), 'general', 'female', $country);

        $this->command?->info("{$country} seeding complete.");
    }
}
