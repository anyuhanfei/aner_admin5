<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection colum
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection tag_ids
     * @property Grid\Column|Collection category_id
     * @property Grid\Column|Collection author
     * @property Grid\Column|Collection intro
     * @property Grid\Column|Collection keyword
     * @property Grid\Column|Collection image
     * @property Grid\Column|Collection content
     * @property Grid\Column|Collection deleted_at
     * @property Grid\Column|Collection uuid
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection uid
     * @property Grid\Column|Collection coin_type
     * @property Grid\Column|Collection fund_type
     * @property Grid\Column|Collection remark
     * @property Grid\Column|Collection user_identity
     * @property Grid\Column|Collection ip
     * @property Grid\Column|Collection insert_time
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection tokenable_type
     * @property Grid\Column|Collection tokenable_id
     * @property Grid\Column|Collection abilities
     * @property Grid\Column|Collection last_used_at
     * @property Grid\Column|Collection url
     * @property Grid\Column|Collection input_type
     * @property Grid\Column|Collection id_card_username
     * @property Grid\Column|Collection id_card_code
     * @property Grid\Column|Collection id_card_front_img
     * @property Grid\Column|Collection id_card_verso_img
     * @property Grid\Column|Collection id_card_hand_img
     * @property Grid\Column|Collection bank_username
     * @property Grid\Column|Collection bank_phone
     * @property Grid\Column|Collection bank_code
     * @property Grid\Column|Collection bank_name
     * @property Grid\Column|Collection site_username
     * @property Grid\Column|Collection site_phone
     * @property Grid\Column|Collection site_province
     * @property Grid\Column|Collection site_city
     * @property Grid\Column|Collection site_district
     * @property Grid\Column|Collection site_address
     * @property Grid\Column|Collection wx_account
     * @property Grid\Column|Collection wx_nickname
     * @property Grid\Column|Collection wx_qrcode
     * @property Grid\Column|Collection alipay_account
     * @property Grid\Column|Collection alipay_username
     * @property Grid\Column|Collection alipay_qrcode
     * @property Grid\Column|Collection qq
     * @property Grid\Column|Collection money
     * @property Grid\Column|Collection account
     * @property Grid\Column|Collection phone
     * @property Grid\Column|Collection nickname
     * @property Grid\Column|Collection level_password
     * @property Grid\Column|Collection password_salt
     * @property Grid\Column|Collection pid
     * @property Grid\Column|Collection is_login
     *
     * @method Grid\Column|Collection colum(string $label = null)
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection tag_ids(string $label = null)
     * @method Grid\Column|Collection category_id(string $label = null)
     * @method Grid\Column|Collection author(string $label = null)
     * @method Grid\Column|Collection intro(string $label = null)
     * @method Grid\Column|Collection keyword(string $label = null)
     * @method Grid\Column|Collection image(string $label = null)
     * @method Grid\Column|Collection content(string $label = null)
     * @method Grid\Column|Collection deleted_at(string $label = null)
     * @method Grid\Column|Collection uuid(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection uid(string $label = null)
     * @method Grid\Column|Collection coin_type(string $label = null)
     * @method Grid\Column|Collection fund_type(string $label = null)
     * @method Grid\Column|Collection remark(string $label = null)
     * @method Grid\Column|Collection user_identity(string $label = null)
     * @method Grid\Column|Collection ip(string $label = null)
     * @method Grid\Column|Collection insert_time(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection tokenable_type(string $label = null)
     * @method Grid\Column|Collection tokenable_id(string $label = null)
     * @method Grid\Column|Collection abilities(string $label = null)
     * @method Grid\Column|Collection last_used_at(string $label = null)
     * @method Grid\Column|Collection url(string $label = null)
     * @method Grid\Column|Collection input_type(string $label = null)
     * @method Grid\Column|Collection id_card_username(string $label = null)
     * @method Grid\Column|Collection id_card_code(string $label = null)
     * @method Grid\Column|Collection id_card_front_img(string $label = null)
     * @method Grid\Column|Collection id_card_verso_img(string $label = null)
     * @method Grid\Column|Collection id_card_hand_img(string $label = null)
     * @method Grid\Column|Collection bank_username(string $label = null)
     * @method Grid\Column|Collection bank_phone(string $label = null)
     * @method Grid\Column|Collection bank_code(string $label = null)
     * @method Grid\Column|Collection bank_name(string $label = null)
     * @method Grid\Column|Collection site_username(string $label = null)
     * @method Grid\Column|Collection site_phone(string $label = null)
     * @method Grid\Column|Collection site_province(string $label = null)
     * @method Grid\Column|Collection site_city(string $label = null)
     * @method Grid\Column|Collection site_district(string $label = null)
     * @method Grid\Column|Collection site_address(string $label = null)
     * @method Grid\Column|Collection wx_account(string $label = null)
     * @method Grid\Column|Collection wx_nickname(string $label = null)
     * @method Grid\Column|Collection wx_qrcode(string $label = null)
     * @method Grid\Column|Collection alipay_account(string $label = null)
     * @method Grid\Column|Collection alipay_username(string $label = null)
     * @method Grid\Column|Collection alipay_qrcode(string $label = null)
     * @method Grid\Column|Collection qq(string $label = null)
     * @method Grid\Column|Collection money(string $label = null)
     * @method Grid\Column|Collection account(string $label = null)
     * @method Grid\Column|Collection phone(string $label = null)
     * @method Grid\Column|Collection nickname(string $label = null)
     * @method Grid\Column|Collection level_password(string $label = null)
     * @method Grid\Column|Collection password_salt(string $label = null)
     * @method Grid\Column|Collection pid(string $label = null)
     * @method Grid\Column|Collection is_login(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection colum
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection type
     * @property Show\Field|Collection version
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection tag_ids
     * @property Show\Field|Collection category_id
     * @property Show\Field|Collection author
     * @property Show\Field|Collection intro
     * @property Show\Field|Collection keyword
     * @property Show\Field|Collection image
     * @property Show\Field|Collection content
     * @property Show\Field|Collection deleted_at
     * @property Show\Field|Collection uuid
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection uid
     * @property Show\Field|Collection coin_type
     * @property Show\Field|Collection fund_type
     * @property Show\Field|Collection remark
     * @property Show\Field|Collection user_identity
     * @property Show\Field|Collection ip
     * @property Show\Field|Collection insert_time
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection tokenable_type
     * @property Show\Field|Collection tokenable_id
     * @property Show\Field|Collection abilities
     * @property Show\Field|Collection last_used_at
     * @property Show\Field|Collection url
     * @property Show\Field|Collection input_type
     * @property Show\Field|Collection id_card_username
     * @property Show\Field|Collection id_card_code
     * @property Show\Field|Collection id_card_front_img
     * @property Show\Field|Collection id_card_verso_img
     * @property Show\Field|Collection id_card_hand_img
     * @property Show\Field|Collection bank_username
     * @property Show\Field|Collection bank_phone
     * @property Show\Field|Collection bank_code
     * @property Show\Field|Collection bank_name
     * @property Show\Field|Collection site_username
     * @property Show\Field|Collection site_phone
     * @property Show\Field|Collection site_province
     * @property Show\Field|Collection site_city
     * @property Show\Field|Collection site_district
     * @property Show\Field|Collection site_address
     * @property Show\Field|Collection wx_account
     * @property Show\Field|Collection wx_nickname
     * @property Show\Field|Collection wx_qrcode
     * @property Show\Field|Collection alipay_account
     * @property Show\Field|Collection alipay_username
     * @property Show\Field|Collection alipay_qrcode
     * @property Show\Field|Collection qq
     * @property Show\Field|Collection money
     * @property Show\Field|Collection account
     * @property Show\Field|Collection phone
     * @property Show\Field|Collection nickname
     * @property Show\Field|Collection level_password
     * @property Show\Field|Collection password_salt
     * @property Show\Field|Collection pid
     * @property Show\Field|Collection is_login
     *
     * @method Show\Field|Collection colum(string $label = null)
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection tag_ids(string $label = null)
     * @method Show\Field|Collection category_id(string $label = null)
     * @method Show\Field|Collection author(string $label = null)
     * @method Show\Field|Collection intro(string $label = null)
     * @method Show\Field|Collection keyword(string $label = null)
     * @method Show\Field|Collection image(string $label = null)
     * @method Show\Field|Collection content(string $label = null)
     * @method Show\Field|Collection deleted_at(string $label = null)
     * @method Show\Field|Collection uuid(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection uid(string $label = null)
     * @method Show\Field|Collection coin_type(string $label = null)
     * @method Show\Field|Collection fund_type(string $label = null)
     * @method Show\Field|Collection remark(string $label = null)
     * @method Show\Field|Collection user_identity(string $label = null)
     * @method Show\Field|Collection ip(string $label = null)
     * @method Show\Field|Collection insert_time(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection tokenable_type(string $label = null)
     * @method Show\Field|Collection tokenable_id(string $label = null)
     * @method Show\Field|Collection abilities(string $label = null)
     * @method Show\Field|Collection last_used_at(string $label = null)
     * @method Show\Field|Collection url(string $label = null)
     * @method Show\Field|Collection input_type(string $label = null)
     * @method Show\Field|Collection id_card_username(string $label = null)
     * @method Show\Field|Collection id_card_code(string $label = null)
     * @method Show\Field|Collection id_card_front_img(string $label = null)
     * @method Show\Field|Collection id_card_verso_img(string $label = null)
     * @method Show\Field|Collection id_card_hand_img(string $label = null)
     * @method Show\Field|Collection bank_username(string $label = null)
     * @method Show\Field|Collection bank_phone(string $label = null)
     * @method Show\Field|Collection bank_code(string $label = null)
     * @method Show\Field|Collection bank_name(string $label = null)
     * @method Show\Field|Collection site_username(string $label = null)
     * @method Show\Field|Collection site_phone(string $label = null)
     * @method Show\Field|Collection site_province(string $label = null)
     * @method Show\Field|Collection site_city(string $label = null)
     * @method Show\Field|Collection site_district(string $label = null)
     * @method Show\Field|Collection site_address(string $label = null)
     * @method Show\Field|Collection wx_account(string $label = null)
     * @method Show\Field|Collection wx_nickname(string $label = null)
     * @method Show\Field|Collection wx_qrcode(string $label = null)
     * @method Show\Field|Collection alipay_account(string $label = null)
     * @method Show\Field|Collection alipay_username(string $label = null)
     * @method Show\Field|Collection alipay_qrcode(string $label = null)
     * @method Show\Field|Collection qq(string $label = null)
     * @method Show\Field|Collection money(string $label = null)
     * @method Show\Field|Collection account(string $label = null)
     * @method Show\Field|Collection phone(string $label = null)
     * @method Show\Field|Collection nickname(string $label = null)
     * @method Show\Field|Collection level_password(string $label = null)
     * @method Show\Field|Collection password_salt(string $label = null)
     * @method Show\Field|Collection pid(string $label = null)
     * @method Show\Field|Collection is_login(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
