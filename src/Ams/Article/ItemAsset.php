<?php
namespace Phpsa\Datastore\Ams\Article;
use Phpsa\Datastore\Asset;


class ItemAsset extends Asset {

    public $name = 'Article';
    public $shortname = 'article';
    public $value_equals = 'title';
    public $status_equals = 'published';


    public $properties = array(
        'title' => array(
            'name' => 'Heading',
            'type' => self::STRING,
			'required' => true
        ),
        'intro' => array(
            'name' => 'Intro',
            'type' => self::TEXT
        ),
        'content' => array(
            'name' => 'Full Body',
            'type' => self::HTML
        ),
        'published' => array(
            'name' => 'Published',
            'type' => self::DROPDOWN,
            'options' => ['draft' => 'Draft', 'published' => 'Published', 'aarchive' => 'Archived']
        ),

    );

    public static function about() {
        return 'An Article Asset  which only holds a particular page\'s content. Can be assigned to one or more Article Categories';
    }




}

?>