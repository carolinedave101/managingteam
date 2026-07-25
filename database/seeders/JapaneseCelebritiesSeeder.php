<?php

namespace Database\Seeders;

class JapaneseCelebritiesSeeder extends BaseCelebritySeeder
{
    public function run(): void
    {
        set_time_limit(0);
        $country = 'Japan';

        $this->command?->info("Seeding {$country}...");

        $this->createCelebrities([
            'Ken Watanabe', 'Toshiro Mifune', 'Hiroyuki Sanada', 'Tadanobu Asano',
            'Ryunosuke Kamiki', 'Shohei Ohtani', 'Sosuke Ikematsu', 'Masaharu Fukuyama',
            'Hiroshi Abe', 'Yoshio Harada', 'Eita Nagayama', 'Shun Oguri',
            'Satoshi Tsumabuki', 'Ryo Kase', 'Goro Inagaki', 'Masanobu Ando',
            'Takahiro Nishijima', 'Hiroshi Tamaki', 'Takao Osawa', 'Yōsuke Eguchi',
        ], 'movie_star', 'male', $country);

        $this->createCelebrities([
            'Rinko Kikuchi', 'Machiko Ono', 'Aoi Miyazaki', 'Haru Kuroki',
            'Sakura Ando', 'Sakurako Ohara', 'Masami Nagasawa', 'Kou Shibasaki',
            'Yui Aragaki', 'Ryoko Hirosue', 'Takako Matsu', 'Sayuri Yoshinaga',
            'Kyoko Kagawa', 'Setsuko Hara', 'Hideko Takamine', 'Kinuyo Tanaka',
            'Mitsuko Baisho', 'Miyuki Yano', 'Nana Komatsu', 'Aya Ueto',
        ], 'movie_star', 'female', $country);

        $this->createCelebrities([
            'Ryuichi Sakamoto', 'Joe Hisaishi', 'Takeshi Kitano', 'Hikaru Utada',
            'Kenshi Yonezu', 'Yoshiki', 'Takanori Nishikawa', 'Ken Hirai',
            'Masaharu Fukuyama', 'Kazumasa Oda', 'Tatsuro Yamashita', 'Miyavi',
            'Koji Wada', 'Gackt', 'HYDE', 'Daigo',
            'Nobuaki Kakuda', 'Perfume', 'Kazama Kyosuke', 'SUGIZO',
        ], 'musician', 'male', $country);

        $this->createCelebrities([
            'Hikaru Utada', 'Miyavi', 'Ayumi Hamasaki', 'Namie Amuro',
            'Kumi Koda', 'Mika Nakashima', 'Maaya Sakamoto', 'Megumi Hayashibara',
            'Yoko Takahashi', 'Yuki Kajiura', 'Yoshino Kimura', 'Mie Nakagawa',
            'Aya Matsuura', 'Miki Fujimoto', 'Rola', 'Miyavi',
            'Chisaki Morishita', 'Yui Horie', 'Rie Kugimiya', 'Aya Hirano',
        ], 'musician', 'female', $country);

        $this->createCelebrities([
            'Minami Kizuki', 'Kiyoshi Hikawa', 'Takeshi Kitayama', 'Ichiro Mizuki',
            'Saburo Kitajima', 'Shinichi Mori', 'Hibari Misora', 'Yujiro Ishihara',
            'Hideo Murata', 'Haruo Minami',
        ], 'country_singer', 'male', $country);

        $this->createCelebrities([
            'Hibari Misora', 'Sayuri Ishikawa', 'Miyako Otsuki', 'Fuyumi Sakamoto',
            'Yoshiko Shimazu', 'Yoshiko Kishi', 'Aki Yashiro', 'Akiko Futaba',
            'Matsu Toshi', 'Kazue Itsuki',
        ], 'country_singer', 'female', $country);

        $this->createCelebrities([
            'Sho Aoyagi', 'Yusuke Kamiyama', 'Tetsuya Ogawa', 'Kaito Ito',
            'Ryoichi Sugiura', 'Daiki Ito', 'Kenji Matsuda', 'Yuya Nishi',
            'Takaaki Hirai', 'Satoshi Maruyama',
        ], 'adult_star', 'male', $country);

        $this->createCelebrities([
            'Sora Aoi', 'Maria Ozawa', 'Yua Mikami', 'Saki Aoyama',
            'Yuna Ogura', 'Moe Hidaka', 'Yui Hatano', 'Ayumi Shinoda',
            'Hitomi Tanaka', 'Asuka Kirara', 'Tomoda Ayaka', 'Konoa Sakura',
        ], 'adult_star', 'female', $country);

        $this->createCelebrities([
            'Shohei Ohtani', 'Ichiro Suzuki', 'Yuzuru Hanyu', 'Naomi Osaka',
            'Hideki Matsuyama', 'Kei Nishikori', 'Kohei Uchimura', 'Hideo Kojima',
            'Shigeru Miyamoto', 'Hayao Miyazaki', 'Yoshinobu Yamamoto', 'Katsuya Nomura',
            'Hiroki Kuroda', 'Yu Darvish', 'Rui Hachimura', 'Momota Kenshi',
        ], 'general', 'male', $country);

        $this->createCelebrities([
            'Naomi Osaka', 'Yuna Kim', 'Mao Asada', 'Saori Yoshida',
            'Ayaka Takahashi', 'Misaki Matsutomo', 'Mariana Yamamoto', 'Kaori Icho',
            'Rino Sashihara', 'Ai Shibata', 'Arisa Tsubata', 'Kiyomi Watanabe',
        ], 'general', 'female', $country);

        $this->command?->info("{$country} seeding complete.");
    }
}
