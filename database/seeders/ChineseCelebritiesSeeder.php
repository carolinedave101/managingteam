<?php

namespace Database\Seeders;

class ChineseCelebritiesSeeder extends BaseCelebritySeeder
{
    public function run(): void
    {
        set_time_limit(0);
        $country = 'China';

        $this->command?->info("Seeding {$country}...");

        $this->createCelebrities([
            'Jackie Chan', 'Jet Li', 'Tony Leung', 'Yao Ming',
            'Zhao Wei', 'Donnie Yen', 'Chow Yun-fat', 'Zhang Yimou',
            'Gong Li', 'Ziyi Zhang', 'Andy Lau', 'Stephen Chow',
            'Leon Lai', 'Aaron Kwok', 'Jacky Cheung', 'Leslie Cheung',
            'Kaneshiro Takeshi', 'Wang Leehom', 'Jay Chou', 'Zhan Liguo',
        ], 'movie_star', 'male', $country);

        $this->createCelebrities([
            'Gong Li', 'Ziyi Zhang', 'Michelle Yeoh', 'Liu Yifei',
            'Fan Bingbing', 'Zhou Xun', 'Tang Wei', 'Li Bingbing',
            'Zhang Ziyi', 'Xu Jinglei', 'Zhao Wei', 'Maggie Cheung',
            'Joey Wong', 'Brigitte Lin', 'Cecilia Cheung', 'Liu Xiaoqing',
            'Nina Li', 'Rosamund Kwan', 'Cherie Chung', 'Anita Mui',
        ], 'movie_star', 'female', $country);

        $this->createCelebrities([
            'Jay Chou', 'Jacky Cheung', 'Leslie Cheung', 'Andy Lau',
            'Eason Chan', 'Wang Leehom', 'Joker Xue', 'Aaron Kwok',
            'Leon Lai', 'Zhou Shen', 'Hua Chenyu', 'Li Ronghao',
            'Mao Buyi', 'Zhang Jie', 'Wang Feng', 'Li Yundi',
            'Lang Lang', 'Tan Dun', 'Cui Jian', 'Song Dongye',
        ], 'musician', 'male', $country);

        $this->createCelebrities([
            'Faye Wong', 'Jolin Tsai', 'Jolin Cai', 'Na Ying',
            'Xu Wei', 'Hebe Tien', 'Teresa Teng', 'Anita Mui',
            'Sandy Lam', 'Kelly Chen', 'Miriam Yeung', 'Gigi Leung',
            'Karen Mok', 'Coco Lee', 'Fish Leong', 'Zhang Bichen',
            'Zhou Bichang', 'Jane Zhang', 'LaLa Hsu', 'A-mei',
        ], 'musician', 'female', $country);

        $this->createCelebrities([
            'Yao Ming', 'Jackie Chan', 'Allen Hei', 'David Chen',
            'Li Donglin', 'Wang Tai', 'Chang Yu', 'Song Yang',
            'Wang Han', 'Zhang Lei',
        ], 'country_singer', 'male', $country);

        $this->createCelebrities([
            'Song Zuying', 'Peng Liyuan', 'Lei Jia', 'Zhang Ye',
            'Tan Zhengzhen', 'Chen Sisi', 'Wang Yizheng', 'Li Lingyu',
            'Qin Yong', 'Tan Li',
        ], 'country_singer', 'female', $country);

        $this->createCelebrities([
            'Wang Jie', 'Li Zong', 'Zhang Fan', 'Chen Linong',
            'Wu Yifan', 'Liu Hao', 'Yang Kai', 'Lin Junjie',
            'Deng Chao', 'Li Chen',
        ], 'adult_star', 'male', $country);

        $this->createCelebrities([
            'Mimi Miyagi', 'Momo Wang', 'Liu Yan', 'Yoko Matsugane',
            'Lin Chi-ling', 'Tang Yan', 'Amber Kuo', 'Kathy Chow',
        ], 'adult_star', 'female', $country);

        $this->createCelebrities([
            'Yao Ming', 'Liu Xiang', 'Lin Dan', 'Sun Yang',
            'Ma Long', 'Zhang Jike', 'Ding Junhui', 'Wang Hao',
            'Zou Shiming', 'Wu Jing', 'Li Na', 'Yang Yang',
            'Xu Haifeng', 'Zhu Ting', 'Lang Ping', 'Wang Meng',
        ], 'general', 'male', $country);

        $this->createCelebrities([
            'Li Na', 'Zhu Ting', 'Zhang Yining', 'Wang Nan',
            'Deng Yaping', 'Fu Mingxia', 'Guo Jingjing', 'Wu Minxia',
            'Chen Ruolin', 'Ye Shiwen', 'Yang Qian', 'Quan Hongchan',
        ], 'general', 'female', $country);

        $this->command?->info("{$country} seeding complete.");
    }
}
