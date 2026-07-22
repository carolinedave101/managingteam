<?php

namespace Database\Seeders;

class JapaneseCelebritiesSeeder extends BaseCelebritySeeder
{
    private array $maleFirstNames = [
        'Hiroshi', 'Takeshi', 'Kenji', 'Satoshi', 'Yoshiki',
        'Taro', 'Shinji', 'Koji', 'Ryo', 'Kazuki',
        'Daiki', 'Haruki', 'Yuto', 'Sota', 'Kaito',
        'Ren', 'Yamato', 'Sora', 'Hinata', 'Minato',
        'Ryota', 'Sho', 'Takumi', 'Kenta', 'Tsubasa',
        'Akira', 'Makoto', 'Isamu', 'Tetsuya', 'Noboru',
        'Osamu', 'Mamoru', 'Susumu', 'Yukio', 'Hideki',
        'Kunio', 'Masao', 'Shigeru', 'Takeo', 'Fumio',
        'Hajime', 'Jiro', 'Katsuo', 'Masaru', 'Shiro',
        'Akio', 'Eiji', 'Goro', 'Hideo', 'Iwao',
        'Kazuo', 'Minoru', 'Norio', 'Rokuro', 'Saburo',
        'Toshiro', 'Umeo', 'Yoshio', 'Zenji', 'Atsushi',
        'Daisuke', 'Fumihiko', 'Genji', 'Hitoshi', 'Katsuya',
        'Masashi', 'Nagisa', 'Ryuichi', 'Shun', 'Tadahiro',
        'Wataru', 'Yuichi', 'Asuka', 'Hayato', 'Keita',
        'Naoki', 'Rikuto', 'Shota', 'Taiga', 'Yuma',
    ];

    private array $femaleFirstNames = [
        'Yuki', 'Sakura', 'Haruka', 'Aoi', 'Hina',
        'Rin', 'Yua', 'Miyu', 'Riko', 'Mei',
        'Yuna', 'Akari', 'Moe', 'Misa', 'Nana',
        'Yui', 'Sora', 'Aya', 'Miki', 'Kana',
        'Ayumi', 'Rina', 'Mai', 'Eri', 'Yuka',
        'Miyabi', 'Natsuki', 'Marina', 'Yoshino', 'Chie',
        'Tomoko', 'Keiko', 'Yoshiko', 'Fumiko', 'Kazuko',
        'Setsuko', 'Hisako', 'Toshiko', 'Sachiko', 'Yasuko',
        'Midori', 'Miyoko', 'Hideko', 'Masako', 'Reiko',
        'Kimiko', 'Harumi', 'Shizuka', 'Akemi', 'Megumi',
        'Anzu', 'Rin', 'Suzu', 'Ume', 'Tsubaki',
        'Sumire', 'Ayame', 'Kiku', 'Botan', 'Fuji',
        'Iris', 'Lily', 'Momo', 'Ran', 'Yuri',
        'Airi', 'Erika', 'Kotone', 'Mizuki', 'Nagi',
        'Reina', 'Sayo', 'Tsukiko', 'Kohana', 'Miyabi',
        'Tamami', 'Yoshimi', 'Chiharu', 'Nobuko', 'Teruyo',
    ];

    private array $lastNames = [
        'Sato', 'Suzuki', 'Takahashi', 'Tanaka', 'Watanabe',
        'Ito', 'Yamamoto', 'Nakamura', 'Ogawa', 'Kato',
        'Yoshida', 'Yamada', 'Sasaki', 'Yamaguchi', 'Matsumoto',
        'Inoue', 'Kimura', 'Shimizu', 'Hayashi', 'Saito',
        'Kobayashi', 'Morita', 'Sakamoto', 'Aoki', 'Fujita',
        'Ishikawa', 'Nakajima', 'Maeda', 'Fujii', 'Ono',
        'Nishimura', 'Kondo', 'Nakagawa', 'Tamura', 'Hara',
        'Ueda', 'Taniguchi', 'Kawakami', 'Ishii', 'Yoshimura',
        'Okada', 'Yamashita', 'Ando', 'Endo', 'Nakano',
        'Sugiyama', 'Kikuchi', 'Sato', 'Sato', 'Kudo',
        'Miyazaki', 'Tsuji', 'Ikeda', 'Nishida', 'Hasegawa',
        'Katsura', 'Yagami', 'Fujiwara', 'Kawaguchi', 'Yamazaki',
        'Murakami', 'Miyamoto', 'Hashimoto', 'Shinoda', 'Wada',
        'Kishimoto', 'Otsuka', 'Noguchi', 'Sakurai', 'Mori',
        'Yoshino', 'Sato', 'Kojima', 'Takeda', 'Sakaguchi',
        'Ishida', 'Kuroda', 'Shibata', 'Ogata', 'Abe',
        'Matsushita', 'Kane', 'Hashida', 'Kita', 'Seki',
        'Yano', 'Baba', 'Kanno', 'Yokoyama', 'Naito',
        'Oishi', 'Nishiyama', 'Shirai', 'Kumagai', 'Tsuchiya',
        'Matsuda', 'Shinohara', 'Tamura', 'Sano', 'Sugimoto',
        'Fukuda', 'Iwasaki', 'Yoshimura', 'Yamane', 'Takeuchi',
        'Komatsu', 'Nakayama', 'Kato', 'Wakabayashi', 'Nishikawa',
    ];

    public function run(): void
    {
        set_time_limit(0);
        $country = 'Japan';

        $this->command?->info("Seeding {$country}...");

        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 1000), 'movie_star', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 1000), 'movie_star', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 400), 'musician', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 400), 'musician', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 100), 'country_singer', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 100), 'country_singer', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 250), 'adult_star', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 250), 'adult_star', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 250), 'general', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 250), 'general', 'female', $country);

        $this->command?->info("{$country} seeding complete.");
    }
}
