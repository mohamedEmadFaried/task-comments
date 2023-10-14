<?php

namespace App\Traits;

trait ValidationRequest
{
    public function authorize()
    {
        return true;
    }

    public function messagesAction(): array
    {
        return [];
    }

    public function messages($array = []): array
    {

        return array_merge(
            [
                'name.required'             => __('api.The name field required.'),
                'name.string'               => __('api.The name field must be string.'),
                'phone_number.*.required'   => __('api.The phone number field required.'),
                'phone_number.*.unique'     => __('api.The phone number field has already been taken.'),
                'phone_number.*.exists'     => __('api.The phone number not found'),
                'phone_number.*.phone'      => __('api.The phone number field field does not contain an invalid number.'),
                'email.required'            => __('api.The email field required.'),
                'email.unique'              => __('api.The email has already been taken.'),
                'email.email'               => __('api.The email must be a valid email.'),
                'password.required'         => __('api.The password field required.'),
                'password.string'           => __('api.The password field must be string.'),
                'password.min:8'            => __('api.The password field must not be less than 8 characters.'),
                'password.confirmed'        => __('api.The password field must be confirmed.'),
                'country.array'             => __('api.The country field required.'),
                'data.array'                => __('api.The data must be array.'),
                'title.array'               => __('api.The title must be array.'),
                'title.*.required'          => __('api.The :attribute field required.'),
                'description.string'         => __('api.The description field must be string.'),
                'site_name.max:100'         => __('api.The site_name must less than 100 characters.'),
                'site_logo.image'           => __('api.The site_logo must be image.'),
                'site_favicon.image'        => __('api.The site_favicon must be image.'),
                'type.required'             => __('api.The type field required.'),
                'price.numeric'             => __('api.The price must be numeric.'),
                'price.min:1'               => __('api.The price must not be less than 1 characters.'),
                'price.max:9999999999'      => __('api.The price must be less than 9999999999 characters.'),
                'logo.image'                => __('api.The logo must be image..'),
                'cover.image'               => __('api.The cover must be image..'),
                'avatar.image'              => __('api.The avatar must be image..'),
                'facebook_url.max:50'       => __('api.The facebook url must less than 50 characters.'),
                'twitter_url.max:50'        => __('api.The twitter url must less than 50 characters.'),
                'instagram_url.max:50'      => __('api.The instagram url must less than 50 characters.'),
                'bank_number.max:15'        => __('api.The bank_number  must less than 15 characters.'),
                'manager_number.max:15'     => __('api.The manager number  must less than 15 characters.'),
                'reason_id.required'          => __('api.The reason id field required.'),
                'phone.required'            => __('api.The phone field required.'),
                'phone.exists'     => __('api.The phone number not found'),
                'phone.min:9'     => __('api.The phone number must be not less than 9 .'),


            ], $this->messagesAction());
    }
}
