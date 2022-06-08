<?php

/*
| MY Helpers.
|
| @author Andre Siantana <andre.anson@rebelworks.co>
*/
use App\Models\Agent;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

if (! function_exists('user_info')) {
    /**
     * Get logged user info.
     *
     * @param  string $column
     * @return mixed
     */
    function user_info($column = null)
    {
        if ($user =Sentinel::check()) {
            if (is_null($column)) {
                return $user;
            }

            if ('full_name' == $column) {
                return user_info('first_name').' '.user_info('last_name');
            }

            if ('role' == $column) {
                return user_info()->roles()->first()->name;
            }

            return $user->{$column};
        }

        return null;
    }
}

if (! function_exists('set_currency')) {
    function set_currency($text = '') {
        return str_replace('.', '', $text);
    }
}

if (! function_exists('str_replace_first')) {
    function str_replace_first($from, $to, $content) {
        $from = '/'.preg_quote($from, '/').'/';

        return preg_replace($from, $to, $content, 1);
    }
}

if (! function_exists('get_currency')) {
    function get_currency($amount = '') {
        return number_format($amount, 0, ',', '.');
    }
}

if (! function_exists('create_date_from_format')) {
    function create_date_from_format($text = '',$format = 'd-m-Y H:i') {
        $date = \Carbon\Carbon::createFromFormat($format,$text);

        return $date;
    }
}

if (! function_exists('randomString')) {
    function randomString($number = 8,$prefix = null)
    {
        $prefixCode = '';

        if($prefix){
            $prefixCode = $prefix.'_';
        }

        return strtoupper($prefixCode.''.Str::random($number));
    }
}

if (! function_exists('sessionFlash')) {
    function sessionFlash($message,$type)
    {
        session()->put('notification',[
            'message' => $message,
            'alert-type' => $type,
        ]);
    }
}

if (! function_exists('getSettings')) {
    function getSettings()
    {
        return \App\Models\Setting::first();
    }
}

if (! function_exists('delimiterToCamelCase')) {
    function delimiterToCamelCase($string, $capitalizeFirstCharacter = false,$delimiter = '.')
    {

        $str = str_replace($delimiter, '', ucwords($string, $delimiter));

        if (!$capitalizeFirstCharacter) {
            $str = lcfirst($str);
        }

        return $str;
    }
}

if (! function_exists('isAdminGroup')) {
    function isAdminGroup()
    {
        $userLoggedIn = Sentinel::getUser();
        $inRoleSuperAdmin = $userLoggedIn->inRole('super-admin');
        $inRoleAdmin = $userLoggedIn->inRole('administrator');
        $inRoleAccountDirector = $userLoggedIn->inRole('account-director');
        if($inRoleSuperAdmin){
            return true;
        }else if($inRoleAdmin){
            return true;
        }else if($inRoleAccountDirector){
            return true;
        }

        return false;
    }
}

if (! function_exists('isRoleNotIn')) {
    function isRoleNotIn($slugName)
    {
        $userLoggedIn = Sentinel::getUser();
        $isRoleNot = $userLoggedIn->inRole($slugName);
        if(!$isRoleNot){
            return true;
        }

        return false;
    }
}

if (! function_exists('isRoleIn')) {
    function isRoleIn($slugName)
    {
        $userLoggedIn = Sentinel::getUser();
        $isRoleNot = $userLoggedIn->inRole($slugName);
        if($isRoleNot){
            return true;
        }

        return false;
    }
}

if (! function_exists('hasErrorField')) {
    function hasErrorField($errors,$field)
    {
        if($errors->has($field)){
            return 'form-control-danger';
        }
    }
}

if (! function_exists('getImageUserLogin')) {
    function getImageUserLogin()
    {
        $url = url('/images/avatar.png');
        if(user_info('user_image') != null){
            $dbUrl = get_file(user_info('user_image'), 'thumbnail');
            $baseUrl = url('');
            $geLocalDbtUrl = str_replace($baseUrl.'/','',$dbUrl);
            if($dbUrl && file_exists($geLocalDbtUrl)){
                $url = $dbUrl;
            }
        }
        return $url;
    }
}

if (! function_exists('setMenuActive')) {
    function setMenuActive($routeName)
    {
        $className = '';
        $baseUrl = url('');
        $uri = str_replace($baseUrl.'/','',route($routeName));
        if(request()->is($uri)){
            $className = 'active';
        }else if(request()->is($uri.'/*')){
            $className = 'active';
        }

        return $className;
    }
}

if (! function_exists('flashDataAfterSave')) {
    function flashDataAfterSave($savedData,$name)
    {
        $message = 'insert new';
        if(request()->isMethod('PUT')){
            $message = 'update';
        }
        if (!empty($savedData)) {
            request()->session()->flash('success', 'Success '.$message.' data '.$name.'!');
        } else {
            request()->session()->flash('error', 'Failed '.$message.' data '.$name.'!');
        }
    }
}

if (! function_exists('createSlug')) {
    function createSlug($word)
    {
        return Str::slug($word, '-');
    }
}

if (! function_exists('camelCaseToSpace')) {
    function camelCaseToSpace($word)
    {
        return preg_replace( '/([a-z0-9])([A-Z])/', "$1 $2", $word );
    }
}

if (! function_exists('delimiterToSpace')) {
    function delimiterToSpace($word)
    {
        $arrDelimiter = ['-','.','_'];
        $wordReplaced = '';
        $i = 0;
        foreach ($arrDelimiter as $delimiter){
            if($wordReplaced != ''){
                $wordReplaced = ucwords(str_replace($delimiter,' ',$wordReplaced));
            }else{
                $wordReplaced = ucwords(str_replace($delimiter,' ',$word));
            }
            $i++;
        }

        return $wordReplaced;
    }
}

if (! function_exists('getFirstModelByIdentifier')) {
    function getFirstModelByIdentifier(\Illuminate\Database\Eloquent\Model $modelsParam,$param){
        $identifier = (int)$param;
        if($identifier != 0){
            return $modelsParam->findOrFail($param);
        }else{
            return $modelsParam->where('code','=',$param)->firstOrFail();
        }
    }
}

if (! function_exists('getCollectionModelByIdentifier')) {
    function getCollectionModelByIdentifier(\Illuminate\Database\Eloquent\Model $modelsParam,$param){
        $identifier = (int)$param;
        if($identifier != 0){
            return $modelsParam->get($param);
        }else{
            return $modelsParam->where('code','=',$param)->get();
        }
    }
}

if (! function_exists('getRouteNameByUrl')) {
    function getRouteNameByUrl($url,$method = null, $__route_name=null)
    {
        if($__route_name!=null){
            return $__route_name;
        }

        if($method == null){
            $routeObj = app('router')
                ->getRoutes()
                ->match(app('request')
                ->create($url))
                ->getName();
        }else{
            $routeObj = app('router')
                ->getRoutes()
                ->match(app('request')
                ->create($url,$method))
                ->getName();
        }

        return $routeObj;
    }
}

if (! function_exists('isHasAnyActionColumn')) {
    function isHasAnyActionColumn($paramRouteName = null)
    {
        $arrayMethodAction = [
            'show',
            'edit',
            'destroy',
        ];

        $routeName = null;

        if($paramRouteName){
            $routeName = $paramRouteName;
        }else{
            $routeName = request()->route()->getName();
        }

        $parentRouteName = explodeByLastDelimiter($routeName);

        $hasAny = [];

        foreach ($arrayMethodAction as $method){
            $hasAny[] = checkPermissionAccess($parentRouteName.'.'.$method);
        }

        return in_array(true, $hasAny);
    }
}

if (! function_exists('isOnlyDataOwned')) {
    function isOnlyDataOwned()
    {
        if(isAdminGroup()){
            return false;
        }

        $userLoggedIn = Sentinel::getUser();

        $routeName = request()->route()->getName();

        $parentRouteName = explodeByLastDelimiter($routeName);

        if ($userLoggedIn->hasAccess($parentRouteName.'.owned')){
            return true;
        }

        return false;
    }
}

if (! function_exists('checkPermissionAccess')) {
    function checkPermissionAccess($routeName = null)
    {
        $userLoggedIn = Sentinel::getUser();
        $roles = Sentinel::findById($userLoggedIn->id)->roles->first();

        if(!$userLoggedIn){
            return false;
        }

        if($routeName == null){
            $getRequestName = request()->route()->getName();
        } else {
            $getRequestName = $routeName;
        }

        if ($userLoggedIn->hasAccess($getRequestName)){
           return true;
        }

        $inRoleSuperAdmin = $userLoggedIn->inRole('super-admin');
        if($inRoleSuperAdmin){
            return true;
        }

        return false;
    }
}

if (! function_exists('allowNotDefinedRoutePermission')) {
    function allowNotDefinedRoutePermission($routeName = null)
    {
        $userLoggedIn = Sentinel::getUser();
        $roles = Sentinel::findById($userLoggedIn->id)->roles->first();

        $inRoleSuperAdmin = $userLoggedIn->inRole('super-admin');
        if($inRoleSuperAdmin){
            return true;
        }

        if(!$userLoggedIn){
            return false;
        }

        if($routeName == null){
            $getRequestName = request()->route()->getName();
        } else {
            $getRequestName = $routeName;
        }

        if($roles){
            $arrPermission = $roles->permissions;
            if(!isset($arrPermission[$getRequestName])){
                return true;
            }
        }

        if ($userLoggedIn->hasAccess($getRequestName)){
            return true;
        }

        return false;
    }
}


if (! function_exists('checkPermissionAccessByUrl')) {
    function checkPermissionAccessByUrl($url,$method = null, $__route_name=null)
    {
        $getRequestName = getRouteNameByUrl($url,$method,$__route_name);
        return checkPermissionAccess($getRequestName);
    }
}

if (! function_exists('explodeByLastDelimiter')) {
    function explodeByLastDelimiter($feed,$delimiter = '.')
    {
        $explodeArr = '';
        $parts = explode($delimiter, $feed);
        $countExploded = count($parts);
        if($countExploded > 1){
            $last = array_pop($parts);
            $parts = array(implode($delimiter, $parts), $last);
            $explodeArr =  $parts[0];
        } else {
            $explodeArr =  $feed;
        }

        return $explodeArr;
    }
}

if (! function_exists('explodeByLastDelimiterGetChild')) {
    function explodeByLastDelimiterGetChild($feed,$delimiter = '.')
    {
        $parts = explode($delimiter, $feed);
        $countExploded = count($parts);
        if($countExploded > 1){
            $last = array_pop($parts);
            $parts = array(implode($delimiter, $parts), $last);
            $explodeArr =  $parts[1];
        } else {
            $explodeArr =  $feed;
        }

        return $explodeArr;
    }
}

if (! function_exists('inArrayContains')) {
    function inArrayContains($str, array $arr)
    {
        foreach($arr as $a) {
            if (stripos($str,$a) !== false) return true;
        }
        return false;
    }
}

if (! function_exists('stringContains')) {
    function stringContains($string,$contains)
    {
        return Str::contains(strtolower($string), $contains);
    }
}

if (! function_exists('permissionAlias')) {
    function permissionAlias($permissionName)
    {
        switch(strtolower($permissionName)) {
            case stringContains($permissionName,'index') :
                $alias = 'Menu';
                break;
            case stringContains($permissionName,'create') :
                $alias = 'Create';
                break;
            case stringContains($permissionName,'store') :
                $alias = 'Save';
                break;
            case stringContains($permissionName,'edit') :
                $alias = 'Edit';
                break;
            case stringContains($permissionName,'update') :
                $alias = 'Update';
                break;
            case stringContains($permissionName,'destroy') :
                $alias = 'Delete';
                break;
            case stringContains($permissionName,'show') :
                $alias = 'Detail';
                break;
            case 'changepassword':
                $alias = 'Change Password';
                break;
            default:
                $alias = $permissionName;
        }

        return ucfirst($alias);

    }
}

if (! function_exists('checkPermissionAccessRouteName')) {
    function checkPermissionAccessRouteName($middlewareName = 'checkAccess',$method = 'crud')
    {
        $collection = Route::getRoutes();

        $routes = [];

        $arrayMethod = ['create','update','destroy','show','edit','store'];

        foreach($collection as $route) {
            $action = $route->getActionName();
            $uri = $route->uri;
            $routeName = $route->getName();
            $middlewareRouteName = @$route->getAction()['middleware'];
            $routeActionMethod = $route->getActionMethod();
            $isInMiddlewareCheckAccess = in_array($middlewareName, @$middlewareRouteName);
            $parentRouteName = explodeByLastDelimiter($routeName);
            $methodsList = $route->methods;
            $defaultList = $route->defaults;

            $routeChildName = explodeByLastDelimiterGetChild($routeName,'.');
            $inRouteActionMethod = in_array($routeChildName,$arrayMethod);
            $isInMiddlewareHiddenPermission = in_array('hiddenPermission', @$middlewareRouteName);

            if($isInMiddlewareCheckAccess && $method == 'crud'){
                if(in_array('GET',$methodsList) || in_array('DELETE',$methodsList)){
                    $data = [
                        'routeName' => $routeName,
                        'routeUri' => $uri,
                        'methodAction' => $routeActionMethod,
                        'methods' => $methodsList,
                        'defaults' => $defaultList,
                        'middleware' => $middlewareRouteName,
                        'parentRoute' =>$parentRouteName,
                        'actionName' =>$action,
                    ];

                    if($isInMiddlewareHiddenPermission){
                        $data = array_merge($data,['hidden' => 'true']);
                    } else {
                        $data = array_merge($data,['hidden' => 'false']);
                    }

                    $routes[$parentRouteName][$routeActionMethod] = $data;
                }
                if(!$inRouteActionMethod){
                    $data = [
                        'routeName' => $routeName,
                        'routeUri' => $uri,
                        'methodAction' => $routeActionMethod,
                        'methods' => $methodsList,
                        'defaults' => $defaultList,
                        'middleware' => $middlewareRouteName,
                        'parentRoute' =>$parentRouteName,
                        'actionName' =>$action,
                    ];

                    if($isInMiddlewareHiddenPermission){
                        $data = array_merge($data,['hidden' => 'true']);
                    } else {
                        $data = array_merge($data,['hidden' => 'false']);
                    }

                    $routes[$parentRouteName][$routeActionMethod] = $data;
                }
            }

            if($isInMiddlewareCheckAccess && $method == 'all'){
                if($routeName == null){
                    continue;
                }

                $data = [
                    'routeName' => $routeName,
                    'routeUri' => $uri,
                    'methodAction' => $routeActionMethod,
                    'methods' => $methodsList,
                    'middleware' => $middlewareRouteName,
                    'parentRoute' =>$parentRouteName,
                    'actionName' =>$action,
                ];

                if($isInMiddlewareHiddenPermission){
                    $data = array_merge($data,['hidden' => 'true']);
                } else {
                    $data = array_merge($data,['hidden' => 'false']);
                }

                $routes[$parentRouteName][$routeActionMethod] = $data;

            }
        }

        return $routes;
    }
}

if (! function_exists('link_to_avatar')) {
    /**
     * Generates link to avatar.
     *
     * @param  null|string $path
     * @return string
     */
    function link_to_avatar($path = null)
    {
        if (is_null($path) || ! file_exists(avatar_path($path))) {
            return 'http://lorempixel.com/128/128/';
        }

        return asset('images/avatars').'/'.trim($path, '/');
    }
}

if (! function_exists('avatar_path')) {
    /**
     * Generates avatars path.
     *
     * @param  null|string $path
     * @return string
     */
    function avatar_path($path = null)
    {
        $link = public_path('images/avatars');

        if (is_null($path)) {
            return $link;
        }

        return $link.'/'.trim($path, '/');
    }
}

if (! function_exists('avatar_user_path')) {
    /**
     * Generates avatar user path.
     *
     * @param  null|string $path
     * @return string
     */
    function avatar_user_path($path = null)
    {
        $link = public_path('images/avatars/users');

        if (is_null($path)) {
            return $link;
        }

        return $link.'/'.trim($path, '/');
    }
}

if (! function_exists('datatables')) {
    /**
     * Shortcut for Datatables::of().
     *
     * @param  mixed $builder
     * @return mixed
     */
    function datatables($builder)
    {
        return DataTables::of($builder);
    }
}

if (! function_exists('upload_file')) {
    function upload_file($data, $filepath = 'uploads/', $filetype = 'image', $type = 'public')
    {
        if (!empty($data) && $data->isValid()) {
            $fileExtension = strtolower($data->getClientOriginalExtension());
            $newFilename = Str::random(20) . '.' . $fileExtension;

            if (!File::exists($filepath)) {
                File::makeDirectory($filepath, $mode = 0777, true, true);
            }

            if ($filetype == 'image' ){
                $file = Image::make($data);
                $file->save($filepath . $newFilename);
                 $compressedImage = compress_image($filepath.$newFilename);
                 $imageThumbnail = image_thumbnail($filepath.$newFilename);
            } else {
                $file = $data->move($filepath, $newFilename);
                $compressedImage = "";
                $imageThumbnail = "";
            }
            $result['original'] = $filepath.$newFilename;
             $result['compressed'] = $compressedImage;
             $result['thumbnail'] = $imageThumbnail;

            return  $result;
        }

        return '';
    }
}

if (! function_exists('get_file')) {
    function get_file($path, $preview = 'compressed', $type = 'public')
    {
        if ($type == 'public' && !empty($path) ){
            if ($preview == 'thumbnail'){
                return URL::to(dirname($path).'/thumb/'.basename($path));
            } else {
                return URL::to($path);
            }

        } else {
            //storage path

        }

    }
}

if (! function_exists('delete_file')) {
    function delete_file($path, $type = 'public')
    {
        if ($type == 'public') {
            $dirname = dirname($path);
            $filename = basename($path);

            if(file_exists(public_path().'/'.$path)){
                File::delete($path); // original
            }

            if(file_exists(public_path().'/'.$dirname.'/compressed/'.$filename)){
                File::delete($dirname.'/compressed/'.$filename);
            }

            if(file_exists(public_path().'/'.$dirname.'/thumb/'.$filename)){
                File::delete($dirname.'/thumb/'.$filename);
            }
        } else {
            if (Storage::has($path)) {
                return Storage::delete($path);
            }
        }
    }
}

if (! function_exists('compress_image')) {
    function compress_image($path, $width = 1366, $type = 'public')
    {
        if($type == 'public'){
            $thumb_path = public_path().'/'.dirname($path).'/compressed/';
            list($img_width, $img_height) = getimagesize(public_path().'/'.$path);

            if($img_width < $width){
                $width = $img_width;
            }

            if(!File::exists($thumb_path)) {
                File::makeDirectory($thumb_path, $mode = 0777, true, true);
            }

            $img = Image::make(public_path() .'/'.$path);
            $img->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumb_path.basename($path), 20);

            return dirname($path).'/compressed/'.basename($path);
        }else{
            //storage path
        }
    }
}

if (! function_exists('image_thumbnail')) {
    function image_thumbnail($path, $width = 200, $type = 'public')
    {
        if($type == 'public'){
            $thumb_path = public_path().'/'.dirname($path).'/thumb/';
            list($img_width, $img_height) = getimagesize(public_path().'/'.$path);

            if($img_width < $width){
                $width = $img_width;
            }

            if(!File::exists($thumb_path)) {
                File::makeDirectory($thumb_path, $mode = 0777, true, true);
            }

            $img = Image::make(public_path() .'/'.$path);
            $img->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($thumb_path.basename($path), 60);

            return dirname($path).'/thumb/'.basename($path);
        }else{
            //storage path
        }
    }
}

if (! function_exists('myDatetime')) {
    /**
     * Generate new datetime from configured format datetime.
     *
     * @param  string $datetime
     * @return string
     */
    function myDatetime($datetime)
    {
        return date(env('APP_DATE_FORMAT', 'd M Y H:i:s'), strtotime($datetime));
    }
}

if (! function_exists('getDayIndo')) {
    /**
     * Generate new datetime from configured format datetime.
     *
     * @param  string $datetime
     * @return string
     */
    function getDayIndo($date)
    {
        $day = date('D', strtotime($date));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );

        return $dayList[$day];
    }
}

if (! function_exists('getDateIndo')) {
    /**
     * Generate new datetime from configured format datetime.
     *
     * @param  string $datetime
     * @return string
     */
    function getDateIndo($date)
    {
        switch(date("F", strtotime($date)))
        {
            case 'January':     $nmb="Januari";     break;
            case 'February':    $nmb="Februari";    break;
            case 'March':       $nmb="Maret";       break;
            case 'April':       $nmb="April";       break;
            case 'May':         $nmb="Mei";         break;
            case 'June':        $nmb="Juni";        break;
            case 'July':        $nmb="Juli";        break;
            case 'August':      $nmb="Agustus";     break;
            case 'September':   $nmb="September";   break;
            case 'October':     $nmb="Oktober";     break;
            case 'November':    $nmb="November";    break;
            case 'December':    $nmb="Desember";    break;
        }

        return date("d",strtotime($date))." "."$nmb"." ".date("Y",strtotime($date));
    }
}

if (! function_exists('getDateIndoWithTime')) {
    /**
     * Generate new datetime from configured format datetime.
     *
     * @param  string $datetime
     * @return string
     */
    function getDateIndoWithTime($date)
    {
        return getDateIndo($date) .' '. date("H:i",strtotime($date));;
    }
}

if (! function_exists('time_elapsed_string')) {
    function time_elapsed_string($start, $end, $full = false) {
        $now = new DateTime($end);
        $ago = new DateTime($start);
        $diff = $now->diff($ago);
        return $diff;
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    if (! function_exists('array_month')) {
       function array_month()
       {
            return array(
                1 => trans('month.january'),
                2 => trans('month.february'),
                3 => trans('month.march'),
                4 => trans('month.april'),
                5 => trans('month.may'),
                6 => trans('month.june'),
                7 => trans('month.july'),
                8 => trans('month.august'),
                9 => trans('month.september'),
                10 => trans('month.october'),
                11 => trans('month.november'),
                12 => trans('month.december')
            );
       }
    }
}

if (!function_exists('recursive_select_option')) {
    function recursive_select_option(Illuminate\Support\Collection $collection, $indentChar = '') {
        $html = '';

        foreach ($collection as $key => $item) {
            $html .= '<option value="' . $item->id . '">';
            $html .=  $indentChar . $item->name;
            $html .= '</option">';

            if (!$item->children->isEmpty()) {
                // $html .= '<optgroup label="' . $indentChar . $item->name . '">';


                $indentChar .= '&nbsp;';
                $html .= recursive_select_option($item->children, $indentChar);
                // $html .= '</optgroup>';

            // } else {
                $html .= '<option value="' . $item->id . '">';
                $html .=  $indentChar . $item->name;
                $html .= '</option">';
            }
        }

        return $html;
    }
}

if (!function_exists('recursive_nestable')) {
    function recursive_nestable(Illuminate\Support\Collection $collection) {
        $html = '';

        foreach ($collection as $key => $item) {
            if($item->is_active) {
                $status_active = 'active';
            } else {
                $status_active = 'non active';
            }
            $html .='<li class="dd-item" data-id="'. $item->id. '">
                        <div class="dd-handle"><span class="badge">' . $item->id . '</span> ' . $item->name .'
                            <span class="pull-right">
                                <span class="badge" style="margin-right: 50px">'.  $status_active .'</span>
                                <a
                                    href=""
                                    class="btn-add"
                                    data-id="' . $item->id . '"
                                    data-parent-id="' . $item->parent_id . '"
                                    data-description="' . $item->description . '"
                                >
                                    <i class="fa fa-plus">
                                    </i>
                                </a>
                                &nbsp;
                                <a
                                    href=""
                                    class="btn-edit"
                                    data-id="' . $item->id . '"
                                    data-name="' . $item->name . '"
                                    data-parent-id="' . $item->parent_id . '"
                                    data-description="' . $item->description . '"
                                    data-order="' . $item->order . '"
                                    data-is-active="' . $item->is_active . '"
                                    data-start-date="' . $item->start_date . '"
                                    data-end-date="' . $item->end_date . '"
                                    data-image="' . $item->image . '"
                                >
                                    <i class="fa fa-pencil">
                                    </i>
                                </a>
                                &nbsp;
                                <a href="" class="btn-delete" data-id="' . $item->id . '">
                                    <i class="fa fa-trash">
                                    </i>
                                </a>
                            </span>
                        </div>';
            if (!$item->children->isEmpty()) {
                $html .= '<ol class="dd-list">';
                $html .= recursive_nestable($item->children);
                $html .= '</ol>';
            }

            $html .= '</li>';
        }

        return $html;
    }
}

if (! function_exists('getInfoAgentLoggedIn')) {
    /**
     * Get data agent that currently loggen in.
     *
     * @param  null
     * @return Models\Agent
     */
    function getInfoAgentLoggedIn()
    {
        return Agent::where('email', user_info('email'))->with(['salesmans'])->first();
    }
}

if (! function_exists('labelStatus')) {
    function labelStatus($type = 'close', $text = '') {

        switch($type) {
            case 'canceled':
                $class = 'danger';
                break;
            case 'close':
                $class = 'success';
                break;
            case 'open':
                $class = 'primary';
                break;
            case 'partial':
                $class = 'info';
                break;
            case 'pending':
                $class = 'warning';
                break;
            default:
                $class = 'default';
        }

        return '<span class="label label-' . $class . '">' . $text . '</span>';

    }
}

