<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Role extends Model
{
    use Sluggable;
    const PERMISSIONS = [
        'USERS_VIEW'                => 'u1',
        'USERS_MANAGE'              => 'u2',
        'ITEMS_VIEW'                => 'i1',
        'ITEMS_MANAGE'              => 'i2',
        'EVENTS_VIEW'               => 'e1',
        'EVENTS_MANAGE'             => 'e2',
        'SERVICE_VIEW'              => 's1',
        'SERVICE_MANAGE'            => 's2',
        'GALLERIES_VIEW'            => 'g1',
        'GALLERIES_MANAGE'          => 'g2',
        'GALLERY_TYPES_VIEW'        => 'gt1',
        'GALLERY_TYPES_MANAGE'      => 'gt2',
        'CATEGORIES_VIEW'           => 'c1',
        'CATEGORIES_MANAGE'         => 'c2',
        'SUB_CATEGORIES_VIEW'       => 'sc1',
        'SUB_CATEGORIES_MANAGE'     => 'sc2',
        'FAMOUS_PEOPLE_VIEW'        => 'fp1',
        'FAMOUS_PEOPLE_MANAGE'      => 'fp2',
        'MENU_VIEW'                 => 'm1',
        'MENU_MANAGE'               => 'm2',
        'SUB_MENU_VIEW'             => 'sm1',
        'SUB_MENU_MANAGE'           => 'sm2',
        'CONTACTS_VIEW'             => 'ct1',
        'CONTACTS_MANAGE'           => 'ct2',
        'PROMOTIONS_VIEW'           => 'p1',
        'PROMOTIONS_MANAGE'         => 'p2',
        'CURRENCIES_VIEW'           => 'cu1',
        'CURRENCIES_MANAGE'         => 'cu2',
        'CONFIGURATIONS_VIEW'       => 'co1',
        'CONFIGURATIONS_MANAGE'     => 'co2',
        'ROLES_VIEW'                => 'r1',
        'ROLES_MANAGE'              => 'r2',
        'PAYMENT_METHOD_VIEW'       => 'pmd1',
        'PAYMENT_METHOD_MANAGE'     => 'pmd2',
        'EMAIL_TEMPLATE_VIEW'       => 'emt1',
        'EMAIL_TEMPLATE_MANAGE'     => 'emt2',
        'WEEKLY_MENU_VIEW'          => 'w1',
        'WEEKLY_MENU_MANAGE'        => 'w2',
        'ABOUT_US_VIEW'             => 'au1',
        'ABOUT_US_MANAGE'           => 'au2',
        'IMAGE_LIST_VIEW'           => 'il1',
        'IMAGE_LIST_MANAGE'         => 'il2',
        'ORDER_VIEW'                => 'or1',
        'ORDER_MANAGE'              => 'or2',
        'FAQ_VIEW'                  => 'faq1',
        'FAQ_MANAGE'                => 'faq2',
        'SERVICE_FEEDBACK_VIEW'     => 'sfb1',
        'SERVICE_FEEDBACK_MANAGE'   => 'sfb2',
        'EVENT_TYPES_VIEW'          => 'et1',
        'EVENT_TYPES_MANAGE'        => 'et2',
        'NEWS_TYPES_VIEW'           => 'nt1',
        'NEWS_TYPES_MANAGE'         => 'nt2',
        'NEWS_VIEW'                 => 'n1',
        'EVENT_MANAGE'              => 'n2',
        'THEME_MANAGE'              => 'theme2',
        'THEME_VIEW'                => 'theme1'
    ];

    const CONTROLLERS = [
        'UsersController' => [
            'index' => ['u1'],
            'show' => ['u1'],
            'edit' => ['u2'],
            'update' => ['u2']
        ],
        'ItemsController' => [
            'index' => ['i1'],
            'show' => ['i1'],
            'edit' => ['i2'],
            'update' => ['i2'],
            'store' => ['i2'],
            'create' => ['i2'],
            'destroy' => ['i2'],
            'getSubCategories' => ['i2'],
            'upload' => ['i2'],
            'updateSequence' => ['i2'],
            'sequenceIndex' => ['i2'],
            'getAllItems' => ['i2'],
            'getItemsData' => ['i2'],
            'getSubSubCategories' => ['i2'],
        ],
        'EventsController' => [
            'index' => ['e1'],
            'show' => ['e1'],
            'edit' => ['e2'],
            'update' => ['e2'],
            'store' => ['e2'],
            'create' => ['e2'],
            'destroy' => ['e2'],
            'upload' => ['e2'],
        ],
        'ServicesController' => [
            'index' => ['s1'],
            'show' => ['s1'],
            'edit' => ['s2'],
            'update' => ['s2'],
            'store' => ['s2'],
            'create' => ['s2'],
            'destroy' => ['s2'],
            'upload' => ['s2'],
        ],
        'GalleriesController' => [
            'index' => ['g1'],
            'show' => ['g1'],
            'edit' => ['g2'],
            'update' => ['g2'],
            'store' => ['g2'],
            'create' => ['g2'],
            'destroy' => ['g2'],
            'upload' => ['g2']
        ],
        'GalleryTypesController' => [
            'index' => ['gt1'],
            'show' => ['gt1'],
            'edit' => ['gt2'],
            'update' => ['gt2'],
            'store' => ['gt2'],
            'create' => ['gt2'],
            'destroy' => ['gt2']
        ],
        'CategoriesController' => [
            'index' => ['c1'],
            'show' => ['c1'],
            'edit' => ['c2'],
            'update' => ['c2'],
            'store' => ['c2'],
            'create' => ['c2'],
            'destroy' => ['c2'],
            'updateSequence' => ['c2'],
            'sequenceIndex' => ['c2'],
        ],
        'SubCategoriesController' => [
            'index' => ['sc1'],
            'show' => ['sc1'],
            'edit' => ['sc2'],
            'update' => ['sc2'],
            'store' => ['sc2'],
            'create' => ['sc2'],
            'destroy' => ['sc2'],
            'updateSequence' => ['sc2'],
            'sequenceIndex' => ['sc2'],
            'getSubSubCategories' => ['sc2'],
        ],
        'CategoryMetaController' => [
            'index' => ['sc1'],
            'show' => ['sc1'],
            'edit' => ['sc2'],
            'update' => ['sc2'],
            'store' => ['sc2'],
            'create' => ['sc2'],
            'destroy' => ['sc2'],
            'updateSequence' => ['sc2'],
            'sequenceIndex' => ['sc2'],
            'getSubCategoryMeta' => ['sc2'],
        ],
        'FamousPeopleController' => [
            'index' => ['fp1'],
            'show' => ['fp1'],
            'edit' => ['fp2'],
            'update' => ['fp2'],
            'store' => ['fp2'],
            'create' => ['fp2'],
            'destroy' => ['fp2'],
            'upload' => ['fp2'],
        ],
        'MenusController' => [
            'index' => ['m1'],
            'show' => ['m1'],
            'edit' => ['m2'],
            'update' => ['m2'],
            'store' => ['m2'],
            'create' => ['m2'],
            'destroy' => ['m2'],
            'updateSequence' => ['m2'],
            'sequenceIndex' => ['m2'],
        ],
        'SubMenusController' => [
            'index' => ['sm1'],
            'show' => ['sm1'],
            'edit' => ['sm2'],
            'update' => ['sm2'],
            'store' => ['sm2'],
            'create' => ['sm2'],
            'destroy' => ['sm2'],
            'updateSequence' => ['sm2'],
            'sequenceIndex' => ['sm2'],
        ],
        'ContactsController' => [
            'index' => ['ct1'],
            'show' => ['ct1'],
            'edit' => ['ct2'],
            'update' => ['ct2'],
            'destroy' => ['ct2']
        ],
        'PromotionsController' => [
            'index' => ['p1'],
            'show' => ['p1'],
            'edit' => ['p2'],
            'update' => ['p2'],
            'store' => ['p2'],
            'create' => ['p2'],
            'destroy' => ['p2'],
            'updateSequence' => ['p2'],
            'sequenceIndex' => ['p2'],
        ],
        'CurrenciesController' => [
            'index' => ['cu1'],
            'show' => ['cu2'],
            'edit' => ['cu2'],
            'update' => ['cu2'],
            'store' => ['cu2'],
            'create' => ['cu2'],
            'destroy' => ['cu2']
        ],
        'ConfigurationsController' => [
            'index' => ['co1'],
            'update' => ['co2'],
        ],
        'RolesController' => [
            'index' => ['r1'],
            'update' => ['r2'],
            'edit' => ['r2'],
            'store' => ['r2'],
            'create' => ['r2'],
            'destroy' => ['r2'],
            'show' => ['r2'],
            'updateUserRole' => ['r2'],
            'deleteUserRole' => ['r2']
        ],
        'PaymentMethodsController' => [
            'index' => ['pmd1'],
            'show' => ['pmd1'],
            'edit' => ['pmd2'],
            'update' => ['pmd2'],
            'store' => ['pmd2'],
            'create' => ['pmd2'],
            'destroy' => ['pmd2']
        ],
        'EmailTemplatesController' => [
            'index' => ['emt1'],
            'show' => ['emt1'],
            'edit' => ['emt2'],
            'update' => ['emt2'],
            'store' => ['emt2'],
            'create' => ['emt2'],
            'destroy' => ['emt2']
        ],
        'WeeklyMenusController' => [
            'index' => ['w1'],
            'show' => ['w1'],
            'edit' => ['w2'],
            'update' => ['w2'],
            'store' => ['w2'],
            'create' => ['w2'],
            'destroy' => ['w2'],
            'upload' => ['w2'],
        ],
        'ThemeController' => [
          'getPageInfo' => ['theme2'],
          'customize' => ['theme2'],
          'updateSectionData' => ['theme2']
        ],
        'AboutUsController' => [
            'index' => ['au1'],
            'show' => ['au1'],
            'edit' => ['au2'],
            'update' => ['au2'],
            'store' => ['au2'],
            'create' => ['au2'],
            'destroy' => ['au2'],
            'upload' => ['au2'],
        ],
        'ImagesController' => [
            'index' => ['il1'],
            'show' => ['il1'],
            'edit' => ['il2'],
            'update' => ['il2'],
            'store' => ['il2'],
            'create' => ['il2'],
            'destroy' => ['il2'],
            'upload' => ['il2'],
            'uploadNewImage' => ['il2'],
            'uploadThumb' => ['il2'],
            'uploadImageList' => ['il2'],
            'deleteImages' => ['il2'],
            'getImageList' => ['il2']
        ],
        'OrdersController' => [
            'index' => ['or1'],
            'show' => ['or1'],
            'edit' => ['or2'],
            'update' => ['or2'],
            'store' => ['or2'],
            'create' => ['or2'],
            'destroy' => ['or2'],
            'upload' => ['or2'],
            'booking' => ['or2'],
            'order' => ['or2'],
            'editBooking' => ['or2'],
            'updateBooking' => ['or2'],
            'viewBooking' => ['or2'],
            'viewOrder' => ['or2'],
        ],
        'FaqsController' => [
            'index' => ['faq1'],
            'show' => ['faq1'],
            'edit' => ['faq2'],
            'update' => ['faq2'],
            'store' => ['faq2'],
            'create' => ['faq2'],
            'destroy' => ['faq2'],
            'upload' => ['faq2'],
        ],
        'ServiceFeedbacksController' => [
            'index' => ['sfb1'],
            'show' => ['sfb1'],
            'edit' => ['sfb2'],
            'update' => ['sfb2'],
            'store' => ['sfb2'],
            'create' => ['sfb2'],
            'destroy' => ['sfb2'],
            'upload' => ['sfb2'],
        ],
        'EventTypesController' => [
            'index' => ['et1'],
            'show' => ['et1'],
            'edit' => ['et2'],
            'update' => ['et2'],
            'store' => ['et2'],
            'create' => ['et2'],
            'destroy' => ['et2']
        ],
        'NewsTypesController' => [
            'index' => ['nt1'],
            'show' => ['nt1'],
            'edit' => ['nt2'],
            'update' => ['nt2'],
            'store' => ['nt2'],
            'create' => ['nt2'],
            'destroy' => ['nt2']
        ],
        'NewsController' => [
            'index' => ['n1'],
            'show' => ['n1'],
            'edit' => ['n2'],
            'update' => ['n2'],
            'store' => ['n2'],
            'create' => ['n2'],
            'destroy' => ['n2']
        ],
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'code', 'permissions'];

    /**
     * Get the users of role.
     */
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    public function sluggable()
    {
        return [
            'code' => [
                'source' => 'name'
            ]
        ];
    }

    public function canDelete()
    {
        return !count($this->users) > 0;
    }
}
