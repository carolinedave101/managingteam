<?php

namespace Database\Seeders;

class SouthKoreanCelebritiesSeeder extends BaseCelebritySeeder
{
    private array $maleFirstNames = [
        'Minho', 'Jinho', 'Sangho', 'Young', 'Hyun',
        'Sung', 'Jae', 'Kyung', 'Seok', 'Woo',
        'Taeyang', 'Jihoon', 'Junseo', 'DoHyun', 'Seung',
        'Joon', 'Hwan', 'Chul', 'Soo', 'Ki',
        'Dong', 'Gyu', 'Hee', 'Ho', 'Hwa',
        'Il', 'Jin', 'Kang', 'Man', 'Myung',
        'Ok', 'Phil', 'Shik', 'Tae', 'Uk',
        'Wan', 'Yong', 'Jung', 'Chan', 'Gun',
        'Hyuk', 'Jong', 'Kap', 'Kwang', 'Moon',
        'Nak', 'Pyung', 'Ryun', 'Shin', 'Won',
        'Bong', 'Chi', 'Eung', 'Geun', 'Ik',
        'Jang', 'Kee', 'Nam', 'Pal', 'Ryul',
        'Sik', 'Un', 'Yun', 'Bo', 'Doo',
        'Eon', 'Gap', 'Hak', 'In', 'Jo',
        'Kil', 'Lak', 'No', 'Pan', 'Sal',
        'Sul', 'Wi', 'Yop', 'Baek', 'Cheol',
    ];

    private array $femaleFirstNames = [
        'Soo', 'Young', 'Mi', 'Hye', 'Kyung',
        'Eun', 'Jin', 'Sun', 'Hee', 'Sook',
        'Ah', 'Ok', 'Ran', 'Hwa', 'Ja',
        'Suk', 'Nan', 'Bok', 'Rye', 'Soon',
        'Hee', 'Yun', 'Bin', 'Chae', 'Dam',
        'Gyeong', 'Ha', 'Im', 'Ju', 'Kkot',
        'Mal', 'Nim', 'Ri', 'Sin', 'Wol',
        'Yang', 'Boon', 'Duk', 'Geum', 'Hyang',
        'Jeong', 'Kil', 'Lye', 'Mae', 'Nyeo',
        'Pok', 'Sam', 'Ui', 'Yeon', 'Jung',
        'Yoon', 'Min', 'Seo', 'Na', 'Hye',
        'Yoo', 'Ji', 'Su', 'Won', 'Ae',
        'Byul', 'Dan', 'Eum', 'Gom', 'In',
        'Lan', 'Mi', 'Nul', 'Pi', 'Seul',
        'Yul', 'Bit', 'Dong', 'Gang', 'Hak',
        'Kkul', 'Mok', 'Nae', 'San', 'Ye',
        'Bae', 'Cho', 'Do', 'Gang', 'Joo',
        'Kyul', 'Lil', 'Myo', 'Nok', 'Sol',
    ];

    private array $lastNames = [
        'Kim', 'Lee', 'Park', 'Choi', 'Jung',
        'Kang', 'Jo', 'Yoon', 'Chang', 'Jang',
        'Lim', 'Han', 'Oh', 'Shin', 'Seo',
        'Kwon', 'Hwang', 'Ahn', 'Song', 'Yoo',
        'Hong', 'Jeon', 'Go', 'Moon', 'Yang',
        'Bae', 'Baek', 'Heo', 'Nam', 'Noh',
        'Ryu', 'Min', 'Jin', 'Bong', 'Chun',
        'Do', 'Eom', 'Guk', 'Joo', 'Ma',
        'Pan', 'Pyo', 'Sim', 'Son', 'Wi',
        'Woo', 'Yun', 'Byun', 'Cha', 'Dong',
        'Gang', 'Geum', 'Gong', 'Gu', 'Ha',
        'Hyun', 'Im', 'Jang', 'Je', 'Kong',
        'Koo', 'Kwon', 'Na', 'Nah', 'Pae',
        'Pi', 'Po', 'Ra', 'Roh', 'Sang',
        'Sok', 'Sung', 'Tak', 'Tan', 'Uhm',
        'Wang', 'Won', 'Yeom', 'Yong', 'Yoon',
        'Ban', 'Bok', 'Boo', 'Byeok', 'Chu',
        'Duk', 'Eun', 'Gal', 'Ge', 'Gye',
        'Hahm', 'Hwangbo', 'Jegal', 'Jin', 'Ju',
        'Ki', 'Kil', 'Kum', 'Lyo', 'Mi',
        'Mok', 'Mu', 'Myung', 'Nang', 'No',
        'Ok', 'On', 'Paeng', 'Pung', 'Ra',
        'Sah', 'Sa', 'Sam', 'Seon', 'Seung',
        'Si', 'Tak', 'To', 'Won', 'Yeon',
    ];

    public function run(): void
    {
        set_time_limit(0);
        $country = 'South Korea';

        $this->command?->info("Seeding {$country}...");

        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 500), 'movie_star', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 500), 'movie_star', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 400), 'musician', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 400), 'musician', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 100), 'country_singer', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 100), 'country_singer', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 200), 'adult_star', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 200), 'adult_star', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 300), 'general', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 300), 'general', 'female', $country);

        $this->command?->info("{$country} seeding complete.");
    }
}
