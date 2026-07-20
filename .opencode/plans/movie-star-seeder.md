# Plan: MovieStarSeeder

## What
Create `database/seeders/MovieStarSeeder.php` that seeds 67 American/Hollywood male movie actors (under 80) as celebrity portals.

## Pricing (uniform for all)

| Item | Price |
|---|---|
| Standard Membership | $3,000 |
| Premium Membership | $5,000 |
| VIP Membership | $10,000 |
| Fan Application Fee | $5,000 |
| Membership Card Fee | $5,000 |
| Meet & Greet Default Price | $1,000 |
| Private Meetup 30 min | $5,000 |
| Private Meetup 60 min | $10,000 |

## Per-actor data
- Name + brief real bio (2-3 sentences)
- Placeholder social links (Instagram, Twitter)
- Cycling theme colors (10 palettes) + fonts (4 pairings)
- All features enabled
- 1 demo fan user per actor (email: `{slug}1@demo.com` / `demo1234!`)
- 3 default payment methods (bank transfer, Stripe, Bitcoin)

## Actor list (67 total)
Samuel L. Jackson, Jeff Bridges, Richard Gere, Bill Murray, Kurt Russell, Michael Keaton, John Malkovich, Bill Pullman, Denzel Washington, Jeff Daniels, Bruce Willis, Willem Dafoe, Mel Gibson, Tom Hanks, Bryan Cranston, Kevin Bacon, Tim Robbins, Sean Penn, George Clooney, Woody Harrelson, Tom Cruise, Steve Carell, Jim Carrey, Johnny Depp, Brad Pitt, Nicolas Cage, Keanu Reeves, Don Cheadle, Robert Downey Jr., Ben Stiller, John Cusack, Adam Sandler, Will Smith, Owen Wilson, Edward Norton, Paul Rudd, Matthew McConaughey, Mark Ruffalo, Jamie Foxx, Will Ferrell, Vince Vaughn, Matt Damon, Hugh Jackman, Mark Wahlberg, Ben Affleck, Dwayne Johnson, Vin Diesel, Christian Bale, Leonardo DiCaprio, Ryan Reynolds, Tom Hardy, Chris Pratt, John Krasinski, Jason Momoa, Jake Gyllenhaal, Ryan Gosling, Chris Evans, Joseph Gordon-Levitt, Channing Tatum, Chris Hemsworth, Michael B. Jordan, Glen Powell, Austin Butler, Ansel Elgort, Timothée Chalamet, Tom Holland

## Files to modify
1. **Create** `database/seeders/MovieStarSeeder.php` — the seeder file (~700 lines)
2. **Edit** `database/seeders/DatabaseSeeder.php` — add `$this->call(MovieStarSeeder::class);`

## Execution
```bash
php artisan db:seed --class=MovieStarSeeder
```
