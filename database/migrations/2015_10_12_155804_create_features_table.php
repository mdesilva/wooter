<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Wooter\LeagueFeature;

class CreateFeaturesTable extends Migration
{
    private $features = [
        ['name' => 'Awards',
         'icon' => '/img/svg/icons/features/Awards.svg'
        ],
        ['name' => 'BBQs',
         'icon' => '/img/svg/icons/features/BBQs.svg'
        ],
        ['name' => 'Contests',
         'icon' => '/img/svg/icons/features/Contests.svg'
        ],
        ['name' => 'DJ',
         'icon' => '/img/svg/icons/features/DJ.svg'
        ],
        ['name' => 'Facilities',
         'icon' => '/img/svg/icons/features/Facilities.svg'
        ],
        ['name' => 'Jerseys',
         'icon' => '/img/svg/icons/features/Jerseys.svg'
        ],
        ['name' => 'Modified Rules',
         'icon' => '/img/svg/icons/features/ModifiedRules.svg'
        ],
        ['name' => 'PED',
         'icon' => '/img/svg/icons/features/PED.svg'
        ],
        ['name' => 'Press',
         'icon' => '/img/svg/icons/features/Press.svg'
        ],
        ['name' => 'Talent Scout',
         'icon' => '/img/svg/icons/features/TalentScout.svg'
        ],
        ['name' => 'Venue',
         'icon' => '/img/svg/icons/features/Venue.svg'
        ],
        ['name' => 'Video',
         'icon' => '/img/svg/icons/features/Video.svg'
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_localized');
            $table->string('icon');
            $table->timestamps();
        });

        $inserts = [];
        foreach ($this->features as $feature){
            $inserts[] = [
                'name' => $feature['name'],
                'name_localized' => 'features.'.strtolower($feature['name']),
                'icon' => $feature['icon'],
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
        }

        DB::table('features')->insert($inserts);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('features');
    }
}
