<?php

namespace Wooter;

use Illuminate\Database\Eloquent\Model;

class ImageRoles extends Model {

    /**
     * Photo Extensions
     */
    protected $extensions = [
        "JPG" => ".jpg",
        "PNG" => ".png",
        "GIF" => ".gif",
        "JPEG" => ".jpeg"
    ];

    /**
     * Image profile identifiers
     */
    const IMAGE_PROFILE = 'image.profile';
    const IMAGE_PROFILE_ID = 1;

    /**
     * Image League identifiers
     */
    const IMAGE_LEAGUE = 'image.league';
    const IMAGE_LEAGUE_ID = 2;

    /**
     * Image Cover identifiers
     */
    const IMAGE_COVER = 'image.cover';
    const IMAGE_COVER_ID = 2;

    /**
     * Image Hidden identifiers
     */
    const IMAGE_HIDDEN = 'image.hidden';
    const IMAGE_HIDDEN_ID = 4;

    /**
     * Image Archived identifiers
     */
    const IMAGE_ARCHIVED = 'image.archived';
    const IMAGE_ARCHIVED_ID = 5;

    /**
     * Image Article identifiers
     */
    const IMAGE_ARTICLE = 'image.article';
    const IMAGE_ARTICLE_ID = 6;


    /**
     * Get array with all image types (RAW << [ id, namespace ] >>)
     * 
     * @return array
     */
    static function getImageTypes () {
        return [
            [
                self::IMAGE_PROFILE_ID,
                self::IMAGE_PROFILE
            ],
            [
                self::IMAGE_LEAGUE_ID,
                self::IMAGE_LEAGUE
            ],
            [
                self::IMAGE_COVER_ID,
                self::IMAGE_COVER
            ],
            [
                self::IMAGE_HIDDEN_ID,
                self::IMAGE_HIDDEN
            ],
            [
                self::IMAGE_ARCHIVED_ID,
                self::IMAGE_ARCHIVED
            ],
            [
                self::IMAGE_ARTICLE_ID,
                self::IMAGE_ARTICLE
            ]
        ];
    }

    /**
     * Get organized Types (just namespace of type)
     *
     * @return array
     */
    static function getImagesTypesOrganized () {
        $tps = self::getImageTypes();
        $ret = [];

        foreach ($tps as $tp){
            $ret[] = $tp[1];
        }

        return $ret;
    }
}
