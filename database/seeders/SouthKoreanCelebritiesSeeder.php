<?php

namespace Database\Seeders;

class SouthKoreanCelebritiesSeeder extends BaseCelebritySeeder
{
    public function run(): void
    {
        set_time_limit(0);
        $country = 'South Korea';

        $this->command?->info("Seeding {$country}...");

        $this->createCelebrities([
            'Song Kang-ho', 'Lee Byung-hun', 'Gong Yoo', 'Kim Dong-hee',
            'Park Seo-joon', 'Hyun Bin', 'Jo In-sung', 'Won Bin',
            'Jang Dong-gun', 'Choi Min-sik', 'Sol Kyung-gu', 'Lee Jung-jae',
            'Jung Woo-sung', 'Yoo Ah-in', 'Kim Woo-bin', 'Park Bo-gum',
            'Song Joong-ki', 'Kim Soo-hyun', 'Lee Min-ho', 'Ma Dong-seok',
        ], 'movie_star', 'male', $country);

        $this->createCelebrities([
            'Kim Tae-ri', 'Jun Ji-hyun', 'Kim Hye-soo', 'Son Ye-jin',
            'Song Hye-kyo', 'Kim Go-eun', 'Bae Doona', 'Youn Yuh-jung',
            'Park Shin-hye', 'Lee Jung-eun', 'Jang Hyuk', 'Ha Ji-won',
            'Lee Young-ae', 'Kim Hee-ae', 'Moon So-ri', 'Jeon Do-yeon',
            'Kim Min-hee', 'Kim Ok-bin', 'Go Hyun-jung', 'Kim Nam-joo',
        ], 'movie_star', 'female', $country);

        $this->createCelebrities([
            'RM', 'Jin', 'SUGA', 'j-hope',
            'Jimin', 'V', 'Jungkook', 'PSY',
            'IU', 'G-Dragon', 'Taeyang', 'Zico',
            'CL', 'Seventeen', 'EXO', 'Stray Kids',
            'NCT', 'Leeteuk', 'Lee Seung-gi', 'Rain',
        ], 'musician', 'male', $country);

        $this->createCelebrities([
            'Jennie', 'Lisa', 'Jisoo', 'Rosé',
            'IU', 'Sunmi', 'Hyuna', 'Taeyeon',
            'Yoona', 'BoA', 'Chung-ha', 'Heize',
            'Ailee', 'Jeon Somi', 'Hwasa', 'Solar',
            'Moonbyul', 'Wheein', 'Seulgi', 'Irene',
        ], 'musician', 'female', $country);

        $this->createCelebrities([
            'Lim Young-woong', 'Kim Ho-joong', 'Lee Chan-won', 'Jang Min-ho',
            'Park Seung-il', 'Yoon Tae-jin', 'Jung Dong-won', 'Kim Soo-chan',
            'Na Hoon-a', 'Tae Jin-ah',
        ], 'country_singer', 'male', $country);

        $this->createCelebrities([
            'Jang Yoon-jung', 'Hong Ji-yoon', 'Kim Seol-ah', 'Song Ga-in',
            'Kwak Eun-ju', 'Kim Young-ja', 'Lee Mi-ja', 'Lee Eun-ha',
            'Yoo Ji-na', 'Kim Hye-won',
        ], 'country_singer', 'female', $country);

        $this->createCelebrities([
            'Kim Hyun-ki', 'Park Dong-jin', 'Lee Sang-woo', 'Seo Yoon-jun',
            'Jang Min-ho', 'Choi Woo', 'Jang Hoon', 'Kim Tae-yong',
        ], 'adult_star', 'male', $country);

        $this->createCelebrities([
            'Kim Hyun-ah', 'Lee Da-hye', 'Yoo Na-mi', 'Kang Hye-jung',
            'Seo Yoon', 'Park Gi-ryun', 'Oh Hee-young', 'Bae Soo-kyung',
        ], 'adult_star', 'female', $country);

        $this->createCelebrities([
            'Son Heung-min', 'Kim Yuna', 'Ryu Hyun-jin', 'BTS',
            'Son Ye-jin', 'Park Chan-wook', 'Bong Joon-ho', 'Ban Ki-moon',
            'Kim Jong-un', 'Lee Kun-hee', 'Shin Seung-hwan', 'Park Tae-hwan',
            'Kim Seung-woo', 'Lee Seung-yoon', 'Ahn Jung-hwan', 'Cha Seung-gi',
        ], 'general', 'male', $country);

        $this->createCelebrities([
            'Kim Yuna', 'Son Ye-jin', 'Choi Min-ji', 'Park Ji-sung',
            'Kim Sie-yeon', 'Yoon Chae-kyung', 'Ahn So-hee', 'Go Hye-sun',
            'Kim Joo-eun', 'Lee Bo-young', 'Kang So-ra', 'Park Bo-young',
        ], 'general', 'female', $country);

        $this->command?->info("{$country} seeding complete.");
    }
}
