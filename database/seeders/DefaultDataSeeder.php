<?php

namespace Database\Seeders;

use App\Models\Celebrity;
use App\Models\CelebrityPage;
use App\Models\FanApplication;
use App\Models\MeetGreetEvent;
use App\Models\MeetGreetTicket;
use App\Models\Membership;
use App\Models\MembershipCard;
use App\Models\Message;
use App\Models\PrivateMeetup;
use App\Models\RedirectLink;
use App\Models\SystemConfig;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultDataSeeder extends Seeder
{
    public function run(): void
    {
        // ─── ADMIN ────────────────────────────────────
        $admin = User::firstOrCreate(
            ['email' => 'admin@managingteam.info'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123!'),
                'role' => 'admin',
                'is_verified' => true,
            ]
        );

        // ─── GLOBAL SYSTEM CONFIG ─────────────────────
        SystemConfig::updateOrCreate(['key' => 'membership_tiers'], [
            'value' => [
                ['id' => 'bronze', 'name' => 'Bronze', 'price' => 1000, 'features' => ['Exclusive community access', 'Monthly newsletter', 'Digital membership card', 'Fan badge', 'Direct messaging with management']],
                ['id' => 'silver', 'name' => 'Silver', 'price' => 2500, 'features' => ['Everything in Bronze', 'Monthly Zoom hangout', 'Early access to merch', 'Exclusive photos', 'Priority response to messages']],
                ['id' => 'gold', 'name' => 'Gold', 'price' => 5000, 'features' => ['Everything in Silver', 'Quarterly 1-on-1 chat', 'Signed merchandise', 'Priority meet & greet access', 'Private Discord role', 'Dedicated management contact']],
                ['id' => 'platinum', 'name' => 'Platinum', 'price' => 10000, 'features' => ['Everything in Gold', 'Monthly 1-on-1 video call', 'Private meetup invitations', 'All-access pass', 'Personalized video message', 'Lifetime membership card', '24/7 priority support']],
            ],
        ]);

        SystemConfig::updateOrCreate(['key' => 'payment_methods'], [
            'value' => [
                ['id' => 'bank_transfer', 'name' => 'Bank Transfer', 'description' => 'Direct bank transfer to our account', 'details' => ['Bank: Chase Bank', 'Account Name: Jennie Kim Management LLC', 'Account Number: 1234567890', 'Routing Number: 021000021', 'Reference: Include your email in the memo'], 'instructions' => 'Send the exact amount via bank transfer. Include your email as reference.'],
                ['id' => 'cashapp', 'name' => 'CashApp', 'description' => 'Pay via CashApp', 'details' => ['$Cashtag: $JennieKimMgmt'], 'instructions' => 'Open CashApp and send the exact amount to $JennieKimMgmt. Include your email in the note.'],
                ['id' => 'bitcoin', 'name' => 'Bitcoin', 'description' => 'Pay with Bitcoin (BTC)', 'details' => ['BTC Address: bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh', 'Network: Bitcoin (BTC)'], 'instructions' => 'Send the exact BTC equivalent of the USD amount to the address above.'],
            ],
        ]);

        // ─── CELEBRITY 1: JENNIE KIM ──────────────────
        $jennie = $this->createJennie($admin);

        // ─── CELEBRITY 2: JUNGKOOK ────────────────────
        $jungkook = $this->createJungkook($admin);

        // ─── CELEBRITY 3: LISA ─────────────────────────
        $lisa = $this->createLisa($admin);

        // ─── FAN USERS ─────────────────────────────────
        $fans = $this->createFans($jennie, $jungkook, $lisa);

        // ─── FAN APPLICATIONS ─────────────────────────
        $this->createApplications($fans, $jennie, $jungkook, $lisa, $admin);

        // ─── MEMBERSHIPS ──────────────────────────────
        $this->createMemberships($fans, $jennie, $jungkook, $lisa);

        // ─── MEET & GREET EVENTS ──────────────────────
        $this->createEvents($jennie, $jungkook, $lisa, $fans, $admin);

        // ─── MESSAGES ─────────────────────────────────
        $this->createMessages($fans, $jennie, $jungkook, $lisa, $admin);

        // ─── MEMBERSHIP CARDS ─────────────────────────
        $this->createCards($fans, $jennie, $jungkook);

        // ─── PRIVATE MEETUPS ──────────────────────────
        $this->createMeetups($fans, $jennie, $lisa, $admin);

        // ─── REDIRECT LINKS ───────────────────────────
        $this->createRedirectLinks($jennie, $lisa, $admin);

        // ─── CUSTOM PAGES ─────────────────────────────
        $this->createPages($jennie, $jungkook);
    }

    // ══════════════════════════════════════════════════
    //  CELEBRITY BUILDERS
    // ══════════════════════════════════════════════════

    private function createJennie(User $admin): Celebrity
    {
        $c = Celebrity::firstOrCreate(['slug' => 'jennie'], [
            'name' => 'Jennie Kim',
            'bio' => 'Global artist, performer, and fashion icon. Member of BLACKPINK. Known for her powerful stage presence, unique fashion sense, and chart-topping solo work.',
            'social_links' => [
                'instagram' => 'https://instagram.com/jennie',
                'twitter' => 'https://twitter.com/jennie',
                'youtube' => 'https://youtube.com/@jennie',
            ],
            'config' => [
                'site_content' => [
                    'hero_title' => 'Welcome to the<br><span class="gradient-text">Jennie Kim</span><br>Fan Community',
                    'hero_subtitle' => 'Join the most exclusive fan community. Access premium content, attend intimate events, and connect with fellow fans worldwide.',
                    'about_title' => 'About Jennie',
                    'about_body' => '<p>Jennie Kim — known mononymously as Jennie — is a global phenomenon. As a member of BLACKPINK, she has broken countless records and captivated audiences worldwide with her charismatic stage presence and undeniable talent.</p><p>Born in Seoul and educated in New Zealand, Jennie brings a unique global perspective to everything she creates — from music to fashion. Her solo debut "SOLO" topped charts globally, and she continues to push boundaries as both an artist and fashion icon.</p><p>This official fan community is your gateway to exclusive content, private events, and a direct connection to the Jennie Kim experience.</p>',
                    'stats' => [
                        ['value' => '90M+', 'label' => 'Instagram Followers'],
                        ['value' => '15+', 'label' => 'Awards Won'],
                        ['value' => '4', 'label' => 'World Tours'],
                        ['value' => '10', 'label' => 'Years Active'],
                    ],
                    'testimonials' => [
                        ['author' => 'Sarah Mitchell', 'quote' => 'This community is incredible! The meet & greet experience was unforgettable — I got to chat with Jennie personally and she was so warm and genuine.', 'badge' => 'Platinum Member'],
                        ['author' => 'James Kim', 'quote' => 'Being part of this fan club has been amazing. The exclusive content is worth every penny, and the community is so welcoming.', 'badge' => 'Gold Member'],
                        ['author' => 'Emily Chen', 'quote' => 'I joined as a Silver member and upgraded to Gold within a week. The photo exclusives and early event access are fantastic!', 'badge' => 'Gold Member'],
                    ],
                ],
                'theme' => [
                    'primary_color' => '#ec4899',
                    'secondary_color' => '#8b5cf6',
                    'fonts' => [
                        'heading' => 'Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,500',
                        'body' => 'Manrope:wght@400;500;600;700;800',
                    ],
                ],
                'membership_tiers' => [
                    ['name' => 'Silver', 'price' => 19.99, 'color' => '#C0C0C0', 'benefits' => ['Exclusive community access', 'Monthly newsletter', 'Digital membership card', 'Direct messaging with team', 'Fan badge']],
                    ['name' => 'Gold', 'price' => 39.99, 'color' => '#FFD700', 'benefits' => ['Everything in Silver', 'Early access to events', 'Priority messaging', 'Exclusive monthly photos', 'Member-only Discord role']],
                    ['name' => 'Platinum', 'price' => 79.99, 'color' => '#E5E4E2', 'benefits' => ['Everything in Gold', 'Quarterly 1-on-1 chat', 'Signed merchandise', 'Private meetup invitations', 'Dedicated support']],
                ],
                'features' => [
                    'fan_applications' => true,
                    'membership' => true,
                    'meet_greet' => true,
                    'membership_card' => true,
                    'private_meetup' => true,
                    'messaging' => true,
                ],
                'pricing' => [
                    'fan_application_fee' => 25.00,
                    'membership_card_fee' => 15.00,
                    'meet_greet_default_price' => 150.00,
                    'private_meetup' => [
                        ['duration' => 30, 'price' => 10.00],
                        ['duration' => 60, 'price' => 25.00],
                        ['duration' => 90, 'price' => 50.00],
                        ['duration' => 120, 'price' => 100.00],
                    ],
                ],
            ],
            'is_active' => true,
            'created_by' => $admin->id,
        ]);
        $c->fans()->detach();
        $this->seedPaymentMethods($c, [
            ['type' => 'bank_transfer', 'label' => 'Bank Transfer', 'sort_order' => 1, 'details' => ['bank_name' => 'Chase Bank', 'account_name' => 'Jennie Kim Management LLC', 'account_number' => '1234567890', 'swift_code' => 'CHASUS33', 'instructions' => '<h4>How to pay via bank transfer:</h4><ul><li>Use your name as payment reference</li><li>Allow 1-3 business days for processing</li><li>Upload the receipt after transferring</li></ul>']],
            ['type' => 'stripe', 'label' => 'Credit/Debit Card', 'sort_order' => 2],
            ['type' => 'cryptocurrency', 'label' => 'Bitcoin', 'sort_order' => 3, 'details' => ['network' => 'bitcoin', 'wallet_address' => 'bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh', 'instructions' => '<p>Send BTC to the address above. <strong>Minimum: 0.001 BTC</strong>. The QR code is auto-generated from the wallet address.</p>']],
            ['type' => 'paypal', 'label' => 'PayPal', 'sort_order' => 4, 'enabled' => false, 'details' => ['email' => 'jennie@managingteam.info']],
            ['type' => 'offline', 'label' => 'GCash', 'sort_order' => 5, 'details' => ['custom_label' => 'GCash Number: 0917-123-4567', 'instructions' => '<p>Send your payment via GCash to the number above. Take a screenshot of your transaction confirmation and upload it below.</p>']],
        ]);

        return $c;
    }

    private function createJungkook(User $admin): Celebrity
    {
        $c = Celebrity::firstOrCreate(['slug' => 'jungkook'], [
            'name' => 'Jungkook',
            'bio' => 'Singer, dancer, songwriter, and youngest member of BTS. Spreading music and positivity worldwide with his golden voice and infectious energy.',
            'social_links' => [
                'instagram' => 'https://instagram.com/jungkook',
                'twitter' => 'https://twitter.com/jungkook',
                'youtube' => 'https://youtube.com/@jungkook',
            ],
            'config' => [
                'site_content' => [
                    'hero_title' => 'Welcome to<br><span class="gradient-text">Jungkook</span>\'s<br>ARMY Community',
                    'hero_subtitle' => 'Join the global ARMY community. Exclusive content, unforgettable events, and a family of fans united by love for Jungkook\'s music.',
                    'about_title' => 'About Jungkook',
                    'about_body' => '<p>Jeon Jungkook — the golden maknae of BTS — has captured hearts worldwide with his extraordinary vocals, electrifying dance moves, and genuine personality. As the youngest member of BTS, he has grown from a teenage trainee into a global superstar.</p><p>His solo work, including hits like "Euphoria" and "Still With You," showcases his incredible range as an artist. Beyond music, Jungkook is known for his artistic pursuits — from photography to painting to sports.</p><p>This is the official community for ARMY to connect, share, and experience exclusive Jungkook content. We purple you! 💜</p>',
                    'stats' => [
                        ['value' => '65M+', 'label' => 'Instagram Followers'],
                        ['value' => '20+', 'label' => 'Music Awards'],
                        ['value' => '7', 'label' => 'World Tours'],
                        ['value' => '12', 'label' => 'Years Active'],
                    ],
                    'testimonials' => [
                        ['author' => 'Mia Johnson', 'quote' => 'Being part of this Jungkook community is the best decision I ever made! The Diamond membership is absolutely worth it.', 'badge' => 'Diamond Member'],
                        ['author' => 'Daniel Park', 'quote' => 'I\'ve been ARMY since 2017 and this community feels like home. The events are incredible and the team is so responsive.', 'badge' => 'Gold Member'],
                        ['author' => 'Luna Kim', 'quote' => 'The OT7 membership is unreal — I got a signed album and a video call. Jungkook was so sweet!', 'badge' => 'OT7 Member'],
                    ],
                ],
                'theme' => [
                    'primary_color' => '#7c3aed',
                    'secondary_color' => '#c026d3',
                    'fonts' => [
                        'heading' => 'Space+Grotesk:wght@500;600;700',
                        'body' => 'Inter:wght@400;500;600;700',
                    ],
                ],
                'membership_tiers' => [
                    ['name' => 'Silver', 'price' => 14.99, 'color' => '#C0C0C0', 'benefits' => ['Community access', 'Monthly newsletter', 'Fan badge', 'Direct messaging with team']],
                    ['name' => 'Gold', 'price' => 29.99, 'color' => '#FFD700', 'benefits' => ['Everything in Silver', 'Early event access', 'Exclusive monthly photos', 'Priority messaging', 'ARMY Discord role']],
                    ['name' => 'Diamond', 'price' => 69.99, 'color' => '#b9f2ff', 'benefits' => ['Everything in Gold', 'Monthly video call', 'Signed merchandise', 'VIP event access', 'Personalized video message']],
                    ['name' => 'OT7', 'price' => 149.99, 'color' => '#a855f7', 'benefits' => ['Everything in Diamond', 'All-access pass', 'Private meetup', 'Lifetime status badge', '24/7 priority support']],
                ],
                'features' => [
                    'fan_applications' => true,
                    'membership' => true,
                    'meet_greet' => true,
                    'membership_card' => true,
                    'private_meetup' => true,
                    'messaging' => true,
                ],
                'pricing' => [
                    'fan_application_fee' => 20.00,
                    'membership_card_fee' => 12.00,
                    'meet_greet_default_price' => 200.00,
                    'private_meetup' => [
                        ['duration' => 30, 'price' => 15.00],
                        ['duration' => 60, 'price' => 35.00],
                        ['duration' => 90, 'price' => 60.00],
                        ['duration' => 120, 'price' => 120.00],
                    ],
                ],
            ],
            'is_active' => true,
            'created_by' => $admin->id,
        ]);
        $c->fans()->detach();
        $this->seedPaymentMethods($c, [
            ['type' => 'bank_transfer', 'label' => 'Bank Transfer', 'sort_order' => 1, 'details' => ['bank_name' => 'HSBC', 'account_name' => 'Jungkook Entertainment Co.', 'account_number' => '9876543210', 'swift_code' => 'HSBCHKHH', 'instructions' => '<h4>Bank Transfer Instructions:</h4><ul><li>Reference: Jungkook Fan Payment</li><li>Include your fan ID in the reference field</li><li>Upload your transfer receipt below</li></ul>']],
            ['type' => 'stripe', 'label' => 'Credit/Debit Card', 'sort_order' => 2],
            ['type' => 'cryptocurrency', 'label' => 'Ethereum', 'sort_order' => 3, 'details' => ['network' => 'ethereum', 'wallet_address' => '0x742d35Cc6634C0532925a3b844Bc9e7595f2bD18', 'instructions' => '<p>Send ETH to the address above. <strong>ERC-20 only.</strong> Scan the QR code or copy the address.</p>']],
            ['type' => 'paypal', 'label' => 'PayPal', 'sort_order' => 4, 'details' => ['email' => 'jungkook@managingteam.info']],
            ['type' => 'offline', 'label' => 'Venmo', 'sort_order' => 5, 'details' => ['custom_label' => '@jungkook-fanclub', 'instructions' => '<p>Pay via Venmo to <strong>@jungkook-fanclub</strong>. Include your fan email in the note so we can match your payment.</p>']],
        ]);

        return $c;
    }

    private function createLisa(User $admin): Celebrity
    {
        $c = Celebrity::firstOrCreate(['slug' => 'lisa'], [
            'name' => 'Lisa',
            'bio' => 'Main dancer, rapper, and vocalist of BLACKPINK. Global fashion icon, solo artist, and dance phenomenon.',
            'social_links' => [
                'instagram' => 'https://instagram.com/lisa',
                'twitter' => 'https://twitter.com/lisa',
                'youtube' => 'https://youtube.com/@lisa',
            ],
            'config' => [
                'site_content' => [
                    'hero_title' => 'Welcome to<br><span class="gradient-text">Lalisa</span>\'s<br>Fan Community',
                    'hero_subtitle' => 'Join the most stylish fan community on the planet. Exclusive dance workshops, fashion drops, and unforgettable moments with Lisa.',
                    'about_title' => 'About Lisa',
                    'about_body' => '<p>Pranpriya Manoban — known worldwide as Lisa — is the main dancer, lead rapper, and vocalist of BLACKPINK. Born in Thailand and trained in South Korea, Lisa has become a global icon known for her incredible dance skills, unique fashion sense, and charismatic stage presence.</p><p>Her solo debut with "LALISA" and "MONEY" broke records and showcased her versatility as an artist. Beyond music, Lisa is a mentor on dance survival shows, a fashion ambassador for luxury brands, and an inspiration to millions.</p><p>This is the official fan community for BLINKs who want the ultimate Lisa experience. Let\'s dance! 💃</p>',
                    'stats' => [
                        ['value' => '100M+', 'label' => 'Instagram Followers'],
                        ['value' => '12+', 'label' => 'Solo Awards'],
                        ['value' => '4', 'label' => 'World Tours'],
                        ['value' => '8', 'label' => 'Years Active'],
                    ],
                    'testimonials' => [
                        ['author' => 'Sophia Williams', 'quote' => 'The Premium membership is amazing! I got access to exclusive dance practice videos and the community is so supportive.', 'badge' => 'Premium Member'],
                        ['author' => 'Noah Garcia', 'quote' => 'I booked a private meetup through this community and it was the best experience of my life. The team made everything perfect.', 'badge' => 'VIP Member'],
                        ['author' => 'Olivia Brown', 'quote' => 'Even as a Standard member, the content you get is incredible. The newsletter alone is worth it!', 'badge' => 'Standard Member'],
                    ],
                ],
                'theme' => [
                    'primary_color' => '#e11d48',
                    'secondary_color' => '#f97316',
                    'fonts' => [
                        'heading' => 'Poppins:wght@600;700;800',
                        'body' => 'DM+Sans:ital,wght@0,400;0,500;0,700;1,400',
                    ],
                ],
                'membership_tiers' => [
                    ['name' => 'Standard', 'price' => 9.99, 'color' => '#94a3b8', 'benefits' => ['Community access', 'Monthly newsletter', 'Fan badge', 'Direct messaging', 'Exclusive wallpapers']],
                    ['name' => 'Premium', 'price' => 24.99, 'color' => '#fbbf24', 'benefits' => ['Everything in Standard', 'Exclusive dance videos', 'Behind-the-scenes photos', 'Priority support', 'Member-only livestreams']],
                    ['name' => 'VIP', 'price' => 59.99, 'color' => '#ef4444', 'benefits' => ['Everything in Premium', 'Quarterly 1-on-1 video call', 'Signed merchandise', 'Event priority access', 'Personalized video message']],
                ],
                'features' => [
                    'fan_applications' => true,
                    'membership' => true,
                    'meet_greet' => true,
                    'membership_card' => true,
                    'private_meetup' => true,
                    'messaging' => true,
                ],
                'pricing' => [
                    'fan_application_fee' => 30.00,
                    'membership_card_fee' => 18.00,
                    'meet_greet_default_price' => 175.00,
                    'private_meetup' => [
                        ['duration' => 30, 'price' => 12.00],
                        ['duration' => 60, 'price' => 30.00],
                        ['duration' => 90, 'price' => 55.00],
                        ['duration' => 120, 'price' => 110.00],
                    ],
                ],
            ],
            'is_active' => true,
            'created_by' => $admin->id,
        ]);
        $c->fans()->detach();
        $this->seedPaymentMethods($c, [
            ['type' => 'bank_transfer', 'label' => 'Bank Transfer', 'sort_order' => 1, 'details' => ['bank_name' => 'KB Bank', 'account_name' => 'Korea Fan Management', 'account_number' => '5555-1234', 'swift_code' => 'KOEXKRSE', 'instructions' => '<h4>Bank Transfer Instructions:</h4><ul><li>Include your fan ID in the reference</li><li>International transfers may take 2-5 business days</li></ul>']],
            ['type' => 'stripe', 'label' => 'Credit/Debit Card', 'sort_order' => 2],
            ['type' => 'cryptocurrency', 'label' => 'USDT (TRC-20)', 'sort_order' => 3, 'details' => ['network' => 'usdt_trc20', 'wallet_address' => 'TXYZ1234567890abcdefghijklmnopqrstuvwxyz', 'instructions' => '<p>Send USDT on the <strong>TRC-20 network</strong> to the address above. Do <em>not</em> send other tokens to this address.</p>']],
            ['type' => 'offline', 'label' => 'Cash Payment', 'sort_order' => 4, 'details' => ['custom_label' => 'Pay at our partner store', 'instructions' => '<p>Visit any of our partner stores worldwide and mention <strong>Lisa Fan Club</strong> to make a cash payment. Show your fan ID for credit.</p>']],
        ]);

        return $c;
    }

    // ══════════════════════════════════════════════════
    //  FANS
    // ══════════════════════════════════════════════════

    private function createFans(Celebrity $jennie, Celebrity $jungkook, Celebrity $lisa): array
    {
        $fanData = [
            // Jennie fans
            ['name' => 'Sarah Mitchell', 'email' => 'sarah@demo.com', 'password' => 'demo1234!', 'celeb' => $jennie],
            ['name' => 'James Kim', 'email' => 'james@demo.com', 'password' => 'demo1234!', 'celeb' => $jennie],
            ['name' => 'Emily Chen', 'email' => 'emily@demo.com', 'password' => 'demo1234!', 'celeb' => $jennie],
            // Jungkook fans
            ['name' => 'Mia Johnson', 'email' => 'mia@demo.com', 'password' => 'demo1234!', 'celeb' => $jungkook],
            ['name' => 'Daniel Park', 'email' => 'daniel@demo.com', 'password' => 'demo1234!', 'celeb' => $jungkook],
            // Lisa fans
            ['name' => 'Sophia Williams', 'email' => 'sophia@demo.com', 'password' => 'demo1234!', 'celeb' => $lisa],
            ['name' => 'Noah Garcia', 'email' => 'noah@demo.com', 'password' => 'demo1234!', 'celeb' => $lisa],
            ['name' => 'Olivia Brown', 'email' => 'olivia@demo.com', 'password' => 'demo1234!', 'celeb' => $lisa],
        ];

        $fans = [];
        foreach ($fanData as $i => $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                    'role' => 'fan',
                    'is_verified' => true,
                ]
            );

            if (! $user->celebrities()->where('celebrity_id', $data['celeb']->id)->exists()) {
                $user->celebrities()->attach($data['celeb']->id, ['status' => 'active']);
            }

            $fans[$data['celeb']->slug][] = $user;
        }

        return $fans;
    }

    // ══════════════════════════════════════════════════
    //  FAN APPLICATIONS
    // ══════════════════════════════════════════════════

    private function createApplications(array $fans, Celebrity $jennie, Celebrity $jungkook, Celebrity $lisa, User $admin): void
    {
        $apps = [
            ['user' => $fans['jennie'][0], 'celeb' => $jennie, 'status' => 'approved', 'bio' => 'Long-time fan since debut!', 'reason' => 'I want to connect with other Jennie fans.'],
            ['user' => $fans['jennie'][1], 'celeb' => $jennie, 'status' => 'pending', 'bio' => 'Love her music and style.', 'reason' => 'Would love to be part of this community.'],
            ['user' => $fans['jungkook'][0], 'celeb' => $jungkook, 'status' => 'approved', 'bio' => 'ARMY since 2017!', 'reason' => 'Jungkook inspires me every day.'],
            ['user' => $fans['lisa'][0], 'celeb' => $lisa, 'status' => 'approved', 'bio' => 'Dancer and BLINK.', 'reason' => 'Lisa is my ultimate role model.'],
        ];

        foreach ($apps as $app) {
            FanApplication::firstOrCreate(
                ['user_id' => $app['user']->id, 'celebrity_id' => $app['celeb']->id],
                [
                    'bio' => $app['bio'],
                    'reason' => $app['reason'],
                    'status' => $app['status'],
                    'reviewed_by' => $app['status'] === 'approved' ? $admin->id : null,
                ]
            );
        }
    }

    // ══════════════════════════════════════════════════
    //  MEMBERSHIPS
    // ══════════════════════════════════════════════════

    private function createMemberships(array $fans, Celebrity $jennie, Celebrity $jungkook, Celebrity $lisa): void
    {
        $data = [
            ['user' => $fans['jennie'][0], 'celeb' => $jennie, 'tier' => 'Platinum', 'price' => 79.99, 'active' => true],
            ['user' => $fans['jennie'][2], 'celeb' => $jennie, 'tier' => 'Gold', 'price' => 39.99, 'active' => true],
            ['user' => $fans['jungkook'][0], 'celeb' => $jungkook, 'tier' => 'Diamond', 'price' => 69.99, 'active' => true],
            ['user' => $fans['lisa'][0], 'celeb' => $lisa, 'tier' => 'Premium', 'price' => 24.99, 'active' => true],
            ['user' => $fans['lisa'][2], 'celeb' => $lisa, 'tier' => 'VIP', 'price' => 59.99, 'active' => false],
        ];

        foreach ($data as $d) {
            Membership::firstOrCreate(
                ['user_id' => $d['user']->id, 'celebrity_id' => $d['celeb']->id],
                [
                    'tier' => $d['tier'],
                    'price' => $d['price'],
                    'start_date' => now()->subDays(rand(10, 60)),
                    'end_date' => now()->addYear(),
                    'is_active' => $d['active'],
                    'auto_renew' => true,
                    'payment_method' => 'stripe',
                    'payment_ref' => 'pi_'.bin2hex(random_bytes(12)),
                ]
            );
        }
    }

    // ══════════════════════════════════════════════════
    //  MEET & GREET EVENTS + TICKETS
    // ══════════════════════════════════════════════════

    private function createEvents(Celebrity $jennie, Celebrity $jungkook, Celebrity $lisa, array $fans, User $admin): void
    {
        $events = [
            ['celeb' => $jennie, 'title' => 'Jennie Fan Meet 2026', 'desc' => 'An exclusive fan meet event in Seoul.', 'date' => now()->addMonths(2), 'location' => 'Seoul, South Korea', 'capacity' => 200, 'price' => 150.00],
            ['celeb' => $jennie, 'title' => 'Intimate Acoustic Session', 'desc' => 'Small group acoustic performance.', 'date' => now()->addMonths(4), 'location' => 'Los Angeles, CA', 'capacity' => 50, 'price' => 300.00],
            ['celeb' => $jungkook, 'title' => 'Jungkook Fan Signing', 'desc' => 'Album signing event with exclusive merch.', 'date' => now()->addMonths(3), 'location' => 'Busan, South Korea', 'capacity' => 150, 'price' => 75.00],
            ['celeb' => $lisa, 'title' => 'Dance Workshop with Lisa', 'desc' => 'Learn choreography from Lisa herself!', 'date' => now()->addMonths(5), 'location' => 'Bangkok, Thailand', 'capacity' => 30, 'price' => 500.00],
        ];

        foreach ($events as $e) {
            MeetGreetEvent::firstOrCreate(
                ['celebrity_id' => $e['celeb']->id, 'title' => $e['title']],
                [
                    'description' => $e['desc'],
                    'date' => $e['date'],
                    'location' => $e['location'],
                    'capacity' => $e['capacity'],
                    'price' => $e['price'],
                    'is_active' => true,
                ]
            );
        }

        // Buy tickets for some fans
        $event1 = MeetGreetEvent::where('celebrity_id', $jennie->id)->first();
        if ($event1 && isset($fans['jennie'][0])) {
            MeetGreetTicket::firstOrCreate(
                ['user_id' => $fans['jennie'][0]->id, 'event_id' => $event1->id],
                [
                    'celebrity_id' => $jennie->id,
                    'quantity' => 2,
                    'total_price' => $event1->price * 2,
                    'status' => 'confirmed',
                    'payment_method' => 'stripe',
                    'payment_ref' => 'pi_'.bin2hex(random_bytes(12)),
                ]
            );
        }
    }

    // ══════════════════════════════════════════════════
    //  MESSAGES (Threaded — Fan ↔ Admin Team)
    // ══════════════════════════════════════════════════

    private function createMessages(array $fans, Celebrity $jennie, Celebrity $jungkook, Celebrity $lisa, User $admin): void
    {
        $threads = [
            [
                'fan' => $fans['jennie'][0],
                'celeb' => $jennie,
                'subject' => 'VIP Event Question',
                'content' => 'Hi team! I have a question about the upcoming VIP event in Seoul. Is there a dress code?',
                'replies' => [
                    'Great question! The dress code is smart casual. We\'ll also send a detailed guide via email closer to the date. Can\'t wait to see you there!',
                    'Thank you so much for the quick response! I\'m really excited!',
                ],
            ],
            [
                'fan' => $fans['jennie'][1],
                'celeb' => $jennie,
                'subject' => 'Membership Upgrade',
                'content' => 'I currently have Silver membership and would like to upgrade to Gold. Can you help with that?',
                'replies' => [
                    'Of course! We can process the upgrade for you. The price difference is $20. Just submit a new subscription with the Gold tier and we\'ll take care of the rest.',
                ],
            ],
            [
                'fan' => $fans['jungkook'][0],
                'celeb' => $jungkook,
                'subject' => 'Signed Album Request',
                'content' => 'I\'m a Diamond member and was wondering if it\'s possible to get a signed copy of Jungkook\'s latest album?',
                'replies' => [
                    'Absolutely! As a Diamond member, you\'re eligible for a signed album. We\'ll ship it to the address on your profile. Let us know if your address has changed!',
                    'My address is still the same. Thank you so much! This means the world to me! 💜',
                    'You\'re welcome! The album is on its way. We\'ll send you the tracking number once it ships.',
                ],
            ],
            [
                'fan' => $fans['lisa'][0],
                'celeb' => $lisa,
                'subject' => 'Dance Workshop Question',
                'content' => 'I just booked the Dance Workshop in Bangkok! What skill level is required?',
                'replies' => [
                    'Congratulations on booking! The workshop is suitable for all levels — from beginners to advanced. Lisa will break down the choreography step by step. Just bring your energy and comfortable clothes! 🩰',
                ],
            ],
        ];

        foreach ($threads as $t) {
            $parent = Message::firstOrCreate(
                [
                    'celebrity_id' => $t['celeb']->id,
                    'sender_id' => $t['fan']->id,
                    'subject' => $t['subject'],
                    'parent_id' => null,
                ],
                [
                    'content' => $t['content'],
                    'is_read' => true,
                ]
            );

            foreach ($t['replies'] as $i => $replyText) {
                $isAdmin = $i % 2 === 0;
                Message::firstOrCreate(
                    [
                        'celebrity_id' => $t['celeb']->id,
                        'sender_id' => $isAdmin ? $admin->id : $t['fan']->id,
                        'parent_id' => $parent->id,
                        'content' => $replyText,
                    ],
                    [
                        'subject' => 'Re: '.$t['subject'],
                        'is_read' => true,
                    ]
                );
            }
        }
    }

    // ══════════════════════════════════════════════════
    //  MEMBERSHIP CARDS
    // ══════════════════════════════════════════════════

    private function createCards(array $fans, Celebrity $jennie, Celebrity $jungkook): void
    {
        $cards = [
            ['fan' => $fans['jennie'][0], 'celeb' => $jennie, 'tier' => 'Platinum', 'num' => 'JK-4820-1937-6502-8841'],
            ['fan' => $fans['jungkook'][0], 'celeb' => $jungkook, 'tier' => 'Diamond', 'num' => 'JK-7731-4502-9918-2367'],
        ];

        foreach ($cards as $c) {
            MembershipCard::firstOrCreate(
                ['card_number' => $c['num']],
                [
                    'celebrity_id' => $c['celeb']->id,
                    'user_id' => $c['fan']->id,
                    'tier' => $c['tier'],
                    'issued_at' => now()->subDays(30),
                    'expires_at' => now()->addYear()->subDays(30),
                    'is_active' => true,
                    'payment_method' => 'stripe',
                    'payment_ref' => 'pi_card_'.bin2hex(random_bytes(8)),
                ]
            );
        }
    }

    // ══════════════════════════════════════════════════
    //  PRIVATE MEETUPS
    // ══════════════════════════════════════════════════

    private function createMeetups(array $fans, Celebrity $jennie, Celebrity $lisa, User $admin): void
    {
        PrivateMeetup::firstOrCreate(
            ['user_id' => $fans['jennie'][0]->id, 'celebrity_id' => $jennie->id, 'title' => 'Birthday Surprise'],
            [
                'description' => 'I want to arrange a private meetup for my sister\'s birthday. She\'s the biggest Jennie fan!',
                'date' => now()->addMonths(1)->setHour(14)->setMinute(0),
                'duration' => 60,
                'location' => 'Seoul',
                'price' => 2500,
                'status' => 'confirmed',
                'notes' => 'Will bring a small cake. Please confirm.',
                'payment_method' => 'stripe',
                'payment_ref' => 'pi_mu_'.bin2hex(random_bytes(8)),
            ]
        );

        PrivateMeetup::firstOrCreate(
            ['user_id' => $fans['lisa'][1]->id, 'celebrity_id' => $lisa->id, 'title' => 'Dance Collaboration'],
            [
                'description' => 'I\'m a choreographer and would love to discuss a potential collaboration.',
                'date' => now()->addMonths(2)->setHour(10)->setMinute(0),
                'duration' => 90,
                'location' => 'Bangkok',
                'price' => 5000,
                'status' => 'pending',
                'notes' => 'Will bring portfolio and demo videos.',
                'payment_method' => 'bank_transfer',
                'payment_ref' => 'BTX-'.bin2hex(random_bytes(8)),
            ]
        );
    }

    // ══════════════════════════════════════════════════
    //  REDIRECT LINKS
    // ══════════════════════════════════════════════════

    private function createRedirectLinks(Celebrity $jennie, Celebrity $lisa, User $admin): void
    {
        $host = parse_url(config('app.url'), PHP_URL_HOST);

        RedirectLink::firstOrCreate(
            ['code' => 'jennie'],
            [
                'celebrity_id' => $jennie->id,
                'target_url' => "https://jennie.{$host}",
                'clicks' => 142,
                'is_active' => true,
                'created_by' => $admin->id,
            ]
        );

        RedirectLink::firstOrCreate(
            ['code' => 'jenjoin'],
            [
                'celebrity_id' => $jennie->id,
                'target_url' => "https://jennie.{$host}/register",
                'clicks' => 58,
                'is_active' => true,
                'created_by' => $admin->id,
            ]
        );

        RedirectLink::firstOrCreate(
            ['code' => 'lisavip'],
            [
                'celebrity_id' => $lisa->id,
                'target_url' => "https://lisa.{$host}/membership",
                'clicks' => 23,
                'is_active' => true,
                'created_by' => $admin->id,
            ]
        );
    }

    // ══════════════════════════════════════════════════
    //  CUSTOM PAGES
    // ══════════════════════════════════════════════════

    private function createPages(Celebrity $jennie, Celebrity $jungkook): void
    {
        CelebrityPage::firstOrCreate(
            ['celebrity_id' => $jennie->id, 'slug' => 'fan-rules'],
            [
                'title' => 'Fan Community Rules',
                'content' => '<h2>Welcome to the Community!</h2><p>To keep this a safe and enjoyable space for everyone, please follow these guidelines:</p><ul><li>Be respectful to all members and staff</li><li>No hate speech, bullying, or harassment</li><li>Do not share personal information of other members</li><li>Follow the instructions of the management team</li><li>Have fun and make friends!</li></ul>',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        CelebrityPage::firstOrCreate(
            ['celebrity_id' => $jungkook->id, 'slug' => 'fan-art'],
            [
                'title' => 'Fan Art Gallery Guidelines',
                'content' => '<h2>Share Your Art!</h2><p>We love seeing your creativity! Here\'s how to submit your fan art:</p><ul><li>Original works only — no AI-generated or stolen art</li><li>Keep it appropriate for all ages</li><li>Credit your inspirations</li><li>Tag us on Instagram for a chance to be featured!</li></ul>',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );
    }

    private function seedPaymentMethods(Celebrity $celebrity, array $methods): void
    {
        $celebrity->paymentMethods()->delete();
        foreach ($methods as $i => $method) {
            $celebrity->paymentMethods()->create([
                'type' => $method['type'],
                'label' => $method['label'],
                'enabled' => $method['enabled'] ?? true,
                'details' => $method['details'] ?? null,
                'sort_order' => $method['sort_order'] ?? $i,
            ]);
        }
    }
}
