<?php
/**
 * Created by PhpStorm.
 * User: maple.xia
 * Date: 2019-03-17
 * Time: 12:25
 */

namespace MapleSnow\LaravelCore\Http\Requests;

use MapleSnow\Yaml\Requests\BaseRequest;
use MapleSnow\LaravelCore\Rules\Ids;

/**
 * Class IdsRequest
 * @package MapleSnow\LaravelCore\Http\Requests
 * @property int|array id
 */
class IdsRequest extends BaseRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'ids' => array("required",new Ids())
        ];
    }

    public function attributes() {
        return [
            'ids'  => 'ID'
        ];
    }
}
